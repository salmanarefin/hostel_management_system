<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Branch;
use App\Models\ExitRequest;
use App\Models\LeaveRequest;
use App\Models\Payment;
use App\Models\Rent;
use App\Models\Room;
use App\Models\Seat;
use App\Models\SeatChangeRequest;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalCustomers' => User::where('role', 'customer')->count(),
            'totalBranches' => Branch::count(),
            'totalRooms' => Room::count(),
            'totalSeats' => Seat::count(),
            'availableSeats' => Seat::where('status', 'available')->count(),
            'bookedSeats' => Seat::where('status', 'booked')->count(),
            'pendingSeatChanges' => SeatChangeRequest::where('status', 'pending')->count(),
            'pendingLeaves' => LeaveRequest::where('status', 'pending')->count(),
            'pendingExits' => ExitRequest::where('status', 'pending')->count(),
            'pendingPayments' => Payment::where('status', 'pending')->count(),
            'dueRents' => Rent::where('status', 'due')->count(),
            'announcements' => Announcement::latest()->take(5)->get(),
        ]);
    }
}