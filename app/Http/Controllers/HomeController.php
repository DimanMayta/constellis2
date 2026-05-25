<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\AboutSection;
use App\Models\ContactOffice;
use App\Models\HomepageEvent;
use App\Models\Testimonial;
use App\Models\HomepageClient;
use App\Models\Service;
use App\Models\PositionCategory;
use App\Models\SupportedProject;
use App\Models\CurrentProject;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
        $aboutSections = AboutSection::where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $events = HomepageEvent::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        $clients = HomepageClient::where('is_active', true)->orderBy('sort_order')->get();
        $positionCategories = PositionCategory::where('is_active', true)->orderBy('sort_order')->get();
        $supportedProjects = SupportedProject::where('is_active', true)->orderBy('sort_order')->get();
        $currentProjects = CurrentProject::where('is_active', true)->orderBy('sort_order')->get();
        $primaryOffice = ContactOffice::active()->ordered()->first();
        $offices = ContactOffice::active()->ordered()->get();

        return view('home', compact(
            'heroSlides',
            'aboutSections',
            'services',
            'events',
            'testimonials',
            'clients',
            'positionCategories',
            'supportedProjects',
            'currentProjects',
            'primaryOffice',
            'offices',
        ));
    }
}
