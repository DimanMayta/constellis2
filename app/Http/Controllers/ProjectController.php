<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::active()->ordered()->get();
        return view('pages.projects.index', compact('projects'));
    }

    public function authenticate(Request $request, Project $project)
    {
        $request->validate(['access_code' => 'required|string']);

        if ($project->verifyAccessCode($request->access_code)) {
            session()->put('project_access.' . $project->id, true);
            return redirect()->route('projects.show', $project);
        }

        return back()->withErrors(['access_code' => 'Invalid access code. Please try again.']);
    }

    public function show(Project $project)
    {
        // Check if user is authenticated OR has session access
        if (!auth()->check() && !session('project_access.' . $project->id)) {
            return redirect()->route('projects.index')
                ->with('error', 'Please enter the access code to view project details.');
        }

        return view('pages.projects.show', compact('project'));
    }
}
