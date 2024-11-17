<?php

namespace App\Http\Controllers;

use App\Models\AchievementStats;
use App\Models\Activity;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $activities = Activity::fromLastMonth();

        $data = [];

        foreach($activities as $activity) {
            $user = User::whereId($activity->user_id);
            $game = Game::whereId($activity->game_id);

            $entry = [];
            $entry['type'] = $activity->type->name;
            $entry['date'] = Carbon::parse($activity->updated_at)->toDateString();

            $entry['user'] = [
                'name' => $user->name,
                'color' => $user->color
            ];

            $entry['game'] = [
                'name' => $game->name,
                'id' => $game->id
            ];

            $data[] = $entry;
        }

        return Inertia::render('Startpage', ['data' => ['activities' => $data]]);
        //return view('index', ['activities' => Activity::fromLastMonth()]);
    }
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


        $data = [];
        $data['user'] = [
            'name' => $user->name
        ];
        $data['completion'] = UserGameStat::getCompletion($user);
        $data['achievements'] = UserGameStat::getAchievementCount($user);
        $data['games'] = [
            'count' => UserGameStat::getGamesCount($user),
            'started' => UserGameStat::getGamesStartedCount($user),
            'finished' => UserGameStat::getCompletedGamesCount($user)
        ];

        
        $data['stats'] = [];
        foreach($stats as $stat){
            $game = Game::whereId($stat->game_id);
            $data['stats'][] = [
                'completion' => $stat->completion(),
                'game' => [
                    'id' => $game->appid,
                    'name' => $game->name
                ]
            ];
        }

        return Inertia::render('Userpage', ['data' => $data]);
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

        $achievements = AchievementStats::get($user, $game);
        $secondChartData = json_encode([]);
        if ($achievements) {
            $secondChartData = $achievements->values;
        }

        return Inertia::render('Gamepage', ['data' => [
            'game' => $game->name,
            'user' => $user->name,
            'chartData' => $chartData,
            'secondChartData' => json_decode($secondChartData),
        ]]);
    }
}
