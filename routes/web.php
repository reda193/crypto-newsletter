<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signup', [NewsletterController::class, 'showSignupForm']);
Route::post('/signup', [NewsletterController::class, 'processSignup']);
Route::get('/success', [NewsletterController::class, 'showSuccess']);
Route::get('/reload-captcha', [NewsletterController::class, 'reloadCaptcha']);
Route::get('/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe']);