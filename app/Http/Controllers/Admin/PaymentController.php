<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\UserNotification;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'rent'])
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function approve(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'This payment is already processed.');
        }

        $payment->update([
            'status' => 'approved',
        ]);

        if ($payment->rent) {
            $payment->rent->update([
                'status' => 'paid',
            ]);
        }

        UserNotification::create([
            'user_id' => $payment->user_id,
            'type' => 'payment',
            'title' => 'Payment Approved',
            'message' => 'Your payment of ' . number_format($payment->amount, 2) . ' BDT has been approved.',
            'action_url' => route('customer.payments.index'),
        ]);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment approved successfully.');
    }

    public function reject(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'This payment is already processed.');
        }

        $payment->update([
            'status' => 'rejected',
        ]);

        UserNotification::create([
            'user_id' => $payment->user_id,
            'type' => 'payment',
            'title' => 'Payment Rejected',
            'message' => 'Your payment of ' . number_format($payment->amount, 2) . ' BDT has been rejected. Please contact admin.',
            'action_url' => route('customer.payments.index'),
        ]);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment rejected successfully.');
    }
}