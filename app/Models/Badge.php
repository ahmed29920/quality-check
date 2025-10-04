<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;


class Badge extends Model
{
    use HasFactory, SoftDeletes , HasTranslations;

    protected $fillable = [
        'name',
        'min_score',
        'max_score',
        'is_active',
    ];
    
    public $translatable = ['name'];

    protected $casts = [
        'name' => 'json',
        'is_active' => 'boolean',
    ];
}
