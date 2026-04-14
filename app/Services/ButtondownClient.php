<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ButtondownClient
{
    public function __construct(
        protected string $apiKey,
        protected string $endpoint,
    ) {}

    public function subscribe(string $email, array $metadata = []): Response
    {
        return $this->request()->post('/subscribers', [
            'email_address' => $email,
            'metadata' => $metadata,
        ]);
    }

    public function isConfigured(): bool
    {
        return filled($this->apiKey);
    }

    protected function request(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Token '.$this->apiKey,
            'Content-Type' => 'application/json',
        ])->baseUrl($this->endpoint);
    }
}
