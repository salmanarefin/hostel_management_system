<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeatChangeRequest;
use App\Models\UserNotification;

class SeatChangeRequestController extends Controller
{
    public function index()
    {
        $requests = SeatChangeRequest::with([
                'user',
                'currentBranch',
                'currentRoom',
                'currentSeat',
                'requestedBranch',
                'requestedRoom',
                'requestedSeat',
            ])
            ->latest()
            ->paginate(10);

        return view('admin.seat-change-requests.index', compact('requests'));
    }

    public function approve(SeatChangeRequest $seatChangeRequest)
    {
        if ($seatChangeRequest->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        $user = $seatChangeRequest->user;
        $oldSeat = $seatChangeRequest->currentSeat;
        $newSeat = $seatChangeRequest->requestedSeat;

        if (!$newSeat || $newSeat->status !== 'available') {
            return back()->with('error', 'Requested seat is no longer available.');
        }

        if ($oldSeat) {
            $oldSeat->update([
                'status' => 'available',
            ]);
        }

        $newSeat->update([
            'status' => 'booked',
        ]);

        $user->update([
            'branch_id' => $seatChangeRequest->requested_branch_id,
            'room_id' => $seatChangeRequest->requested_room_id,
            'seat_id' => $seatChangeRequest->requested_seat_id,
            'balance' => $user->balance - $seatChangeRequest->payment_difference,
        ]);

        $seatChangeRequest->update([
            'status' => 'approved',
        ]);

        UserNotification::create([
            'user_id' => $user->id,
            'type' => 'seat_change',
            'title' => 'Seat Change Approved',
            'message' => 'Your seat change request has been approved. Your new seat is ' . ($newSeat->seat_number ?? 'N/A') . '.',
            'action_url' => route('customer.seat-change.index'),
        ]);

        return redirect()
            ->route('admin.seat-change-requests.index')
            ->with('success', 'Seat change request approved successfully.');
    }

    public function reject(SeatChangeRequest $seatChangeRequest)
    {
        if ($seatChangeRequest->status !== 'pending') {
            return back()->with('error', 'This request is already processed.');
        }

        $seatChangeRequest->update([
            'status' => 'rejected',
        ]);

        if ($seatChangeRequest->user) {
            UserNotification::create([
                'user_id' => $seatChangeRequest->user->id,
                'type' => 'seat_change',
                'title' => 'Seat Change Rejected',
                'message' => 'Your seat change request has been rejected by admin.',
                'action_url' => route('customer.seat-change.index'),
            ]);
        }

        return redirect()
            ->route('admin.seat-change-requests.index')
            ->with('success', 'Seat change request rejected successfully.');
    }
}