<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Religion;
use App\Models\ProfileType;
use App\Models\CompanyType;
use App\Models\JobType;
use App\Models\AnnualIncome;
use App\Models\Caste;
use App\Models\City;
use App\Models\Complexion;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\State;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('religion', 'caste')->where('id', '!=', 1)->get();
        return view('user.index', compact('users'));
    }

    public function edit($id)
    {
        $religions = Religion::where('status', 'show')
            ->select('rid as id', 'name')
            ->get();

        $States = State::where('status', 'active')
            ->select('sid as id', 'name')
            ->get();

        $ProfileTypes = ProfileType::where('status', 'show')
            ->select('ptid as id', 'name')
            ->get();

        $CompanyType = CompanyType::where('status', 'show')
            ->select('ctid as id', 'name')
            ->get();

        $JobType = JobType::where('status', 'show')
            ->select('jtid as id', 'name')
            ->get();

        $AnnualIncome = AnnualIncome::where('status', 'show')
            ->select('aid as id', 'range as name')
            ->get();

        $Occupation = Occupation::where('status', 'show')
            ->select('oid as id', 'name')
            ->get();

        $Education = Education::where('status', 'show')
            ->select('eid as id', 'name')
            ->get();

        $Complexions = Complexion::where('status', 'show')
            ->select('id', 'name', 'hindi_name')
            ->get()
            ->map(function ($item) {
                $item->name = $item->name . ' (' . $item->hindi_name . ')';
                return $item;
            });

        $user = User::findOrFail($id);
        return view('user.view', compact('user', 'religions', 'States', 'ProfileTypes', 'CompanyType', 'JobType', 'AnnualIncome', 'Occupation', 'Education', 'Complexions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'profile_for' => 'required',
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits_between:10,15',
            'myself' => 'nullable|string',
            'age' => 'required|numeric|min:1|max:100',
            'dob' => 'required|date',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:male,female,other',
            'religion_id' => 'required|exists:religions,rid',
            'caste_id' => 'nullable|exists:castes,cid',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'state_id' => 'required|exists:state,sid',
            'city_id' => 'required|exists:city,cityid',
            'education_id' => 'required|exists:educations,eid',
            'job_type_id' => 'nullable|exists:job_types,jtid',
            'company_type_id' => 'nullable|exists:company_types,ctid',
            'occupation_id' => 'nullable|exists:occupations,oid',
            'annual_income_id' => 'nullable|exists:annual_incomes,aid',
            'profile_image' => 'nullable',
            'profile_image.*' => 'image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'brothers' => 'nullable|integer|min:0',
            'sisters' => 'nullable|integer|min:0',
            'birthplace' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'complexion_id' => 'nullable|exists:castes,cid',
        ]);

        if ($request->profile_image) {
            $profile = $user->profile;
            if (!empty($profile) && file_exists(public_path($profile))) {
                unlink(public_path($profile));
            }
            $imgName = rand(99999, 9999999) . time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('profile'), $imgName);
            $user->profile = 'profile/' . $imgName;
        }

        $user->profile_for = $request->input('profile_for');
        $user->name = trim($request->input('name'));
        $user->mobile = $request->input('mobile');
        $user->myself = $request->input('myself');
        $user->age = $request->input('age');
        $user->dob = date('Y-m-d', strtotime($request->input('dob')));
        $user->email = strtolower($request->input('email'));
        $user->gender = $request->input('gender');
        $user->religion_id = $request->input('religion_id');
        $user->caste_id = $request->input('caste_id');
        $user->height = $request->input('height');
        $user->weight = $request->input('weight');
        $user->state_id = $request->input('state_id');
        $user->city_id = $request->input('city_id');
        $user->education_id = $request->input('education_id');
        $user->job_type_id = $request->input('job_type_id');
        $user->company_type_id = $request->input('company_type_id');
        $user->occupation_id = $request->input('occupation_id');
        $user->annual_income_id = $request->input('annual_income_id');
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->brothers = $request->brothers;
        $user->sisters = $request->sisters;
        $user->birthplace = $request->birthplace;
        $user->address = $request->address;
        $user->complexion_id = $request->complexion_id;

        $user->save();

        return redirect()->route('user.edit', $user->id)->with('success', 'User updated successfully.');
    }

    public function gallery($userid)
    {
        $gallery = Gallery::where('user_id', $userid)->get();

        return view('gallery.index', compact('gallery', 'userid'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1000, 9999) . '.' . $image->extension();
 
                $image->move(public_path('gallery'), $imageName);

                Gallery::create([
                    'user_id' => $id,
                    'image_path' => 'gallery/' . $imageName,
                ]);
            }
        }

        return back()->with('success', 'Gallery uploaded successfully');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function getCaste($religion)
    {
        try {
            $validator = Validator::make(
                ['religionId' => $religion],
                ['religionId' => ['required', 'integer', 'exists:religions,rid']]
            );

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $castes = Caste::where('religionid', $religion)
                ->where('status', 'show')
                ->get(['cid as id', 'name']);

            if ($castes->isEmpty()) {
                return response()->json([
                    'message' => 'Caste data not found'
                ], 404);
            }

            return response()->json([
                'message' => 'Caste data fetched successfully',
                'castes' => $castes
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getCity($state)
    {
        try {
            $validator = Validator::make(
                ['state' => $state],
                ['state' => ['required', 'integer', 'exists:state,sid']]
            );

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $cities = City::where('state_id', $state)
                ->where('status', 'active')
                ->get(['cityid as id', 'name']);

            if ($cities->isEmpty()) {
                return response()->json([
                    'message' => 'City data not found'
                ], 404);
            }

            return response()->json([
                'message' => 'City data fetched successfully',
                'cities' => $cities
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
