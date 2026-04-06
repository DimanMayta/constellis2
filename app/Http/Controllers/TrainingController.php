<?php

namespace App\Http\Controllers;

use App\Models\TrainingCategory;

class TrainingController extends Controller
{
    public function index()
    {
        $categories = TrainingCategory::active()->ordered()->with('courses')->get();
        return view('pages.training.index', compact('categories'));
    }
}
