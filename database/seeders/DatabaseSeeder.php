<?php
// portfolio-api/database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProfileSeeder::class,
            EducationSeeder::class,   // ← new
            AwardSeeder::class,       // ← new
            ExperienceSeeder::class,
            SkillSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
