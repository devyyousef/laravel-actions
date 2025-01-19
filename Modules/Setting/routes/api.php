<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Actions\CreateSettingAction;
use Modules\Setting\Actions\GetSettingByIDAction;
use Modules\Setting\Actions\GetSettingByKeyAction;
use Modules\Setting\Actions\GetSettingsAction;
use Modules\Setting\Actions\UpdateSettingByIDAction;
use Modules\Setting\Actions\UpdateSettingByKeyAction;
use Modules\Setting\Http\Controllers\SettingController;
use Modules\Users\Enums\RolesEnum;


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

Route::prefix('v1')->group(function () {
    Route::prefix('settings')->group(function () {
        Route::middleware(['auth:sanctum', 'role:' . RolesEnum::SUPER_ADMIN->value])->group(function () {
            Route::post('/store', CreateSettingAction::class);
            Route::post('update-by-id/{setting}', UpdateSettingByIDAction::class);
            Route::post('update-by-key/{key}', UpdateSettingByKeyAction::class);
        });

        Route::get('/', GetSettingsAction::class);
        Route::get('/get-by-key/{key}', GetSettingByKeyAction::class);
        Route::get('/get-by-id/{setting}', GetSettingByIDAction::class);
    });
});

Route::prefix('v1')->middleware(['auth:sanctum', 'role:' . RolesEnum::SUPER_ADMIN->value])->group(function () {
    Route::prefix('settings')->group(function () {});
});
