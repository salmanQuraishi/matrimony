<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public static function formatUserResponse($user)
    {
        $user = User::with('profileFor','education','occupation','annualIncome','jobType','companyType','religion','caste')->where('id', $user)->first();
        
        return [
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
}