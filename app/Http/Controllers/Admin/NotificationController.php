<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function unread()
    {
        $notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Notification',
                    'message' => $notification->data['message'] ?? '',
                    'url' => $notification->data['url'] ?? '#',
                    'type' => $notification->data['type'] ?? 'general',
                    'sound' => $notification->data['sound'] ?? 'notification.mp3',
                    'created_at' => $notification->data['created_at'] ?? '',
                ];
            });

        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'status' => true,
        ]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update([
            'read_at' => now()
        ]);

        return response()->json([
            'status' => true,
        ]);
    }
}
