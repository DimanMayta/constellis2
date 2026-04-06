<?php

namespace App\Http\Controllers;

use App\Models\SatisfactionSurvey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'overall_rating' => 'required|integer|min:1|max:5',
            'design_rating' => 'nullable|integer|min:1|max:5',
            'usability_rating' => 'nullable|integer|min:1|max:5',
            'content_rating' => 'nullable|integer|min:1|max:5',
            'would_recommend' => 'nullable|boolean',
            'suggestions' => 'nullable|string|max:2000',
            'visitor_name' => 'nullable|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
        ]);

        $validated['ip_address'] = $request->ip();

        SatisfactionSurvey::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Thank you for your feedback!']);
        }

        return back()->with('survey_success', 'Thank you for your feedback! Your input helps us improve.');
    }
}
