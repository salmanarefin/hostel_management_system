<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\UserNotification;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.leave-requests.index', compact('leaves'));
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'This leave request is already processed.');
        }

        $leaveRequest->update([
            'status' => 'approved',
        ]);

        UserNotification::create([
            'user_id' => $leaveRequest->user_id,
            'type' => 'leave',
            'title' => 'Leave Approved',
            'message' => 'Your leave request from ' . $leaveRequest->start_date . ' to ' . $leaveRequest->end_date . ' has been approved.',
            'action_url' => route('customer.leaves.index'),
        ]);

        return redirect()
            ->route('admin.leave-requests.index')
            ->with('success', 'Leave request approved successfully.');
    }

    public function reject(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'This leave request is already processed.');
        }

        $leaveRequest->update([
            'status' => 'rejected',
        ]);

        UserNotification::create([
            'user_id' => $leaveRequest->user_id,
            'type' => 'leave',
            'title' => 'Leave Rejected',
            'message' => 'Your leave request from ' . $leaveRequest->start_date . ' to ' . $leaveRequest->end_date . ' has been rejected.',
            'action_url' => route('customer.leaves.index'),
        ]);

        return redirect()
            ->route('admin.leave-requests.index')
            ->with('success', 'Leave request rejected successfully.');
    }
}