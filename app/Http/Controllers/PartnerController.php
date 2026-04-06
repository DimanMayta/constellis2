<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::active()->ordered()->get();
        return view('pages.partners', compact('partners'));
    }
}
