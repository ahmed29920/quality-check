<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'status', 'ticket_from', 'description'
    ];

    protected static function booted(){
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }
}
