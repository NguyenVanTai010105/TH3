<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $categories = Category::all();
        $validate = $request->validate([
            'name' => 'required|string|max:20'
        ]);
        $validate['slug'] = Str::slug($request->name);
        $original_slug = $validate['slug'];
        $count = 1;
        while (Category::where('slug', $validate['slug'])->exists()) {
            $validate['slug'] = $original_slug . '-' . $count;
            $count++;
        }

        if (Category::where('name', $validate['name'])->exists()) {
            return back()->withErrors(['name' => 'Tên bị trùng']);
        }

        Category::create($validate);
        return redirect()->route('admin.categories.create')->with('success_create', 'Tạo thành công');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with('success_deleted', 'Xóa thành công');
        //
    }
}
