<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $token = session('user_token');
        
        // Fetch states for filter dropdown
        $states = InternalApi::call('GET', '/api/get/state/list');

        // Fetch matches using filters passed in request
        $response = InternalApi::call('GET', '/api/get/matches', $request->only('state', 'city', 'age_min', 'age_max'), $token);
        
        $matches = [];
        if (isset($response['status']) && $response['status']) {
            $matches = $response['data'] ?? [];
        }

        // Fetch cities for currently selected state in filter
        $cities = [];
        if ($request->filled('state')) {
            $citiesResponse = InternalApi::call('GET', "/api/get/city/list/" . $request->state);
            $cities = $citiesResponse['data'] ?? [];
        }

        return view('frontend.user.matches', [
            'matches' => $matches,
            'states' => $states['data'] ?? [],
            'cities' => $cities,
            'filters' => $request->all(),
        ]);
    }

    public function show($id)
    {
        $token = session('user_token');
        
        // Fetch profile details
        $response = InternalApi::call('GET', "/api/get/matches/details/{$id}", [], $token);
        
        if (!isset($response['status']) || !$response['status']) {
            return redirect()->route('user.matches')->with('error', $response['message'] ?? 'Profile not found.');
        }

        return view('frontend.user.view-profile', [
            'profile' => $response['data'] ?? [],
        ]);
    }

    public function search(Request $request)
    {
        $token = session('user_token');
        $search = $request->query('query');
        
        $users = [];
        if ($search) {
            $response = InternalApi::call('GET', "/api/search/users", ['search' => $search], $token);
            if (isset($response['status']) && $response['status']) {
                $users = $response['data'] ?? [];
            }
        }

        return view('frontend.user.search-results', [
            'users' => $users,
            'search' => $search,
        ]);
    }
}
