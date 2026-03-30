<?php
// portfolio-api/database/seeders/ProfileSeeder.php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate first so re-seeding is safe
        Profile::truncate();

        Profile::create([
            'name'         => 'Val Krystoper Abilo',
            'role'         => 'QA Engineer II',
            'bio'          => 'Detail-oriented QA Engineer with 2+ years of hands-on experience designing comprehensive test plans, executing test suites, and shipping bug-free software. Skilled in identifying, documenting, and resolving defects with a strong understanding of QA methodologies. Collaborative team player, Agile-fluent, and passionate about quality at every stage of development.',
            'location'     => 'Manggahan, Pasig City, PH',
            'email'        => 'abilovalkrystoper@gmail.com',
            'phone'        => '+63 947 809 2197',
            'linkedin_url' => 'https://linkedin.com/in/valkrystoper-abilo-a5b88a236',
            'github_url'   => 'https://github.com/YOUR_USERNAME',  // ← update this
            'available'    => true,
        ]);
    }
}
