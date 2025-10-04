<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository
{
    protected Service $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getQuery()
    {
        return $this->model->query();
    }

    public function allWithTrashed()
    {
        return $this->model->withTrashed()->get();
    }

    public function active($limit)
    {
        return $this->model->active()->paginate($limit);
    }

    public function findById($id): Service
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug($slug): Service
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function findWithTrashedBySlug($slug): Service
    {
        return $this->model->withTrashed()->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): Service
    {
        return $this->model->create($data);
    }

    public function update(array $data, Service $service): Service
    {
        $service->update($data);
        return $service;
    }

    public function delete(Service $service): bool
    {
        return (bool) $service->delete();
    }

    public function restore(Service $service): bool
    {
        return (bool) $service->restore();
    }

    public function forceDelete(Service $service): bool
    {
        return (bool) $service->forceDelete();
    }

    public function filter(array $filters)
    {
        $query = $this->model->query();

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['is_pricable'])) {
            $query->where('is_pricable', $filters['is_pricable']);
        }

        if (isset($filters['show_deleted'])) {
            if ($filters['show_deleted'] == 1) {
                $query->withTrashed();
            } elseif ($filters['show_deleted'] == 2) {
                $query->onlyTrashed();
            }
        }

        return $query->latest()->get();
    }
}
