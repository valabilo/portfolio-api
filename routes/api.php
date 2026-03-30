<?php
// portfolio-api/routes/api.php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| GET  /api/portfolio          → All portfolio data (profile, exp, skills, projects)
| POST /api/contact            → Save contact form submission
| GET  /api/contacts           → List all contact submissions
| PATCH /api/contacts/{id}/read → Mark a message read
| GET  /api/health             → Health check
|
*/

// Portfolio content — fetched once by React at boot
Route::get('/portfolio', [PortfolioController::class, 'index']);

// Contact form
Route::post('/contact',               [ContactController::class, 'store']);
Route::get('/contacts',               [ContactController::class, 'index']);
Route::patch('/contacts/{contact}/read', [ContactController::class, 'markRead']);

// Health check
Route::get('/health', fn () => response()->json([
    'status'  => 'ok',
    'service' => 'ValOS Portfolio API',
    'time'    => now()->toISOString(),
]));
