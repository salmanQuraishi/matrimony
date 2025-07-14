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

        $sentInterestUserIds = DB::table('interests')
        ->where('sender_id', $user->id)
        ->whereIn('status', ['pending', 'accepted'])
        ->pluck('receiver_id')
        ->toArray();

        // Get IDs of users the authenticated user has liked
        $likedUserIds = $user->likes()->pluck('users.id')->toArray();

        // Fetch matched users with filters
        $matches = User::where('id', '!=', $user->id)
        
            ->whereNotIn('id', $sentInterestUserIds)

            ->when(!is_null($user->gender), function ($query) use ($user) {
                return $query->where('gender', '!=', $user->gender);
            })
            ->when(!is_null($user->religion_id), function ($query) use ($user) {
                return $query->where('religion_id', $user->religion_id);
            })
            ->when(!is_null($user->caste_id), function ($query) use ($user) {
                return $query->where('caste_id', $user->caste_id);
            })
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

            return MethodController::successResponse('Matches Data', MethodController::formatUserResponse($userData->id));

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }

    }

}