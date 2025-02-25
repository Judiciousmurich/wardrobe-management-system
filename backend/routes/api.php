<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClothingItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Clothing Items
    Route::apiResource('clothing-items', ClothingItemController::class);
    Route::get('/categories', [ClothingItemController::class, 'getCategories']);
    Route::get('/clothing-items/filter/{category}', [ClothingItemController::class, 'filterByCategory']);
    Route::get('/clothing-items/search/{query}', [ClothingItemController::class, 'search']);
});