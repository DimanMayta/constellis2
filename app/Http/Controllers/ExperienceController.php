<?php

namespace App\Http\Controllers;

use App\Models\Leader;

class ExperienceController extends Controller
{
    public function index()
    {
        $leaders = Leader::active()->ordered()->get();
        $combinedYears = Leader::getCombinedYears();
        $countries = Leader::getAllCountries();
        $veteranPercentage = Leader::getVeteranPercentage();
        $totalLeaders = $leaders->count();
        $totalVeterans = $leaders->where('is_veteran', true)->count();

        return view('pages.experience', compact(
            'leaders', 'combinedYears', 'countries',
            'veteranPercentage', 'totalLeaders', 'totalVeterans'
        ));
    }
}
