<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 15);
        $categories = $this->categoryService->active($limit);
        return  CategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category =  $this->categoryService->findById($id);
        return new CategoryResource($category);
    }
}
