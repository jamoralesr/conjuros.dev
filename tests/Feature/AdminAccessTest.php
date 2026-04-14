<?php

use App\Enums\UserRole;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

test('guest is redirected to login from admin', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

test('regular user is forbidden from admin', function () {
    $user = User::factory()->create(['role' => UserRole::Member]);

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('admin user reaches dashboard', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Panel de administración');
});

test('admin can list articles', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $category = Category::factory()->create();
    Article::factory()->for($category)->create(['title' => 'Artículo del admin test']);

    $this->actingAs($admin)
        ->get(route('admin.articles.index'))
        ->assertOk()
        ->assertSee('Artículo del admin test');
});
