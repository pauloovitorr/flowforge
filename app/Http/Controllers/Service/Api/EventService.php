<?php

namespace App\Http\Controllers\Service\Api;

use App\Jobs\ProcessaApiJob;
use App\Jobs\ProcessaEmailJob;
use App\Models\Api\Event;
use App\Models\Email;
use App\Models\Project;
use App\Models\Workflow;
use App\Models\WorkflowActions;
use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
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
    // CORREÇÃO 1: Adicionado o $eventId = null no final da assinatura do método
    public static function dispatchJob($actions, $payload, $eventId = null)
    {
        try {
            // 1. Isolamos os dados internos
            $dadosBrutos = $payload['payload'] ?? $payload;

            // 2. Filtro agressivo: GARANTE que $variaveisBlade só tenha Strings ou Números
            $variaveisBlade = [];
            foreach ($dadosBrutos as $key => $value) {
                if (is_string($value) || is_numeric($value)) {
                    $variaveisBlade[$key] = $value;
                }
            }

            // DEBUG 1: Ver no log o que sobrou para o Blade usar
            Log::info('DEBUG 1 - Variáveis filtradas para o Blade:', $variaveisBlade);

            foreach ($actions as $action) {
                if ($action->type == 'email') {

                    $email = Email::where('id', $action->email_id)->firstOrFail();

                    $template = preg_replace('/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/', '{{ $$1 }}', $email->body);

                    // DEBUG 2: Verificando o template do e-mail
                    Log::info('DEBUG 2 - Renderizando E-mail. Template: '.substr($template, 0, 50).'...');

                    $htmlFinal = Blade::render($template, $variaveisBlade);

                    $recipient = $dadosBrutos['recipient'] ?? ($payload['recipient'] ?? 'fallback@email.com');

                    // Se o seu ProcessaEmailJob também aceitar ID futuramente, passe aqui:
                    ProcessaEmailJob::dispatch($email->subject, $htmlFinal, $recipient);

                } elseif ($action->type == 'api') {

                    if (empty($action->config_api)) {
                        continue;
                    }

                    // 1. Decodifica o JSON original do banco primeiro (sem mexer com Blade ainda)
                    $configApiData = is_array($action->config_api)
                        ? $action->config_api
                        : json_decode($action->config_api, true);

                    if (! $configApiData) {
                        Log::error('Erro ao decodificar config_api. JSON inválido.');

                        continue;
                    }

                    // 2. Renderiza a URL se ela tiver variáveis
                    if (! empty($configApiData['url'])) {
                        $urlTemplate = preg_replace('/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/', '{{ $$1 }}', $configApiData['url']);
                        $configApiData['url'] = Blade::render($urlTemplate, $variaveisBlade);
                    }

                    // 3. Renderiza o BODY se ele existir e tiver variáveis
                    if (! empty($configApiData['body']) && is_array($configApiData['body'])) {
                        foreach ($configApiData['body'] as $chaveBody => $valorBody) {
                            if (is_string($valorBody)) {
                                $bodyTemplate = preg_replace('/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/', '{{ $$1 }}', $valorBody);
                                $configApiData['body'][$chaveBody] = Blade::render($bodyTemplate, $variaveisBlade);
                            }
                        }
                    }

                    // CORREÇÃO 2: Passando o $eventId recebido para dentro do Dispatch do Job!
                    ProcessaApiJob::dispatch($configApiData, $eventId);
                }
            }

        } catch (Exception $e) {
            // Se falhar antes da fila, atualiza como erro se houver ID
            if ($eventId) {
                DB::table('events')->where('id', $eventId)->update([
                    'status' => 'error',
                    'error_message' => $e->getMessage(),
                    'updated_at' => now(),
                ]);
            }
            Log::error('Erro ao dispatchar job: '.$e->getMessage()."\n".$e->getTraceAsString());
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
