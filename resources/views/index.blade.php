<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Steam Achievement Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body>
<div class="container">
    <div class="centered-title text-center mt-5">
        <h1>Steam Achievement Dashboard</h1>
    </div>
    <div class="list-group">
        @foreach($activities as $activity)
            @php
                $user = \App\Models\User::whereId($activity->user_id);
                $game = \App\Models\Game::whereId($activity->game_id);
            @endphp
            <div class="list-group-item">
                @switch($activity->type->name)
                    @case('AchievementGained')
                        <p><a href="stats/{{ $user->name }}" class="link-style"><strong>{{ $user->name }}</strong></a> <span class="achievement-gained">gained</span> achievements in <a href="stats/{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                    @case('AchievementLost')
                        <p><a href="stats/{{ $user->name }}" class="link-style"><strong>{{ $user->name }}</strong></a> <span class="achievement-lost">lost</span> achievements in <a href="stats/{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                    @case('GameAchievementAdded')
                        <p>Achievements <span class="game-added">added</span> to <a href="stats/{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                    @case('GameAchievementRemoved')
                        <p>Achievements <span class="game-removed">removed</span> from <a href="stats/{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                @endswitch
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
