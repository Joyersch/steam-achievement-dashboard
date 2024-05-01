@foreach($stats as $stat)
    <br>
    {{$stat->created_at}} |{{$stat->updated_at}} | {{$stat->completion()}}
@endforeach
