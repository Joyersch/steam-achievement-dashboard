<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Stats for {{$user->name}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/tableOptions.js', 'resources/sass/app.scss'])
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mt-5">
                <h1>Stats for {{$user->name}}</h1>
            </div>
            <div>
                <h2 class="mt-4">Average Completion: {{ number_format($completion * 100, 2) }}%</h2>
            </div>
            <div class="btn-group mt-3" role="group" aria-label="Filter Buttons">
                <button type="button" class="btn btn-filter" id="hide100">Hide 100% Completion</button>
                <button type="button" class="btn btn-filter" id="hide0">Hide 0% Completion</button>
                <button type="button" class="btn btn-filter" id="hideOthers">Hide Other% Completion</button>
            </div>
            <table class="table table-striped mt-3">
                <thead>
                <tr>
                    <th>Game Name</th>
                    <th>Completion Rate (%)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stats as $stat)
                    @php
                        $game = \App\Models\Game::whereId($stat->game_id);
                    @endphp
                    <tr>
                        <td><a href="/stats/{{ $user->name }}/{{ $game->appid }}" class="link-style">{{ $game->name }}</a>
                        </td>
                        <td>{{ number_format($stat->completion() * 100, 2) }}%</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
