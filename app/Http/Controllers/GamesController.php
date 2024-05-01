<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;

class GamesController extends Controller
{
    public function user(string $name)
    {
        $user = User::whereName($name);
        if (!$user) {
            return view('errors.404', ['message' => 'no user with that name!'], 404);
        }
        $stats = $user->latestStats();
        if (!$stats) {
            return view('errors.404', ['message' => 'no stats for that user!'], 404);
        }

        return view('user', ['stats' => $stats, 'completion' => UserGameStat::getCompletion($user)]);
    }

    public function forUser(string $name, int $appid)
    {
        $user = User::whereName($name);
        if (!$user) {
            return view('errors.404', ['message' => 'no user with that name!'], 404);
        }

        $game = Game::whereAppid($appid);
        if (!$game) {
            return view('errors.404', ['message' => 'no game with that appid!'], 404);
        }

        $stats = $user->stats($game);
        if (!$stats) {
            return view('errors.404', ['message' => 'no stats for that game and user combination!'], 404);
        }
        return view('gameStats', ['stats' => $stats]);
    }
}
