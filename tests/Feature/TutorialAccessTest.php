<?php

use App\Models\Category;
use App\Models\Tutorial;

beforeEach(function () {
    $this->category = Category::factory()->create();
});

test('free tutorial renders full body', function () {
    $tutorial = Tutorial::factory()
        ->published()
        ->for($this->category)
        ->create([
            'body' => '<p>'.str_repeat('libre ', 300).'</p>',
        ]);

    $this->get(route('front.tutorials.show', $tutorial))
        ->assertOk()
        ->assertSee($tutorial->title)
        ->assertDontSee('Contenido Pro');
});

test('pro tutorial shows paywall', function () {
    $tutorial = Tutorial::factory()
        ->published()
        ->pro()
        ->for($this->category)
        ->create([
            'body' => '<p>'.str_repeat('secreto ', 500).'</p>',
        ]);

    $this->get(route('front.tutorials.show', $tutorial))
        ->assertOk()
        ->assertSee('Contenido Pro');
});

test('tutorials index lists only published', function () {
    Tutorial::factory()->published()->for($this->category)->create(['title' => 'Publicado']);
    Tutorial::factory()->for($this->category)->create(['title' => 'Borrador']);

    $this->get(route('front.tutorials.index'))
        ->assertOk()
        ->assertSee('Publicado')
        ->assertDontSee('Borrador');
});
