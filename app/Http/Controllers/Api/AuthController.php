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
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\MethodController;
use App\Models\Gallery;
use App\Models\Interest;
use App\Models\InterestNot;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required',
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
                'fcm_token' => $request->fcm_token,
                'dummyid' => MethodController::generateUniqueDummyId('WEB', 6),
                'profile_for' => $request->profile_for,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Registration successful',
                'token' => $token,
                'user' => [
                    'dummyid' => $user->dummyid,
                    'name'  => $user->name,
                    'mobile' => $user->mobile,
                ],
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
            'fcm_token' => 'required',
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

        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'dummyid' => $user->dummyid,
                'name'  => $user->name,
                'mobile' => $user->mobile,
            ],
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

            $user = $request->user();

            $request->validate([
                'dob' => 'required', 'date',
                'age' => 'required', 'integer', 'min:0',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'gender' => 'required', 'in:male,female,other',
            ]);

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
                'state' => ['required','integer','exists:state,sid'],                
                'city' => ['required','integer','exists:city,cityid'],
            ]);

            $user = $request->user();

            $user->height = $request->height;
            $user->weight = $request->weight;
            $user->state_id = $request->state;
            $user->city_id = $request->city;
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
                'images' => 'nullable',
                'images.*' => 'image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            ]);

            $user = $request->user();

            $profile = $user->profile;

            $user->myself = $validated['myself'];
            if($request->images){

                if (!empty($profile) && file_exists(public_path($profile))) {
                    unlink(public_path($profile));
                }

                $img = "profile/".rand(99999,9999999).time().'.'.$request->images->extension(); 
                $request->images->move(public_path('profile/'), $img);
                $user->profile = $img;
            }else{
                $user->profile = $profile;
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
    public function updateGallery(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $validated = $request->validate([
                'images' => 'nullable',
                'images.*' => 'image|mimes:jpg,jpeg,png,webp,svg',
            ]);

            $userId = $request->user()->id;

            // print_r($request->images);
            // return;

            if (!empty($request->images)) {
                foreach ($request->images as $image) {
                    $imgName = "profile/" . rand(99999, 9999999) . time() . '.' . $image->extension(); 
                    $image->move(public_path('profile/'), $imgName);

                    Gallery::create([
                        'user_id'    => $userId,
                        'image_path' => $imgName,
                    ]);
                }
            }

            return response()->json([
                'status'  => true,
                'message' => 'Gallery updated successfully.',
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
    public function getUser(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            return response()->json([
                'status'  => true,
                'message' => 'User Data',
                'user' => MethodController::formatUserResponse($user->id),
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
    public function Home(Request $request)
    {
        try {
            $request->headers->set('Accept', 'application/json');

            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            $likesCount           = $user->likedBy()->count();
            $sendRequestCount     = Interest::where('sender_id', $user->id)->count();
            $receivedRequestCount = Interest::where('receiver_id', $user->id)->count();
            $notInterestedCount   = InterestNot::where('user_id', $user->id)->count();
            
            return response()->json([
                'status'  => true,
                'message' => 'User Data',
                'data' => [
                    'total_likes'             => $likesCount,
                    'sent_requests'     => $sendRequestCount,
                    'received_requests' => $receivedRequestCount,
                    'not_interested'    => $notInterestedCount,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => 'An unexpected error occurred.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Logged out'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Already logged out or not authenticated'
        ], 401);
    }

}