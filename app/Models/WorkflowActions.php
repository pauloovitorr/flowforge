<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowActions extends Model
{
    protected $fillable = [
        'workflow_id', 
        'email_id', 
        'type', 
        'config_api', 
    ];

    public function casts(){
      return  [
            'config_api' => 'array'
        ];
    }
}
