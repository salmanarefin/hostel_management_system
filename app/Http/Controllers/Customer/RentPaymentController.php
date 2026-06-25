<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rent;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class RentPaymentController extends Controller
{
    private function createRentReminderNotifications($user)
    {
        $dueRents = Rent::where('user_id', $user->id)
            ->where('status', 'due')
            ->get();

        foreach ($dueRents as $rent) {
            $alreadyExists = UserNotification::where('user_id', $user->id)
                ->where('type', 'rent_reminder')
                ->where('action_url', route('customer.payments.index'))
                ->where('message', 'Your rent for ' . $rent->month . ' is due. Amount: ' . number_format($rent->amount, 2) . ' BDT. Due date: ' . $rent->due_date . '.')
                ->exists();

            if (!$alreadyExists) {
                UserNotification::create([
                    'user_id' => $user->id,
                    'type' => 'rent_reminder',
                    'title' => 'Rent Payment Reminder',
                    'message' => 'Your rent for ' . $rent->month . ' is due. Amount: ' . number_format($rent->amount, 2) . ' BDT. Due date: ' . $rent->due_date . '.',
                    'action_url' => route('customer.payments.index'),
                ]);
            }
        }
    }

    public function index()
    {
        $user = auth()->user();

        $this->createRentReminderNotifications($user);

        $rents = Rent::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $payments = Payment::with('rent')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('customer.payments.index', compact('rents', 'payments'));
    }

    public function create()
    {
        $user = auth()->user();

        $this->createRentReminderNotifications($user);

        $dueRents = Rent::where('user_id', $user->id)
            ->where('status', 'due')
            ->latest()
            ->get();

        return view('customer.payments.create', compact('dueRents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rent_id' => 'required|exists:rents,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:100',
            'transaction_id' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $rent = Rent::where('id', $request->rent_id)
            ->where('user_id', $user->id)
            ->where('status', 'due')
            ->firstOrFail();

        if ($request->amount < $rent->amount) {
            return back()
                ->withInput()
                ->with('error', 'Payment amount cannot be less than rent amount.');
        }

        Payment::create([
            'user_id' => $user->id,
            'rent_id' => $rent->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'pending',
        ]);

        UserNotification::create([
            'user_id' => $user->id,
            'type' => 'payment',
            'title' => 'Payment Submitted',
            'message' => 'Your payment has been submitted successfully. Please wait for admin approval.',
            'action_url' => route('customer.payments.index'),
        ]);

        return redirect()
            ->route('customer.payments.index')
            ->with('success', 'Payment submitted successfully. Please wait for admin approval.');
    }
}