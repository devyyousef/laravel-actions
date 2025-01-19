<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Actions\AddRoleAction;
use Modules\Users\Actions\AssignPermissionToRoleAction;
use Modules\Users\Actions\GetPermissionsAction;
use Modules\Users\Actions\GetPermissionsByRoleAction;
use Modules\Users\Actions\GetRolesAction;
use Modules\Users\Actions\SyncRolesForUserAction;
use Modules\Users\Enums\RolesEnum;
use Modules\Users\Http\Controllers\UsersController;








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
