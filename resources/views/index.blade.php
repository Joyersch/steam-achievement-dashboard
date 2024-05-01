<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Steam Achievement Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .achievement-gained {
            color: green;
        }

        .achievement-lost {
            color: red;
        }

        .game-added {
            color: blue;
        }

        .game-removed {
            color: orange;
        }

        .link-style {
            text-decoration: none;
            color: inherit;
        }

        .link-style:hover {
            text-decoration: underline;
        }
    </style>
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
                        <p><a href="{{ $user->name }}" class="link-style"><strong>{{ $user->name }}</strong></a> <span class="achievement-gained">gained</span> achievements in <a href="{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                    @case('AchievementLost')
                        <p><a href="{{ $user->name }}" class="link-style"><strong>{{ $user->name }}</strong></a> <span class="achievement-lost">lost</span> achievements in <a href="{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                    @case('GameAchievementAdded')
                        <p>Achievements <span class="game-added">added</span> to <a href="{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                    @case('GameAchievementRemoved')
                        <p>Achievements <span class="game-removed">removed</span> from <a href="{{ $user->name }}/{{ $game->appid }}" class="link-style"><strong>{{ $game->name }}</strong></a></p>
                        @break
                @endswitch
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
