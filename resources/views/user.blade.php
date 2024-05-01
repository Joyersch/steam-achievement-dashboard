<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<div>Average: {{ $completion }}</div>


@foreach($stats as $stat)
    <br>
    {{\App\Models\Game::whereId($stat->game_id)->name}} | {{$stat->updated_at}} | {{$stat->completion() * 100}}
@endforeach
