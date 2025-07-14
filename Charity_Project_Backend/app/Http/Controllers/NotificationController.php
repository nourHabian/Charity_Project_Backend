<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function showAllAndMarkAsRead()
    {
        $user = Auth::user();
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        Carbon::setLocale('ar');
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {

                $relativeTime = $notification->created_at->diffForHumans();
                if ($notification->created_at->diffInSeconds() < 60) {
                    $relativeTime = 'الآن';
                }

                return [
                    'id'            => $notification->id,
                    'title'         => $notification->title,
                    'message'       => $notification->message,
                    'is_read'       => $notification->is_read,
                    'sent_at'       => $relativeTime,
                ];
            });


        return response()->json(['notifications' => $notifications], 200);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount], 200);
    }

}
