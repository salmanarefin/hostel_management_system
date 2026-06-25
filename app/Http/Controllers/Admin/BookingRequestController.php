<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingRequest;
use App\Models\Rent;
use App\Models\UserNotification;

class BookingRequestController extends Controller
{
    public function index()
    {
        $bookings = BookingRequest::with(['user', 'branch', 'room', 'seat', 'payment'])
            ->latest()
            ->paginate(10);

        return view('admin.booking-requests.index', compact('bookings'));
    }

    public function approve(BookingRequest $bookingRequest)
    {
        if ($bookingRequest->status !== 'pending') {
            return back()->with('error', 'This booking request is already processed.');
        }

        $user = $bookingRequest->user;
        $seat = $bookingRequest->seat;

        if (!$seat || $seat->status !== 'available') {
            return back()->with('error', 'This seat is no longer available.');
        }

        $seat->update([
            'status' => 'booked',
        ]);

        $user->update([
            'branch_id' => $bookingRequest->branch_id,
            'room_id' => $bookingRequest->room_id,
            'seat_id' => $bookingRequest->seat_id,
            'deposit_amount' => $bookingRequest->total_amount,
            'balance' => 0,
        ]);

        if ($bookingRequest->payment) {
            $bookingRequest->payment->update([
                'status' => 'approved',
            ]);
        }

        Rent::create([
            'user_id' => $user->id,
            'month' => 'Booking for ' . $bookingRequest->paid_days . ' day(s)',
            'amount' => $bookingRequest->total_amount,
            'due_date' => now()->addDays($bookingRequest->paid_days)->toDateString(),
            'status' => 'paid',
        ]);

        $bookingRequest->update([
            'status' => 'approved',
        ]);

        UserNotification::create([
            'user_id' => $user->id,
            'type' => 'booking',
            'title' => 'Booking Approved',
            'message' => 'Your booking has been approved. Seat: ' . ($seat->seat_number ?? 'N/A') . '. Paid days: ' . $bookingRequest->paid_days . '.',
            'action_url' => route('customer.bookings.index'),
        ]);

        return redirect()
            ->route('admin.booking-requests.index')
            ->with('success', 'Booking request approved successfully.');
    }

    public function reject(BookingRequest $bookingRequest)
    {
        if ($bookingRequest->status !== 'pending') {
            return back()->with('error', 'This booking request is already processed.');
        }

        $bookingRequest->update([
            'status' => 'rejected',
        ]);

        if ($bookingRequest->payment) {
            $bookingRequest->payment->update([
                'status' => 'rejected',
            ]);
        }

        UserNotification::create([
            'user_id' => $bookingRequest->user_id,
            'type' => 'booking',
            'title' => 'Booking Rejected',
            'message' => 'Your booking request has been rejected by admin. Please contact office for details.',
            'action_url' => route('customer.bookings.index'),
        ]);

        return redirect()
            ->route('admin.booking-requests.index')
            ->with('success', 'Booking request rejected successfully.');
    }
}