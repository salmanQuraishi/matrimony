<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public static function formatUserResponse($user)
    {
        $user = User::with('profileFor','education','occupation','annualIncome','jobType','companyType','religion','caste')->where('id', $user)->first();
        
        return [
            'dummyid' => $user->dummyid ?? null,
            'name' => $user->name ?? null,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'age' => $user->age ?? 0,
            'dob' => $user->dob ?? 0,
            'height' => $user->height ?? 0,
            'weight' => $user->weight ?? 0,
            'myself' => $user->myself ?? null,
            'images' => json_decode($user->images) ?? null,
            'gender' => $user->gender ?? null,
            'profileFor' => $user->profileFor ?? null,
            'education' => $user->education ?? null,
            'occupation' => $user->occupation ?? null,
            'annualIncome' => $user->annualIncome ?? null,
            'jobType' => $user->jobType ?? null,
            'companyType' => $user->companyType ?? null,
            'relegion' => $user->religion ?? null,
            'caste' => $user->caste ?? null,
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

}