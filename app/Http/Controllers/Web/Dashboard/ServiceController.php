<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ServiceRequest;
use App\Services\ServiceService;
use App\Models\Service;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;
    protected $categoryService;
    public function __construct(ServiceService $serviceService, CategoryService $categoryService)
    {
        $this->serviceService = $serviceService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = $this->serviceService->all();
        $categories = $this->categoryService->all();

        return view('dashboard.services.index', compact('services', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->all();
        return view('dashboard.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {

        $this->serviceService->create($request->validated());
        return redirect()->route('admin.services.index')->with('success', 'Service created successfully! 🎯');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('dashboard.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = $this->categoryService->all();
        
        return view('dashboard.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $this->serviceService->update($request->validated(), $service);
        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully! ✏️');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->serviceService->delete($service);
        return response()->json(['message' => 'Service deleted successfully! 🗑️']);
    }

    public function filter(Request $request)
    {
        $services = $this->serviceService->filter($request->all());
        $html = view('dashboard.services._rows', compact('services'))->render();
        return response()->json(['html' => $html]);
    }

    public function restore($slug)
    {
        $this->serviceService->restore($slug);
        return response()->json(['message' => 'Service restored successfully! 🎯']);
    }
    
    public function forceDelete($slug)
    {
        $this->serviceService->forceDelete($slug);
        return response()->json(['message' => 'Service force deleted successfully! 🗑️']);
    }
}
