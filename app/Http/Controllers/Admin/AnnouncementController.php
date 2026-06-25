<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        $customers = User::where('role', 'customer')->get();

        foreach ($customers as $customer) {
            UserNotification::create([
                'user_id' => $customer->id,
                'type' => 'announcement',
                'title' => 'New Announcement: ' . $announcement->title,
                'message' => Str::limit($announcement->message, 180),
                'action_url' => route('customer.dashboard'),
            ]);
        }

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully and customers notified.');
    }

    public function show(Announcement $announcement)
    {
        return redirect()->route('admin.announcements.index');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $announcement->update([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}