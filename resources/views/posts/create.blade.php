@extends('layouts.app')

@section('content')

    <h1>Create New Post</h1>
    <form method="post" action="/posts">
        <input type="text" name="title" placeholder="Enter title"><br />
        {{ csrf_field() }}
        <textarea name="content" id="content" cols="30" rows="10" placeholder="Enter content"></textarea><br />
        <input type="submit" name="submit">
    </form>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>    
                @endforeach
            </ul>
        </div>
    @endif
@endsection