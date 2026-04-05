<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = [
        'name', 
        'project_id', 
        'user_id', 
        'trigger_event', 
        'status', 
        'description'
        ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
