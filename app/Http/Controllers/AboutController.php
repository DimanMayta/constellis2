<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Models\Certification;
use App\Models\Division;

class AboutController extends Controller
{
    public function leadership()
    {
        $leaders = Leader::active()->ordered()->get();
        return view('pages.about.leadership', compact('leaders'));
    }

    public function leaderProfile(Leader $leader)
    {
        return view('pages.about.leader-profile', compact('leader'));
    }

    public function ethics()
    {
        $certifications = Certification::all();
        return view('pages.about.ethics', compact('certifications'));
    }

    public function history()
    {
        return view('pages.about.history');
    }

    public function divisions()
    {
        $divisions = Division::active()->ordered()->get();
        return view('pages.about.divisions', compact('divisions'));
    }
}
