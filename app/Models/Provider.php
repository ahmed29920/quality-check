<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Provider extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'user_id',
        'category_id',
        'badge_id',
        'latitude',
        'longitude',
        'address',
        'website_link',
        'established_date',
        'start_time',
        'end_time',
        'is_active',
        'is_verified',
        'image',
        'pdf',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'established_date' => 'date',
    ];

    protected $appends = ['image_url', 'pdf_url'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('dashboard/img/placeholder/no-image.png');
    }

    public function getPdfUrlAttribute()
    {
        return $this->pdf ? asset('storage/' . $this->pdf) : asset('dashboard/img/placeholder/no-image.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Get all answers provided by this provider.
     */
    public function answers()
    {
        return $this->hasMany(ProviderAnswer::class);
    }

    /**
     * Get evaluated answers for this provider.
     */
    public function evaluatedAnswers()
    {
        return $this->hasMany(ProviderAnswer::class)->evaluated();
    }

    /**
     * Get pending evaluation answers for this provider.
     */
    public function pendingAnswers()
    {
        return $this->hasMany(ProviderAnswer::class)->pendingEvaluation();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function services()
    {
        return $this->hasMany(ProviderService::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ProviderSubscription::class);
    }
}
