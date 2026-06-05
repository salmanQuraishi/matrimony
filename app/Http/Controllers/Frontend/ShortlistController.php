<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;
use App\Models\User;
use App\Http\Controllers\Api\MethodController;

class ShortlistController extends Controller
{
    public function index(Request $request)
    {
        $user = session('user_data');
        
        // Retrieve shortlisted/liked users directly from the relation
        $userModel = User::find($user['id']);
        $likedUsers = $userModel->likes;

        // Reuse MethodController's formatter to keep logic centralized
        $formattedUsers = MethodController::formatUserCollectionResponse($likedUsers);

        return view('frontend.user.shortlist', [
            'shortlisted' => $formattedUsers,
        ]);
    }

    public function toggle(Request $request, $likedId)
    {
        $token = session('user_token');
        
        $response = InternalApi::call('POST', '/api/update/like-user', [
            'liked_id' => $likedId
        ], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', $response['message'] ?? 'Shortlist updated.');
        }

        return back()->with('error', $response['message'] ?? 'Failed to update shortlist.');
    }
}
