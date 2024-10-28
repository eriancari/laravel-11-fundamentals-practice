<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

// Routing Controllers
// Route::get('/posts', [PostsController::class, 'index']);

// Route::get('/posts/{id}', [PostsController::class, 'show']); // this automatically passes parameters

// Resource
Route::resource('posts', PostsController::class);
Route::get('/summary/{id}/{name}/{password}', [PostsController::class, 'summary']); // custom function

Route::group(['middleware' =>['web']], function() {


});

/* Application Routes */

Route::get('/insert', function() {
    DB::insert('insert into posts(title, content) values(?, ?)', ['PHP with Laravel', 'Laravel is the best thing that happened to PHP']);
});

Route::get('/read', function() {
    $results = DB::select('SELECT * FROM posts where id = ?', [1]);

    return $results;
    /* foreach($results as $post) {
        return $post->content;
    } */
});

Route::get('/update', function() {
    $updated = DB::update('UPDATE posts SET title = "Updated title" WHERE id = ?', [1]);

    return $updated;
});

Route::get('/delete', function() {
    $deleted = DB::delete('DELETE FROM posts WHERE id = ?', [1]);
    return $deleted;
});