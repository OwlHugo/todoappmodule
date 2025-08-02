<?php

use App\Modules\Task\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
}); 