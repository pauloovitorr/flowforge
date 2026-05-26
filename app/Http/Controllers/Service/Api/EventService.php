<?php

namespace App\Http\Controllers\Service\Api;

use App\Jobs\ProcessaEmailJob;
use App\Models\Api\Event;
use App\Models\Email;
use App\Models\Project;
use App\Models\Workflow;
use App\Models\WorkflowActions;
use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;

class EventService
{
    public static function searchProject(string $token)
    {

        try {
            $project = Project::where('api_key', $token)
                ->select('id')
                ->firstOrFail();

            return $project->id;

        } catch (Exception $e) {
            Log::error('Erro ao buscar projeto: '.$e->getMessage());
            throw $e;
        }

    }

    public static function searchWorkflow($project_id, $event_name)
    {

        try {
            $workflow = Workflow::where('project_id', $project_id)
                ->where('status', 'active')
                ->where('trigger_event', $event_name)
                ->select(['id'])
                ->firstOrFail();

            return $workflow->id;

        } catch (Exception $e) {
            Log::error('Erro ao buscar workflow: '.$e->getMessage());
            throw $e;
        }

    }

    // Procuro as actions relacionadas ao workflow
    public static function searchActions($workflow_id)
    {

        try {
            $actions = WorkflowActions::where('workflow_id', $workflow_id)
                ->get();

            return $actions;

        } catch (Exception $e) {
            Log::error('Erro ao buscar actions: '.$e->getMessage());
            throw $e;
        }

    }

    // Dispach o job de acordo com as actions encontradas
    public static function dispatchJob($actions, $payload)
    {
        try {
            foreach ($actions as $action) {
                if ($action->type == 'email') {

                    $email = Email::where('id', $action->email_id)
                        ->firstOrFail();

                    $template = preg_replace('/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/', '{{ $$1 }}', $email->body);

                    $htmlFinal = Blade::render($template, $payload);

                    ProcessaEmailJob::dispatch($email->subject, $htmlFinal, $payload['recipient']);

                }
            }

        } catch (Exception $e) {
            Log::error('Erro ao dispatchar job: '.$e->getMessage());
            throw $e;
        }
    }

    public static function createProject(int $id, array $data)
    {
        try {

            $data['project_id'] = $id;
            $data['status'] = 'pending';
            $event = Event::create($data);

            return $event;

        } catch (Exception $e) {
            Log::error('Erro ao cadastrar o evento: '.$e->getMessage());
            throw $e;
        }

    }
}
