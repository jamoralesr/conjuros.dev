<?php

namespace App\Jobs;

use App\Services\ButtondownClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncSubscriberToButtondown implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(
        public string $email,
        public array $metadata = [],
    ) {}

    public function handle(ButtondownClient $client): void
    {
        if (! $client->isConfigured()) {
            Log::info('Buttondown not configured, skipping sync.', ['email' => $this->email]);

            return;
        }

        $response = $client->subscribe($this->email, $this->metadata);

        if ($response->failed() && $response->status() !== 400) {
            Log::warning('Buttondown sync failed.', [
                'email' => $this->email,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            $response->throw();
        }
    }
}
