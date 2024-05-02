<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'appid',
        'name',
        'id',
        'created_at',
        'updated_at'
    ];

    public function gameStats()
    {
        return $this->hasMany(UserGameStat::class);
    }

    public static function whereAppid(int $appid): Game|null
    {
        return Game::where('appid', $appid)->first();
    }

    public static function whereId(int $id): Game|null
    {
        return Game::where('id', $id)->first();
    }
}
