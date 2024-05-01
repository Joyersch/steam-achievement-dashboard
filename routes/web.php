<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\GamesController;

Route::get('/', [IndexController::class, 'index']);
Route::get('{userid}', [IndexController::class, 'user']);
Route::get('games/{userid}', [GamesController::class, 'list']);
Route::get('games/{userid}/{gameid}', [GamesController::class, 'forUser']);
