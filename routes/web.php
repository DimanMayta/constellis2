<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\IntranetController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureStoreAccess;
use App\Http\Middleware\EnsureIntranetAccess;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────
// Authentication
// ──────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ──────────────────────────────────────────────
// Homepage
// ──────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ──────────────────────────────────────────────
// Who We Are
// ──────────────────────────────────────────────
Route::prefix('who-we-are')->name('about.')->group(function () {
    Route::get('/leadership', [AboutController::class, 'leadership'])->name('leadership');
    Route::get('/leadership/{leader}', [AboutController::class, 'leaderProfile'])->name('leader');
    Route::get('/ethics-policies-and-certifications', [AboutController::class, 'ethics'])->name('ethics');
    Route::get('/constellis-history', [AboutController::class, 'history'])->name('history');
    Route::get('/divisions', [AboutController::class, 'divisions'])->name('divisions');
});

// ──────────────────────────────────────────────
// Mission & Vision
// ──────────────────────────────────────────────
Route::get('/mission-vision', function () {
    return view('pages.mission-vision');
})->name('mission-vision');

// ──────────────────────────────────────────────
// Experience
// ──────────────────────────────────────────────
Route::get('/experience', [ExperienceController::class, 'index'])->name('experience');

// ──────────────────────────────────────────────
// Partners
// ──────────────────────────────────────────────
Route::get('/partners', [PartnerController::class, 'index'])->name('partners');

// ──────────────────────────────────────────────
// Projects (Public + Restricted)
// ──────────────────────────────────────────────
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::post('/{project}/authenticate', [ProjectController::class, 'authenticate'])->name('authenticate');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
});

// ──────────────────────────────────────────────
// Jobs Portal
// ──────────────────────────────────────────────
Route::prefix('careers')->name('jobs.')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
    Route::get('/{job}', [JobController::class, 'show'])->name('show');
    Route::get('/{job}/apply', [JobController::class, 'apply'])->name('apply');
    Route::post('/{job}/apply', [JobController::class, 'submitApplication'])->name('submit');
});

// ──────────────────────────────────────────────
// What We Do (Services)
// ──────────────────────────────────────────────
Route::prefix('what-we-do')->name('services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/{category}', [ServiceController::class, 'category'])->name('category');
    Route::get('/{category}/{service}', [ServiceController::class, 'show'])->name('show');
});

// ──────────────────────────────────────────────
// Contracts
// ──────────────────────────────────────────────
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');

// ──────────────────────────────────────────────
// Training
// ──────────────────────────────────────────────
Route::get('/training', [TrainingController::class, 'index'])->name('training.index');

// ──────────────────────────────────────────────
// News
// ──────────────────────────────────────────────
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{article}', [NewsController::class, 'show'])->name('show');
});

// ──────────────────────────────────────────────
// Contact + Survey
// ──────────────────────────────────────────────
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');

// ──────────────────────────────────────────────
// Employee Store (Protected)
// ──────────────────────────────────────────────
Route::get('/store/login', [StoreController::class, 'gate'])->name('store.gate');
Route::post('/store/login', [StoreController::class, 'login'])->name('store.login');

Route::prefix('store')->name('store.')->middleware(EnsureStoreAccess::class)->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('index');
    Route::get('/cart', [StoreController::class, 'cart'])->name('cart');
    Route::post('/cart/add', [StoreController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove', [StoreController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [StoreController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [StoreController::class, 'checkout'])->name('checkout.process');
    Route::get('/{product}', [StoreController::class, 'show'])->name('show');
});

// ──────────────────────────────────────────────
// Intranet (Protected)
// ──────────────────────────────────────────────
Route::prefix('intranet')->name('intranet.')->middleware(EnsureIntranetAccess::class)->group(function () {
    Route::get('/', [IntranetController::class, 'dashboard'])->name('dashboard');

    // WhatsApp-style Chat
    Route::get('/chat', [IntranetController::class, 'chat'])->name('chat');
    Route::get('/chat/messages/{user}', [IntranetController::class, 'fetchMessages'])->name('chat.messages');
    Route::get('/chat/poll/{user}', [IntranetController::class, 'pollMessages'])->name('chat.poll');
    Route::post('/chat/send', [IntranetController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/contacts', [IntranetController::class, 'chatContacts'])->name('chat.contacts');
    Route::post('/chat/heartbeat', [IntranetController::class, 'heartbeat'])->name('chat.heartbeat');

    // Announcements
    Route::get('/announcements', [IntranetController::class, 'announcements'])->name('announcements');

    // Documents
    Route::get('/documents', [IntranetController::class, 'documents'])->name('documents');
    Route::get('/documents/{document}/download', [IntranetController::class, 'downloadDocument'])->name('document.download');
});

// ──────────────────────────────────────────────
// Static Pages
// ──────────────────────────────────────────────
Route::get('/who-we-serve', function () {
    return view('pages.who-we-serve');
})->name('who-we-serve');

Route::get('/lexso', function () {
    return view('pages.lexso');
})->name('lexso');

// CMS Pages (catch-all — must be last)
Route::get('/{page}', [PageController::class, 'show'])->name('page.show');
