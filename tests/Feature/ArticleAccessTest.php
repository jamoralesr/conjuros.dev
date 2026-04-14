<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\User;

beforeEach(function () {
    $this->category = Category::factory()->create();
});

test('free article renders full body to anyone', function () {
    $article = Article::factory()
        ->published()
        ->for($this->category)
        ->create([
            'body' => '<p>'.str_repeat('completamente libre ', 300).'</p>',
        ]);

    $this->get(route('front.articles.show', $article))
        ->assertOk()
        ->assertSee($article->title)
        ->assertDontSee('Contenido Pro')
        ->assertSee('completamente libre', escape: false);
});

test('pro article shows paywall gate to guest', function () {
    $article = Article::factory()
        ->published()
        ->pro()
        ->for($this->category)
        ->create([
            'body' => '<p>'.str_repeat('secreto pro ', 500).'</p>',
        ]);

    $this->get(route('front.articles.show', $article))
        ->assertOk()
        ->assertSee($article->title)
        ->assertSee('Contenido Pro');
});

test('draft article returns 404', function () {
    $article = Article::factory()
        ->for($this->category)
        ->create();

    $this->get(route('front.articles.show', $article))
        ->assertNotFound();
});

test('pro article without pro user shows paywall', function () {
    $user = User::factory()->create();
    $article = Article::factory()
        ->published()
        ->pro()
        ->for($this->category)
        ->create([
            'body' => '<p>'.str_repeat('secreto ', 500).'</p>',
        ]);

    $this->actingAs($user)
        ->get(route('front.articles.show', $article))
        ->assertOk()
        ->assertSee('Contenido Pro');
});
