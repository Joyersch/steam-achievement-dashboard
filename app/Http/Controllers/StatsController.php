<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Support\Facades\Redirect;

class StatsController extends Controller
{
    public function user(string $name)
    {
        $user = User::whereName($name);
        if (!$user) {
            return Redirect::away(route('index'));
        }
        $stats = $user->latestStats();
        if (!$stats) {
            return Redirect::away(route('index'));
        }

        return view('user', ['user' => $user, 'stats' => $stats, 'completion' => UserGameStat::getCompletion($user)]);
    }

    public function forUser(string $name, int $appid)
    {
        $user = User::whereName($name);
        if (!$user) {
            return Redirect::away(route('index'));
        }

        $game = Game::whereAppid($appid);
        if (!$game) {
            return Redirect::away(route('index'));
        }

        $stats = $user->stats($game);
        if (!$stats) {
            return Redirect::away(route('index'));
        }

        $chartData = [];
        foreach ($stats as $stat) {
            $chartData[] = [
                'x' => $stat->created_at->toDateTimeString(),
                'y' => $stat->completion() * 100
            ];

            if ($stat->created_at != $stat->updated_at) {
                $chartData[] = [
                    'x' => $stat->updated_at->toDateTimeString(),
                    'y' => $stat->completion() * 100
                ];
            }
        }

        return view('gameStats', ['chartData' => $chartData, 'game' => $game]);
    }
}
