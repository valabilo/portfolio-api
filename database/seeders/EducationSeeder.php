<?php
// portfolio-api/database/seeders/EducationSeeder.php
namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        Education::truncate();

        $entries = [
            [
                'type'        => 'degree',
                'title'       => 'BS Computer Engineering',
                'institution' => 'ICCT Colleges Inc.',
                'year'        => '2013',
                'sort_order'  => 1,
            ],
            [
                'type'        => 'certification',
                'title'       => 'Full-Stack Web Development',
                'institution' => 'KodeGo',
                'year'        => 'Dec 2022 – Apr 2023',
                'sort_order'  => 2,
            ],
            [
                'type'        => 'training',
                'title'       => 'JavaScript Programming',
                'institution' => 'Bayan Academy (Supported by J.P. Morgan)',
                'year'        => 'Mar 2023',
                'sort_order'  => 3,
            ],
            [
                'type'        => 'training',
                'title'       => 'Teaching English as a Second Language',
                'institution' => 'Clair Voyance',
                'year'        => 'Sep – Oct 2022',
                'sort_order'  => 4,
            ],
            [
                'type'        => 'training',
                'title'       => "Nanay's in I.T. Program",
                'institution' => 'DICT / Government Initiative',
                'year'        => 'Oct 2023 – Apr 2024',
                'sort_order'  => 5,
            ],
        ];

        foreach ($entries as $entry) {
            Education::create($entry);
        }
    }
}
