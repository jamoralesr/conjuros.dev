<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::published()
            ->with(['category', 'authors'])
            ->latest('published_at')
            ->paginate(12);

        return view('front.articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        abort_unless(
            $article->status->value === 'published' && $article->published_at?->isPast(),
            404,
        );

        $article->load(['category', 'tags', 'authors', 'resources']);

        return view('front.articles.show', compact('article'));
    }
}
