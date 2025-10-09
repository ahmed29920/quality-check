<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => [
                    'en' => 'Bronze',
                    'ar' => 'برونزي'
                ],
                'min_score' => 0,
                'max_score' => 49,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Silver',
                    'ar' => 'فضي'
                ],
                'min_score' => 50,
                'max_score' => 69,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Gold',
                    'ar' => 'ذهبي'
                ],
                'min_score' => 70,
                'max_score' => 84,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Platinum',
                    'ar' => 'بلاتيني'
                ],
                'min_score' => 85,
                'max_score' => 94,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Diamond',
                    'ar' => 'ماسي'
                ],
                'min_score' => 95,
                'max_score' => 100,
                'is_active' => true,
            ],
        ];

        foreach ($badges as $badgeData) {
            Badge::create($badgeData);
        }
    }
}

