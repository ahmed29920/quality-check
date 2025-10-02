<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;
use App\Models\Category;
use App\Models\McqQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $repository){
        $this->categoryRepository = $repository;
    }

    public function all()
    {
        return $this->categoryRepository->all();
    }

    public function active($limit)
    {
        return $this->categoryRepository->active($limit);
    }

    public function pricable()

    {
        return $this->categoryRepository->pricable();
    }

    public function findById($id)
    {
        return $this->categoryRepository->findById($id);
    }
    public function findBySlug($slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function create(array $data)
    {
        return DB::transaction(function() use ($data) {
            // Handle image upload
            if (isset($data['image'])) {
                $imagePath = $data['image']->store('categories', 'public');
                $data['image'] = $imagePath;
            }

            // Create category
            $data['slug'] = Str::slug($data['name']['en']);
            $category = $this->categoryRepository->create($data);

            // Create questions if provided
            if (isset($data['questions']) && is_array($data['questions'])) {
                $this->createQuestions($category, $data['questions']);
            }

            return $category;
        });
    }

    public function update(array $data, Category $category)
    {
        return DB::transaction(function() use ($data, $category) {
            // Handle image upload
            if (isset($data['image'])) {
                // Delete old image if exists
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $imagePath = $data['image']->store('categories', 'public');
                $data['image'] = $imagePath;
            }

            // Update category
            $data['slug'] = Str::slug($data['name']['en']);
            $category = $this->categoryRepository->update($data, $category);

            // Handle questions update
            if (isset($data['questions'])) {
                $this->updateQuestions($category, $data['questions']);
            }

            return $category;
        });
    }

    /**
     * Create questions for a category
     */
    private function createQuestions(Category $category, array $questions)
    {
        foreach ($questions as $index => $questionData) {
            // Set sort order if not provided
            if (!isset($questionData['sort_order'])) {
                $questionData['sort_order'] = $index + 1;
            }

            $questionData['category_id'] = $category->id;
            McqQuestion::create($questionData);
        }
    }

    /**
     * Update questions for a category
     */
    private function updateQuestions(Category $category, array $questions)
    {
        // Delete existing questions
        $category->questions()->delete();

        // Create new questions
        $this->createQuestions($category, $questions);
    }

    public function delete(Category $category)

    {
        return $this->categoryRepository->delete($category);
    }

    public function restore(Category $category){
        return $this->categoryRepository->restore($category);
    }

    public function forceDelete(Category $category)
    {
        return $this->categoryRepository->forceDelete($category);
    }


}
