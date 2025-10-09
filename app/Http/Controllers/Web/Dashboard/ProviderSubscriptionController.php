<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ProviderSubscriptionService;
use Illuminate\Http\Request;

class ProviderSubscriptionController extends Controller
{
    protected $providerSubscriptionService;

    public function __construct(ProviderSubscriptionService $providerSubscriptionService)
    {
        $this->providerSubscriptionService = $providerSubscriptionService;
    }

    public function index(Request $request)
    {
        $providerSubscriptions = $this->providerSubscriptionService->all($request);
        return view('dashboard.provider-subscriptions.index', compact('providerSubscriptions'));
    }
    public function filter(Request $request)
    {
        $providerSubscriptions = $this->providerSubscriptionService->all($request);
        $html = view('dashboard.provider-subscriptions._rows', compact('providerSubscriptions'))->render();
        return response()->json(['html' => $html]);
    }

    public function show($uuid)
    {
        $providerSubscription = $this->providerSubscriptionService->findByUuid($uuid);
        return view('dashboard.provider-subscriptions.show', compact('providerSubscription'));
    }

}
