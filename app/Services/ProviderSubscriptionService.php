<?php

namespace App\Services;

use App\Repositories\ProviderSubscriptionRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class ProviderSubscriptionService
{
    protected $providerSubscriptionRepository;
    protected $categoryRepository;
    public function __construct(ProviderSubscriptionRepository $providerSubscriptionRepository, CategoryRepository $categoryRepository)
    {
        $this->providerSubscriptionRepository = $providerSubscriptionRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function all(Request $request)
    {
        return $this->providerSubscriptionRepository->filter($request->all());
    }
    public function allByProvider($providerId)
    {
        return $this->providerSubscriptionRepository->filter(['provider_id' => $providerId]);
    }

    public function findById($id)
    {
        return $this->providerSubscriptionRepository->findById($id);
    }

    public function findByUuid($uuid)
    {
        return $this->providerSubscriptionRepository->findByUuid($uuid);
    }

    public function create(array $data)
    {
        $provider = auth()->user()->provider;
        $category = $this->categoryRepository->findById($data['category_id']);
        if ($provider->category_id != $category->id) {
            throw new \Exception('Provider can have provider subscriptions only for categories in his category');
        }
        if ($category->has_pricable_services) {
            throw new \Exception('Category has pricable services, it cannot be subscribed to');
        }

        if ($provider->subscriptions()->where('category_id', $category->id)->where('status', 'active')->exists()) {
            throw new \Exception('You already have an active subscription for this category');
        }
        if ($provider->subscriptions()->where('category_id', $category->id)->where('status', 'pending')->exists()) {
            throw new \Exception('You already have a pending subscription for this category');
        }
        if ($data['type'] == 'monthly') {
            $data['start_date'] = now();
            $data['end_date'] = now()->addMonth();
            $data['amount'] = $category->monthly_subscription_price;
        } else {
            $data['start_date'] = now();
            $data['end_date'] = now()->addYear();
            $data['amount'] = $category->yearly_subscription_price;
        }
        $data['provider_id'] = $provider->id;

        return $this->providerSubscriptionRepository->create($data);
    }

    public function pay($id)
    {
        $providerSubscription = $this->providerSubscriptionRepository->findById($id);
        if (!$providerSubscription) {
            throw new \Exception('Provider subscription not found');
        }
        if($providerSubscription->status != 'pending'){
            throw new \Exception('Provider subscription is not pending');
        }
        // return $this->providerSubscriptionRepository->pay($providerSubscription);
        $this->providerSubscriptionRepository->update($providerSubscription, [
            'status' => 'active'
        ]);
        return $providerSubscription;
    }

}
