<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Religion;
use App\Models\User;
use App\Models\ProfileType;
use App\Models\CompanyType;
use App\Models\JobType;
use App\Models\AnnualIncome;
use App\Models\Caste;
use App\Models\City;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\State;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('religion','caste')->where('id','!=',1)->get();
        // dd($users);
        return view('user.index',compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function view($id)
    {
        $religions = Religion::where('status','show')
                    ->select('rid as id', 'name')
                    ->get();

        $States = State::where('status','active')
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

        $user = User::findOrFail($id);
        return view('user.view', compact('user','religions','States','ProfileTypes','CompanyType','JobType','AnnualIncome','Occupation','Education'));
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
