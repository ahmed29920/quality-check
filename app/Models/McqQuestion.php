<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class McqQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'options',
        'allows_attachments',
        'requires_attachment',
        'score',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'allows_attachments' => 'boolean',
        'requires_attachment' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the MCQ question.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include active questions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get formatted options for display.
     */
    public function getFormattedOptionsAttribute()
    {
        if (!$this->options) return [];

        return array_map(function($option, $index) {
            return [
                'value' => chr(65 + $index), // A, B, C, D...
                'text' => $option,
                'index' => $index
            ];
        }, $this->options, array_keys($this->options));
    }

    /**
     * Get total possible score for this question.
     */
    public function getTotalScoreAttribute()
    {
        return $this->score;
    }
}
