<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
Welcome!

@foreach($activities as $activity)
    <br>
    {{\App\Models\User::whereId($activity->user_id)->name}} | {{\App\Models\Game::whereId($activity->game_id)->name}}
    | {{$activity->type->name}}
@endforeach
