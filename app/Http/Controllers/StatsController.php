<?php

namespace App\Http\Controllers;

use App\Models\AchievementStats;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Support\Facades\Redirect;

class StatsController extends Controller
{
    public function userStats(string $name)
    {
        $user = User::whereName($name);
        if (!$user) {
            return Redirect::away(route('index'));
        }
        $stats = $user->latestStats();
        if (!$stats) {
            return Redirect::away(route('index'));
        }

        return view('user', ['user' => $user,
            'stats' => $stats,
            'completion' => UserGameStat::getCompletion($user),
            'achievements' => UserGameStat::getAchievementCount($user),
            'games' => UserGameStat::getGamesCount($user),
            'gamesStarted' => UserGameStat::getGamesStartedCount($user),
            'finishedGames' => UserGameStat::getCompletedGamesCount($user),
        ]);
    }

    public function gameStats(string $name, int $appid)
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

        $secondChartData = AchievementStats::get($user, $game)->values;
        return view('gameStats', [
            'game' => $game,
            'user' => $user,
            'chartData' => $chartData,
            'secondChartData' => json_decode($secondChartData),

        ]);
    }
}
