<?php

namespace App\Repositories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProviderRepository
{
    protected Provider $model;

    public function __construct(Provider $model)
    {
        $this->model = $model;
    }

    /**
     * Get all providers
     */
    public function all()
    {
        return $this->model->all();
    }
    /**
     * Filter providers with pagination.
     */
    public function filter(array $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['category', 'badge', 'user'])
            ->withCount('answers');

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhereHas('user', function ($userQuery) use ($filters) {
                        $userQuery->where('name', 'like', "%{$filters['search']}%")
                            ->orWhere('email', 'like', "%{$filters['search']}%")
                            ->orWhere('phone', 'like', "%{$filters['search']}%");
                    });
            });
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['is_verified'])) {
            $query->where('is_verified', $filters['is_verified']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * Create a new provider.
     */
    public function create(array $data): Provider
    {
        return $this->model->create($data);
    }

    /**
     * Find provider by ID.
     */
    public function findById($id): ?Provider
    {
        return $this->model->with(['category', 'badge', 'user'])->find($id);
    }

    /**
     * Find provider by slug.
     */
    public function findBySlug($slug): ?Provider
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Update a provider.
     */
    public function update(Provider $provider, array $data): bool
    {
        return $provider->update($data);
    }

    /**
     * Find provider by user ID.
     */
    public function findByUserId($userId): ?Provider
    {
        return $this->model->where('user_id', $userId)->first();
    }

    /**
     * Delete a provider.
     */
    public function delete(Provider $provider): bool
    {
        return $provider->delete();
    }

    /**
     * Get query builder.
     */
    public function getQuery()
    {
        return $this->model->query();
    }
}
