<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::where('user_id', Auth::id())->with('notification')->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $userNotification = UserNotification::where('user_id', Auth::id())->where('id', $id)->first();
        if ($userNotification) {
            $userNotification->read_status = 'read';
            $userNotification->save();
        }
        return redirect()->back();
    }
}
