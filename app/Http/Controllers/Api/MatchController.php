<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\MethodController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MatchController extends Controller
{
    public function getRelevantUsers(Request $request)
    {
        $user = Auth::user();

        $profileCompletion = MethodController::profileCompletion($user->id);

        if($profileCompletion < 50) {
            return MethodController::errorResponse('Please complete your profile at least 50% to view matches.', 403);
        }

        $sentInterestUserIds = DB::table('interests')
        ->where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })
        ->whereIn('status', ['pending', 'accepted'])
        ->get(['sender_id', 'receiver_id'])
        ->flatMap(fn($row) => [$row->sender_id, $row->receiver_id])
        ->unique()
        ->values()
        ->toArray();

        $notInterestUserIds = DB::table('not_interests')
        ->where('user_id', $user->id)
        ->pluck('not_interest_user_id')
        ->toArray();

        // Get IDs of users the authenticated user has liked
        $likedUserIds = $user->likes()->pluck('users.id')->toArray();

        // Fetch matched users with filters
        $matches = User::where('id', '!=', $user->id)
        
            ->whereNotIn('id', $sentInterestUserIds)
            
            ->whereNotIn('id', $notInterestUserIds)

            ->when(!is_null($user->gender), function ($query) use ($user) {
                return $query->where('gender', '!=', $user->gender);
            })
            ->when(!is_null($user->religion_id), function ($query) use ($user) {
                return $query->where('religion_id', $user->religion_id);
            })
            // ->when(!is_null($user->caste_id), function ($query) use ($user) {
            //     return $query->where('caste_id', $user->caste_id);
            // })
            ->when($request->state, function ($query) use ($request) {
                return $query->where('state_id', $request->state);
            })
            ->when($request->city, function ($query) use ($request) {
                return $query->where('city_id', $request->city);
            })
            ->when($request->age_min, function ($query) use ($request) {
                return $query->where('age', '>=', $request->age_min);
            })
            ->when($request->age_max, function ($query) use ($request) {
                return $query->where('age', '<=', $request->age_max);
            })
            ->get()
            ->map(function ($matchedUser) use ($likedUserIds) {
                $matchedUser->is_liked = in_array($matchedUser->id, $likedUserIds) ? true : false;
                return $matchedUser;
            });

        if ($matches->isEmpty()) {
            return MethodController::errorResponse('Matches Data not found', 404);
        }

        return MethodController::successResponse(
            'Matches Data',
            MethodController::formatUserCollectionResponse($matches)
        );
    }
    public function getRelevantUserDetails($user)
    {

        try {
            $validator = Validator::make(
            ['user' => $user],
            ['user' => ['required', 'integer', 'exists:users,id']]
            );

            if ($validator->fails()) {
                return MethodController::errorResponse($validator->errors()->first(), 422);
            }

            $userData = User::find($user);
            $formattedData = MethodController::formatUserResponse($userData->id);

            // Fetch interest status between authenticated user and target user
            $authUserId = auth()->id();
            $interest = DB::table('interests')
                ->where(function($query) use ($authUserId, $user) {
                    $query->where('sender_id', $authUserId)->where('receiver_id', $user);
                })
                ->orWhere(function($query) use ($authUserId, $user) {
                    $query->where('sender_id', $user)->where('receiver_id', $authUserId);
                })
                ->first();

            $isLiked = false;
            if ($authUserId) {
                $isLiked = DB::table('user_likes')
                    ->where('liker_id', $authUserId)
                    ->where('liked_id', $user)
                    ->exists();
            }

            $formattedData['interest_id'] = $interest ? $interest->id : null;
            $formattedData['interest_status'] = $interest ? $interest->status : null;
            $formattedData['interest_sender_id'] = $interest ? $interest->sender_id : null;
            $formattedData['is_liked'] = $isLiked;

            return MethodController::successResponse('Matches Data', $formattedData);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }

    }

}