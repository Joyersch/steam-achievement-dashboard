<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;

class GamesController extends Controller
{
    public function list(string $name)
    {
        $user = User::whereName($name);
        if (!$user) {
            return view('errors.404', ['message' => 'no user with that name!'], 404);
        }
        $stats = $user->gameStats()->get();
        if (!$stats) {
            return view('errors.404', ['message' => 'no stats for that user!'], 404);
        }

        return view('games.list', ['stats' => $stats]);
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
        return view('games.forUser', ['stats' => $stats]);
    }
}
