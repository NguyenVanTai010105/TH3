<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        //
        $viewsPost = $request->session()->get('view_post', []);
        if (!isset($viewsPost[$post->id])) {
            //$post->increment('view_count');
            Post::where('id', $post->id)->increment('view_count');
            $viewsPost[$post->id] = true;
            $request->session()->put('view_post', $viewsPost);
        }

        return view('posts.show', compact('post'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view();
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
    public function byCategory($id)
    {
        $category = Category::findOrFail($id);

        $posts = Post::with(['category', 'tags'])
            ->where('category_id', $id)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->get();

        return view('posts.index', compact('posts', 'category'));
    }

    public function byTag($id)
    {
        $tag = Tag::findOrFail($id);

        $posts = $tag->posts()
            ->with(['category', 'tags'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->get();


        return view('posts.index', compact('posts', 'tag'));
    }
}
