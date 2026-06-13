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

    public function workflow(){
      return  $this->belongsTo(Workflow::class, 'workflow_id');
    }

    /**
     * Relacionamento com o e-mail mapeado nesta ação
     */
    public function email()
    {
        // Importante: Verifique se o seu model de Email se chama 'Email' e está em App\Models\Email
        return $this->belongsTo(Email::class, 'email_id');
    }



}
