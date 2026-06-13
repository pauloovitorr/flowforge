<?php

namespace App\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // Importar DB para atualizar a tabela
use Illuminate\Support\Facades\Log;

class ProcessaApiJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    protected array $config;

    protected ?int $eventId; // Propriedade para guardar o ID do evento

    /**
     * Create a new job instance.
     */
    // Atualizado para receber o $eventId (com o null como padrão caso não seja enviado)
    public function __construct(array $config, ?int $eventId = null)
    {
        $this->config = $config;
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     */
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = $this->config['url'] ?? null;
        $method = strtoupper($this->config['method'] ?? 'GET');
        $headers = $this->config['headers'] ?? [];
        $body = $this->config['body'] ?? [];

        if (! $url) {
            $this->marcarComoErro('URL de destino não configurada.');

            return;
        }

        try {
            $request = Http::withoutVerifying()->withHeaders($headers);

            if ($method === 'GET') {
                $response = $request->get($url, $body);
            } else {
                $response = $request->asJson()->send($method, $url, ['json' => $body]);
            }

            if ($response->failed()) {
                throw new Exception('API respondeu com status: '.$response->status());
            }

            // === SUCESSO ===
            if ($this->eventId) {
                DB::table('events')->where('id', $this->eventId)->update([
                    'status' => 'success',
                    'error_message' => null, // Limpa o erro se antes tinha falhado
                    'updated_at' => now(),
                ]);
            }

        } catch (Exception $e) {
            Log::error('Erro fatal no ProcessaApiJob: '.$e->getMessage());

            // Só marca erro definitivo na tabela se esgotar as 3 tentativas do Job
            if ($this->attempts() >= $this->tries) {
                $this->marcarComoErro($e->getMessage());
            }

            throw $e;
        }
    }

    /**
     * Auxiliar simplificado para atualizar o banco
     */
    protected function marcarComoErro(string $motivo)
    {
        if ($this->eventId) {
            DB::table('events')->where('id', $this->eventId)->update([
                'status' => 'error',
                'error_message' => $motivo, // Agora salvamos o erro real aqui!
                'updated_at' => now(),
            ]);
        }
    }
}
