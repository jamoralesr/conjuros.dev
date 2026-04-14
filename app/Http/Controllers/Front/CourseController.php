<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::published()
            ->with(['category', 'authors'])
            ->withCount('lessons')
            ->latest('published_at')
            ->paginate(12);

        return view('front.courses.index', compact('courses'));
    }

    public function show(Course $course): View
    {
        abort_unless(
            $course->status->value === 'published' && $course->published_at?->isPast(),
            404,
        );

        $course->load(['category', 'tags', 'authors', 'lessons']);

        return view('front.courses.show', compact('course'));
    }

    public function lesson(Course $course, Lesson $lesson): View
    {
        abort_unless($lesson->course_id === $course->id, 404);
        abort_unless(
            $course->status->value === 'published' && $course->published_at?->isPast(),
            404,
        );

        $course->load('lessons');

        return view('front.courses.lesson', compact('course', 'lesson'));
    }
}
