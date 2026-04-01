<?php
// portfolio-api/app/Http/Controllers/Api/ChatController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillSuite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * POST /api/chat
     *
     * Receives a conversation history from React, builds a system prompt
     * from Val's live MySQL data, then calls the Google Gemini API.
     *
     * Uses: gemini-2.0-flash  (free tier, fast, generous limits)
     * Free limits: 15 requests/min · 1,500 requests/day · 1M tokens/min
     *
     * Request body:
     * {
     *   "messages": [
     *     { "role": "user",      "content": "Has Val done test automation?" },
     *     { "role": "assistant", "content": "Yes, ..." },
     *     { "role": "user",      "content": "Tell me more." }
     *   ]
     * }
     *
     * Response: { "reply": "..." }
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'messages'           => ['required', 'array', 'min:1', 'max:20'],
            'messages.*.role'    => ['required', 'in:user,assistant'],
            'messages.*.content' => ['required', 'string', 'max:2000'],
        ]);

        $apiKey = config('services.gemini.key');

        if (empty($apiKey)) {
            return response()->json(
                ['error' => 'Gemini API key is not configured. Add GEMINI_API_KEY to your .env file.'],
                500
            );
        }

        // 1 ── Build system prompt from database ─────────────────────
        $systemPrompt = $this->buildSystemPrompt();

        // 2 ── Convert messages to Gemini format ─────────────────────
        //
        // Anthropic uses: role "assistant"
        // Gemini uses:    role "model"
        //
        // Anthropic uses: content (string)
        // Gemini uses:    parts  (array of {text})
        //
        $geminiContents = collect($request->input('messages'))
            ->map(fn ($msg) => [
                'role'  => $msg['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $msg['content']]],
            ])
            ->values()
            ->toArray();

        // 3 ── Call Gemini API ────────────────────────────────────────
        $model    = config('services.gemini.model', 'gemini-3-flash-preview');
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::timeout(30)
            ->post($endpoint, [
                'system_instruction' => [
                    'parts' => [['text' => $systemPrompt]],
                ],
                'contents'           => $geminiContents,
                'generationConfig'   => [
                    'maxOutputTokens' => 1024,
                    'temperature'     => 0.7,
                ],
                'safetySettings' => [
                    ['category' => 'HARM_CATEGORY_HARASSMENT',        'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_HATE_SPEECH',        'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',  'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',  'threshold' => 'BLOCK_NONE'],
                ],
            ]);

        // 4 ── Handle errors ──────────────────────────────────────────
        if ($response->failed()) {
            Log::error('ChatController: Gemini API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            $errorMsg = $response->json('error.message') ?? 'AI service temporarily unavailable.';

            return response()->json(['error' => $errorMsg], 502);
        }

        // 5 ── Extract reply ──────────────────────────────────────────
        $reply = data_get(
            $response->json(),
            'candidates.0.content.parts.0.text',
            'Sorry, I could not generate a response. Please try again.'
        );

        return response()->json(['reply' => $reply]);
    }

    // ─────────────────────────────────────────────────────────────────
    // Build system prompt from MySQL — called on every request
    // ─────────────────────────────────────────────────────────────────
    private function buildSystemPrompt(): string
    {
        $profile     = Profile::first();
        $education   = Education::orderBy('sort_order')->get();
        $awards      = Award::orderBy('sort_order')->get();
        $experiences = Experience::with(['bullets', 'tags'])->orderBy('sort_order')->get();
        $skillSuites = SkillSuite::with('skills')->orderBy('sort_order')->get();
        $projects    = Project::with(['tags'])->orderBy('sort_order')->get();

        // ── Profile ───────────────────────────────────────────────────
        $profileBlock = <<<EOT
IDENTITY
Name: {$profile->name}
Role: {$profile->role}
Location: {$profile->location}
Email: {$profile->email}
Phone: {$profile->phone}
LinkedIn: {$profile->linkedin_url}
GitHub: {$profile->github_url}
Available for work: {$this->bool($profile->available)}

BIO
{$profile->bio}
EOT;

        // ── Education ─────────────────────────────────────────────────
        $eduBlock = $education->map(fn ($e) =>
            "- [{$e->type}] {$e->title} — {$e->institution}" . ($e->year ? ", {$e->year}" : '')
        )->implode("\n");

        // ── Awards ────────────────────────────────────────────────────
        $awardsBlock = $awards->map(fn ($a) =>
            "- {$a->title}" . ($a->issuer ? " ({$a->issuer})" : '') . ($a->year ? ", {$a->year}" : '')
        )->implode("\n");

        // ── Experience ────────────────────────────────────────────────
        $expBlock = $experiences->map(function ($exp) {
            $bullets = $exp->bullets->map(fn ($b) => "  • {$b->bullet_text}")->implode("\n");
            $tags    = $exp->tags->pluck('tag_name')->implode(', ');
            $status  = $exp->status === 'progress' ? 'CURRENT ROLE' : 'PREVIOUS ROLE';
            return "[{$status}] {$exp->title}\n"
                 . "Period: {$exp->date_range} | Type: {$exp->type}\n"
                 . "Location: {$exp->sub_location}\n"
                 . "Key achievements:\n{$bullets}\n"
                 . "Skills used: {$tags}";
        })->implode("\n\n");

        // ── Skills ────────────────────────────────────────────────────
        $skillsBlock = $skillSuites->map(function ($suite) {
            $skills = $suite->skills->map(fn ($s) =>
                "  - {$s->name} ({$s->percentage}%)" . ($s->tag === 'warn' ? ' [actively learning]' : '')
            )->implode("\n");
            return "{$suite->label}:\n{$skills}";
        })->implode("\n\n");

        // ── Projects ──────────────────────────────────────────────────
        $projectsBlock = $projects->map(fn ($p) =>
            "- {$p->name} [{$p->type}]: {$p->description} | Tools: " .
            $p->tags->pluck('tag_name')->implode(', ')
        )->implode("\n");

        return <<<PROMPT
You are the AI representative of {$profile->name}, a professional QA Tester.
Your role is to answer questions from recruiters, hiring managers, clients, and
collaborators who are visiting Val's interactive portfolio website (ValOS).

Speak on Val's behalf — use first person ("I", "my", "I have") as if you ARE Val.
Be professional, concise, confident, and honest.
Only use the data provided below — do not invent any information. Avoid adding special characters or formatting that isn't in the source data. If you don't know the answer, say "I don't have that information. You can send an email to {$profile->email} to answer that question. I will get back to you as soon as possible."
Keep answers under 150 words unless a detailed explanation is genuinely needed.
Do not mention that you are an AI or that you are reading from a database.
Do not use closing sign-offs like "Best regards" or "Feel free to ask".
For salary/rate questions: say you are open to discussing based on the role.

═══════════════════════════════════════════════════
VAL'S PORTFOLIO DATA (live from database)
═══════════════════════════════════════════════════

{$profileBlock}

EDUCATION
{$eduBlock}

AWARDS & RECOGNITION
{$awardsBlock}

WORK EXPERIENCE
{$expBlock}

TECHNICAL SKILLS
{$skillsBlock}

QA PROJECTS & PORTFOLIO
{$projectsBlock}
PROMPT;
    }

    private function bool(bool $val): string
    {
        return $val ? 'Yes' : 'No';
    }
}
