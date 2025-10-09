<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\McqQuestionService;
use App\Http\Resources\McqQuestionResource;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(McqQuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function indexByCategory(Request $request, $id)
    {
        $limit = $request->query('limit', 15);
        $questions = $this->questionService->indexByCategory($id, $limit);
        return McqQuestionResource::collection($questions);
    }
}
