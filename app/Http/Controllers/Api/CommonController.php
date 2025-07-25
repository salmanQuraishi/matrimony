<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MethodController;
use Illuminate\Support\Facades\Validator;
use App\Models\AnnualIncome;
use App\Models\Caste;
use App\Models\CompanyType;
use App\Models\ProfileType;
use App\Models\Education;
use App\Models\JobType;
use App\Models\Occupation;
use App\Models\Religion;
use App\Models\State;
use App\Models\City;
use App\Models\Gallery;
use App\Models\UserNotification;

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
    public function getCaste($religion)
    {
        try {
            $validator = Validator::make(
                ['religionId' => $religion],
                ['religionId' => ['required', 'integer', 'exists:religions,rid']]
            );;

            $Caste = Caste::where('religionid', $religion)
                        ->where('status', 'show')
                        ->get(['cid', 'name', 'description']);

            if ($Caste->isEmpty()) {
                return MethodController::errorResponse('Caste Data not found', 404);
            }

            return MethodController::successResponse('Caste Data', $Caste);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return MethodController::errorResponse($e->errors(), 422);
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
    public function getState()
    {
        try {
            $State = State::where('status', 'Active')->get(['sid','name']);

            if ($State->isEmpty()) {
                return MethodController::errorResponse('State Data not found', 404);
            }

            return MethodController::successResponse('State Data', $State);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function getCity($state)
    {
        try {
            $validator = Validator::make(
                ['state' => $state],
                ['state' => ['required', 'integer', 'exists:state,sid']]
            );;

            $Caste = City::where('state_id', $state)
                        ->where('status', 'Active')
                        ->get(['cityid', 'name']);

            if ($Caste->isEmpty()) {
                return MethodController::errorResponse('Caste Data not found', 404);
            }

            return MethodController::successResponse('Caste Data', $Caste);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return MethodController::errorResponse($e->errors(), 422);
        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public static function UserNotificationStore($userid,$title,$body,$isread)
    {
        UserNotification::create([
            'user_id' => $userid,
            'title' => $title,
            'body' => $body,
            'is_read' => $isread,
        ]);
        return MethodController::successResponseSimple('user notification send successfully');
    }
    public function getUserNotification()
    {
        $userId = auth()->id();

        try {
            $notifications = UserNotification::where('user_id', $userId)->get();

            if ($notifications->isEmpty()) {
                return MethodController::errorResponse('No notifications found.', 404);
            }

            return MethodController::successResponse('User notifications retrieved successfully.', $notifications);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }
    public function UserNotificationRead(Request $request)
    {
        $userId = auth()->id();

        try {
            $updated = UserNotification::where('user_id', $userId)
                        ->where('is_read', false)
                        ->update(['is_read' => true]);

            if ($updated === 0) {
                return MethodController::errorResponse('No unread notifications found.');
            }

            return MethodController::successResponseSimple('All notifications marked as read.');

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }

}