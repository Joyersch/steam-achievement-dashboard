<?php

namespace App\Models;

use App\Enums\ActivityType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'type',
        'id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'type' => ActivityType::class,
    ];

    public static function fromLastMonth(): Collection
    {
        return Activity::where('created_at', '>=', Carbon::now()->subDays(30))
            ->where('created_at', '<=', now())
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
