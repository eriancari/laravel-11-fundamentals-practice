<?php

use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\PostsController;
use Illuminate\Database\Eloquent\Model;
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

// Route::get('/post/{id}/{name}', function ($id, $name) {
//     return "Post ID is " . $id . " by " . $name;
// });

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
// Route::resource('posts', PostsController::class);
// Route::get('/summary/{id}/{name}/{password}', [PostsController::class, 'summary']); // custom function

Route::group(['middleware' =>['web']], function() {


});

/* Application Routes */

// Route::get('/insert', function() {
//     DB::insert('insert into posts(title, content) values(?, ?)', ['Practice Laravel', 'Laravel is the best thing that happened to PHP']);
// });

// Route::get('/read', function() {
//     $results = DB::select('SELECT * FROM posts where id = ?', [1]);

//     return $results;
//     /* foreach($results as $post) {
//         return $post->content;
//     } */
// });

// Route::get('/update', function() {
//     $updated = DB::update('UPDATE posts SET title = "Updated title" WHERE id = ?', [1]);

//     return $updated;
// });

// Route::get('/delete', function() {
//     $deleted = DB::delete('DELETE FROM posts WHERE id = ?', [1]);
//     return $deleted;
// });

/** 
 * ELOQUENT
*/

// READ
Route::get('/read', function() {
     $posts  = Post::all();
     
     foreach($posts as $post) {
        return $post->title;
     }
});

Route::get('/find', function() {
    $post = Post::find(2);
    return $post->title;
});

Route::get('/findwhere', function(){
    $posts = Post::where('id', 2)->orderBy('id', 'desc')->take(1)->get();
    return $posts;
});

Route::get('/findmore', function() {
    $posts = Post::findOrFail(4);
    return $posts;
});

// INSERT
Route::get('/basicinsert', function() {
    $post = new Post;

    $post->title = 'New Eloquent title insert';
    $post->content = 'New Eloquent is really cool!';
    $post->save();
});

Route::get('/findandupdate', function() {
    $post = Post::find(2);

    $post->title = 'New Eloquent title insert #2';
    $post->content = 'New Eloquent is really cool! #2';
    $post->save();
});

Route::get('/create', function() {
    Post::create([
        'title' => 'the create method',
        'content' => 'I\'m learning a lot',
    ]);
});

// UPDATE
Route::get('/update', function() {
    Post::where('id', 2)->where('is_admin', 0)->update(['title' => 'NEW PHP TITLE', 'content' => 'NEW CONTENT!!!']);
});

// DELETE
Route::get('/delete', function() {
    $post = Post::find(1);
    $post->delete();
});

Route::get('/destroy', function() {
    Post::destroy(3);
    
    // deleting multiple
    // Post::destroy([4,5]);

    // another delete option
    // Post::where('is_admin', 0)->delete();
});

// SOFT DELETE
Route::get('/softdelete', function() {
    Post::find(6)->delete();
});

Route::get('/readsoftdelete', function() {
    $posts = Post::withTrashed()->where('is_admin', 0)->get();
    // $posts = Post::onlyTrashed()->where('is_admin', 0)->get();

    return $posts;
});

Route::get('/restore', function() {
    $posts = Post::withTrashed()->where('is_admin', 0)->restore();
    
    return $posts;
});

// THIS METHOD FORCE DELETE RECORD WHEN SOFTDELETE IS ENABLED
Route::get('/forcedelete', function() {
    $posts = Post::onlyTrashed()->where('is_admin', 0)->forceDelete();
    
    return $posts;
});

/**
 * ELOQUENT RELATIONSHIPS
 */

// ONE TO ONE RELATIONSHIP

// THIS FETCHES USER'S POST
Route::get('/user/{id}/post', function($id) {
    return User::find($id)->post->title;
});

// INVERSE RELATION
Route::get('/post/{id}/user', function($id) {
    return Post::find($id)->user->name;
});

// ONE TO MANY RELATIONSHIP
Route::get('/posts', function() {
    
    $user = User::find(1);

    foreach($user->posts as $post) {
        echo $post->title . "<br />";
    }
});