@foreach($stats as $stat)
    <br>
    {{\App\Models\Game::whereId($stat->game_id)->name}} | {{$stat->updated_at}} | {{$stat->completion() * 100}}
@endforeach
