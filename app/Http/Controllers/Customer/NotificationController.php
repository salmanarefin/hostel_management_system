<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('customer.notifications.index', compact('notifications'));
    }

    public function unreadCount()
    {
        $count = UserNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        $latest = UserNotification::where('user_id', auth()->id())
            ->latest()
            ->first();

        return response()->json([
            'count' => $count,
            'latest_title' => $latest?->title,
            'latest_message' => $latest?->message,
        ]);
    }

    public function markAsRead(UserNotification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update([
            'read_at' => now(),
        ]);

        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return redirect()
            ->route('customer.notifications.index')
            ->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        UserNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        return redirect()
            ->route('customer.notifications.index')
            ->with('success', 'All notifications marked as read.');
    }
}