<?php

namespace App\Repositories;

use App\Models\McqQuestion;

class McqQuestionRepository
{
    public function getAllWithCategory($perPage = 20)
    {
        return McqQuestion::with('category')->ordered()->paginate($perPage);
    }

    public function getByCategoryId($categoryId, $perPage = 20)
    {
        return McqQuestion::with('category')
            ->where('category_id', $categoryId)
            ->ordered()
            ->paginate($perPage);
    }

    public function findById($id)
    {
        return McqQuestion::with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return McqQuestion::create($data);
    }

    public function update(McqQuestion $mcqQuestion, array $data)
    {
        return $mcqQuestion->update($data);
    }

    public function delete(McqQuestion $mcqQuestion)
    {
        return $mcqQuestion->delete();
    }

    public function getMaxSortOrder($categoryId)
    {
        return McqQuestion::where('category_id', $categoryId)->max('sort_order');
    }
}
