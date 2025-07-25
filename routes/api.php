<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Middleware\AuthGatesMiddleware;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\WareHouseController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SystemSettingController;
use App\Http\Controllers\Api\ProfileSettingController;

// Login Route
Route::post('/login', LoginController::class);

// System Setting Data
Route::get('/system-setting',[ SystemSettingController::class, 'index']);

Route::middleware(['auth:sanctum', AuthGatesMiddleware::class])->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // System Setting Routes
    Route::put('/system-setting/{id}', [SystemSettingController::class, 'update']);
    Route::get('/site-timezone', [SystemSettingController::class, 'siteTimeZone']);

    // Profile Setting Routes
    Route::get('/profile-info', [ProfileSettingController::class, 'profileInfo']);
    Route::post('/update-profile', [ProfileSettingController::class, 'updateProfile']);
    Route::post('/update-password', [ProfileSettingController::class, 'updatePassword']);
    Route::get('/user-permissions', [ProfileSettingController::class, 'userPermissions']);

    // Module Routes
    Route::apiResource('/modules', ModuleController::class);
    Route::get('/all-modules', [ModuleController::class, 'allModules']);

    // Permission Routes
    Route::apiResource('/permissions', PermissionController::class);
    Route::get('/all-permissions', [PermissionController::class, 'allPermissions']);

    // Role Routes
    Route::apiResource('/roles', RoleController::class);
    Route::get('/all-roles', [RoleController::class, 'allRoles']);

    // Category Routes
    Route::apiResource('/categories', CategoryController::class);
    Route::get('/all-categories', [CategoryController::class, 'allCategories']);
    Route::get('/category/status/{id}', [CategoryController::class, 'status']);

    // Brand Routes
    Route::apiResource('/brands', BrandController::class);
    Route::get('/all-brands', [BrandController::class, 'allBrands']);
    Route::get('/brand/status/{id}', [BrandController::class, 'status']);

    // WareHouse Routes
    Route::apiResource('/warehouses', WareHouseController::class);
    Route::get('/all-warehouses', [WareHouseController::class, 'allWareHouses']);
    Route::get('/warehouse/status/{id}', [WareHouseController::class, 'status']);

    // Supplier Routes
    Route::apiResource('/suppliers', SupplierController::class);
    Route::get('/all-suppliers', [SupplierController::class, 'allSuppliers']);
    Route::get('/supplier/status/{id}', [SupplierController::class, 'status']);

    // Product Routes
    Route::apiResource('/products', ProductController::class);
    Route::get('/all-products', [ProductController::class, 'allProducts']);
    Route::get('/product/status/{id}', [ProductController::class, 'status']);
});
