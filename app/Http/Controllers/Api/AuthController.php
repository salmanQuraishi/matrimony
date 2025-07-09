<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\UserController;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_for' => 'required|exists:profile_types,ptid',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,mobile',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::create([
                'profile_for' => $request->profile_for,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Registration successful',
                'token' => 'Bearer ' . $token,
                'user' => UserController::formatUserResponse($user->id),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits_between:10,15',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $mobile = $request->mobile;
        $throttleKey = Str::lower($mobile) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return response()->json([
                'status' => false,
                'message' => 'Too many login attempts. Try again in ' . RateLimiter::availableIn($throttleKey) . ' seconds.',
            ], 429);
        }

        $user = User::where('mobile', $mobile)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            return response()->json([
                'status' => false,
                'message' => 'Invalid login credentials',
            ], 401);
        }

        if ($user->id === 1) {
            return response()->json([
                'status' => false,
                'message' => 'Only non-admin users are allowed to log in.',
            ], 403);
        }

        RateLimiter::clear($throttleKey);

        $token = $user->createToken('api_token', ['*'])->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => 'Bearer ' . $token,
            'user' => UserController::formatUserResponse($user->id),
        ]);
    }
    public function changePassword(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user = $request->user();

            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['The current password is incorrect.'],
                ]);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully.',
            ],200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }

    public function updateBasic(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $request->validate([
                'dob' => ['required', 'date'],
                'age' => ['required', 'integer', 'min:0'],
                'email' => ['required','email'],
                'gender' => ['required', 'in:male,female,other'],
            ]);

            $user = $request->user();

            $user->age = $request->age;
            $user->dob = date('Y-m-d', strtotime($request->dob));
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Basic details updated successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }
    public function updateReligion(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $request->validate([
                'religion' => ['required'],
                'caste' => ['required']
            ]);

            $user = $request->user();

            $user->religion_id = $request->religion;
            $user->caste_id = $request->caste;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Religion details updated successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }
    public function updatePersonal(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $request->validate([
                'height' => ['required', 'numeric', 'min:0'],
                'weight' => ['required', 'numeric', 'min:0'],
            ]);

            $user = $request->user();

            $user->height = $request->height;
            $user->weight = $request->weight;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Personal details updated successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }
    public function updateProfessional(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $validated = $request->validate([
                'education' => 'required|integer|exists:educations,eid',
                'jobtype' => 'required|integer|exists:job_types,jtid',
                'companytype' => 'required|integer|exists:company_types,ctid',
                'occupation' => 'required|integer|exists:occupations,oid',
                'annualincome' => 'required|integer|exists:annual_incomes,aid',
            ]);

            $user = $request->user();

            $user->education_id       = $validated['education'];
            $user->job_type_id        = $validated['jobtype'];
            $user->company_type_id    = $validated['companytype'];
            $user->occupation_id      = $validated['occupation'];
            $user->annual_income_id   = $validated['annualincome'];
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'Professional details updated successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error'  => 'An unexpected error occurred.',
            ], 500);
        }
    }
    public function updateAbout(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $validated = $request->validate([
                'myself' => 'required|string|min:20|max:100',
                'images' => 'required',
                'images.*' => 'image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            ]);

            $user = $request->user();
            $user->myself = $validated['myself'];
            if($request->images){
                $img = "profile/".rand(99999,9999999).time().'.'.$request->images->extension(); 
                $request->images->move(public_path('profile/'), $img);
                $user->images = json_encode($img);
            }
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'Profile details updated successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error'  => 'An unexpected error occurred.',
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

}