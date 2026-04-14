<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;

beforeEach(function () {
    $this->category = Category::factory()->create();
});

test('course detail is public but lessons are gated for guests', function () {
    $course = Course::factory()->published()->for($this->category)->create();
    Lesson::factory()->published()->for($course)->create(['title' => 'Primera lección']);

    $this->get(route('front.courses.show', $course))
        ->assertOk()
        ->assertSee($course->title)
        ->assertSee('Primera lección')
        ->assertSee('Contenido Pro');
});

test('draft course returns 404', function () {
    $course = Course::factory()->for($this->category)->create();

    $this->get(route('front.courses.show', $course))
        ->assertNotFound();
});

test('lesson detail shows paywall for guest', function () {
    $course = Course::factory()->published()->for($this->category)->create();
    $lesson = Lesson::factory()->published()->for($course)->create([
        'body' => '<p>'.str_repeat('pro ', 300).'</p>',
    ]);

    $this->get(route('front.courses.lesson', [$course, $lesson]))
        ->assertOk()
        ->assertSee('Contenido Pro');
});
