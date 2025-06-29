<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class HandleSquareWebhook extends SpatieProcessWebhookJob
{


    public function handle(): void
    {
        $webhook = $this->webhookCall;
        dd($webhook);
    }
}
