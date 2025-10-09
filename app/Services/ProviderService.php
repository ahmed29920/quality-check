<?php

namespace App\Services;

use App\Models\Provider;
use App\Repositories\ProviderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class ProviderService
{
    protected $providerRepository;

    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    /**
     * Get all providers with
     */
    public function all()
    {
        return $this->providerRepository->all();
    }
    /**
     * Get all providers with filtering and pagination.
     */
    public function getAll(Request $request)
    {
        return $this->providerRepository->filter($request->all());
    }

    /**
     * Get provider by ID.
     */
    public function findById($id): ?Provider
    {
        return $this->providerRepository->findById($id);
    }
    /**
     * Get provider by slug.
     */
    public function findBySlug($slug): ?Provider
    {
        return $this->providerRepository->findBySlug($slug);
    }

    /**
     * Create a new provider.
     */
    public function createProvider(array $data): Provider
    {
        return $this->providerRepository->create($data);
    }

    /**
     * Update a provider.
     */
    public function update(Provider $provider, array $data): bool
    {
        return $this->providerRepository->update($provider, $data);
    }

    /**
     * Toggle provider active status.
     */
    public function toggleStatus(Provider $provider): bool
    {
        return $this->providerRepository->update($provider, [
            'is_active' => !$provider->is_active
        ]);
    }

    /**
     * Toggle provider verification status.
     */
    public function toggleVerification(Provider $provider): bool
    {
        return $this->providerRepository->update($provider, [
            'is_verified' => !$provider->is_verified
        ]);
    }

    /**
     * Store provider image.
     */
    public function storeImage(UploadedFile $file, $providerId): string
    {
        $filename = 'provider_' . $providerId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('providers/images', $filename, 'public');

        return $path;
    }

    /**
     * Store provider PDF.
     */
    public function storePdf(UploadedFile $file, $providerId): string
    {
        $filename = 'provider_' . $providerId . '_' . time() . '.pdf';
        $path = $file->storeAs('providers/pdfs', $filename, 'public');

        return $path;
    }

    public function getStatistics(){
        $totalProviders = $this->providerRepository->getQuery()->count();
        $activeProviders = $this->providerRepository->getQuery()->where('is_active', true)->count();
        $verifiedProviders = $this->providerRepository->getQuery()->where('is_verified', true)->count();
        $inactiveProviders = $this->providerRepository->getQuery()->where('is_active', false)->count();
        $unverifiedProviders = $this->providerRepository->getQuery()->where('is_verified', false)->count();

        return [
            'total_providers' => $totalProviders,
            'active_providers' => $activeProviders,
            'verified_providers' => $verifiedProviders,
            'inactive_providers' => $inactiveProviders,
            'unverified_providers' => $unverifiedProviders,
        ];
    }


}
