<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProviderServiceRequest;
use App\Http\Requests\Api\UpdateProviderServiceRequest;
use App\Services\ProviderServiceService;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{
    protected $providerServiceService;

    public function __construct(ProviderServiceService $providerServiceService)
    {
        $this->providerServiceService = $providerServiceService;
    }
    public function providerIndex()
    {
        $provider = auth()->user()->provider;
        $providerServices = $provider->services()->with(['service', 'provider'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Provider services retrieved successfully',
            'data' => $providerServices
        ]);
    }

    // Create a new provider service
    public function store(CreateProviderServiceRequest $request)
    {
        return $this->providerServiceService->apiCreate($request->validated());
    }

    public function update(UpdateProviderServiceRequest $request, $id)
    {
        $this->providerServiceService->apiUpdate($request->validated(), $id);
        return response()->json([
            'success' => true,
            'message' => 'Provider service updated successfully',
        ]);
    }
    public function destroy($id)
    {
        $this->providerServiceService->apiDelete($id);
        return response()->json([
            'success' => true,
            'message' => 'Provider service deleted successfully',
        ]);
    }

}
