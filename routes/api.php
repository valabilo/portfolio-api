<?php
// portfolio-api/routes/api.php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| GET    /api/portfolio               → Full portfolio data (profile, exp, skills, projects)
| POST   /api/chat                    → AI chat — powered by Anthropic Claude
| POST   /api/contact                 → Save + email contact form submission
| GET    /api/contacts                → List all contact submissions
| PATCH  /api/contacts/{contact}/read → Mark a message as read
| GET    /api/health                  → Health check
|
*/

// Portfolio content
Route::get('/portfolio', [PortfolioController::class, 'index']);

// AI chat
Route::post('/chat', [ChatController::class, 'chat']);

// Contact form
Route::post('/contact',                  [ContactController::class, 'store']);
Route::get('/contacts',                  [ContactController::class, 'index']);
Route::patch('/contacts/{contact}/read', [ContactController::class, 'markRead']);

// Health check
Route::get('/health', fn () => response()->json([
    'status'  => 'ok',
    'service' => 'ValOS Portfolio API',
    'time'    => now()->toISOString(),
]));
