<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Actions\ForgetPasswordAction;
use Modules\Auth\Actions\LoginAction;
use Modules\Auth\Actions\RegisterAction;
use Modules\Auth\Actions\ResetPasswordAction;
use Modules\Users\Actions\AddRoleAction;
use Modules\Users\Actions\AssignPermissionToRoleAction;
use Modules\Users\Actions\GetPermissionsAction;
use Modules\Users\Actions\GetPermissionsByRoleAction;
use Modules\Users\Actions\GetRolesAction;
use Modules\Users\Actions\GetUserAction;
use Modules\Users\Actions\SyncRolesForUserAction;
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

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('auth', AuthController::class)->names('auth');
// });
Route::prefix('v1/auth')->group(function () {
    Route::post('register', RegisterAction::class);
    Route::post('login', LoginAction::class);
    Route::post('forget-password', ForgetPasswordAction::class);
    Route::post('reset-password/{token}', ResetPasswordAction::class)->name('password.reset');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', GetUserAction::class);
    });
});
Route::prefix('v1')->middleware(['auth:sanctum', 'role:' . RolesEnum::SUPER_ADMIN->value])->group(function () {
    Route::get('permissions', GetPermissionsAction::class)->middleware('permission:read-permissions');

    Route::prefix('roles')->group(function () {
        Route::get('/', GetRolesAction::class)->middleware('permission:read-roles');
        Route::post('/add-role', AddRoleAction::class)->middleware('permission:create-role');
        Route::get('/{id}/permissions', GetPermissionsByRoleAction::class)->middleware('permission:read-permissions');
        Route::post('/sync-roles', SyncRolesForUserAction::class)->middleware('permission:sync-roles');
        Route::post('{role}/assign-permission', [AssignPermissionToRoleAction::class, 'assignSingle'])->middleware('permission:assign-permission');
        Route::post('{role}/assign-permissions', [AssignPermissionToRoleAction::class, 'syncMultiple'])->middleware('permission:sync-permissions');
    });
});
