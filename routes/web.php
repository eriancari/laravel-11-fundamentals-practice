<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return "About page";
});

Route::get('/contact', function () {
    return "Contact page";
});

// passing with parameters
Route::get('/post/{id}', function ($id) {
    return "Post ID is " . $id;
});

Route::get('/post/{id}/{name}', function ($id, $name) {
    return "Post ID is " . $id . " by " . $name;
});

// naming routes
Route::get('/admin/post/example', array('as' => 'admin.home', function () {
    
    $url = route('admin.home');

    // this can be used like: <a href="route(admin.home)">Click here</a>
    return "This url is " . $url;
}));

Route::group(['middleware' =>['web']], function() {


});