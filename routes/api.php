<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\SystemSettingController;

// Login Route
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // System Setting Routes
    Route::apiResource('/system-setting', SystemSettingController::class)->only(['index', 'update']);
    Route::get('/site-timezone', [SystemSettingController::class, 'siteTimeZone']);
});
