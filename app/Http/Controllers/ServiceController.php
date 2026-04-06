<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::active()->ordered()->with('services')->get();
        return view('pages.services.index', compact('categories'));
    }

    public function category(ServiceCategory $category)
    {
        $category->load('services');
        return view('pages.services.category', compact('category'));
    }

    public function show(ServiceCategory $category, Service $service)
    {
        return view('pages.services.show', compact('category', 'service'));
    }
}
