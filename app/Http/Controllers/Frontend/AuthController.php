<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user_token')) {
            return redirect()->route('user.dashboard');
        }
        return view('frontend.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'password' => 'required',
        ]);

        $response = InternalApi::call('POST', '/api/login', [
            'mobile' => $request->mobile,
            'password' => $request->password,
            'fcm_token' => 'web_browser_session_token_' . time(),
        ]);

        if (isset($response['status']) && $response['status']) {
            session([
                'user_token' => $response['token'],
                'user_data' => $response['user'],
            ]);

            return redirect()->route('user.dashboard')->with('success', 'Logged in successfully!');
        }

        $message = $response['message'] ?? 'Invalid login credentials.';
        return back()->withErrors(['mobile' => $message])->withInput();
    }

    public function showRegister()
    {
        if (session('user_token')) {
            return redirect()->route('user.dashboard');
        }
        
        $profileFors = InternalApi::call('GET', '/api/get/profilefor/list');
        
        return view('frontend.register', [
            'profileFors' => $profileFors['data'] ?? [],
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'profile_for' => 'required',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|regex:/^[0-9]{10,15}$/',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $response = InternalApi::call('POST', '/api/register', [
            'profile_for' => $request->profile_for,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'fcm_token' => 'web_browser_session_token_' . time(),
        ]);

        if (isset($response['status']) && $response['status']) {
            session([
                'user_token' => $response['token'],
                'user_data' => $response['user'],
            ]);

            return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome to Matrimony.');
        }

        $errors = [];
        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $errors[$field] = $messages[0] ?? 'Validation error.';
            }
        } else {
            $errors['mobile'] = $response['message'] ?? 'Registration failed.';
        }

        return back()->withErrors($errors)->withInput();
    }

    public function logout(Request $request)
    {
        $token = session('user_token');
        
        if ($token) {
            InternalApi::call('POST', '/api/logout', [], $token);
        }

        session()->forget(['user_token', 'user_data']);

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $token = session('user_token');
        $response = InternalApi::call('POST', '/api/change-password', [
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Password changed successfully!');
        }

        $errors = [];
        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $errors[$field] = $messages[0] ?? 'Error changing password.';
            }
        } else {
            $errors['current_password'] = $response['message'] ?? 'Password change failed.';
        }

        return back()->withErrors($errors);
    }
}
