<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\McqQuestionRequest;
use App\Models\Category;
use App\Models\McqQuestion;
use Illuminate\Http\Request;

class McqQuestionController extends Controller
{
    /**
     * Display a listing of MCQ questions for a category.
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');

        if ($categoryId) {
            $questions = McqQuestion::with('category')
                ->where('category_id', $categoryId)
                ->ordered()
                ->paginate(20);

            $category = Category::find($categoryId);
        } else {
            $questions = McqQuestion::with('category')
                ->ordered()
                ->paginate(20);
            $category = null;
        }

        $categories = Category::active()->get();

        return view('dashboard.mcq-questions.index', compact('questions', 'categories', 'category'));
    }

    /**
     * Show the form for creating a new MCQ question.
     */
    public function create(Request $request)
    {
        $categoryId = $request->get('category_id');
        $category = $categoryId ? Category::find($categoryId) : null;
        $categories = Category::active()->get();

        return view('dashboard.mcq-questions.create', compact('categories', 'category'));
    }

    /**
     * Store a newly created MCQ question in storage.
     */
    public function store(McqQuestionRequest $request)
    {
        $data = $request->validated();

        // Set sort order if not provided
        if (!isset($data['sort_order'])) {
            $maxOrder = McqQuestion::where('category_id', $data['category_id'])
                ->max('sort_order');
            $data['sort_order'] = ($maxOrder ?? 0) + 1;
        }

        McqQuestion::create($data);

        return redirect()
            ->route('admin.mcq-questions.index', ['category_id' => $data['category_id']])
            ->with('success', 'MCQ question created successfully! 🎯');
    }

    /**
     * Display the specified MCQ question.
     */
    public function show(McqQuestion $mcqQuestion)
    {
        $mcqQuestion->load('category');
        return view('dashboard.mcq-questions.show', compact('mcqQuestion'));
    }

    /**
     * Show the form for editing the specified MCQ question.
     */
    public function edit(McqQuestion $mcqQuestion)
    {
        $categories = Category::active()->get();
        return view('dashboard.mcq-questions.edit', compact('mcqQuestion', 'categories'));
    }

    /**
     * Update the specified MCQ question in storage.
     */
    public function update(McqQuestionRequest $request, McqQuestion $mcqQuestion)
    {
        $data = $request->validated();

        $mcqQuestion->update($data);

        return redirect()
            ->route('admin.mcq-questions.index', ['category_id' => $mcqQuestion->category_id])
            ->with('success', 'MCQ question updated successfully! ✏️');
    }

    /**
     * Remove the specified MCQ question from storage.
     */
    public function destroy(McqQuestion $mcqQuestion)
    {
        $mcqQuestion->delete();
        return response()->json(['message' => 'MCQ question deleted successfully! 🗑️']);
    }

    /**
     * Toggle the active status of a question.
     */
    public function toggleStatus(McqQuestion $mcqQuestion)
    {
        $mcqQuestion->update([
            'is_active' => !$mcqQuestion->is_active
        ]);

        $status = $mcqQuestion->is_active ? 'activated' : 'deactivated';

        return response()->json(['success' => true, 'message' => "MCQ question {$status} successfully! 🔄",'is_active' => $mcqQuestion->is_active]);
    }

    /**
     * Update sort order of questions.
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:mcq_questions,id',
            'questions.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->questions as $questionData) {
            McqQuestion::find($questionData['id'])
                ->update(['sort_order' => $questionData['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'Sort order updated successfully!']);
    }
}
