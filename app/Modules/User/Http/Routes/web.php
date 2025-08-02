<?php

use App\Modules\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])
        ->name('user.profile');
    
    Route::put('/profile', [UserController::class, 'updateProfile'])
        ->name('user.profile.update');
    
    Route::get('/settings', [UserController::class, 'settings'])
        ->name('user.settings');
}); 