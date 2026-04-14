<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use Illuminate\Contracts\View\View;

class TutorialController extends Controller
{
    public function index(): View
    {
        $tutorials = Tutorial::published()
            ->with(['category', 'authors'])
            ->latest('published_at')
            ->paginate(12);

        return view('front.tutorials.index', compact('tutorials'));
    }

    public function show(Tutorial $tutorial): View
    {
        abort_unless(
            $tutorial->status->value === 'published' && $tutorial->published_at?->isPast(),
            404,
        );

        $tutorial->load(['category', 'tags', 'authors', 'resources']);

        return view('front.tutorials.show', compact('tutorial'));
    }
}
