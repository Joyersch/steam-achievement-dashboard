<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserGameStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'total',
        'achieved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public static function latestEntry(User $user, Game $game): UserGameStat|null
    {
        return UserGameStat::where('user_id', $user->id)
            ->where('game_id', $game->id)
            ->latest('updated_at')
            ->first();
    }

    public static function getCompletion(User $user): float
    {
        $sum = 0;
        $count = 0;
        // we want to only use the last entry of each game
        $gamestats = UserGameStat::getLatestStats($user);

        foreach ($gamestats as $gamestat) {
            if ($gamestat->achieved == 0) {
                continue;
            }
            $sum += $gamestat->achieved / $gamestat->total;
            $count++;
        }

        if (!$count) {
            return 0;
        }

        return $sum / $count;
    }

    public static function getLatestStats(User $user): Collection|null
    {
        return $user->gameStats()
            ->get()
            ->groupBy('game_id')
            ->map(fn($g) => $g->sortByDesc('updated_at')
                ->first());
    }

    public function completion(): float
    {
        return $this->achieved / $this->total;
    }
}
