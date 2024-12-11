<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\Photo;
use App\Models\Tag;
use App\Models\Address;
use App\Models\Staff;
use App\Models\Product;
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
/* Route::get('/post/{id}', function ($id) {
    return "Post ID is " . $id;
}); */

/* Route::get('/post/{id}/{name}', function ($id, $name) {
    return "Post ID is " . $id . " by " . $name;
}); */

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

Route::get('/insert', function() {
    $user = User::findOrFail(1);
    
    $address = new Address([
        'name' => 'Pagadian, Zamboanga del Sur'
    ]);

    $user->address()->save($address);

    // DB::insert('insert into posts(title, content) values(?, ?)', ['Practice Laravel', 'Laravel is the best thing that happened to PHP']);
});

Route::get('/read', function() {

    $user = User::findOrFail(1);
    return $user->address->name;

    // $results = DB::select('SELECT * FROM posts where id = ?', [1]);

    // return $results;
    /* foreach($results as $post) {
        return $post->content;
    } */
});

Route::get('/update', function() {
    
    $address = Address::whereUserId('1')->first();
    
    $address->name = "Pagadian, Zamboanga del Sur, PH";

    $address->save();

    // $updated = DB::update('UPDATE posts SET title = "Updated title" WHERE id = ?', [1]);
    // return $updated;
});
 
Route::get('/delete', function() {

    $user = User::findOrFail(2);
    $user->address()->delete();
    // $deleted = DB::delete('DELETE FROM posts WHERE id = ?', [1]);
    // return $deleted;
});

Route::get('/create/posts', function() {

    $user = User::findOrFail(1);
    $post = new Post(['title'=>'Fake Faces', 'content'=>'And I tried to give what they want from me / This one-sided love is slowly killing me']);
    $user->post()->save($post);
    
});

Route::get('/read/user/posts', function() {

    $user = User::findOrFail(1);
    // return $user->posts;

    foreach($user->posts as $post) {
        echo $post->title . "<br />";
    }
    
});

Route::get('/update/user/posts', function() {

    $user = User::findOrFail(1);

    $user->posts()->whereId(1)->update([
        'title' => 'Bulan!',
        'content' => 'Abante lang, walang atrasan / Ang bumangga giba / Kabisig man o hindi ang mundo / Tuluy-tuloy lang ang takbo'
    ]);
    
});

Route::get('/delete/user/posts', function() {

    $user = User::findOrFail(1);

    $user->posts()->whereId(1)->delete();
    
});

Route::get('/create/user/role', function() {
    $user = User::find(2);

    $role = new Role(['name' => 'administrator']);

    $user->roles()->save($role);
});

Route::get('/read/user/role', function() {
    $user = User::findOrFail(2);

    foreach($user->roles as $role) {
        echo $role->name;
    }
});

Route::get('/update/user/role', function() {
    $user = User::findOrFail(2);

    if ($user->has('roles')) {
        foreach ($user->roles as $role) {
            if ($role->name === 'Subscriber') {
                $role->name = 'Administrator';
                $role->save();
            }
        }
    }
});

Route::get('/delete/user/role', function() {
    $user = User::findOrFail(2);

    foreach ($user->roles as $role) {
        $role->whereId(4)->delete();
    }
});

// ATTACHES A ROLE TO A USER
Route::get('/attach', function() {
    $user = User::findOrFail(1);

    $user->roles()->attach(2); // similar with adding role, but tagging it to a specific user
    // CONS: everytime the "attach" is used, it will add another record
});

// REMOVES ATTACHMENT TO A USER
Route::get('/detach', function() {
    $user = User::findOrFail(1);
    
    $user->roles()->detach(); // similar with adding role, but tagging it to a specific user
    // CONS: everytime the "attach" is used, it will add another record
});

// SYNC
Route::get('/sync', function() {
    $user = User::findOrFail(1);

    $user->roles()->sync([1, 2]);
});

/** 
 * ELOQUENT
*/

// READ
Route::get('/read/posts', function() {
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
Route::get('/update/post', function() {
    Post::where('id', 2)->where('is_admin', 0)->update(['title' => 'NEW PHP TITLE', 'content' => 'NEW CONTENT!!!']);
});

// DELETE
Route::get('/delete/posts', function() {
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

// MANY TO MANY RELATIONSHIP
Route::get('/user/{id}/role', function($id) {
    
    $user = User::find($id)->roles;

    return $user;
});

// ACCESSING INTERMEDIATE TABLE (PIVOT TABLE)
Route::get('/user/pivot', function() {
    $user = User::find(1);

    // return $user->roles;
    foreach($user->roles as $role) {
        return $role->pivot->created_at;
    }
});

// HAS MANY THROUGH RELATIONS
Route::get('/user/country', function() {
    $country = Country::find(4);

    foreach($country->posts as $post) {
        return $post->title;
    }
});

// POLYMORPHIC RELATIONS
Route::get('/user/photos', function() {
    $user = User::find(1);
    
    foreach($user->photos as $photo) {
        return $photo;
    }
});

Route::get('/post/photos', function() {
    $post = Post::find(1);
    
    foreach($post->photos as $photo) {
        return $photo->path;
    }
});

Route::get('/photo/{id}/post', function($id) { // POLYMORPHIC THE INVERSE
    $photo = Photo::findOrFail($id);

    return $photo->imageable;
});

// POLYMORPHIC MANY TO MANY
Route::get('/post/tag', function() {
    $post = Post::find(1);
    
    foreach($post->tags as $tag) {
        echo $tag->name;
    }
});

Route::get('/tag/post', function() {
    $tag = Tag::find(2);
    
    foreach($tag->posts as $post) {
        echo $post->title;
    }
});

// POLYMORPH

Route::get('/create/staff/photo', function() {
    $staff = Staff::find(1);

    $staff->photos()->create(['path' => 'example.jpg']);
});

Route::get('/read/staff/photo', function() {
    $staff = Staff::findOrFail(1);

    foreach($staff->photos as $photo) {
        echo $photo->path;
    }
});

Route::get('/read/staff/photo', function() {
    $staff = Staff::findOrFail(1);

    foreach($staff->photos as $photo) {
        echo $photo->path;
    }
});

Route::get('/update/staff/photo', function() {
    $staff = Staff::findOrFail(1);

    $photo = $staff->photos()->whereId(2)->first();
    $photo->path = "Example.jpg";
    $photo->save();
});

Route::get('/delete/staff/photo', function() {
    $staff = Staff::findOrFail(1);

    $staff->photos()->delete();
});

Route::get('/assign', function() {
    $staff = Staff::findOrFail(1);

    $photo = Photo::findOrFail(3);

    $staff->photos()->save($photo);
});

Route::get('/unassign', function() {
    $staff = Staff::findOrFail(1);

    $photo = Photo::findOrFail(3);

    $staff->photos()->whereId(3)->update(['imageable_id' => 0, "imageable_type" => ""]);
});
 

