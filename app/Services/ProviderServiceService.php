<?php

namespace App\Services;

use App\Models\ProviderService;
use App\Repositories\ProviderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ProviderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProviderServiceService
{
    protected $providerServiceRepository;
    protected $serviceRepository;
    protected $providerRepository;
    public function __construct(ProviderServiceRepository $providerServiceRepository, ServiceRepository $serviceRepository, ProviderRepository $providerRepository)
    {
        $this->providerServiceRepository = $providerServiceRepository;
        $this->serviceRepository = $serviceRepository;
        $this->providerRepository = $providerRepository;
    }

    /**
     * Get all providers
     */
    public function all()
    {
        return $this->providerServiceRepository->all();
    }
    /**
     * Get all providers with filtering and pagination.
     */
    public function getAll(Request $request)
    {
        return $this->providerServiceRepository->filter($request->all());
    }

    /**
     * Get provider by provider ID.
     */
    public function findByProviderId($providerId): ?ProviderService
    {
        return $this->providerServiceRepository->findByProviderId($providerId);
    }

    /**
     * Get provider by ID.
     */
    public function findById($id): ?ProviderService
    {
        return $this->providerServiceRepository->findById($id);
    }

    /**
     * Get provider by UUID.
     */
    public function findByUuid($uuid): ?ProviderService
    {
        return $this->providerServiceRepository->findByUuid($uuid);
    }

    /**
     * Create a new provider.
     */
    public function create(array $data)
    {
        $provider = $this->providerRepository->findById($data['provider_id']);
        $service = $this->serviceRepository->findById($data['service_id']);
        if($provider->category_id != $service->category_id){
            throw new \Exception('Provider can have provider services only for services in his category');
        }
        if(!$service->category->has_pricable_services){
            $providerSubscription = $provider->subscriptions()->where('category_id', $service->category_id)->where('status', 'active')->first();
            if(!$providerSubscription){
                throw new \Exception('You are not subscribed to this service, please subscribe to the category of this service to add it');
            }
        }else{
            if(!$data['price']){
                throw new \Exception('Price is required');
            }
        }
        if($provider->services()->where('service_id', $service->id)->exists()){
            throw new \Exception('You already have this service');
        }
        if(isset($data['image'])){
            $data['image'] = $this->storeImage($data['image'], $provider->id);
        }
        $data['provider_id'] = $provider->id;
        $data['is_active'] = $data['is_active'] == '1' ? true : false;
        return $this->providerServiceRepository->create($data);
    }

    /**
     * Update a provider.
     */
    public function update(ProviderService $provider, array $data): bool
    {
        return $this->providerServiceRepository->update($provider, $data);
    }

    /**
     * Toggle provider active status.
     */
    public function toggleStatus(ProviderService $provider): bool
    {
        return $this->providerServiceRepository->update($provider, [
            'is_active' => !$provider->is_active
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
     * Create a new provider service.
     */
    public function apiCreate($data)
    {
        $provider = auth()->user()->provider;
        $service = $this->serviceRepository->findById($data['service_id']);
        if($provider->category_id != $service->category_id){
            return response()->json(['message' => 'You are not allowed to add this service because it is not in your category'], 400);
        }
        if($provider->is_verified == false){
            return response()->json(['message' => 'Your account is not verified'], 400);
        }
        if(!$service->category->has_pricable_services){
            $providerSubscription = $provider->subscriptions()
            ->where('category_id', $service->category_id)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();
            if(!$providerSubscription){
                return response()->json(['message' => 'You are not subscribed to this service, please subscribe to the category of this service to add it'], 400);
            }
        }else{
            if(!$data['price']){
                return response()->json(['message' => 'Price is required'], 400);
            }
        }
        if($provider->services()->where('service_id', $service->id)->exists()){
            return response()->json(['message' => 'You already have this service'], 400);
        }
        if(isset($data['image'])){
            $data['image'] = $this->storeImage($data['image'], $provider->id);
        }
        $data['provider_id'] = $provider->id;

        $providerService = $this->providerServiceRepository->create($data);
        return response()->json(['message' => 'Service added successfully', 'data' => $providerService], 200);


    }

    public function apiUpdate($data, $id)
    {
        $providerService = $this->providerServiceRepository->findById($id);
        if(!$providerService){
            return response()->json(['message' => 'Provider service not found'], 404);
        }
        if($providerService->provider_id != auth()->user()->provider->id){
            return response()->json(['message' => 'You are not allowed to update this service'], 403);
        }
        if(isset($data['image'])){
            $data['image'] = $this->storeImage($data['image'], $providerService->provider_id);
        }
        return $this->providerServiceRepository->update($providerService, $data);
    }

    /**
     * Delete a provider service.
     */
    public function delete(string $uuid)
    {
        $providerService = $this->providerServiceRepository->findByUuid($uuid);
        return $this->providerServiceRepository->delete($providerService);
    }
    public function apiDelete($id)
    {
        $providerService = $this->providerServiceRepository->findById($id);
        if(!$providerService){
            return response()->json(['message' => 'Provider service not found'], 404);
        }
        return $this->providerServiceRepository->delete($providerService);
    }

    public function getStatistics(){
        $totalProviderServices = $this->providerServiceRepository->getQuery()->count();
        $activeProviderServices = $this->providerServiceRepository->getQuery()->where('is_active', true)->count();
        $inactiveProviderServices = $this->providerServiceRepository->getQuery()->where('is_active', false)->count();

        return [
            'total_provider_services' => $totalProviderServices,
            'active_provider_services' => $activeProviderServices,
            'inactive_provider_services' => $inactiveProviderServices,
        ];
    }
}
