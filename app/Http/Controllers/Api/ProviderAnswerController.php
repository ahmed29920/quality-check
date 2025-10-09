<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProviderAnswerRequest;
use App\Http\Resources\ProviderAnswerResource;
use App\Services\ProviderAnswerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProviderAnswerController extends Controller
{
    protected $providerAnswerService;

    public function __construct(ProviderAnswerService $providerAnswerService)
    {
        $this->providerAnswerService = $providerAnswerService;
    }

    /**
     * Store a newly created provider answer.
     */
    public function store(StoreProviderAnswerRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $attachment = $request->file('attachment');

            $answer = $this->providerAnswerService->submitAnswer($data, $attachment);

            return response()->json([
                'success' => true,
                'message' => 'Answer submitted successfully.',
                'data' => new ProviderAnswerResource($answer->load(['provider', 'question']))
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit answer.',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get the authenticated provider's answers.
     */
    public function getMyAnswers(Request $request)  
    {
        try {
            $providerId = auth()->user()->provider->id ?? null;

            if (!$providerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Provider account not found.'
                ], 404);
            }

            $perPage = $request->query('per_page', 15);
            $answers = $this->providerAnswerService->getByProvider($providerId, $perPage);

            return ProviderAnswerResource::collection($answers);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve your answers.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
