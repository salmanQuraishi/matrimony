<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\MethodController;
use Illuminate\Support\Facades\Validator;

class LikedController extends Controller
{
    public function likeUser(Request $request)
    {
        $request->validate([
            'liked_id' => 'required|exists:users,id',
        ]);

        $liker = Auth::user();
        $likedId = (int) $request->input('liked_id');

        if ($liker->id === $likedId) {
            return MethodController::errorResponse('You cannot like yourself.', 400);
        }

        $alreadyLiked = $liker->likes()->where('liked_id', $likedId)->exists();

        if ($alreadyLiked) {
            $liker->likes()->detach($likedId);
            return MethodController::successResponse('User unliked successfully', $likedId);
        } else {
            $liker->likes()->attach($likedId);
            return MethodController::successResponse('User liked successfully', $likedId);
        }
    }
}
