<?php

namespace App\Http\Controllers\Service;

use App\Models\Workflow;
use Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class WorkflowService
{
    public static function addWorkflow(array $data)
    {
        try {

            Workflow::create($data);

        } catch (Exception $e) {
            Log::error('Erro ao criar projeto: '.$e->getMessage());
            throw $e;
        }

    }

    public static function updateProject($id, array $data)
    {
        try {

        } catch (Exception $e) {
            Log::error('Erro ao atualizar projeto ID '.$e->getMessage());
            throw $e;
        }
    }
}
