<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function showAllAndMarkAsRead()
    {
        $user = Auth::user();

        // أولاً: تعليم جميع الإشعارات كمقروءة
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // ثانياً: جلب جميع الإشعارات بعد التحديث
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications, 200);
    }
}
