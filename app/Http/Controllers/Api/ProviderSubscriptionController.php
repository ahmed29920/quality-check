<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProviderSubscriptionRequest;
use App\Services\ProviderSubscriptionService;
use Illuminate\Http\Request;

class ProviderSubscriptionController extends Controller
{
    protected $providerSubscriptionService;

    public function __construct(ProviderSubscriptionService $providerSubscriptionService)
    {
        $this->providerSubscriptionService = $providerSubscriptionService;
    }

    public function index()
    {
        return $this->providerSubscriptionService->allByProvider(auth()->user()->provider->id);
    }
    public function store(ProviderSubscriptionRequest $request)
    {
        return $this->providerSubscriptionService->create($request->validated());
    }
    public function pay($id){
        return $this->providerSubscriptionService->pay($id);
    }
}
