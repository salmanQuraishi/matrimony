<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\InterestController;
use App\Http\Controllers\Api\LikedController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\ChatController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/get/religion/list', [CommonController::class, 'getReligion']);
Route::get('/get/caste/list/{religion}', [CommonController::class, 'getCaste']);
Route::get('/get/profilefor/list', [CommonController::class, 'getProfileFor']);
Route::get('/get/education/list', [CommonController::class, 'getEducation']);
Route::get('/get/occupation/list', [CommonController::class, 'getOccupation']);
Route::get('/get/annual/income/list', [CommonController::class, 'getAnnualIncome']);
Route::get('/get/job/type/list', [CommonController::class, 'getJobType']);
Route::get('/get/company/type/list', [CommonController::class, 'getCompanyType']);

Route::get('/get/state/list', [CommonController::class, 'getState']);
Route::get('/get/city/list/{state}', [CommonController::class, 'getCity']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/update-basic', [AuthController::class, 'updateBasic']);
    Route::post('/update-religion', [AuthController::class, 'updateReligion']);
    Route::post('/update-personal', [AuthController::class, 'updatePersonal']);
    Route::post('/update-professional', [AuthController::class, 'updateProfessional']);
    Route::post('/update-about', [AuthController::class, 'updateAbout']);
    Route::post('/update-gallery', [AuthController::class, 'updateGallery']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/get-user', [AuthController::class, 'getUser']);
    
    Route::get('/get/matches', [MatchController::class, 'getRelevantUsers']);
    Route::get('/get/matches/details/{user}', [MatchController::class, 'getRelevantUserDetails']);

    Route::post('/update/like-user', [LikedController::class, 'likeUser']);

    Route::post('/interests/send/{receiver}', [InterestController::class, 'sendInterest']);
    Route::post('/interests/accept/{interest}', [InterestController::class, 'acceptInterest']);
    Route::post('/interests/reject/{interest}', [InterestController::class, 'rejectInterest']);
    Route::get('/interests/sent', [InterestController::class, 'sent']);
    Route::get('/interests/received', [InterestController::class, 'received']);

    Route::get('/get-chats', [ChatController::class,'chatList']);

});