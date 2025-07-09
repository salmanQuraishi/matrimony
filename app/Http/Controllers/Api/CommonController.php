<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MethodController;
use App\Models\AnnualIncome;
use App\Models\Caste;
use App\Models\CompanyType;
use App\Models\ProfileType;
use App\Models\Education;
use App\Models\JobType;
use App\Models\Occupation;
use App\Models\Religion;

class CommonController extends Controller
{
    public function getReligion()
    {
        try {
            $Religion = Religion::where('status', 'show')->get(['rid','name','description']);

            if ($Religion->isEmpty()) {
                return MethodController::errorResponse('Religion Data not found', 404);
            }

            return MethodController::successResponse('Religion Data', $Religion);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getCaste(Request $request)
    {
        try {
            
            $religionId = $request->religion;

            $Caste = Caste::where('religionid',$religionId)->where('status', 'show')->get(['cid','name','description']);

            if ($Caste->isEmpty()) {
                return MethodController::errorResponse('Caste Data not found', 404);
            }

            return MethodController::successResponse('Caste Data', $Caste);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getProfileFor()
    {
        try {
            $ProfileType = ProfileType::where('status', 'show')->get(['ptid','name']);

            if ($ProfileType->isEmpty()) {
                return MethodController::errorResponse('Profile For Data not found', 404);
            }

            return MethodController::successResponse('Profile For Data', $ProfileType);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getEducation()
    {
        try {
            $Education = Education::where('status', 'show')->get(['eid','name']);

            if ($Education->isEmpty()) {
                return MethodController::errorResponse('Education Data not found', 404);
            }

            return MethodController::successResponse('Education Data', $Education);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getOccupation()
    {
        try {
            $Occupation = Occupation::where('status', 'show')->get(['oid','name']);

            if ($Occupation->isEmpty()) {
                return MethodController::errorResponse('Occupation Data not found', 404);
            }

            return MethodController::successResponse('Occupation Data', $Occupation);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getAnnualIncome()
    {
        try {
            $AnnualIncome = AnnualIncome::where('status', 'show')->get(['aid','range']);

            if ($AnnualIncome->isEmpty()) {
                return MethodController::errorResponse('Annual Income Data not found', 404);
            }

            return MethodController::successResponse('Annual Income Data', $AnnualIncome);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getJobType()
    {
        try {
            $JobType = JobType::where('status', 'show')->get(['jtid','name']);

            if ($JobType->isEmpty()) {
                return MethodController::errorResponse('Job Type Data not found', 404);
            }

            return MethodController::successResponse('Job Type Data', $JobType);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getCompanyType()
    {
        try {
            $CompanyType = CompanyType::where('status', 'show')->get(['ctid','name']);

            if ($CompanyType->isEmpty()) {
                return MethodController::errorResponse('Company Type Data not found', 404);
            }

            return MethodController::successResponse('Company Type Data', $CompanyType);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }

}