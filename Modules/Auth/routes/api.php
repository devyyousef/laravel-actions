<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Actions\ForgetPasswordAction;
use Modules\Auth\Actions\LoginAction;
use Modules\Auth\Actions\RegisterAction;
use Modules\Auth\Actions\ResendVerifyEmailAction;
use Modules\Auth\Actions\ResetPasswordAction;
use Modules\Auth\Actions\VerifyEmailAction;
use Modules\Users\Actions\GetUserAction;


/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('auth', AuthController::class)->names('auth');
// });
Route::prefix('v1/auth')->group(function () {
    Route::post('register', RegisterAction::class);
    Route::post('login', LoginAction::class);
    Route::post('forget-password', ForgetPasswordAction::class);
    Route::post('reset-password/{token}', ResetPasswordAction::class)->name('password.reset');
    Route::post('/resend-verify-email', ResendVerifyEmailAction::class);
    Route::post('/verify-email', VerifyEmailAction::class);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', GetUserAction::class);
    });
});
