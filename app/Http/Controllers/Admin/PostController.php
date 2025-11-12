<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validate = $request->validate([
            'title' => 'required|string|max:20',
            'content' => 'required|string',
            'status' => 'required',
            'published_at' => 'nullable|date'

        ]);
        $validate['slug']  = Str::slug($request->title);
        $original_slug = $validate['slug'];
        $count = 1;
        while (Post::where('slug', $validate['slug'])->exists()) {
            $validate['slug'] = $original_slug . '-' . $count;
            $count++;
        }
        if ($validate['status'] === 'published' && empty($validate['published_at'])) {
            $validate['published_at'] = now();
        }
        Post::create($validate);
        return redirect()->route('admin.posts.index')->with('success_create', 'Đã tạo bài viết mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $post = Post::findOrFail($id);
        $validate = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'published_at' => 'nullable|date'
        ]);
        $validate['slug']  = Str::slug($request->title);
        if ($validate['status'] === 'published' && empty($validate['published_at'])) {
            $validate['published_at'] = now();
        }
        $post->update($validate);
        return redirect()->route('admin.posts.index')->with('success_edit', 'Thay đổi thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success_delete', 'Xóa thành công');
    }
}
