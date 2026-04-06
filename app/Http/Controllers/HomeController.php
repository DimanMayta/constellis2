<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Models\ServiceCategory;
use App\Models\Division;

class HomeController extends Controller
{
    public function index()
    {
        $serviceCategories = ServiceCategory::active()->ordered()->with('services')->get();
        $latestNews = NewsArticle::published()->latest()->take(5)->get();
        $divisions = Division::active()->ordered()->get();

        return view('home', compact('serviceCategories', 'latestNews', 'divisions'));
    }
}
