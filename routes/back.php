<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', EnsureUserIsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::livewire('/', 'pages::admin.dashboard')->name('dashboard');

        Route::livewire('articles', 'pages::admin.articles.index')->name('articles.index');
        Route::livewire('articles/create', 'pages::admin.articles.form')->name('articles.create');
        Route::livewire('articles/{article:slug}/edit', 'pages::admin.articles.form')->name('articles.edit');

        Route::livewire('tutorials', 'pages::admin.tutorials.index')->name('tutorials.index');
        Route::livewire('tutorials/create', 'pages::admin.tutorials.form')->name('tutorials.create');
        Route::livewire('tutorials/{tutorial:slug}/edit', 'pages::admin.tutorials.form')->name('tutorials.edit');

        Route::livewire('courses', 'pages::admin.courses.index')->name('courses.index');
        Route::livewire('courses/create', 'pages::admin.courses.form')->name('courses.create');
        Route::livewire('courses/{course:slug}/edit', 'pages::admin.courses.form')->name('courses.edit');
        Route::livewire('courses/{course:slug}/lessons', 'pages::admin.lessons.index')->name('lessons.index');
        Route::livewire('courses/{course:slug}/lessons/create', 'pages::admin.lessons.form')->name('lessons.create');
        Route::livewire('courses/{course:slug}/lessons/{lesson:slug}/edit', 'pages::admin.lessons.form')->name('lessons.edit');

        Route::livewire('resources', 'pages::admin.resources.index')->name('resources.index');
        Route::livewire('resources/create', 'pages::admin.resources.form')->name('resources.create');
        Route::livewire('resources/{resource:slug}/edit', 'pages::admin.resources.form')->name('resources.edit');

        Route::livewire('categories', 'pages::admin.categories.index')->name('categories.index');
        Route::livewire('tags', 'pages::admin.tags.index')->name('tags.index');
        Route::livewire('authors', 'pages::admin.authors.index')->name('authors.index');
        Route::livewire('plans', 'pages::admin.plans.index')->name('plans.index');
        Route::livewire('subscribers', 'pages::admin.subscribers.index')->name('subscribers.index');
    });
