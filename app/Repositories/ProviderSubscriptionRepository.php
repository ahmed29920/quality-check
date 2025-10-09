<?php

namespace App\Repositories;

use App\Models\ProviderSubscription;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderSubscriptionRepository
{
    protected ProviderSubscription $model;

    public function __construct(ProviderSubscription $model)
    {
        $this->model = $model;
    }

    /**
     * Filter providers with pagination.
     */
    public function filter(array $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['category', 'provider']);

        if (isset($filters['provider_id'])) {
            $query->where('provider_id', $filters['provider_id']);
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', Carbon::parse($filters['start_date']));
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', Carbon::parse($filters['end_date']));
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * Create a new provider.
     */
    public function create(array $data): ProviderSubscription
    {
        return $this->model->create($data);
    }

    /**
     * Find provider by ID.
     */
    public function findById($id): ?ProviderSubscription
    {
        return $this->model->with(['category', 'provider'])->find($id);
    }

    /**
     * Find provider by slug.
     */
    public function findByUuid($uuid): ?ProviderSubscription
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    /**
     * Update a provider.
     */
    public function update(ProviderSubscription $provider, array $data): bool
    {
        return $provider->update($data);
    }

    /**
     * Find provider by user ID.
     */
    public function findByProviderId($providerId): ?ProviderSubscription
    {
        return $this->model->where('provider_id', $providerId)->first();
    }

    /**
     * Delete a provider.
     */
    public function delete(ProviderSubscription $provider): bool
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
