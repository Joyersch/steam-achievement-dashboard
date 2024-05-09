<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\StatsController;

Route::middleware(['web'])->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/stats/{userid}', [StatsController::class, 'userStats'])->name('stats.userStats');
    Route::get('/stats/{userid}/{gameid}', [StatsController::class, 'gameStats'])->name('stats.gameStats');
});
