<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class MethodController extends Controller
{
    public static function formatUserCollectionResponse($users)
    {
        return $users->map(function ($user) {
            return [
                'likes' => $user->likedBy()->count(),
                'is_liked' => $user->is_liked ?? 0,
                'id' => $user->id,
                'dummyid' => $user->dummyid ?? null,
                'name' => $user->name ?? null,
                'email' => $user->email ?? null,
                'mobile' => $user->mobile ?? null,
                'age' => $user->age ?? 0,
                'dob' => $user->dob ?? 0,
                'height' => $user->height ?? 0,
                'weight' => $user->weight ?? 0,
                'myself' => $user->myself ?? null,
                'profile' => $user->profile ?? null,
                'gender' => $user->gender ?? null,
                'profileFor' => $user->profileFor ?? null,
                'education' => $user->education ?? null,
                'occupation' => $user->occupation ?? null,
                'annualIncome' => $user->annualIncome ?? null,
                'jobType' => $user->jobType ?? null,
                'companyType' => $user->companyType ?? null,
                'relegion' => $user->religion ?? null,
                'caste' => $user->caste ?? null,
                'state' => $user->state ?? null,
                'city' => $user->city ?? null,
                'galleries' => $user->galleries ?? null,
            ];
        })->values();
    }

    public static function formatUserResponse($user)
    {
        $user = User::with('profileFor','education','occupation','annualIncome','jobType','companyType','religion','caste','state','city','galleries')->where('id', $user)->first();
        
        return [
            'id' => $user->id,
            'dummyid' => $user->dummyid ?? null,
            'name' => $user->name ?? null,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'age' => $user->age ?? 0,
            'dob' => $user->dob ?? 0,
            'height' => $user->height ?? 0,
            'weight' => $user->weight ?? 0,
            'myself' => $user->myself ?? null,
            'profile' => $user->profile ?? null,
            'gender' => $user->gender ?? null,
            'profileFor' => $user->profileFor ?? null,
            'education' => $user->education ?? null,
            'occupation' => $user->occupation ?? null,
            'annualIncome' => $user->annualIncome ?? null,
            'jobType' => $user->jobType ?? null,
            'companyType' => $user->companyType ?? null,
            'relegion' => $user->religion ?? null,
            'caste' => $user->caste ?? null,
            'state' => $user->state ?? null,
            'city' => $user->city ?? null,
            'galleries' => $user->galleries ?? null,
        ];
    }
    public static function generateUniqueDummyId($prefix = 'WEB', $length = 6)
    {
        do {
            $randomNumber = str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
            $dummyId = $prefix . $randomNumber;
        } while (
            User::where('dummyid', $dummyId)->exists()
        );
        return $dummyId;
    }
    public static function successResponse($message, $data)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }
    public static function successResponseSimple($message)
    {
        return response()->json([
            'status' => true,
            'message' => $message
        ], 200);
    }

    public static function errorResponse($message = 'Something went wrong', $status = 404)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $status);
    }

}