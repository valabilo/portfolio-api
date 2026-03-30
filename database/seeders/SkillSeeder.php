<?php
// portfolio-api/database/seeders/SkillSeeder.php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillSuite;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        SkillSuite::query()->delete(); // cascades to skills

        $suites = [
            [
                'suite_key'  => 'qa',
                'label'      => 'Testing · QA & Manual',
                'count_text' => '6 passed',
                'sort_order' => 1,
                'skills' => [
                    ['name' => 'Manual Testing',               'percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'Regression Testing',           'percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'Functional Testing',           'percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'User Acceptance Testing (UAT)','percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'Mobile Testing (iOS/Android)', 'percentage' =>  95, 'tag' => 'pass'],
                    ['name' => 'Smoke & Sanity Testing',       'percentage' =>  95, 'tag' => 'pass'],
                ],
            ],
            [
                'suite_key'  => 'api',
                'label'      => 'Testing · API & Backend',
                'count_text' => '3 passed',
                'sort_order' => 2,
                'skills' => [
                    ['name' => 'API Testing (Postman)',       'percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'SQL / Database Testing',      'percentage' =>  90, 'tag' => 'pass'],
                    ['name' => 'Backend Performance Testing', 'percentage' =>  85, 'tag' => 'pass'],
                ],
            ],
            [
                'suite_key'  => 'tools',
                'label'      => 'Testing · Tools & Process',
                'count_text' => '4 passed · 1 learning',
                'sort_order' => 3,
                'skills' => [
                    ['name' => 'Jira — Issue & Bug Tracking',       'percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'Agile / Scrum Methodology',          'percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'Test Case Design & Documentation',   'percentage' => 100, 'tag' => 'pass'],
                    ['name' => 'Playwright — E2E Automation',        'percentage' =>  90, 'tag' => 'pass'],
                    ['name' => 'GitHub Actions — CI/CD',             'percentage' =>  80, 'tag' => 'warn'],
                ],
            ],
            [
                'suite_key'  => 'dev',
                'label'      => 'Testing · Dev Stack',
                'count_text' => '4 passed',
                'sort_order' => 4,
                'skills' => [
                    ['name' => 'React JS — Frontend',          'percentage' => 90, 'tag' => 'pass'],
                    ['name' => 'Laravel — Backend Framework',  'percentage' => 85, 'tag' => 'pass'],
                    ['name' => 'MySQL — Relational Database',  'percentage' => 90, 'tag' => 'pass'],
                    ['name' => 'JavaScript — Scripting',       'percentage' => 85, 'tag' => 'pass'],
                ],
            ],
        ];

        foreach ($suites as $suiteData) {
            $suite = SkillSuite::create([
                'suite_key'  => $suiteData['suite_key'],
                'label'      => $suiteData['label'],
                'count_text' => $suiteData['count_text'],
                'sort_order' => $suiteData['sort_order'],
            ]);

            foreach ($suiteData['skills'] as $i => $skill) {
                Skill::create([
                    'suite_id'   => $suite->id,
                    'name'       => $skill['name'],
                    'percentage' => $skill['percentage'],
                    'tag'        => $skill['tag'],
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
