<?php

namespace App\Models\Api;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    protected $fillable = [
        'project_id',
        'event_name',
        'payload',
        'status'
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    
}