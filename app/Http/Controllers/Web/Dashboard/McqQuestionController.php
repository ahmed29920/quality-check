<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\McqQuestionRequest;
use App\Models\Category;
use App\Models\McqQuestion;
use App\Services\CategoryService;
use App\Services\McqQuestionService;
use Illuminate\Http\Request;

class McqQuestionController extends Controller
{
    protected $service , $categoryService;
    
    public function __construct(McqQuestionService $service , CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $data = $this->service->listQuestions($request->get('category_id'));
        return view('dashboard.mcq-questions.index', $data);
    }

    public function create(Request $request)
    {
        $categoryId = $request->get('category_id');
        $category = $categoryId ? $this->categoryService->findById($categoryId) : null;
        $categories = Category::active()->get();

        return view('dashboard.mcq-questions.create', compact('categories', 'category'));
    }

    public function store(McqQuestionRequest $request)
    {
        $mcq = $this->service->createQuestion($request->validated());

        return redirect()
            ->route('admin.mcq-questions.index', ['category_id' => $mcq->category_id])
            ->with('success', 'MCQ question created successfully! 🎯');
    }

    public function show(McqQuestion $mcqQuestion)
    {
        $mcqQuestion->load('category');
        return view('dashboard.mcq-questions.show', compact('mcqQuestion'));
    }

    public function edit(McqQuestion $mcqQuestion)
    {
        $categories = Category::active()->get();
        return view('dashboard.mcq-questions.edit', compact('mcqQuestion', 'categories'));
    }

    public function update(McqQuestionRequest $request, McqQuestion $mcqQuestion)
    {
        $this->service->updateQuestion($mcqQuestion, $request->validated());

        return redirect()
            ->route('admin.mcq-questions.index', ['category_id' => $mcqQuestion->category_id])
            ->with('success', 'MCQ question updated successfully! ✏️');
    }

    public function destroy(McqQuestion $mcqQuestion)
    {
        $this->service->deleteQuestion($mcqQuestion);
        return response()->json(['message' => 'MCQ question deleted successfully! 🗑️']);
    }

    public function toggleStatus(McqQuestion $mcqQuestion)
    {
        $updated = $this->service->toggleStatus($mcqQuestion);
        $status = $updated->is_active ? 'activated' : 'deactivated';

        return response()->json([
            'success' => true,
            'message' => "MCQ question {$status} successfully! 🔄",
            'is_active' => $updated->is_active
        ]);
    }

    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:mcq_questions,id',
            'questions.*.sort_order' => 'required|integer|min:0',
        ]);

        $this->service->updateSortOrder($request->questions);

        return response()->json(['success' => true, 'message' => 'Sort order updated successfully!']);
    }
}
