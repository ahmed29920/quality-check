<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\CategoryResource;
use App\Services\ServiceService;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 15);
        $services = $this->serviceService->active($limit);
        return ServiceResource::collection($services->items());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = $this->serviceService->findById($id);
        return new ServiceResource($service);
    }
}
