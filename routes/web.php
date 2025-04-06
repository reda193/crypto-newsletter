<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;

// Redirect the homepage to the signup form
Route::get('/', function () {
    return redirect()->route('signup.form');
});

// Newsletter routes
Route::prefix('newsletter')->group(function () {
    // Using 'signup' as alias for consistency with route names
    Route::get('/signup', [NewsletterController::class, 'showSignupForm'])->name('signup.form');
    Route::post('/signup', [NewsletterController::class, 'processSignup'])->name('signup.process');
    Route::get('/success', [NewsletterController::class, 'showSuccess'])->name('signup.success');
    Route::get('/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});

// AJAX route for captcha reload
Route::get('/reload-captcha', [NewsletterController::class, 'reloadCaptcha'])->name('captcha.reload');