<?php

use Illuminate\Support\Facades\Route;


Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

    Route::get('/login', [App\Http\Controllers\Admin\Auth\AuthController::class, 'login'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\AuthController::class, 'authenticate'])->name('login.post');
    Route::get('/forget-password', [App\Http\Controllers\Admin\Auth\AuthController::class, 'forgetPassword'])->name('forget.password');
    Route::post('forget-password', [App\Http\Controllers\Admin\Auth\AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [App\Http\Controllers\Admin\Auth\AuthController::class, 'showResetPasswordForm'])->name('reset.password');
    Route::post('reset-password',  [App\Http\Controllers\Admin\Auth\AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::get('test', function () {
        return "Hi";
    });

    Route::group(['middleware' => ['auth.admin', 'preventBackHistory', 'role.auth']], function () {


        // Clinical Trials
        Route::get('/clinical-trials', [App\Http\Controllers\Admin\ClinicalTrialController::class, 'index'])->name('clinical-trials.index');
         Route::get('/clinical-trials/show/{id}', [App\Http\Controllers\Admin\ClinicalTrialController::class, 'edit'])->name('clinical-trials.edit');

        // Ask Doctor
        Route::get('/ask-doctors', [App\Http\Controllers\Admin\AskDoctorController::class, 'index'])->name('ask-doctors.index');

        // Home Page
        Route::get('/home-page', [App\Http\Controllers\Admin\HomePageController::class, 'index'])->name('home-page.index');
        Route::get('/home-page/{id}', [App\Http\Controllers\Admin\HomePageController::class, 'edit'])->name('home-page.edit');
        Route::post('/home-page/{id}', [App\Http\Controllers\Admin\HomePageController::class, 'update'])->name('home-page.update');

        //User
        Route::resource('user', App\Http\Controllers\Admin\UserController::class);

        // Forums
        Route::resource('forums', App\Http\Controllers\Admin\ForumController::class);
        Route::delete('forum-comments/{id}', [App\Http\Controllers\Admin\ForumController::class, 'deleteForumComment'])->name('forum_comments.destroy');


        Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
        Route::get('/roles/{role}/permissions', [App\Http\Controllers\Admin\UserController::class, 'getRolePermissions'])->name('role.permission');

        Route::get('/dashboard', [App\Http\Controllers\Admin\Auth\AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [App\Http\Controllers\Admin\Auth\AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/logout', [App\Http\Controllers\Admin\Auth\AuthController::class, 'logout'])->name('logout');
        Route::get('/change-password', [App\Http\Controllers\Admin\Auth\AuthController::class, 'changePassword'])->name('change.password');
        Route::post('/change-password', [App\Http\Controllers\Admin\Auth\AuthController::class, 'savePassword'])->name('save.password');

        Route::resource('/users', App\Http\Controllers\Admin\UserController::class);

        // Working Partner Images In Home Page
        Route::resource('/working-partners', App\Http\Controllers\Admin\WorkingPartnerController::class);

        // Medicines
        Route::resource('/medicines', App\Http\Controllers\Admin\MedicineController::class);
        Route::get('medicines-import', [App\Http\Controllers\Admin\MedicineImportController::class, 'showForm'])->name('medicines.import.form');
        Route::post('medicines-import', [App\Http\Controllers\Admin\MedicineImportController::class, 'importCsv'])->name('medicines.import');

        // CDC
        Route::resource('/cdcs', App\Http\Controllers\Admin\CdcController::class);

        // FAQ
        Route::resource('/faqs', App\Http\Controllers\Admin\FAQController::class);

        Route::resource('settings', App\Http\Controllers\Admin\SettingController::class);

        Route::resource('pages', App\Http\Controllers\Admin\PageController::class);

        Route::resource('donation', App\Http\Controllers\Admin\DonationController::class);

        Route::resource('coupon', App\Http\Controllers\Admin\CouponController::class);

        Route::resource('plan', App\Http\Controllers\Admin\PlanController::class);
        Route::resource('/sub-admin', App\Http\Controllers\Admin\SubAdminController::class);
        Route::get('donation/{id}/subscription', [App\Http\Controllers\Admin\DonationController::class, 'subscriptionDetail'])
            ->name('donation.subscription');
    });
});
