<?php

namespace App\Helpers;

use App\Models\User;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SteamApiHelper
{
    private static string $gameUrl = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=%s&steamid=%s&skip_unvetted_apps=true&include_played_free_games=1";


    private static string $achievementUrl = "http://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=%s&key=%s&steamid=%s";

    public static function GetUserGames(User $user): Collection|null
    {
        try {
            $responseString = Http::get(sprintf(SteamApiHelper::$gameUrl, config('steam.apikey'), $user->steam_user_id));
            $response = json_decode($responseString->body());
            return collect($response->response->games);

        } catch (RequestException $exception) {
            return null;
        }
    }

    public static function GetAchievements(User $user, int $appid): array|null
    {
        try {
            $responseString = Http::get(sprintf(SteamApiHelper::$achievementUrl, $appid, config('steam.apikey'), $user->steam_user_id));
            $response = json_decode($responseString->body());

            if (!$response->playerstats->success)
                return null;

            $name = $response->playerstats->gameName;
            $achievements = $response->playerstats->achievements;
            $count = count($achievements);
            $unlocked = 0;
            $dates = collect();
            foreach ($achievements as $achievement) {
                if ($achievement->achieved) {
                    $unlockTime = $achievement->unlocktime;
                    if ($achievement->unlocktime != 0) {
                        $date = Carbon::createFromTimestamp($unlockTime);
                        $dates->add($date);
                    }
                    else{
                        $dates->add(null);
                    }
                    $unlocked++;
                }
            }
            return ['name' => $name, 'total' => $count, 'achieved' => $unlocked, 'dates' => $dates];
        } catch (Exception $exception) {
            return null;
        }
    }
}
