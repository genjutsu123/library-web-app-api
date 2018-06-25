@extends('layouts.app')
@section('content')
    <p>SHELVES</p>

    @foreach($shelves as $shelf)
        <ul><li>{{$shelf}}</li></ul>
    @endforeach

@endsection