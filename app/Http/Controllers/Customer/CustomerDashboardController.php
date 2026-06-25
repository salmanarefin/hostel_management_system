<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ExitRequest;
use App\Models\LeaveRequest;
use App\Models\Payment;
use App\Models\Rent;
use App\Models\SeatChangeRequest;
use App\Models\UserNotification;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('customer.dashboard', [
            'user' => $user->load(['branch', 'room', 'seat']),
            'latestRent' => Rent::where('user_id', $user->id)->latest()->first(),
            'payments' => Payment::where('user_id', $user->id)->latest()->take(5)->get(),
            'seatChangeRequests' => SeatChangeRequest::where('user_id', $user->id)->latest()->take(5)->get(),
            'leaveRequests' => LeaveRequest::where('user_id', $user->id)->latest()->take(5)->get(),
            'exitRequests' => ExitRequest::where('user_id', $user->id)->latest()->take(5)->get(),
            'announcements' => Announcement::latest()->take(5)->get(),
            'notifications' => UserNotification::where('user_id', $user->id)->latest()->take(5)->get(),
            'unreadNotificationCount' => UserNotification::where('user_id', $user->id)->whereNull('read_at')->count(),
        ]);
    }
}