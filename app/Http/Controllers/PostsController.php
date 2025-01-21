<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // fetching records from request
        // return $request->get('title');
        // return $request->title; // return as object

        // STORING DATA [OPTION 1]
        Post::create($request->all());

        // STORING DATA [OPTION 2]
        /* $input = $request->all();
        $input['title'] = $request->title;
        Post::create($input); */

        // STORING DATA [OPTION 3]
        /* $post = new Post();
        $post->title = $request->title;
        $post->save(); */

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect('/posts');
        // $post = Post::whereId($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::whereId($id)->delete();

        return redirect('/posts');
    }

    // custom function
    public function summary(string $id, string $name, string $password) {
        return view('posts.summary', compact('id', 'name', 'password'));
    }
}
