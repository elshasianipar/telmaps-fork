<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicArticleController extends Controller
{
    /**
     * Resolve the requested locale from ?lang=, defaulting to Indonesian.
     * English falls back to Indonesian per-field when the EN field is empty.
     */
    protected function locale(Request $request): string
    {
        return $request->query('lang') === 'en' ? 'en' : 'id';
    }

    public function index(Request $request): View
    {
        $lang = $this->locale($request);
        app()->setLocale($lang);

        $articles = Article::published()->latest('published_at')->get();

        return view('articles.index', [
            'articles' => $articles,
            'lang' => $lang,
        ]);
    }

    public function show(Request $request, Article $article): View
    {
        if (! $article->isPublished()) {
            abort(404);
        }

        $lang = $this->locale($request);
        app()->setLocale($lang);

        return view('articles.show', [
            'article' => $article,
            'lang' => $lang,
        ]);
    }
}
