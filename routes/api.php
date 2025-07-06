<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SystemSettingController;
use App\Http\Controllers\Api\ProfileSettingController;

// Login Route
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // System Setting Routes
    Route::apiResource('/system-setting', SystemSettingController::class)->only(['index', 'update']);
    Route::get('/site-timezone', [SystemSettingController::class, 'siteTimeZone']);

    // Profile Setting Routes
    Route::get('/profile-info', [ProfileSettingController::class, 'profileInfo']);
    Route::post('/update-profile', [ProfileSettingController::class, 'updateProfile']);
    Route::post('/update-password', [ProfileSettingController::class, 'updatePassword']);

    // Module Routes
    Route::apiResource('/modules', ModuleController::class);
    Route::get('/all-modules', [ModuleController::class, 'allModules']);

    // Permission Routes
    Route::apiResource('/permissions', PermissionController::class);
    Route::get('/all-permissions', [PermissionController::class, 'allPermissions']);

    // Role Routes
    Route::apiResource('/roles', RoleController::class);
    Route::get('/all-roles', [RoleController::class, 'allRoles']);
});
