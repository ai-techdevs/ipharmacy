<?php

use App\Models\Donation;
use Illuminate\Support\Facades\Route;


Route::get('/cache-clear', function () {
     Artisan::call('config:cache');
     Artisan::call('optimize:clear');
     Artisan::call('view:cache');
     Artisan::call('route:clear');
     Artisan::call('cache:clear');
   
    return 'Cache Cleared';
});

Route::get('/storage-link', function () {

     Artisan::call('storage:link');

   
    return 'Done!!';
});

Route::get('/check-square', function () {
    $installed = json_decode(file_get_contents(base_path('vendor/composer/installed.json')), true);

    // Depending on Composer version, structure is slightly different
    $packages = $installed['packages'] ?? $installed;

    $squarePackages = collect($packages)
        ->filter(fn($pkg) => str_contains($pkg['name'], 'square'))
        ->map(fn($pkg) => $pkg['name'] . ' : ' . $pkg['version']);

    return '<pre>' . implode("\n", $squarePackages->toArray()) . '</pre>';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage Linked';
});

Route::get('clinical-trails', [App\Http\Controllers\Web\HomeController::class, 'clinicalTrails'])->name('clinical-trails');
Route::post('clinical-trails', [App\Http\Controllers\Web\HomeController::class, 'trialSave'])->name('save.trial');


// Forum
Route::get('forum', [App\Http\Controllers\Web\HomeController::class, 'forum'])->name('forum');
Route::post('forum-likes/{id}', [App\Http\Controllers\Web\HomeController::class, 'forumLike'])->name('forum.like');
Route::post('/forum/{id}/comment', [App\Http\Controllers\Web\HomeController::class, 'forumComment'])->name('forum.comment');
Route::get('/forum/{forum}/comments', [App\Http\Controllers\Web\HomeController::class, 'loadComments'])->name('forum.comments');
Route::get('/privacy-policy', [App\Http\Controllers\Web\HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-use', [App\Http\Controllers\Web\HomeController::class, 'terms'])->name('terms');
Route::get('ask-ai', [App\Http\Controllers\Web\HomeController::class, 'askAI'])->name('askai');
Route::post('/chat', [App\Http\Controllers\Web\HomeController::class, 'ask'])->name('chat.ask');

// Drug
Route::get('/drug-information', [App\Http\Controllers\Web\DrugController::class, 'info'])->name('drugs.info');
Route::get('/drug-information/drugs-begining-with-letter-{letter}', [App\Http\Controllers\Web\DrugController::class, 'index'])->name('drugs.index');
Route::get('/drug-information/drugs-begining-with-letter-{letter}/{slug}', [App\Http\Controllers\Web\DrugController::class, 'show'])->name('drug.detail');

Route::get('/drugs-detail/{slug}/ask-doctor', [App\Http\Controllers\Web\DrugController::class, 'askDoctor'])->name('ask.doctor');
Route::post('/drugs-detail/{slug}/ask-doctor', [App\Http\Controllers\Web\DrugController::class, 'store'])->name('send.doctor');
Route::get('/drugs/search', [App\Http\Controllers\Web\HomeController::class, 'search'])->name('drugs.search');

Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'indexPage'])->name('index');
Route::get('faq', [App\Http\Controllers\Web\HomeController::class, 'faq'])->name('faq');
Route::get('cdc-media', [App\Http\Controllers\Web\HomeController::class, 'media'])->name('media');
Route::get('cdc-media/cdc-media-with-letter-{letter}', [App\Http\Controllers\Web\HomeController::class, 'mediaLetter'])->name('media-letter');
Route::get('cdc-media/{slug}', [App\Http\Controllers\Web\HomeController::class, 'mediaDetail'])->name('media-detail');
Route::post('cdc/comment-submit', [App\Http\Controllers\Web\HomeController::class, 'cdcStore'])->name('cdc.comment.submit');
Route::get('sponsor', [App\Http\Controllers\Web\HomeController::class, 'sponsor'])->name('sponsor');
Route::get('clinical-trails', [App\Http\Controllers\Web\HomeController::class, 'clinicalTrails'])->name('clinical-trails');
Route::get('coupons', [App\Http\Controllers\Web\HomeController::class, 'coupons'])->name('coupons');
Route::get('coupons/coupons-with-letter-{letter}', [App\Http\Controllers\Web\HomeController::class, 'couponsLetter'])->name('coupons-letter');
Route::get('coupon/pdf/{id}', [App\Http\Controllers\Web\HomeController::class, 'downloadPdf'])->name('coupon.pdf');


