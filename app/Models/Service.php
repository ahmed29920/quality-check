<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, SoftDeletes , HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'image',
        'slug',
        'category_id',
        'is_active',
        'is_pricable',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'slug' => 'string',
        'category_id' => 'integer',
        'is_active' => 'boolean',
        'is_pricable' => 'boolean',
    ];
    protected $appends = ['image_url'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('dashboard/img/placeholder/no-image.png');
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name.en' => 'Deleted Category',
            'name.ar' => 'فئة محذوفة',
        ]);
    }

    public function providers()
    {
        // return $this->hasMany();
    }

}
