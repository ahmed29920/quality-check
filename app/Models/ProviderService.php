<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class ProviderService extends Model
{
    use HasFactory, SoftDeletes , HasTranslations;

    protected $fillable = ['uuid', 'provider_id', 'service_id', 'price', 'description', 'image', 'is_active'];

    protected $casts = [
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    protected $translatable = ['description'];

    protected $appends = ['image_url'];

    protected static function booted(){
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('dashboard/img/placeholder/no-image.png');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
