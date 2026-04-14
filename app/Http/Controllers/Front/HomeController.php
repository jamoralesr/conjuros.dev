<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Course;
use App\Models\Tutorial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('front.home', [
            'latestArticles' => Article::published()->latest('published_at')->take(3)->get(),
            'latestTutorials' => Tutorial::published()->latest('published_at')->take(3)->get(),
            'latestCourses' => Course::published()->latest('published_at')->take(3)->get(),
        ]);
    }
}
