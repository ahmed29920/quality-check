<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProviderSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'provider_id', 'category_id', 'start_date', 'end_date', 'status', 'payment_method', 'payment_status', 'amount'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
        'status' => 'string',
        'payment_method' => 'string',
        'payment_status' => 'string',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted(){
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
