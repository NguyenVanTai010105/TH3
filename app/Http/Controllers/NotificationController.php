<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        // Redirect to the relevant question
        if (isset($notification->data['question_id'])) {
            return redirect()->route('questions.show', $notification->data['question_id']);
        }

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back()
            ->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc.');
    }

    public function getUnreadCount()
    {
        $count = auth()->user()->unreadNotifications->count();
        
        return response()->json([
            'count' => $count,
        ]);
    }
}