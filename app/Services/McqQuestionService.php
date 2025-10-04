<?php

namespace App\Services;

use App\Models\Category;
use App\Models\McqQuestion;
use App\Repositories\McqQuestionRepository;

class McqQuestionService
{
    protected $repository;

    public function __construct(McqQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listQuestions($categoryId = null, $perPage = 20)
    {
        if ($categoryId) {
            $questions = $this->repository->getByCategoryId($categoryId, $perPage);
            $category = Category::find($categoryId);
        } else {
            $questions = $this->repository->getAllWithCategory($perPage);
            $category = null;
        }

        $categories = Category::active()->get();

        return compact('questions', 'categories', 'category');
    }

    public function createQuestion(array $data)
    {
        if (!isset($data['sort_order'])) {
            $maxOrder = $this->repository->getMaxSortOrder($data['category_id']);
            $data['sort_order'] = ($maxOrder ?? 0) + 1;
        }

        return $this->repository->create($data);
    }

    public function updateQuestion(McqQuestion $mcqQuestion, array $data)
    {
        return $this->repository->update($mcqQuestion, $data);
    }

    public function deleteQuestion(McqQuestion $mcqQuestion)
    {
        return $this->repository->delete($mcqQuestion);
    }

    public function toggleStatus(McqQuestion $mcqQuestion)
    {
        $mcqQuestion->update([
            'is_active' => !$mcqQuestion->is_active
        ]);

        return $mcqQuestion;
    }

    public function updateSortOrder(array $questions)
    {
        foreach ($questions as $questionData) {
            McqQuestion::find($questionData['id'])
                ->update(['sort_order' => $questionData['sort_order']]);
        }

        return true;
    }
}
