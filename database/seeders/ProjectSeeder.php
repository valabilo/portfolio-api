<?php
// portfolio-api/database/seeders/ProjectSeeder.php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectMeta;
use App\Models\ProjectTag;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::query()->delete();

        $projects = [
            [
                'project_key' => 'p1',
                'icon'        => '🌐',
                'name'        => 'opencart-test-suite',
                'label'       => 'opencart-suite',
                'type'        => 'WEB APPLICATION TESTING · MANUAL',
                'description' => 'Comprehensive manual test suite for OpenCart e-commerce. Covers login validation, product search, cart management, and full checkout flow. Includes test case spreadsheets with TC-ID, steps, expected vs actual results, and severity-classified bug reports with screenshots.',
                'github_url'  => 'https://github.com/YOUR_USERNAME/qa-testing-projects',
                'sort_order'  => 1,
                'meta' => [
                    ['meta_key' => 'Status',      'meta_value' => '● Active',                          'is_highlighted' => true],
                    ['meta_key' => 'Test Cases',  'meta_value' => '80+ written in Excel',              'is_highlighted' => false],
                    ['meta_key' => 'Bug Reports', 'meta_value' => '12 documented defects',             'is_highlighted' => false],
                    ['meta_key' => 'Modules',     'meta_value' => 'Login · Search · Cart · Checkout · Payment', 'is_highlighted' => false],
                    ['meta_key' => 'Coverage',    'meta_value' => '92%',                               'is_highlighted' => true],
                ],
                'tags' => ['Manual Testing','Regression','Excel','Bug Reports','UAT'],
            ],
            [
                'project_key' => 'p2',
                'icon'        => '⚡',
                'name'        => 'rest-api-collection',
                'label'       => 'api-collection',
                'type'        => 'API TESTING · POSTMAN',
                'description' => 'Postman collection with 40+ automated API tests using JavaScript test scripts. Validates REST endpoints for authentication, CRUD operations, and error handling. Includes environment variables, pre-request scripts, and a full README for team usage.',
                'github_url'  => 'https://github.com/YOUR_USERNAME/qa-testing-projects',
                'sort_order'  => 2,
                'meta' => [
                    ['meta_key' => 'Status',     'meta_value' => '● Active',                               'is_highlighted' => true],
                    ['meta_key' => 'API Tests',  'meta_value' => '40+ automated assertions',               'is_highlighted' => false],
                    ['meta_key' => 'Endpoints',  'meta_value' => 'GET · POST · PUT · DELETE',              'is_highlighted' => false],
                    ['meta_key' => 'Assertions', 'meta_value' => 'Status codes · Response body · Headers', 'is_highlighted' => false],
                    ['meta_key' => 'Pass Rate',  'meta_value' => '100%',                                   'is_highlighted' => true],
                ],
                'tags' => ['Postman','REST API','JavaScript','Laravel API','MySQL'],
            ],
            [
                'project_key' => 'p3',
                'icon'        => '🤖',
                'name'        => 'playwright-e2e-suite',
                'label'       => 'playwright-e2e',
                'type'        => 'E2E AUTOMATION · PLAYWRIGHT',
                'description' => 'End-to-end automated test suite using Playwright (JavaScript). Covers login, search, cart, and checkout flows. Generates HTML reports with screenshots and video traces. Integrated with GitHub Actions for automatic test runs on every push to main.',
                'github_url'  => 'https://github.com/YOUR_USERNAME/qa-testing-projects',
                'sort_order'  => 3,
                'meta' => [
                    ['meta_key' => 'Status',    'meta_value' => '● Active',              'is_highlighted' => true],
                    ['meta_key' => 'E2E Tests', 'meta_value' => '15 automated scripts',  'is_highlighted' => false],
                    ['meta_key' => 'CI/CD',     'meta_value' => 'GitHub Actions on push','is_highlighted' => false],
                    ['meta_key' => 'Reports',   'meta_value' => 'HTML + screenshots + video', 'is_highlighted' => false],
                    ['meta_key' => 'Pass Rate', 'meta_value' => '93%',                   'is_highlighted' => true],
                ],
                'tags' => ['Playwright','JavaScript','GitHub Actions','HTML Reports','CI/CD'],
            ],
            [
                'project_key' => 'p4',
                'icon'        => '🤖',
                'name'        => 'writetext-ai-qa-docs',
                'label'       => 'writetext-qa',
                'type'        => 'AI PLATFORM QA · DOCUMENTATION',
                'description' => 'Full QA documentation from my role at 1902 Software Development. Includes test strategy, detailed test plans, severity matrix, and bug tracker for WriteText.ai — an AI-powered content generation platform.',
                'github_url'  => 'https://github.com/YOUR_USERNAME/qa-testing-projects',
                'sort_order'  => 4,
                'meta' => [
                    ['meta_key' => 'Status',     'meta_value' => '○ Archived',             'is_highlighted' => false],
                    ['meta_key' => 'Test Cases', 'meta_value' => '120+ covering AI outputs','is_highlighted' => false],
                    ['meta_key' => 'Platform',   'meta_value' => 'WriteText.ai (SaaS)',     'is_highlighted' => false],
                    ['meta_key' => 'Type',       'meta_value' => 'AI accuracy · API · Performance', 'is_highlighted' => false],
                    ['meta_key' => 'Severity',   'meta_value' => '3 Critical · 8 High found','is_highlighted' => false],
                ],
                'tags' => ['AI Testing','SaaS QA','Test Strategy','Jira','1902 Software'],
            ],
            [
                'project_key' => 'p5',
                'icon'        => '📱',
                'name'        => 'mobile-qa-checklist',
                'label'       => 'mobile-checklist',
                'type'        => 'MOBILE TESTING · iOS & ANDROID',
                'description' => 'A reusable mobile QA framework covering device compatibility, gestures, push notifications, offline mode behavior, deep links, and OS version matrix for both iOS and Android.',
                'github_url'  => 'https://github.com/YOUR_USERNAME/qa-testing-projects',
                'sort_order'  => 5,
                'meta' => [
                    ['meta_key' => 'Status',    'meta_value' => '● Active',            'is_highlighted' => true],
                    ['meta_key' => 'Platforms', 'meta_value' => 'iOS 15–17 · Android 11–14', 'is_highlighted' => false],
                    ['meta_key' => 'Checklist', 'meta_value' => '60+ test points',     'is_highlighted' => false],
                    ['meta_key' => 'Covers',    'meta_value' => 'Gestures · Offline · Notifications', 'is_highlighted' => false],
                    ['meta_key' => 'Reusable',  'meta_value' => 'Yes — template format','is_highlighted' => true],
                ],
                'tags' => ['Mobile Testing','iOS','Android','Compatibility Matrix'],
            ],
            [
                'project_key' => 'p6',
                'icon'        => '🗄️',
                'name'        => 'mysql-database-tests',
                'label'       => 'mysql-db-tests',
                'type'        => 'DATABASE TESTING · SQL',
                'description' => 'SQL-based test cases for MySQL database integrity validation. Covers data consistency, foreign key constraint testing, stored procedure validation, and data migration verification.',
                'github_url'  => 'https://github.com/YOUR_USERNAME/qa-testing-projects',
                'sort_order'  => 6,
                'meta' => [
                    ['meta_key' => 'Status',    'meta_value' => '● Active',            'is_highlighted' => true],
                    ['meta_key' => 'DB Tests',  'meta_value' => '30+ SQL test cases',  'is_highlighted' => false],
                    ['meta_key' => 'Covers',    'meta_value' => 'Integrity · FK · Stored Procs', 'is_highlighted' => false],
                    ['meta_key' => 'Stack',     'meta_value' => 'MySQL · Laravel ORM', 'is_highlighted' => false],
                    ['meta_key' => 'Pass Rate', 'meta_value' => '100%',                'is_highlighted' => true],
                ],
                'tags' => ['MySQL','SQL','Laravel','Data Integrity','Stored Procedures'],
            ],
        ];

        foreach ($projects as $item) {
            $project = Project::create([
                'project_key' => $item['project_key'],
                'icon'        => $item['icon'],
                'name'        => $item['name'],
                'label'       => $item['label'],
                'type'        => $item['type'],
                'description' => $item['description'],
                'github_url'  => $item['github_url'],
                'sort_order'  => $item['sort_order'],
            ]);

            foreach ($item['meta'] as $i => $m) {
                ProjectMeta::create([
                    'project_id'     => $project->id,
                    'meta_key'       => $m['meta_key'],
                    'meta_value'     => $m['meta_value'],
                    'is_highlighted' => $m['is_highlighted'],
                    'sort_order'     => $i + 1,
                ]);
            }

            foreach ($item['tags'] as $i => $tag) {
                ProjectTag::create([
                    'project_id' => $project->id,
                    'tag_name'   => $tag,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
