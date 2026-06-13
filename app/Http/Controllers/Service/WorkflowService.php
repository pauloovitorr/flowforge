<?php

namespace App\Http\Controllers\Service;

use App\Models\Workflow;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Retorna o workflow e extrai todas as variáveis dinâmicas das suas actions e tabelas vinculadas.
     */
    public static function getWorkflowWithVariables(Workflow $workflow): array
    {
        // Garante a segurança: o workflow pertence ao usuário logado?
        if ($workflow->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        // Carrega as ações trazendo junto o e-mail (se houver) e o projeto
        $workflow->load(['project', 'actions.email']);

        $variaveisMapeadas = [];

        foreach ($workflow->actions as $action) {

            // 1. Se a ação for de E-mail e possuir um e-mail vinculado
            if ($action->type === 'email' && $action->email) {
                // Caça os {{ variavel }} diretamente dentro da coluna 'body' da tabela de emails
                preg_match_all('/\{\{\s*([\w_]+)\s*\}\}/', $action->email->body, $matches);
                if (! empty($matches[1])) {
                    $variaveisMapeadas = array_merge($variaveisMapeadas, $matches[1]);
                }
            }
            
            // 2. Se a ação for de API/Webhook, extrai as variáveis dinâmicas do body configurado
            if ($action->type === 'api' && isset($action->config_api['body'])) {
                
                foreach ($action->config_api['body'] as $key => $value) {
                    // Descobre onde está o conteúdo textual (pode ser direto no value ou estruturado)
                    $textoParaValidar = '';
                    
                    if (is_array($value)) {
                        // Caso seu formulário salve como estruturado: ['value' => '...', 'key' => '...']
                        $textoParaValidar = $value['value'] ?? $value['text'] ?? '';
                    } elseif (is_string($value)) {
                        // Caso salve direto: "nome" => "{{ nome_cliente }}"
                        $textoParaValidar = $value;
                    }

                    // Se encontrou algum texto, roda a Regex para capturar os {{ variavel }}
                    if (!empty($textoParaValidar)) {
                        preg_match_all('/\{\{\s*([\w_]+)\s*\}\}/', $textoParaValidar, $matches);
                        if (!empty($matches[1])) {
                            $variaveisMapeadas = array_merge($variaveisMapeadas, $matches[1]);
                        }
                    }
                }
            }
        }

        // Remove duplicados e reorganiza os índices do array
        $variaveisMapeadas = array_values(array_unique($variaveisMapeadas));

        return [
            'workflow' => $workflow,
            'variaveisMapeadas' => $variaveisMapeadas,
        ];
    }
}
