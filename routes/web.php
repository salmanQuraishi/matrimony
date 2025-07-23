<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\CasteController;
use App\Http\Controllers\ProfileTypeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\AnnualIncomeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CompanyTypeController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;

Route::fallback(function () {
    return view('error.404');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // chat
    Route::get('/chat/{id}', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{id}', [ChatController::class, 'getMessages'])->name('chat.getMessages');
    Route::post('/chat/broadcast', [ChatController::class, 'broadcast'])->name('chat.broadcast');

    // notification
    Route::get('/send/notification', [NotificationController::class, 'sendNotification'])->name('notification.send');
    Route::get('/notification/create', [NotificationController::class, 'create'])->name('notification.create');
    Route::post('/notification/store', [NotificationController::class, 'store'])->name('notification.store');
    Route::get('/notification/index', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notification/edit/{id}', [NotificationController::class, 'edit'])->name('notification.edit');
    Route::post('/notification/update/{id}', [NotificationController::class, 'update'])->name('notification.update');

    // caste
    Route::get('/get/caste/list/{religion}', [UserController::class, 'getCaste'])->name('user.caste');
    Route::get('/get/city/list/{state}', [UserController::class, 'getCity'])->name('user.city');

    // user
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/view/{id}', [UserController::class, 'edit'])->name('user.view');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    // religion
    Route::get('/religion', [ReligionController::class, 'index'])->name('religion.index');
    Route::get('/religion/create', [ReligionController::class, 'create'])->name('religion.create');
    Route::post('/religion/store', [ReligionController::class, 'store'])->name('religion.store');
    Route::get('/religion/edit/{id}', [ReligionController::class, 'edit'])->name('religion.edit');
    Route::put('/religion/update/{id}', [ReligionController::class, 'update'])->name('religion.update');

    // caste
    Route::get('/caste', [CasteController::class, 'index'])->name('caste.index');
    Route::get('/caste/create', [CasteController::class, 'create'])->name('caste.create');
    Route::post('/caste/store', [CasteController::class, 'store'])->name('caste.store');
    Route::get('/caste/edit/{id}', [CasteController::class, 'edit'])->name('caste.edit');
    Route::put('/caste/update/{id}', [CasteController::class, 'update'])->name('caste.update');

    // profiletype
    Route::get('/profiletype', [ProfileTypeController::class, 'index'])->name('profiletype.index');
    Route::get('/profiletype/create', [ProfileTypeController::class, 'create'])->name('profiletype.create');
    Route::post('/profiletype/store', [ProfileTypeController::class, 'store'])->name('profiletype.store');
    Route::get('/profiletype/edit/{id}', [ProfileTypeController::class, 'edit'])->name('profiletype.edit');
    Route::put('/profiletype/update/{id}', [ProfileTypeController::class, 'update'])->name('profiletype.update');

    // education
    Route::get('/education', [EducationController::class, 'index'])->name('education.index');
    Route::get('/education/create', [EducationController::class, 'create'])->name('education.create');
    Route::post('/education/store', [EducationController::class, 'store'])->name('education.store');
    Route::get('/education/edit/{id}', [EducationController::class, 'edit'])->name('education.edit');
    Route::put('/education/update/{id}', [EducationController::class, 'update'])->name('education.update');

    // occupation
    Route::get('/occupation', [OccupationController::class, 'index'])->name('occupation.index');
    Route::get('/occupation/create', [OccupationController::class, 'create'])->name('occupation.create');
    Route::post('/occupation/store', [OccupationController::class, 'store'])->name('occupation.store');
    Route::get('/occupation/edit/{id}', [OccupationController::class, 'edit'])->name('occupation.edit');
    Route::put('/occupation/update/{id}', [OccupationController::class, 'update'])->name('occupation.update');

    // annualincome
    Route::get('/annualincome', [AnnualIncomeController::class, 'index'])->name('annualincome.index');
    Route::get('/annualincome/create', [AnnualIncomeController::class, 'create'])->name('annualincome.create');
    Route::post('/annualincome/store', [AnnualIncomeController::class, 'store'])->name('annualincome.store');
    Route::get('/annualincome/edit/{id}', [AnnualIncomeController::class, 'edit'])->name('annualincome.edit');
    Route::put('/annualincome/update/{id}', [AnnualIncomeController::class, 'update'])->name('annualincome.update');

    // jobtype
    Route::get('/jobtype', [JobTypeController::class, 'index'])->name('jobtype.index');
    Route::get('/jobtype/create', [JobTypeController::class, 'create'])->name('jobtype.create');
    Route::post('/jobtype/store', [JobTypeController::class, 'store'])->name('jobtype.store');
    Route::get('/jobtype/edit/{id}', [JobTypeController::class, 'edit'])->name('jobtype.edit');
    Route::put('/jobtype/update/{id}', [JobTypeController::class, 'update'])->name('jobtype.update');

    // jobtype
    Route::get('/companytype', [CompanyTypeController::class, 'index'])->name('companytype.index');
    Route::get('/companytype/create', [CompanyTypeController::class, 'create'])->name('companytype.create');
    Route::post('/companytype/store', [CompanyTypeController::class, 'store'])->name('companytype.store');
    Route::get('/companytype/edit/{id}', [CompanyTypeController::class, 'edit'])->name('companytype.edit');
    Route::put('/companytype/update/{id}', [CompanyTypeController::class, 'update'])->name('companytype.update');
    

});

require __DIR__.'/auth.php';