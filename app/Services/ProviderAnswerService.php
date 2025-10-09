<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\ProviderAnswer;
use App\Models\Provider;
use App\Models\McqQuestion;
use App\Repositories\BadgeRepository;
use App\Repositories\ProviderAnswerRepository;
use App\Repositories\ProviderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProviderAnswerService
{
    protected $answerRepository;
    protected $providerRepository;
    protected $badgeRepository;
    public function __construct(
        ProviderAnswerRepository $answerRepository,
        ProviderRepository $providerRepository,
        BadgeRepository $badgeRepository
    )
    {
        $this->answerRepository = $answerRepository;
        $this->providerRepository = $providerRepository;
        $this->badgeRepository = $badgeRepository;
    }

    /**
     * Get all provider answers with pagination.
     */
    public function getAll()
    {
        return $this->answerRepository->getAll();
    }

    /**
     * Get provider answer by ID.
     */
    public function findById($id): ?ProviderAnswer
    {
        return $this->answerRepository->findById($id);
    }

    /**
     * Get answers for a specific provider.
     */
    public function getByProvider($providerId, $perPage = 15): LengthAwarePaginator
    {
        return $this->answerRepository->getByProvider($providerId, $perPage);
    }

    /**
     * Get answers for a specific question.
     */
    public function getByQuestion($questionId, $perPage = 15): LengthAwarePaginator
    {
        return $this->answerRepository->getByQuestion($questionId, $perPage);
    }

    /**
     * Get evaluated answers.
     */
    public function getEvaluated($perPage = 15): LengthAwarePaginator
    {
        return $this->answerRepository->getEvaluated($perPage);
    }

    /**
     * Get pending evaluation answers.
     */
    public function getPendingEvaluation($perPage = 15): LengthAwarePaginator
    {
        return $this->answerRepository->getPendingEvaluation($perPage);
    }

    /**
     * Submit an answer for a provider to a question.
     */
    public function submitAnswer(array $data, ?UploadedFile $attachment = null, $providerId = null): ProviderAnswer
    {
        $providerId = $providerId ?? auth()->user()->provider->id ?? null;

        if (!$providerId) {
            throw new \Exception('Provider ID is required.');
        }

        $provider = Provider::findOrFail($providerId);
        $question = McqQuestion::findOrFail($data['question_id']);
        if($provider->category_id && $provider->category_id != $question->category_id){
            throw new \Exception('Provider can have provider answers only for questions in his category');
        }
        if ($this->answerRepository->hasAnswered($providerId, $data['question_id'])) {
            throw new \Exception('Provider has already answered this question.');
        }

        $data['provider_id'] = $providerId;

        if ($attachment) {
            if ($question->requires_attachment && !$attachment) {
                throw new \Exception('This question requires an attachment.');
            }

            if (!$question->allows_attachments && $attachment) {
                throw new \Exception('This question does not allow attachments.');
            }

            $data['attachment'] = $this->storeAttachment($attachment, $provider->id, $question->id);
        } elseif ($question->requires_attachment) {
            throw new \Exception('This question requires an attachment.');
        }

        return $this->answerRepository->create($data);
    }

    /**
     * Update an existing answer.
     */
    public function updateAnswer(ProviderAnswer $answer, array $data, ?UploadedFile $attachment = null): ProviderAnswer
    {
        if ($answer->is_evaluated) {
            throw new \Exception('Cannot update an evaluated answer.');
        }

        if ($attachment) {
            if ($answer->attachment) {
                $this->deleteAttachment($answer->attachment);
            }

            $data['attachment'] = $this->storeAttachment($attachment, $answer->provider_id, $answer->question_id);
        }

        $this->answerRepository->update($answer, $data);
        return $answer->fresh();
    }

    /**
     * Evaluate an answer.
     */
    public function evaluateAnswer(ProviderAnswer $answer, bool $isCorrect): ProviderAnswer
    {
        if($isCorrect){
            $score = $answer->question->score;
        }else{
            $score = 0;
        }

        $answer->markAsEvaluated($score, $isCorrect);

        // Check if this was the last unanswered question for this provider
        $this->checkAndAssignBadge($answer->provider_id);

        return $answer->fresh();
    }

    /**
     * Check if all questions are evaluated and assign appropriate badge and category.
     */
    public function checkAndAssignBadge(int $providerId): void
    {
        // Get all answers for this provider
        $allAnswers = $this->answerRepository->getAllByProvider($providerId);

        // Check if all answers are evaluated
        $totalAnswers = $allAnswers->count();
        $evaluatedAnswers = $allAnswers->where('is_evaluated', true)->count();

        if ($totalAnswers > 0 && $totalAnswers === $evaluatedAnswers) {
            // All questions are evaluated, calculate total score and percentage
            $totalScore = $allAnswers->sum('score');
            $maxPossibleScore = $allAnswers->sum(function($answer) {
                return $answer->question->score;
            });

            $percentage = $maxPossibleScore > 0 ? ($totalScore / $maxPossibleScore) * 100 : 0;

            // Find appropriate badge based on percentage
            $badge = $this->findBadgeByPercentage($percentage);

            // Find the most common category from answered questions
            $category = $allAnswers->first()->question->category;

            // Update provider with badge and category
            $provider = $this->providerRepository->findById($providerId);
            if ($provider) {
                $updateData = [];

                if ($badge) {
                    $updateData['badge_id'] = $badge->id;
                }

                if ($category) {
                    $updateData['category_id'] = $category->id;
                }

                if (!empty($updateData)) {
                    $provider->update($updateData);
                }
            }
        }
    }

    /**
     * Find badge based on score percentage.
     */
    private function findBadgeByPercentage(float $percentage): ? Badge
    {
        // Get all active badges ordered by min_score descending
        $badges = $this->badgeRepository->all();

        // Find the highest badge that matches the percentage
        foreach ($badges as $badge) {
            if ($percentage >= $badge->min_score &&
                ($badge->max_score === null || $percentage <= $badge->max_score)) {
                return $badge;
            }
        }

        return null;
    }


    /**
     * Manually assign badge and category to a provider based on their current answers.
     */
    public function assignBadgeToProvider(int $providerId): bool
    {
        try {
            $this->checkAndAssignBadge($providerId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get provider's score summary for badge calculation.
     */
    public function getProviderScoreSummary(int $providerId): array
    {
        $allAnswers = $this->answerRepository->getAllByProvider($providerId);

        $totalAnswers = $allAnswers->count();
        $evaluatedAnswers = $allAnswers->where('is_evaluated', true)->count();
        $totalScore = $allAnswers->sum('score');
        $maxPossibleScore = $allAnswers->sum(function($answer) {
            return $answer->question->score;
        });

        $percentage = $maxPossibleScore > 0 ? ($totalScore / $maxPossibleScore) * 100 : 0;

        return [
            'total_answers' => $totalAnswers,
            'evaluated_answers' => $evaluatedAnswers,
            'pending_answers' => $totalAnswers - $evaluatedAnswers,
            'total_score' => $totalScore,
            'max_possible_score' => $maxPossibleScore,
            'percentage' => round($percentage, 2),
            'is_complete' => $totalAnswers > 0 && $totalAnswers === $evaluatedAnswers,
        ];
    }

    /**
     * Get category statistics for a provider.
     */
    public function getProviderCategoryStats(int $providerId): array
    {
        $allAnswers = $this->answerRepository->getAllByProvider($providerId);

        $categoryCounts = [];
        $categoryScores = [];

        foreach ($allAnswers as $answer) {
            if ($answer->question && $answer->question->category_id) {
                $categoryId = $answer->question->category_id;
                $categoryName = $answer->question->category->name ?? 'Unknown';

                // Count questions per category
                $categoryCounts[$categoryId] = ($categoryCounts[$categoryId] ?? 0) + 1;

                // Track scores per category
                if (!isset($categoryScores[$categoryId])) {
                    $categoryScores[$categoryId] = [
                        'name' => $categoryName,
                        'total_score' => 0,
                        'max_score' => 0,
                        'count' => 0
                    ];
                }

                $categoryScores[$categoryId]['total_score'] += $answer->score;
                $categoryScores[$categoryId]['max_score'] += $answer->question->score;
                $categoryScores[$categoryId]['count']++;
            }
        }

        // Calculate percentages for each category
        foreach ($categoryScores as $categoryId => &$stats) {
            $stats['percentage'] = $stats['max_score'] > 0 ?
                round(($stats['total_score'] / $stats['max_score']) * 100, 2) : 0;
        }

        return [
            'category_counts' => $categoryCounts,
            'category_scores' => $categoryScores,
            'most_common_category' => !empty($categoryCounts) ?
                array_keys($categoryCounts, max($categoryCounts))[0] : null
        ];
    }

    /**
     * Delete a provider answer.
     */
    public function deleteAnswer(ProviderAnswer $answer): bool
    {
        if ($answer->attachment) {
            $this->deleteAttachment($answer->attachment);
        }

        return $this->answerRepository->delete($answer);
    }

    /**
     * Get statistics for a provider.
     */
    public function getProviderStats($providerId): array
    {
        return $this->answerRepository->getProviderStats($providerId);
    }

    /**
     * Get statistics for a question.
     */
    public function getQuestionStats($questionId): array
    {
        return $this->answerRepository->getQuestionStats($questionId);
    }

    /**
     * Get answers that need evaluation for a specific question.
     */
    public function getAnswersNeedingEvaluation($questionId): Collection
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->forQuestion($questionId)
            ->pendingEvaluation()
            ->orderBy('submitted_at', 'asc')
            ->get();
    }

    /**
     * Get answers that need evaluation for a specific provider.
     */
    public function getProviderAnswersNeedingEvaluation($providerId): Collection
    {
        return ProviderAnswer::with(['provider', 'question'])
            ->forProvider($providerId)
            ->pendingEvaluation()
            ->orderBy('submitted_at', 'asc')
            ->get();
    }

    /**
     * Store attachment file
     */
    protected function storeAttachment(UploadedFile $file, $providerId, $questionId): string
    {
        $filename = 'provider_' . $providerId . '_question_' . $questionId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('provider_answers', $filename, 'public');

        return $path;
    }

    /**
     * Delete attachment file.
     */
    protected function deleteAttachment(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Get attachment URL for an answer.
     */
    public function getAttachmentUrl(ProviderAnswer $answer): ?string
    {
        return $answer->attachment_url;
    }

    /**
     * Download attachment for an answer.
     */
    public function downloadAttachment(ProviderAnswer $answer)
    {
        if (!$answer->attachment) {
            throw new \Exception('No attachment found for this answer.');
        }

        $path = storage_path('app/public/' . $answer->attachment);

        if (!file_exists($path)) {
            throw new \Exception('Attachment file not found.');
        }

        return response()->download($path);
    }
}
