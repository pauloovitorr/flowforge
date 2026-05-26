<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessaEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $subject, public string $body, public string $recipient)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::html($this->body, function ($message) {
            $message->to($this->recipient)
                ->subject($this->subject);
        });
    }
}
