<?php
// portfolio-api/app/Http/Controllers/Api/ContactController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactReceived;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * POST /api/contact
     *
     * 1. Validates the form fields
     * 2. Saves the message to the contacts table
     * 3. Sends a branded notification email to Val
     *
     * The email is sent synchronously (no queue needed for a portfolio).
     * If the email fails, the message is still saved and the API
     * returns 201 — the form submission is never lost.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string',  'max:100'],
            'email'   => ['required', 'email',   'max:255'],
            'subject' => ['required', 'string',  'max:200'],
            'message' => ['required', 'string'],
        ]);

        // 1 — Save to database (always succeeds before trying email)
        $contact = Contact::create($validated);

        // 2 — Send notification email to Val
        try {
            Mail::to(config('mail.portfolio_recipient'))
                ->send(new ContactReceived($contact));
        } catch (\Throwable $e) {
            // Log the error but don't fail the API response.
            // The message is saved — Val can check the DB if email fails.
            Log::error('ContactController: email send failed', [
                'contact_id' => $contact->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return response()->json(['message' => 'Message received!'], 201);
    }

    /**
     * GET /api/contacts
     * List all contact submissions (for verification).
     */
    public function index(): JsonResponse
    {
        return response()->json(Contact::latest()->get());
    }

    /**
     * PATCH /api/contacts/{contact}/read
     * Mark a message as read.
     */
    public function markRead(Contact $contact): JsonResponse
    {
        $contact->update(['read_at' => now()]);
        return response()->json(['message' => 'Marked as read.']);
    }
}
