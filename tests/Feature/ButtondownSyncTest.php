<?php

use App\Jobs\SyncSubscriberToButtondown;
use App\Services\ButtondownClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

test('registration dispatches Buttondown sync job', function () {
    Queue::fake();

    $this->post(route('register'), [
        'name' => 'Ana Prueba',
        'email' => 'ana@conjuros.test',
        'password' => 'SuperSecreto123!',
        'password_confirmation' => 'SuperSecreto123!',
    ]);

    Queue::assertPushed(SyncSubscriberToButtondown::class, function (SyncSubscriberToButtondown $job) {
        return $job->email === 'ana@conjuros.test';
    });
});

test('job is a no-op when Buttondown is not configured', function () {
    config()->set('services.buttondown.key', '');
    $this->app->forgetInstance(ButtondownClient::class);

    Http::fake();

    $job = new SyncSubscriberToButtondown('nobody@conjuros.test', []);
    $job->handle(app(ButtondownClient::class));

    Http::assertNothingSent();
});

test('job sends subscribe request when configured', function () {
    config()->set('services.buttondown.key', 'test-key');
    config()->set('services.buttondown.endpoint', 'https://api.buttondown.email/v1');
    $this->app->forgetInstance(ButtondownClient::class);

    Http::fake([
        'api.buttondown.email/*' => Http::response(['id' => 'sub_1'], 201),
    ]);

    $job = new SyncSubscriberToButtondown('hola@conjuros.test', ['source' => 'test']);
    $job->handle(app(ButtondownClient::class));

    Http::assertSent(fn ($request) => $request->url() === 'https://api.buttondown.email/v1/subscribers'
        && $request['email_address'] === 'hola@conjuros.test'
        && $request['metadata']['source'] === 'test'
    );
});
