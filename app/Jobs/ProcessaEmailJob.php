<?php

namespace App\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessaEmailJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    // Adicionamos o ?int $eventId como propriedade pública opcional no construtor
    public function __construct(
        public string $subject, 
        public string $body, 
        public string $recipient,
        public ?int $eventId = null
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Executa o envio do e-mail
            Mail::html($this->body, function ($message) {
                $message->to($this->recipient)
                    ->subject($this->subject);
            });

           
            if ($this->eventId) {
                DB::table('events')->where('id', $this->eventId)->update([
                    'status' => 'success',
                    'error_message' => null, // Limpa qualquer erro anterior se houver
                    'updated_at' => now(),
                ]);
            }

            Log::info("ProcessaEmailJob: E-mail enviado com sucesso para {$this->recipient}");

        } catch (Exception $e) {
            Log::error("Erro fatal no ProcessaEmailJob: " . $e->getMessage());

            // Só marca erro definitivo na tabela se esgotar as 3 tentativas do Job da fila
            if ($this->attempts() >= $this->tries) {
                $this->marcarComoErro($e->getMessage());
            }

            throw $e;
        }
    }

    
    protected function marcarComoErro(string $motivo)
    {
        if ($this->eventId) {
            DB::table('events')->where('id', $this->eventId)->update([
                'status' => 'error',
                'error_message' => "Falha no envio de e-mail: " . $motivo,
                'updated_at' => now(),
            ]);
        }
    }
}