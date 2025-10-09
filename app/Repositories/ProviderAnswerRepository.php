<?php

namespace App\Repositories;

use App\Models\ProviderAnswer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderAnswerRepository
{
    /**
     * Get all provider answers with pagination.
     */
    public function getAll()
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get provider answer by ID.
     */
    public function findById($id): ?ProviderAnswer
    {
        return ProviderAnswer::with(['provider', 'question'])->find($id);
    }

    /**
     * Get answers for a specific provider.
     */
    public function getByProvider($providerId, $perPage = 15): LengthAwarePaginator
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->forProvider($providerId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get answers for a specific question.
     */
    public function getByQuestion($questionId, $perPage = 15): LengthAwarePaginator
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->forQuestion($questionId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get evaluated answers.
     */
    public function getEvaluated($perPage = 15): LengthAwarePaginator
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->evaluated()
            ->orderBy('evaluated_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get pending evaluation answers.
     */
    public function getPendingEvaluation($perPage = 15): LengthAwarePaginator
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->pendingEvaluation()
            ->orderBy('submitted_at', 'asc')
            ->paginate($perPage);
    }

    /**
     * Create a new provider answer.
     */
    public function create(array $data): ProviderAnswer
    {
        $data['submitted_at'] = now();

        return ProviderAnswer::create($data);
    }

    /**
     * Update a provider answer.
     */
    public function update(ProviderAnswer $answer, array $data): bool
    {
        return $answer->update($data);
    }

    /**
     * Delete a provider answer.
     */
    public function delete(ProviderAnswer $answer): bool
    {
        return $answer->delete();
    }

    /**
     * Check if provider has already answered a question.
     */
    public function hasAnswered($providerId, $questionId): bool
    {
        return ProviderAnswer::where('provider_id', $providerId)
            ->where('question_id', $questionId)
            ->exists();
    }

    /**
     * Get answer by provider and question.
     */
    public function getByProviderAndQuestion($providerId, $questionId): ?ProviderAnswer
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->where('provider_id', $providerId)
            ->where('question_id', $questionId)
            ->first();
    }

    /**
     * Get all answers for a provider (without pagination).
     */
    public function getAllByProvider($providerId): \Illuminate\Database\Eloquent\Collection
    {
        return ProviderAnswer::with('question')
            ->where('provider_id', $providerId)
            ->get();
    }

    /**
     * Get statistics for a provider.
     */
    public function getProviderStats($providerId): array
    {
        $totalAnswers = ProviderAnswer::forProvider($providerId)->count();
        $evaluatedAnswers = ProviderAnswer::forProvider($providerId)->evaluated()->count();
        $pendingAnswers = ProviderAnswer::forProvider($providerId)->pendingEvaluation()->count();
        $averageScore = ProviderAnswer::forProvider($providerId)->evaluated()->avg('score');

        return [
            'total_answers' => $totalAnswers,
            'evaluated_answers' => $evaluatedAnswers,
            'pending_answers' => $pendingAnswers,
            'average_score' => round($averageScore ?? 0, 2),
        ];
    }

    /**
     * Get statistics for a question.
     */
    public function getQuestionStats($questionId): array
    {
        $totalAnswers = ProviderAnswer::forQuestion($questionId)->count();
        $evaluatedAnswers = ProviderAnswer::forQuestion($questionId)->evaluated()->count();
        $pendingAnswers = ProviderAnswer::forQuestion($questionId)->pendingEvaluation()->count();
        $averageScore = ProviderAnswer::forQuestion($questionId)->evaluated()->avg('score');

        return [
            'total_answers' => $totalAnswers,
            'evaluated_answers' => $evaluatedAnswers,
            'pending_answers' => $pendingAnswers,
            'average_score' => round($averageScore ?? 0, 2),
        ];
    }
}
