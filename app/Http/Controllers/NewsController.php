<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;

class NewsController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::published()->latest()->paginate(12);
        return view('pages.news.index', compact('articles'));
    }

    public function show(NewsArticle $article)
    {
        $related = NewsArticle::published()
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.news.show', compact('article', 'related'));
    }
}
