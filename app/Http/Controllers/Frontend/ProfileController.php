<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('frontend.user.profile');
    }

    public function edit(Request $request)
    {
        $token = session('user_token');
        $user = session('user_data');

        // Fetch lists for editing
        $complexions = InternalApi::call('GET', '/api/get/complexion/list');
        $religions = InternalApi::call('GET', '/api/get/religion/list');
        $educations = InternalApi::call('GET', '/api/get/education/list');
        $occupations = InternalApi::call('GET', '/api/get/occupation/list');
        $annualIncomes = InternalApi::call('GET', '/api/get/annual/income/list');
        $jobTypes = InternalApi::call('GET', '/api/get/job/type/list');
        $companyTypes = InternalApi::call('GET', '/api/get/company/type/list');
        $countries = InternalApi::call('GET', '/api/get/country/list');

        // Fetch states for user's country if set
        $states = [];
        if (!empty($user['country']['id'])) {
            $statesResponse = InternalApi::call('GET', "/api/get/state/list/" . $user['country']['id']);
            $states = $statesResponse['data'] ?? [];
        }

        // Fetch castes for user's religion if set
        $castes = [];
        if (!empty($user['relegion']['rid'])) {
            $castesResponse = InternalApi::call('GET', "/api/get/caste/list/" . $user['relegion']['rid']);
            $castes = $castesResponse['data'] ?? [];
        }

        // Fetch cities for user's state if set
        $cities = [];
        if (!empty($user['state']['sid'])) {
            $citiesResponse = InternalApi::call('GET', "/api/get/city/list/" . $user['state']['sid']);
            $cities = $citiesResponse['data'] ?? [];
        }

        return view('frontend.user.edit', [
            'complexions' => $complexions['data'] ?? [],
            'religions' => $religions['data'] ?? [],
            'educations' => $educations['data'] ?? [],
            'occupations' => $occupations['data'] ?? [],
            'annualIncomes' => $annualIncomes['data'] ?? [],
            'jobTypes' => $jobTypes['data'] ?? [],
            'companyTypes' => $companyTypes['data'] ?? [],
            'countries' => $countries['data'] ?? [],
            'states' => $states,
            'castes' => $castes,
            'cities' => $cities,
        ]);
    }

    public function updateBasic(Request $request)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', '/api/update-basic', $request->all(), $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Basic details updated successfully!');
        }

        return $this->handleErrors($response);
    }

    public function updateReligion(Request $request)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', '/api/update-religion', $request->all(), $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Religion details updated successfully!');
        }

        return $this->handleErrors($response);
    }

    public function updatePersonal(Request $request)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', '/api/update-personal', $request->all(), $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Personal details updated successfully!');
        }

        return $this->handleErrors($response);
    }

    public function updateProfessional(Request $request)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', '/api/update-professional', $request->all(), $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Professional details updated successfully!');
        }

        return $this->handleErrors($response);
    }

    public function updateAbout(Request $request)
    {
        $token = session('user_token');
        
        $files = [];
        if ($request->hasFile('images')) {
            $files['images'] = $request->file('images');
        }

        $response = InternalApi::call('POST', '/api/update-about', $request->only('myself'), $token, $files);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'About details & profile picture updated successfully!');
        }

        return $this->handleErrors($response);
    }

    public function updateGallery(Request $request)
    {
        $token = session('user_token');
        
        $files = [];
        if ($request->hasFile('images')) {
            $files['images'] = $request->file('images');
        }

        $response = InternalApi::call('POST', '/api/update-gallery', [], $token, $files);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Gallery photos uploaded successfully!');
        }

        return $this->handleErrors($response);
    }

    private function handleErrors($response)
    {
        $errors = [];
        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $errors[$field] = $messages[0] ?? 'Validation error.';
            }
        } else {
            $errors['form'] = $response['message'] ?? 'Profile update failed.';
        }

        return back()->withErrors($errors)->withInput();
    }
}
