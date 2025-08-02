<?php

use App\Modules\User\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [UserApiController::class, 'profile']);
    Route::put('profile', [UserApiController::class, 'updateProfile']);
    Route::get('settings', [UserApiController::class, 'settings']);
}); 