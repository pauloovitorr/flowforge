<?php

namespace App\Http\Controllers\Service;

use App\Models\Workflow;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkflowService
{
    public static function addWorkflow(array $data)
    {
        try {
            Workflow::create($data);
        } catch (Exception $e) {
            throw $e;
        }

    }

    public static function updateProject($id, array $data)
    {
        try {

           $workflow = Workflow::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            $workflow->update($data);

        } catch (Exception $e) {
            
            throw $e;
        }
    }
}
