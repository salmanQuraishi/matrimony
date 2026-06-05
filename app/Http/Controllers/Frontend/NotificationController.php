<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $token = session('user_token');
        
        $response = InternalApi::call('GET', '/api/get-user-notification', [], $token);
        $notifications = [];
        
        if (isset($response['status']) && $response['status']) {
            $notifications = $response['data'] ?? [];
        }

        return view('frontend.user.notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', '/api/user-notification-read', [], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'All notifications marked as read.');
        }

        return back()->with('error', $response['message'] ?? 'No unread notifications.');
    }
}
