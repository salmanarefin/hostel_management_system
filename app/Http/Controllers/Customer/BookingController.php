<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BookingRequest;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = BookingRequest::with(['branch', 'room', 'seat', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->seat_id) {
            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'You already have a booked seat. You can use seat change option.');
        }

        $availableSeats = Seat::with('room.branch')
            ->where('status', 'available')
            ->orderBy('seat_number')
            ->get();

        return view('customer.bookings.create', compact('availableSeats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seat_id' => 'required|exists:seats,id',
            'paid_days' => 'required|integer|min:1',
            'payment_method' => 'required|string|max:100',
            'transaction_id' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        if ($user->seat_id) {
            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'You already have a booked seat. You can use seat change option.');
        }

        $seat = Seat::with('room.branch')->findOrFail($request->seat_id);

        if ($seat->status !== 'available') {
            return back()
                ->withInput()
                ->with('error', 'This seat is not available.');
        }

        $dailyRent = $seat->room->rent_amount;
        $paidDays = (int) $request->paid_days;
        $totalAmount = $dailyRent * $paidDays;

        $payment = Payment::create([
            'user_id' => $user->id,
            'rent_id' => null,
            'amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'pending',
        ]);

        BookingRequest::create([
            'user_id' => $user->id,
            'branch_id' => $seat->room->branch_id,
            'room_id' => $seat->room_id,
            'seat_id' => $seat->id,
            'payment_id' => $payment->id,
            'paid_days' => $paidDays,
            'daily_rent' => $dailyRent,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'pending',
            'note' => $request->note,
        ]);

        UserNotification::create([
            'user_id' => $user->id,
            'type' => 'booking',
            'title' => 'Booking Request Submitted',
            'message' => 'Your seat booking request has been submitted. Please wait for admin approval.',
            'action_url' => route('customer.bookings.index'),
        ]);

        return redirect()
            ->route('customer.bookings.index')
            ->with('success', 'Booking request submitted successfully. Please wait for admin approval.');
    }
}