<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StatsController;

Route::middleware(['web'])->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('index');
    Route::get('/stats/{userid}', [PageController::class, 'userStats'])->name('stats.userStats');
    Route::get('/stats/{userid}/{gameid}', [PageController::class, 'gameStats'])->name('stats.gameStats');
});
