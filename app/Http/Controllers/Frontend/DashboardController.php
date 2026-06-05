<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $token = session('user_token');
        
        // Fetch stats
        $statsResponse = InternalApi::call('GET', '/api/home', [], $token);
        $stats = $statsResponse['data'] ?? [
            'unread_notification' => 0,
            'total_likes' => 0,
            'sent_requests' => 0,
            'received_requests' => 0,
            'not_interested' => 0,
        ];

        // Override total_likes to show profiles this user has liked/shortlisted
        $userSession = session('user_data');
        if (!empty($userSession['id'])) {
            $userModel = \App\Models\User::find($userSession['id']);
            if ($userModel) {
                $stats['total_likes'] = $userModel->likes()->count();
            }
        }

        // Fetch a few recommended matches
        $matchesResponse = InternalApi::call('GET', '/api/get/matches', [], $token);
        $matches = $matchesResponse['data'] ?? [];
        
        // Limit to 4 for the dashboard overview
        $matches = array_slice($matches, 0, 4);

        return view('frontend.user.dashboard', [
            'stats' => $stats,
            'matches' => $matches,
        ]);
    }
}
