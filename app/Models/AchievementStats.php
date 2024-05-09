<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementStats extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'values'
    ];

    public static function get(User $user, Game $game) : null|AchievementStats
    {
        return self::where('user_id', $user->id)
            ->where('game_id', $game->id)
            ->first();
    }
}
