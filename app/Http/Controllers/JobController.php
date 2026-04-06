<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::active()->ordered()->with('project');

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('type')) {
            $query->where('employment_type', $request->type);
        }
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $jobs = $query->paginate(12);
        return view('pages.jobs.index', compact('jobs'));
    }

    public function show(JobPosting $job)
    {
        $job->load('project');
        return view('pages.jobs.show', compact('job'));
    }

    public function apply(JobPosting $job)
    {
        return view('pages.jobs.apply', compact('job'));
    }

    public function submitApplication(Request $request, JobPosting $job)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'cover_letter' => 'nullable|string|max:5000',
            'experience_summary' => 'nullable|string|max:5000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'nda' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'interview_request' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'application_form' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $application = new JobApplication([
            'job_posting_id' => $job->id,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'experience_summary' => $validated['experience_summary'] ?? null,
            'status' => 'received',
        ]);

        // Store uploaded files
        if ($request->hasFile('cv')) {
            $application->cv_path = $request->file('cv')->store('applications/cv', 'public');
        }
        if ($request->hasFile('nda')) {
            $application->nda_path = $request->file('nda')->store('applications/nda', 'public');
        }
        if ($request->hasFile('interview_request')) {
            $application->interview_request_path = $request->file('interview_request')->store('applications/interview', 'public');
        }
        if ($request->hasFile('application_form')) {
            $application->application_form_path = $request->file('application_form')->store('applications/forms', 'public');
        }

        $application->save();

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Your application has been submitted successfully. We will review it and get back to you.');
    }
}
