<?php
// portfolio-api/database/seeders/ExperienceSeeder.php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\ExperienceBullet;
use App\Models\ExperienceTag;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        // Safe to re-seed — cascadeOnDelete cleans up bullets & tags
        Experience::query()->delete();

        $data = [
            [
                'issue_key'    => 'VK-003',
                'title'        => 'Quality Assurance Engineer II · Thurston Software Solutions Inc.',
                'sub_location' => '📍 5F F. Blumentrit, San Juan, Metro Manila',
                'status'       => 'progress',
                'type'         => 'FULL-TIME',
                'date_range'   => 'Apr 14, 2025 → Present',
                'sort_order'   => 1,
                'bullets' => [
                    'Designed and maintained comprehensive test plans and test cases covering functional and regression testing for all product modules.',
                    'Onboarded and mentored newly hired QA team members — led system walkthroughs, maintained clear feature documentation, and established team standards.',
                    'Collaborated with developers, project supervisors, and QA peers to plan testing activities, review strategies, and proactively address risks before each release.',
                    'Analyzed reported issues, performed root cause analysis, and recommended practical fixes to improve system quality and long-term stability.',
                ],
                'tags' => ['Test Plans','Regression','Team Mentoring','Root Cause Analysis','Jira','Agile/Scrum','Documentation'],
            ],
            [
                'issue_key'    => 'VK-002',
                'title'        => 'Software Quality Assurance · 1902 Software Development',
                'sub_location' => '📍 Asean Drive, corner Singapura Rd, Muntinlupa · WriteText.ai',
                'status'       => 'done',
                'type'         => 'PROJECT-BASED',
                'date_range'   => 'Sep 18, 2024 → Mar 17, 2025',
                'sort_order'   => 2,
                'bullets' => [
                    'Spearheaded QA for WriteText.ai — an AI-powered text generation platform. Tested both frontend functionality and backend performance for seamless UX and system reliability.',
                    'Developed and executed test cases to validate AI-generated text accuracy, API integrations, and backend processing pipelines. Reported critical defects directly to the dev team.',
                    'Collaborated with cross-functional teams to improve product quality — provided detailed feedback and recommendations based on comprehensive test results.',
                ],
                'tags' => ['WriteText.ai','AI Platform QA','API Testing','Postman','Backend Testing','Cross-functional Teams'],
            ],
            [
                'issue_key'    => 'VK-001',
                'title'        => 'Software QA Intern · DW Morgan',
                'sub_location' => '📍 Ortigas Center, Mandaluyong',
                'status'       => 'done',
                'type'         => 'INTERNSHIP',
                'date_range'   => 'Oct 16, 2023 → Jul 15, 2024',
                'sort_order'   => 3,
                'bullets' => [
                    'Wrote test scenarios evaluating software usability across multiple modules and user flows — ensuring features met defined acceptance criteria.',
                    'Executed full testing cycles (functional, regression, UAT) and prepared detailed effectiveness reports with defect documentation, severity classifications, and reproduction steps for the production team.',
                ],
                'tags' => ['Test Scenarios','Usability Testing','UAT','Bug Reporting','Defect Tracking'],
            ],
        ];

        foreach ($data as $item) {
            $exp = Experience::create([
                'issue_key'    => $item['issue_key'],
                'title'        => $item['title'],
                'sub_location' => $item['sub_location'],
                'status'       => $item['status'],
                'type'         => $item['type'],
                'date_range'   => $item['date_range'],
                'sort_order'   => $item['sort_order'],
            ]);

            foreach ($item['bullets'] as $i => $text) {
                ExperienceBullet::create([
                    'experience_id' => $exp->id,
                    'bullet_text'   => $text,
                    'sort_order'    => $i + 1,
                ]);
            }

            foreach ($item['tags'] as $i => $tag) {
                ExperienceTag::create([
                    'experience_id' => $exp->id,
                    'tag_name'      => $tag,
                    'sort_order'    => $i + 1,
                ]);
            }
        }
    }
}
