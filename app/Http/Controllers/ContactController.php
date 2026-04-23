<?php

namespace App\Http\Controllers;

use App\Models\ContactOffice;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        $offices = ContactOffice::active()->ordered()->get();
        return view('pages.contact', compact('offices'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactSubmission::create([
            ...$validated,
            'form_type' => 'general',
            'status' => 'new',
        ]);

        return back()->with('success', 'Thank you for contacting us. We will respond within 24 hours.');
    }
}
