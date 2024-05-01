<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'steam_user_id'
    ];

    public function gameStats()
    {
        return $this->hasMany(UserGameStat::class);
    }

    public function stats(Game $game): Collection
    {
        return $this->gameStats()->where('game_id', $game->id)->get();
    }

    public static function whereName(string $name): User|null
    {
        return User::where('name', $name)->first();
    }

    public static function whereId(int $id): User|null
    {
        return User::where('id', $id)->first();
    }

    public function latestStats()
    {
        return UserGameStat::getLatestStats($this);
    }
}