Route::get('donation', [App\Http\Controllers\Web\HomeController::class, 'donation'])->name('donation');
Route::post('/medicine/{id}/video-watch', [App\Http\Controllers\Web\HomeController::class, 'incrementVideoWatch'])->name('medicine.video.watch');
Route::post('/medicine/{id}/pdf-download', [App\Http\Controllers\Web\HomeController::class, 'incrementPdfDownload'])->name('medicine.pdf.download');
//Route::get('otp', [App\Http\Controllers\Web\HomeController::class, 'otp'])->name('otp');
Route::get('/login', [App\Http\Controllers\Web\AuthController::class, 'showForm'])->name('login');
Route::get('/forget-password', [App\Http\Controllers\Web\AuthController::class, 'forgetPassword'])->name('forget.password');
Route::post('forget-password', [App\Http\Controllers\Web\AuthController::class,'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [App\Http\Controllers\Web\AuthController::class,'showResetPasswordForm'])->name('reset.password');
Route::post('reset-password',  [App\Http\Controllers\Web\AuthController::class,'submitResetPasswordForm'])->name('reset.password.post');
Route::get('/registration', [App\Http\Controllers\Web\AuthController::class, 'showForm'])->name('registration');
Route::post('/login', [App\Http\Controllers\Web\AuthController::class, 'doLogin'])->name('doLogin');
Route::post('/registration', [App\Http\Controllers\Web\AuthController::class, 'doRegistration'])->name('doRegistration');
Route::get('/verify-otp', [App\Http\Controllers\Web\AuthController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [App\Http\Controllers\Web\AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
Route::post('/resend-otp', [App\Http\Controllers\Web\AuthController::class, 'resendOtp'])->name('otp.resend');







Route::get('paypal/payment', [App\Http\Controllers\Web\PaypalController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/subscription', [App\Http\Controllers\Web\PaypalController::class, 'subscription'])->name('paypal.subscription');
Route::get('payment/success', [App\Http\Controllers\Web\PaypalController::class, 'success'])->name('paypal.success');
Route::get('payment/cancel', [App\Http\Controllers\Web\PaypalController::class, 'cancel'])->name('paypal.cancel');

Route::get('/square/payment', [App\Http\Controllers\Web\SquareController::class, 'payment'])->name('square.payment');
Route::post('/square/process', [App\Http\Controllers\Web\SquareController::class, 'processPayment'])->name('square.process');
Route::get('square/success/{donation}', [App\Http\Controllers\Web\SquareController::class, 'success'])
    ->name('square.success');

    Route::post('/subscription/{donationId}/cancel', [App\Http\Controllers\Web\SquareController::class, 'cancelSubscription'])->name('square.subscription.cancel');
Route::post('/subscription/{donationId}/pause', [App\Http\Controllers\Web\SquareController::class, 'pauseSubscription'])->name('square.subscription.pause');
Route::post('/subscription/{donationId}/resume', [App\Http\Controllers\Web\SquareController::class, 'resumeSubscription'])->name('square.subscription.resume');
Route::get('/subscription/{donationId}/status', [App\Http\Controllers\Web\SquareController::class, 'getSubscriptionStatus'])->name('square.subscription.status');
Route::post('square/subscription/{id}/cancel-scheduled-pause', [App\Http\Controllers\Web\SquareController::class, 'cancelScheduledPause'])->name('square.subscription.cancel-scheduled-pause');
// routes/web.php or routes/api.php

Route::post('/square-webhook', [App\Http\Controllers\Web\SquareWebhookController::class, 'handleWebhook'])->name('square.webhook');
// Optional: Create a subscription management page
// Route::get('/manage-subscription/{donationId}', function($donationId) {
//     $donation = Donation::findOrFail($donationId);
//     return view('manage-subscription', compact('donation'));
// })->name('subscription.manage');

Route::prefix('subscription')->group(function () {
    Route::put('{donation}/pause', [App\Http\Controllers\Web\PaypalController::class, 'pauseSubscription'])->name('subscription.pause');
    Route::put('{donation}/resume', [App\Http\Controllers\Web\PaypalController::class, 'resumeSubscription'])->name('subscription.resume');
    Route::put('{donation}/cancel', [App\Http\Controllers\Web\PaypalController::class, 'cancelSubscription'])->name('subscription.cancel');
    Route::get('{donation}/status', [App\Http\Controllers\Web\PaypalController::class, 'subscriptionStatus'])->name('subscription.status');
});

Route::get('square/cancel/{donation}', [App\Http\Controllers\Web\SquareController::class, 'cancel'])
    ->name('square.cancel');
    Route::post('/paypal/webhook', [App\Http\Controllers\Web\PaypalController::class, 'webhook'])->name('paypal.webhook');

Route::group(['middleware' => ['auth', 'preventBackHistory']], function () {
    // Route::get('/dashboard', function () {
    //     return view('welcome');
    // })->name('dashboard');
    Route::get('/dashboard', [App\Http\Controllers\Web\HomeController::class, 'dashboard'])->name('dashboard');
 Route::get('/user-subscriptions', [App\Http\Controllers\Web\HomeController::class, 'subscription'])->name('subscription.list');
   Route::get('user/{id}/subscription', [App\Http\Controllers\Admin\DonationController::class, 'subscriptionDetail'])
    ->name('user.subscription');

    Route::post('/logout', [App\Http\Controllers\Web\AuthController::class, 'logout'])->name('logout');
    Route::post('forum', [App\Http\Controllers\Web\ForumWebController::class, 'store'])->name('forum.store');
     Route::get('/account-setting', [App\Http\Controllers\Web\HomeController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [App\Http\Controllers\Web\AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/change-password', [App\Http\Controllers\Web\HomeController::class, 'changePasswordForm'])->name('password.change');
Route::post('/change-password', [App\Http\Controllers\Web\HomeController::class, 'changePassword'])->name('password.update');

});
