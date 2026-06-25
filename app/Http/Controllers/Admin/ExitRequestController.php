<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExitRequest;
use App\Models\UserNotification;

class ExitRequestController extends Controller
{
    public function index()
    {
        $exits = ExitRequest::with(['user.branch', 'user.room', 'user.seat'])
            ->latest()
            ->paginate(10);

        return view('admin.exit-requests.index', compact('exits'));
    }

    public function approve(ExitRequest $exitRequest)
    {
        if ($exitRequest->status !== 'pending') {
            return back()->with('error', 'This exit request is already processed.');
        }

        $user = $exitRequest->user;

        if ($user) {
            if ($user->seat) {
                $user->seat->update([
                    'status' => 'available',
                ]);
            }

            $user->update([
                'branch_id' => null,
                'room_id' => null,
                'seat_id' => null,
                'balance' => $exitRequest->final_type === 'payable'
                    ? -$exitRequest->final_amount
                    : $exitRequest->final_amount,
            ]);

            UserNotification::create([
                'user_id' => $user->id,
                'type' => 'exit',
                'title' => 'Exit Request Approved',
                'message' => 'Your exit request has been approved. Final settlement: ' . ucfirst($exitRequest->final_type) . ' ' . number_format($exitRequest->final_amount, 2) . ' BDT.',
                'action_url' => route('customer.exits.index'),
            ]);
        }

        $exitRequest->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.exit-requests.index')
            ->with('success', 'Exit request approved successfully.');
    }

    public function reject(ExitRequest $exitRequest)
    {
        if ($exitRequest->status !== 'pending') {
            return back()->with('error', 'This exit request is already processed.');
        }

        $exitRequest->update([
            'status' => 'rejected',
        ]);

        if ($exitRequest->user) {
            UserNotification::create([
                'user_id' => $exitRequest->user->id,
                'type' => 'exit',
                'title' => 'Exit Request Rejected',
                'message' => 'Your exit request has been rejected by admin.',
                'action_url' => route('customer.exits.index'),
            ]);
        }

        return redirect()
            ->route('admin.exit-requests.index')
            ->with('success', 'Exit request rejected successfully.');
    }
}