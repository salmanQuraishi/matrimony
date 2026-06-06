<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class HomeController extends Controller
{
    public function home()
    {
        // Fetch metadata for quick search
        $religions = InternalApi::call('GET', '/api/get/religion/list');
        $countries = InternalApi::call('GET', '/api/get/country/list');
        $profileFors = InternalApi::call('GET', '/api/get/profilefor/list');
        $complexions = InternalApi::call('GET', '/api/get/complexion/list');

        return view('frontend.home', [
            'religions' => $religions['data'] ?? [],
            'countries' => $countries['data'] ?? [],
            'profileFors' => $profileFors['data'] ?? [],
            'complexions' => $complexions['data'] ?? [],
        ]);
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function privacy()
    {
        return view('frontend.privacy');
    }

    public function terms()
    {
        return view('frontend.terms');
    }

    public function successStories()
    {
        return view('frontend.success-stories');
    }

    // Ajax helpers
    public function getCastes($religionId)
    {
        $response = InternalApi::call('GET', "/api/get/caste/list/{$religionId}");
        return response()->json($response);
    }

    public function getStates($countryId)
    {
        $response = InternalApi::call('GET', "/api/get/state/list/{$countryId}");
        return response()->json($response);
    }

    public function getCities($stateId)
    {
        $response = InternalApi::call('GET', "/api/get/city/list/{$stateId}");
        return response()->json($response);
    }
}
