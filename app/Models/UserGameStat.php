<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGameStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'total',
        'achieved'
    ];

    public static function latestEntry(User $user, Game $game): UserGameStat|null
    {
        return UserGameStat::where('user_id', $user->id)
            ->where('game_id', $game->id)
            ->latest('updated_at')
            ->first();
    }
}
