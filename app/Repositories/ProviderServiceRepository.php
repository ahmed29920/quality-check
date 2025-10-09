<?php

namespace App\Repositories;

use App\Models\ProviderService;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderServiceRepository
{
    protected ProviderService $model;

    public function __construct(ProviderService $model)
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
        $query = $this->model->with(['provider']);

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

        if (isset($filters['provider_id'])) {
            $query->where('provider_id', $filters['provider_id']);
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }


        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * Create a new provider.
     */
    public function create(array $data): ProviderService
    {
        return $this->model->create($data);
    }

    /**
     * Find provider by ID.
     */
    public function findById($id): ?ProviderService
    {
        return $this->model->with(['provider', 'service'])->find($id);
    }

    /**
     * Find provider by uuid.
     */
    public function findByUuid($uuid): ?ProviderService
    {
        return $this->model->with(['provider', 'service'])->where('uuid', $uuid)->first();
    }

    /**
     * Update a provider.
     */
    public function update(ProviderService $provider, array $data): bool
    {
        return $provider->update($data);
    }

    /**
     * Find provider by user ID.
     */
    public function findByProviderId($providerId): ?ProviderService
    {
        return $this->model->where('provider_id', $providerId)->first();
    }

    /**
     * Delete a provider.
     */
    public function delete(ProviderService $provider): bool
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
