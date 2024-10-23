@extends('layouts.app')

@section('content')
    <h1>Show Page</h1>

    @if (count($people))
        @foreach ($people as $person)
            <li>{{$person}}</li>
        @endforeach
    @else
        
    @endif
@stop