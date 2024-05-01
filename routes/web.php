<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\GamesController;

Route::get('/', [IndexController::class, 'index']);
Route::get('{userid}', [GamesController::class, 'user']);
Route::get('{userid}/{gameid}', [GamesController::class, 'forUser']);
