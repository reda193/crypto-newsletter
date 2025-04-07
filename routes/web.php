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

    Route::get('/unsubscribe', [NewsletterController::class, 'showUnsubscribeForm'])->name('newsletter.unsubscribe.form');
    Route::post('/unsubscribe', [NewsletterController::class, 'processUnsubscribe'])->name('newsletter.unsubscribe.process');
    Route::get('/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});

// Add these routes to your routes/web.php file

// Show the password reset request form
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Process the form submission and send reset link
Route::post('/forgot-password', function (Request $request) {
    // This route should handle sending the reset link email
    // For now, we'll just redirect with a message
    return redirect()->back()->with('status', 'Password reset link sent!');
})->name('password.email');

// Show the password reset form
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// Process the new password
Route::post('/reset-password', function (Request $request) {
    // This route should handle the password update
    // For now, we'll just redirect with a message
    return redirect()->route('login')->with('status', 'Password has been reset!');
})->name('password.update');