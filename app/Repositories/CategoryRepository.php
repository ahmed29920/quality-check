<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /** @return \Illuminate\Database\Eloquent\Collection */
    public function all()
    {
        return $this->model->all();
    }

    /** @return \Illuminate\Database\Eloquent\Collection */
    public function allWithTrashed()
    {
        return $this->model->withTrashed()->get();
    }

    public function active($limit)
    {
        return $this->model->active()->paginate($limit);
    }

    public function pricable()
    {
        return $this->model->pricable()->get();
    }

    public function findById($id): Category
    {
        return $this->model->with('questions', 'services')->findOrFail($id);
    }
    public function findBySlug($slug): Category
    {
        return $this->model->findOrFail($slug);
    }
    

    public function create(array $data): Category
    {
        return $this->model->create($data);
    }

    public function update(array $data, Category $category): Category
    {
        $category->update($data);

        return $category;
    }

    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }

    public function restore(Category $category): bool
    {
        return (bool) $category->restore();
    }

    public function forceDelete(Category $category): bool
    {
        return (bool) $category->forceDelete();
    }
}
