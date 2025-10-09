<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProviderProfileRequest;
use App\Http\Resources\ProviderResource;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected $providerService;

    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
    }

    public function profile()
    {
        $provider = auth()->user()->provider;
        return response()->json([
            'success' => true,
            'message' => 'Provider profile retrieved successfully',
            'data' => new ProviderResource($provider->load(['category', 'badge']))
        ]);
    }
    public function updateProfile(UpdateProviderProfileRequest $request)
    {
        $data = $request->validated();
        $provider = auth()->user()->provider;
        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Provider not found',
            ], 404);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $this->providerService->storeImage($request->file('image'), $provider->id);
        }
        if ($request->hasFile('pdf')) {
            $data['pdf'] = $this->providerService->storePdf($request->file('pdf'), $provider->id);
        }
      
        $this->providerService->update($provider, $data);
        return response()->json([
            'success' => true,
            'message' => 'Provider profile updated successfully',
        ]);
    }

}
