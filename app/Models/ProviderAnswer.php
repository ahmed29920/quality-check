<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'provider_id',
        'question_id',
        'answer',
        'attachment',
        'score',
        'is_correct',
        'is_evaluated',
        'submitted_at',
        'evaluated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_evaluated' => 'boolean',
        'score' => 'integer',
        'is_correct' => 'boolean',
        'submitted_at' => 'datetime',
        'evaluated_at' => 'datetime',
    ];

    /**
     * Get the provider that owns the answer.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get the question that this answer belongs to.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(McqQuestion::class, 'question_id');
    }

    /**
     * Scope a query to only include evaluated answers.
     */
    public function scopeEvaluated($query)
    {
        return $query->where('is_evaluated', true);
    }

    /**
     * Scope a query to only include unevaluated answers.
     */
    public function scopePendingEvaluation($query)
    {
        return $query->where('is_evaluated', false);
    }

    /**
     * Scope a query to filter by provider.
     */
    public function scopeForProvider($query, $providerId)
    {
        return $query->where('provider_id', $providerId);
    }

    /**
     * Scope a query to filter by question.
     */
    public function scopeForQuestion($query, $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    /**
     * Get the attachment URL if attachment exists.
     */
    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    /**
     * Check if the answer has an attachment.
     */
    public function hasAttachment()
    {
        return !empty($this->attachment);
    }

    /**
     * Mark the answer as evaluated with score and feedback.
     */
    public function markAsEvaluated($score = null, $isCorrect = null)
    {
        $this->update([
            'is_evaluated' => true,
            'score' => $score,
            'is_correct' => $isCorrect,
            'evaluated_at' => now(),
        ]);
    }
}
