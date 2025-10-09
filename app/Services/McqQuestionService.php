<?php

namespace App\Services;

use App\Models\Category;
use App\Models\McqQuestion;
use App\Repositories\CategoryRepository;
use App\Repositories\McqQuestionRepository;

class McqQuestionService
{
    protected $repository;
    protected $categoryRepository;
    public function __construct(McqQuestionRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
    }
    public function indexByCategory($id, $limit)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            throw new \Exception('Category not found');
        }
        return $this->repository->getByCategoryId($id, $limit);
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
