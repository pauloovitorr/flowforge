<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'user_id', 'api_key'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
