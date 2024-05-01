@foreach($stats as $stat)
    <br>
    {{$stat->updated_at}} | {{$stat->completion()}}
@endforeach
