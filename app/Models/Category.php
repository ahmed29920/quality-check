<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, SoftDeletes , HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'has_pricable_services',
        'monthly_subscription_price',
        'yearly_subscription_price',
    ];

    protected $casts = [
        'name' => 'json',
        'slug' => 'string',
        'description' => 'json',
        'is_active' => 'boolean',
        'has_pricable_services' => 'boolean',
        'monthly_subscription_price' => 'decimal:2',
        'yearly_subscription_price' => 'decimal:2',
    ];

    protected $appends = ['image_url'];

    public $translatable = ['name', 'description'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePricable($query)
    {
        return $query->where('has_pricable_services', true);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('dashboard/img/placeholder/no-image.png');
    }

    // public function services()
    // {
    //     return $this->hasMany(Service::class);
    // }

    /**
     * Get the MCQ questions for this category.
     */
    public function questions()
    {
        return $this->hasMany(McqQuestion::class)->active()->ordered();
    }

    /**
     * Get total questions count for this category.
     */
    public function getQuestionsCountAttribute()
    {
        return $this->questions()->count();
    }

    /**
     * Get total possible score for this category.
     */
    public function getTotalScoreAttribute()
    {
        return $this->questions()->sum('score');
    }
}
