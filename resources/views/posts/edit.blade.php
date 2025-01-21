@extends('layouts.app')

@section('content')

    <h1>Edit {{$post->title}} Post</h1>
    <br />
    <form method="post" action="/posts/{{$post->id}}">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}

        <input type="text" name="title" value="{{$post->title}}" placeholder="Enter title"><br />
        <textarea name="content" id="content" cols="30" rows="10" placeholder="Enter content">{{$post->content}}</textarea><br />
        <input type="submit" name="UPDATE">
    </form>

    <form method="post" action="/posts/{{$post->id}}">
        <input type="hidden" name="_method" value="DELETE">
        {{ csrf_field() }}
        <input type="submit" value="DELETE">
    </form>

@endsection