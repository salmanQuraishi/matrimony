<?php

use App\Http\Controllers\ComplexionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
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
use App\Http\Controllers\NikahCardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WebSettingController;

Route::fallback(function () {
    return view('error.404');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Clear cache
    Route::get('/clear-cache', function () {
        Cache::forget('websetting');

        Artisan::call('optimize:clear');

        return redirect()->back()->with('success', 'Cache cleared successfully!');
    })->name('cache.clear');

    // web setting
    Route::get('/web/setting', [WebSettingController::class, 'index'])->name('websetting.index');
    Route::put('/web/setting', [WebSettingController::class, 'update'])->name('websetting.update');

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
    Route::get('/get/state/list/{country}', [UserController::class, 'getState'])->name('user.state');
    Route::get('/get/city/list/{state}', [UserController::class, 'getCity'])->name('user.city');

    // user
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/view/{id}', [UserController::class, 'edit'])->name('user.view');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/gallery/{id}', [UserController::class, 'gallery'])->name('gallery.index');
    Route::post('/user/gallery/store/{id}', [UserController::class, 'store'])->name('gallery.store');
    Route::delete('/user/gallery/destroy/{id}', [UserController::class, 'destroy'])->name('gallery.destroy');

    // nikha card
    Route::get('/nikah-card/list/{id}', [NikahCardController::class, 'cardlist'])->name('nikah-card.list');
    Route::get('/nikah-card/generate/{id}', [NikahCardController::class, 'generateCardForm'])->name('nikah-card.form');
    Route::post('/nikah-card/generate/{id}', [NikahCardController::class, 'generate'])->name('nikah-card.generate');
    Route::get('/nikah-card/download/{id}', [NikahCardController::class, 'download'])->name('nikah-card.download');
    Route::delete('/nikah-card/delete/{id}', [NikahCardController::class, 'delete'])->name('nikah-card.delete');

    // complexion
    Route::get('/complexion', [ComplexionController::class, 'index'])->name('complexion.index');
    Route::get('/complexion/create', [ComplexionController::class, 'create'])->name('complexion.create');
    Route::post('/complexion/store', [ComplexionController::class, 'store'])->name('complexion.store');
    Route::get('/complexion/edit/{id}', [ComplexionController::class, 'edit'])->name('complexion.edit');
    Route::put('/complexion/update/{id}', [ComplexionController::class, 'update'])->name('complexion.update');

    // religion
    Route::get('/religion/', [ReligionController::class, 'index'])->name('religion.index');
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

// ==========================================
// MATRIMONY WEBSITE FRONTEND ROUTES
// ==========================================

// Public Frontend Routes
Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'home'])->name('home');
Route::get('/about', [\App\Http\Controllers\Frontend\HomeController::class, 'about'])->name('about');
Route::get('/contact', [\App\Http\Controllers\Frontend\HomeController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [\App\Http\Controllers\Frontend\HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [\App\Http\Controllers\Frontend\HomeController::class, 'terms'])->name('terms');
Route::get('/success-stories', [\App\Http\Controllers\Frontend\HomeController::class, 'successStories'])->name('success-stories');

// Dynamic Select Bindings (AJAX)
Route::get('/ajax/castes/{religion}', [\App\Http\Controllers\Frontend\HomeController::class, 'getCastes'])->name('ajax.castes');
Route::get('/ajax/states/{country}', [\App\Http\Controllers\Frontend\HomeController::class, 'getStates'])->name('ajax.states');
Route::get('/ajax/cities/{state}', [\App\Http\Controllers\Frontend\HomeController::class, 'getCities'])->name('ajax.cities');

// User Auth Routes (Guests only)
Route::middleware('guest')->group(function () {
    Route::get('/user/login', [\App\Http\Controllers\Frontend\AuthController::class, 'showLogin'])->name('user.login');
    Route::post('/user/login', [\App\Http\Controllers\Frontend\AuthController::class, 'login'])->name('user.login.post');
    Route::get('/user/register', [\App\Http\Controllers\Frontend\AuthController::class, 'showRegister'])->name('user.register');
    Route::post('/user/register', [\App\Http\Controllers\Frontend\AuthController::class, 'register'])->name('user.register.post');
});

// Authenticated User Routes (Protected by user.auth middleware)
Route::middleware('user.auth')->group(function () {
    Route::post('/user/logout', [\App\Http\Controllers\Frontend\AuthController::class, 'logout'])->name('user.logout');
    Route::post('/user/settings/change-password', [\App\Http\Controllers\Frontend\AuthController::class, 'changePassword'])->name('user.change-password');

    Route::get('/user/dashboard', [\App\Http\Controllers\Frontend\DashboardController::class, 'index'])->name('user.dashboard');

    // My Profile
    Route::get('/user/my-profile', [\App\Http\Controllers\Frontend\ProfileController::class, 'show'])->name('user.profile');
    Route::get('/user/my-profile/edit', [\App\Http\Controllers\Frontend\ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/user/my-profile/update-basic', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateBasic'])->name('user.profile.update-basic');
    Route::post('/user/my-profile/update-religion', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateReligion'])->name('user.profile.update-religion');
    Route::post('/user/my-profile/update-personal', [\App\Http\Controllers\Frontend\ProfileController::class, 'updatePersonal'])->name('user.profile.update-personal');
    Route::post('/user/my-profile/update-professional', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateProfessional'])->name('user.profile.update-professional');
    Route::post('/user/my-profile/update-about', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateAbout'])->name('user.profile.update-about');
    Route::post('/user/my-profile/update-gallery', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateGallery'])->name('user.profile.update-gallery');

    // Matches & Search
    Route::get('/user/matches', [\App\Http\Controllers\Frontend\MatchController::class, 'index'])->name('user.matches');
    Route::get('/user/profile/{id}', [\App\Http\Controllers\Frontend\MatchController::class, 'show'])->name('user.profile.view');
    Route::get('/user/search', [\App\Http\Controllers\Frontend\MatchController::class, 'search'])->name('user.search');

    // Interests / Match Requests
    Route::get('/user/interests', [\App\Http\Controllers\Frontend\InterestController::class, 'index'])->name('user.interests');
    Route::post('/user/interests/send/{receiver}', [\App\Http\Controllers\Frontend\InterestController::class, 'send'])->name('user.interests.send');
    Route::post('/user/interests/accept/{interest}', [\App\Http\Controllers\Frontend\InterestController::class, 'accept'])->name('user.interests.accept');
    Route::post('/user/interests/reject/{interest}', [\App\Http\Controllers\Frontend\InterestController::class, 'reject'])->name('user.interests.reject');
    Route::post('/user/interests/revoke/{interest}', [\App\Http\Controllers\Frontend\InterestController::class, 'revoke'])->name('user.interests.revoke');
    Route::post('/user/interests/ignore/{receiver}', [\App\Http\Controllers\Frontend\InterestController::class, 'ignore'])->name('user.interests.ignore');
    Route::post('/user/interests/ignore/revoke/{ignored}', [\App\Http\Controllers\Frontend\InterestController::class, 'revokeIgnore'])->name('user.interests.ignore.revoke');

    // Shortlist / Likes
    Route::get('/user/shortlist', [\App\Http\Controllers\Frontend\ShortlistController::class, 'index'])->name('user.shortlist');
    Route::post('/user/shortlist/toggle/{likedId}', [\App\Http\Controllers\Frontend\ShortlistController::class, 'toggle'])->name('user.shortlist.toggle');

    // Chat / Messages
    Route::get('/user/messages', [\App\Http\Controllers\Frontend\MessageController::class, 'index'])->name('user.messages');
    Route::post('/user/messages/store', [\App\Http\Controllers\Frontend\MessageController::class, 'store'])->name('user.messages.store');

    // Notifications
    Route::get('/user/notifications', [\App\Http\Controllers\Frontend\NotificationController::class, 'index'])->name('user.notifications');
    Route::post('/user/notifications/read', [\App\Http\Controllers\Frontend\NotificationController::class, 'markAsRead'])->name('user.notifications.read');

    // Settings
    Route::get('/user/settings', function () {
        return view('frontend.user.settings');
    })->name('user.settings');
});