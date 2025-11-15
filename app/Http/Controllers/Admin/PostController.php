<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
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
        $posts =  Post::with(['category', 'tags'])->get();
        return view('admin.posts.index', compact('posts'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
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
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id'

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
        $post = Post::create($validate);
        //kiểm tra gắn tag
        if (!empty($request->tags)) {
            $tagsArray = array_map('trim', explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagsArray as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }


            $post->tags()->sync($tagIds);
        }


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
        $post = Post::with(['category', 'tags'])->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date'
        ]);

        $validated['slug'] = Str::slug($request->title);
        $original_slug = $validated['slug'];
        $count = 1;

        while (Post::where('slug', $validated['slug'])->where('id', '<>', $post->id)->exists()) {
            $validated['slug'] = $original_slug . '-' . $count;
            $count++;
        }


        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Cập nhật bài viết
        $post->update($validated);

        //tag
        if (!empty($request->tags)) {
            $tagsArray = array_map('trim', explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagsArray as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }


            $post->tags()->sync($tagIds);
        } else {

            $post->tags()->sync([]);
        }

        return redirect()->route('admin.posts.index')
            ->with('success_edit', 'Cập nhật bài viết thành công!');
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
    // Lấy tất cả bài viết theo category
   
}
