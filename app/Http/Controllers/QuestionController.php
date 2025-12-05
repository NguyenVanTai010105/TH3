<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $questions = Question::with(['user', 'tags', 'answers'])
            ->withCount('answers')
            ->latest()
            ->paginate(15);

        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('questions.create', compact('tags'));
    }   

    public function store(StoreQuestionRequest $request)
    {
        try {
            $question = Question::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'content' => $request->input('content'),
            ]);

            $tagIds = [];
            if ($request->has('tags')) {
                $tagIds = $request->tags;
            }

            if ($request->filled('new_tags')) {
                $newTagNames = array_map('trim', explode(',', $request->new_tags));
                
                $costToCreateTag = config('reputation.costs.create_tag', 10);
                $requiredReputation = config('reputation.requirements.create_tag', 50);
                $user = auth()->user();
                
                foreach ($newTagNames as $tagName) {
                    if (empty($tagName)) continue;
                    
                    $existingTag = Tag::where('name', $tagName)->first();
                    
                    if ($existingTag) {
                        $tagIds[] = $existingTag->id;
                    } else {
                        if ($user->reputation < $requiredReputation) {
                            return redirect()->back()
                                ->with('error', 'Bạn cần ít nhất ' . $requiredReputation . ' điểm danh vọng để tạo tag mới!')
                                ->withInput();
                        }
                        
                        if ($user->reputation < $costToCreateTag) {
                            return redirect()->back()
                                ->with('error', 'Không đủ điểm! Cần ' . $costToCreateTag . ' điểm để tạo tag "' . $tagName . '"')
                                ->withInput();
                        }
                        
                        $user->decrement('reputation', $costToCreateTag);
                        
                        $tag = Tag::create([
                            'name' => $tagName,
                            'slug' => \Illuminate\Support\Str::slug($tagName)
                        ]);
                        
                        $tagIds[] = $tag->id;
                    }
                }
            }

            if (!empty($tagIds)) {
                $question->tags()->sync(array_unique($tagIds));
            }

            $questionReward = config('reputation.rewards.post_question', 5);
            auth()->user()->increment('reputation', $questionReward);

            return redirect()->route('questions.show', $question)
                ->with('success', 'Câu hỏi đã được đăng thành công! (+' . $questionReward . ' điểm)');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Question $question)
    {
        $question->incrementViews();
        
        $question->load([
            'user', 
            'tags', 
            'answers' => function($query) {
                $query->with('user')->latest();
            }
        ]);

        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $this->authorize('update', $question);
        $tags = Tag::all();
        return view('questions.edit', compact('question', 'tags'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
    $validated = $request->validated();

    $question->update([
        'title' => $validated['title'],
        'content' => $validated['content'],
    ]);

    if (!empty($validated['tags'])) {
        $question->tags()->sync($validated['tags']);
    } else {
        $question->tags()->detach(); 
    }

    return redirect()->route('questions.show', $question)
                     ->with('success', 'Câu hỏi đã được cập nhật.');
    }

    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);
        $question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Câu hỏi đã được xóa.');
    }
}