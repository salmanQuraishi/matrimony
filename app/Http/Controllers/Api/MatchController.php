<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\MethodController;

class MatchController extends Controller
{
    public function getRelevantUsers(Request $request)
    {
        $user = Auth::user();

        $matches = User::where('id', '!=', $user->id)
            ->when($user->gender, function ($query) use ($user) {
                return $query->where('gender', '!=', $user->gender);
            })
            ->when($user->religion, function ($query) use ($user) {
                return $query->where('religion_id', $user->religion_id);
            })
            ->when($user->caste, function ($query) use ($user) {
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
            ->get();

if ($matches->isEmpty()) {
    return MethodController::errorResponse('Matches Data not found', 404);
}


        // return response()->json([
        //     'data' => $matches
        // ]);
        return MethodController::successResponse('Matches Data', $matches);
    }
}