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
                'father_name' => $user->father_name ?? null,
                'mother_name' => $user->mother_name ?? null,
                'brothers' => $user->brothers ?? null,
                'sisters' => $user->sisters ?? null,
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
                'complexion' => $user->complexion ?? null,
            ];
        })->values();
    }

    public static function formatUserResponse($user)
    {
        $user = User::with('complexion', 'profileFor', 'education', 'occupation', 'annualIncome', 'jobType', 'companyType', 'religion', 'caste', 'state', 'city', 'galleries')->where('id', $user)->first();

        $profileCompletion = self::profileCompletion($user->id);

        return [
            'id' => $user->id,
            'profile_completion' => $profileCompletion,
            'dummyid' => $user->dummyid ?? null,
            'name' => $user->name ?? null,
            'father_name' => $user->father_name ?? null,
            'mother_name' => $user->mother_name ?? null,
            'brothers' => $user->brothers ?? null,
            'sisters' => $user->sisters ?? null,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'age' => $user->age ?? 0,
            'dob' => $user->dob ?? 0,
            'height' => $user->height ?? 0,
            'weight' => $user->weight ?? 0,
            'myself' => $user->myself ?? null,
            'profile' => $user->profile ?? null,
            'birthplace' => $user->birthplace ?? null,
            'address' => $user->address ?? null,
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
            'complexion' => $user->complexion ?? null,
        ];
    }

    public static function profileCompletion($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return 0;
        }

        $fields = [
            'company_type_id',
            'job_type_id',
            'annual_income_id',
            'occupation_id',
            'caste_id',
            'religion_id',
            'education_id',
            'profile_for',
            'city_id',
            'state_id',
            'complexion_id',
            'name',
            'father_name',
            'mother_name',
            'dummyid',
            'email',
            'mobile',
            'age',
            'dob',
            'birthplace',
            'height',
            'weight',
            'myself',
            'address',
            'profile',
            'gender',
        ];

        $totalFields = count($fields);
        $filledFields = 0;

        foreach ($fields as $field) {
            if ($user->$field !== null && $user->$field !== '') {
                $filledFields++;
            }
        }

        return round(($filledFields / $totalFields) * 100);
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