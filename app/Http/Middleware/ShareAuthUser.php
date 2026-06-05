<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\InternalApi;
use Illuminate\Support\Facades\View;

class ShareAuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Fetch website settings from API
        $settingsResponse = InternalApi::call('GET', '/api/get/settings');
        $settings = $settingsResponse['data'] ?? null;
        View::share('settings', $settings);

        $token = session('user_token');

        if ($token) {
            $response = InternalApi::call('GET', '/api/get-user', [], $token);

            if (isset($response['status']) && $response['status']) {
                $userData = $response['user'];
                
                // Share with all Blade views
                View::share('authUser', $userData);
                
                // Bind to request attributes and merge into inputs
                $request->attributes->set('authUser', $userData);
                $request->merge(['authUser' => $userData]);
                
                // Sync latest user details into session
                session(['user_data' => $userData]);
            } else {
                echo "GET_USER_FAIL_RESPONSE: " . json_encode($response) . "\n";
                // Invalid or expired token - clear session keys
                session()->forget(['user_token', 'user_data']);
            }
        }

        return $next($request);
    }
}
