<?php

namespace App\Services;

use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

class InternalApi
{
    /**
     * Dispatch an internal request to the Laravel API.
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param string|null $token
     * @param array $files
     * @return array
     */
    public static function call($method, $uri, array $data = [], $token = null, array $files = [])
    {
        // 1. Backup the original request and auth state to prevent leaks
        $originalRequest = app('request');
        $originalUser = auth()->user();
        $originalSanctumUser = auth('sanctum')->user();

        // Ensure uri starts with /api/
        if (!str_starts_with($uri, '/api')) {
            $uri = '/api/' . ltrim($uri, '/');
        }

        // Create a simulated request for the sub-request context, preserving the original host/port/scheme
        $server = [];
        if ($originalRequest) {
            $server = array_intersect_key($originalRequest->server->all(), array_flip([
                'HTTP_HOST', 'HTTP_USER_AGENT', 'HTTP_ACCEPT', 'HTTP_ACCEPT_LANGUAGE', 'HTTP_ACCEPT_ENCODING',
                'SERVER_NAME', 'SERVER_PORT', 'SERVER_ADDR', 'REMOTE_ADDR', 'REQUEST_SCHEME', 'HTTPS', 'SERVER_PROTOCOL'
            ]));
        }

        $request = LaravelRequest::create($uri, $method, $data, [], $files, $server);
        $request->headers->set('Accept', 'application/json');
        
        if ($token) {
            $request->headers->set('Authorization', 'Bearer ' . $token);

            // Resolve Sanctum user and force-bind it to guards for internal request context
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken && $accessToken->tokenable) {
                $user = $accessToken->tokenable;
                
                // Force authenticate on both the default guard and sanctum guard
                auth()->setUser($user);
                auth('sanctum')->setUser($user);
            }
        } else {
            // Safely clear the resolved user from the guard instances for the sub-request
            if (method_exists(auth(), 'forgetUser')) {
                auth()->forgetUser();
            }
            if (method_exists(auth('sanctum'), 'forgetUser')) {
                auth('sanctum')->forgetUser();
            }
        }

        // 2. Handle the request through the kernel/router
        $response = app()->handle($request);

        // 3. Restore the container to its original state (original request and auth)
        app()->instance('request', $originalRequest);
        if ($originalRequest) {
            app('url')->setRequest($originalRequest);
        }

        if ($originalUser) {
            auth()->setUser($originalUser);
        } else {
            if (method_exists(auth(), 'forgetUser')) {
                auth()->forgetUser();
            }
        }

        if ($originalSanctumUser) {
            auth('sanctum')->setUser($originalSanctumUser);
        } else {
            if (method_exists(auth('sanctum'), 'forgetUser')) {
                auth('sanctum')->forgetUser();
            }
        }
        
        return json_decode($response->getContent(), true);
    }
}
