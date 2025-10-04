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
        'website',
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
    
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

}
