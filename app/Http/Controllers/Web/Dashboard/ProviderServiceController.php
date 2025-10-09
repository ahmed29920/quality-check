<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ProviderServiceRequest;
use App\Services\BadgeService;
use App\Services\CategoryService;
use App\Services\ProviderServiceService;
use App\Services\ProviderService;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProviderServiceController extends Controller
{
    protected $providerServiceService;
    protected $providerService;
    protected $categoryService;
    protected $badgeService;
    protected $serviceService;

    public function __construct(ProviderServiceService $providerServiceService, ProviderService $providerService, CategoryService $categoryService, BadgeService $badgeService, ServiceService $serviceService)
    {
        $this->providerServiceService = $providerServiceService;
        $this->providerService = $providerService;
        $this->categoryService = $categoryService;
        $this->badgeService = $badgeService;
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of providers.
     */
    public function index(Request $request): View
    {
        $providerServices = $this->providerServiceService->getAll($request);

        return view('dashboard.provider-services.index', compact('providerServices'));
    }

    /**
     * Filter providers via AJAX.
     */
    public function filter(Request $request)
    {
        $providerServices = $this->providerServiceService->getAll($request);

        $html = view('dashboard.provider-services._rows', compact('providerServices'))->render();

        return response()->json(['html' => $html]);
    }

    /**
     * Display the specified provider with their answers.
     */
    public function show($uuid)
    {
        $providerService = $this->providerServiceService->findByUuid($uuid);

        if (!$providerService) {
            abort(404, 'Provider service not found');
        }

        return view('dashboard.provider-services.show', compact('providerService'));
    }
    /**
     * Display the form for creating a new provider service.
     */
    public function create(): View
    {
        $providers = $this->providerService->all();
        $categories = $this->categoryService->all();
        $badges = $this->badgeService->all();
        $services = $this->serviceService->all();
        return view('dashboard.provider-services.create', compact('providers', 'categories', 'badges', 'services'));
    }
    /**
     * Store a newly created provider service in storage.
     */
    public function store(ProviderServiceRequest $request)
    {
        try {
            $this->providerServiceService->create($request->validated());
            return redirect()->route('admin.provider-services.index')->with('success', 'Provider service created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create provider service: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified provider.
     */
    public function edit($uuid): View
    {
        $providerService = $this->providerServiceService->findByUuid($uuid);

        if (!$providerService) {
            abort(404, 'Provider service not found');
        }

        // Get categories for dropdown
        $categories = $this->categoryService->all();
        $badges = $this->badgeService->all();
        $providers = $this->providerService->all();

        $services = $this->serviceService->all();
        return view('dashboard.provider-services.edit', compact('providerService', 'categories', 'badges', 'providers', 'services'));
    }

    /**
     * Update the specified provider in storage.
     */
    public function update(ProviderServiceRequest $request, string $uuid): RedirectResponse
    {

        try {
            $providerService = $this->providerServiceService->findByUuid($uuid);
            if (!$providerService) {
                return redirect()->back()->with('error', 'Provider service not found');
            }

            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $this->providerServiceService->storeImage($request->file('image'), $providerService->uuid);
            }

            $this->providerServiceService->update($providerService, $data);

            return redirect()->route('admin.provider-services.show', $providerService->uuid)->with('success', 'Provider service updated successfully');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update provider service: ' . $e->getMessage());
        }
    }

    /**
     * Toggle provider Service active status.
     */
    public function toggleStatus(string $uuid)
    {
        try {
            $provider = $this->providerServiceService->findByUuid($uuid);

            if (!$provider) {
                return redirect()->back()->with('error', 'Provider service not found');
            }

            $this->providerServiceService->toggleStatus($provider);

            $status = $provider->is_active ? 'activated' : 'deactivated';
            return response()->json(['success' => true, 'message' => "Provider service {$status} successfully"]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update provider service status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified provider service from storage.
     */
    public function destroy(string $uuid)
    {
        $this->providerServiceService->delete($uuid);
        return response()->json(['message' => 'Provider service deleted successfully! 🗑️']);
    }
}
