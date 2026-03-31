<?php
// portfolio-api/app/Http/Controllers/Api/PortfolioController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillSuite;
use Illuminate\Http\JsonResponse;

class PortfolioController extends Controller
{
    /**
     * GET /api/portfolio
     *
     * Returns the COMPLETE portfolio payload — all content comes from DB.
     * React fetches this once at boot. Update the DB to change any content.
     *
     * Response shape:
     * {
     *   profile:     { name, role, bio, location, email, phone, linkedin_url, github_url, available }
     *   education:   [ { type, title, institution, year } ]
     *   awards:      [ { title, issuer, year } ]
     *   experiences: [ { key, title, sub, status, type, date, bullets[], tags[] } ]
     *   skillSuites: [ { id, label, countText, tests: [{ name, pct, tag }] } ]
     *   projects:    [ { id, icon, name, label, type, desc, github, meta[][], tags[] } ]
     * }
     */
    public function index(): JsonResponse
    {
        $profile = Profile::first();

        $education = Education::orderBy('sort_order')->get()
            ->map(fn ($e) => [
                'type'        => $e->type,
                'title'       => $e->title,
                'institution' => $e->institution,
                'year'        => $e->year,
            ]);

        $awards = Award::orderBy('sort_order')->get()
            ->map(fn ($a) => [
                'title'  => $a->title,
                'issuer' => $a->issuer,
                'year'   => $a->year,
            ]);

        $experiences = Experience::with(['bullets', 'tags'])
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($exp) => [
                'key'     => $exp->issue_key,
                'title'   => $exp->title,
                'sub'     => $exp->sub_location,
                'status'  => $exp->status,
                'type'    => $exp->type,
                'date'    => $exp->date_range,
                'bullets' => $exp->bullets->pluck('bullet_text')->toArray(),
                'tags'    => $exp->tags->pluck('tag_name')->toArray(),
            ]);

        $skillSuites = SkillSuite::with('skills')
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($suite) => [
                'id'        => $suite->suite_key,
                'label'     => $suite->label,
                'countText' => $suite->count_text,
                'tests'     => $suite->skills->map(fn ($skill) => [
                    'name' => $skill->name,
                    'pct'  => $skill->percentage,
                    'tag'  => $skill->tag,
                ])->toArray(),
            ]);

        $projects = Project::with(['meta', 'tags'])
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($p) => [
                'id'     => $p->project_key,
                'icon'   => $p->icon,
                'name'   => $p->name,
                'label'  => $p->label,
                'type'   => $p->type,
                'desc'   => $p->description,
                'github' => $p->github_url,
                'meta'   => $p->meta->map(fn ($m) => [
                    $m->meta_key,
                    $m->meta_value,
                    $m->is_highlighted,
                ])->toArray(),
                'tags'   => $p->tags->pluck('tag_name')->toArray(),
            ]);

        return response()->json([
            'profile'     => $profile,
            'education'   => $education,
            'awards'      => $awards,
            'experiences' => $experiences,
            'skillSuites' => $skillSuites,
            'projects'    => $projects,
        ]);
    }
}
