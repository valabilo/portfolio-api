<?php
// portfolio-api/database/seeders/AwardSeeder.php
namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    public function run(): void
    {
        Award::truncate();

        $awards = [
            [
                'title'      => 'Top 1 · KodeGo Full-Stack Web Development Best Capstone',
                'issuer'     => 'KodeGo Bootcamp',
                'year'       => '2023',
                'sort_order' => 1,
            ],
            [
                'title'      => 'KodeGo Full-Stack Web Development Excellence Award',
                'issuer'     => 'KodeGo Bootcamp',
                'year'       => '2023',
                'sort_order' => 2,
            ],
        ];

        foreach ($awards as $award) {
            Award::create($award);
        }
    }
}
