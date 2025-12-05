<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('questions')->get();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        Gate::authorize('create-tag');
        return view('tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        try {
            $existingTag = Tag::where('name', $request->name)->first();
            
            if ($existingTag) {
                return redirect()->route('tags.index')
                    ->with('error', 'Tag "' . $request->name . '" đã tồn tại!');
            }

            $costToCreateTag = config('reputation.costs.create_tag', 10);
            $requiredReputation = config('reputation.requirements.create_tag', 50);
            $user = auth()->user();
            
            if ($user->reputation < $requiredReputation) {
                return redirect()->back()
                    ->with('error', 'Bạn cần ít nhất ' . $requiredReputation . ' điểm danh vọng để tạo tag!')
                    ->withInput();
            }
            
            if ($user->reputation < $costToCreateTag) {
                return redirect()->back()
                    ->with('error', 'Không đủ điểm! Bạn cần ' . $costToCreateTag . ' điểm để tạo tag.')
                    ->withInput();
            }

            $user->decrement('reputation', $costToCreateTag);

            $tag = Tag::create([
                'name' => $request->name,
            ]);

            return redirect()->route('tags.index')
                ->with('success', 'Tag đã được tạo thành công! (-' . $costToCreateTag . ' điểm danh vọng)');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Tag $tag)
    {
        $questions = $tag->questions()
            ->with(['user', 'tags'])
            ->withCount('answers')
            ->latest()
            ->paginate(15);

        return view('tags.show', compact('tag', 'questions'));
    }
}
