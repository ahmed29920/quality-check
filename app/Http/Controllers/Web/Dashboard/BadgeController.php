<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\BadgeRequest;
use App\Models\Badge;
use App\Services\BadgeService;

class BadgeController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function index()
    {
        $badges = $this->badgeService->all();
        return view('dashboard.badges.index', compact('badges'));
    }
    
       
    public function store(BadgeRequest $request)
    {
        $this->badgeService->create($request->validated());
        return response()->json(['message' => 'Badge created successfully! 🎯']);
    }

    public function show(Badge $badge)
    {
        return response()->json($badge);
    }

    public function update(BadgeRequest $request, Badge $badge)
    {
        $this->badgeService->update($request->validated(), $badge);
        return response()->json(['message' => 'Badge updated successfully! 🎯']);
    }
    
    public function destroy(Badge $badge)
    {
        $this->badgeService->delete($badge);
        return response()->json(['message' => 'Badge deleted successfully! 🗑️']);
    }
    
}
