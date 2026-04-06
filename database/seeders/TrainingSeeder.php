<?php

namespace Database\Seeders;

use App\Models\TrainingCategory;
use App\Models\TrainingCourse;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'High Threat Protection',
                'slug' => 'high-threat-protection',
                'anchor_id' => 'High_Threat_Protection',
                'description' => 'Advanced protective security operations training for high-risk environments.',
                'sort_order' => 1,
                'courses' => [
                    ['name' => 'Protective Security Detail (PSD)', 'description' => 'Comprehensive training in protective operations, advance work, and motorcade security.', 'location' => 'Moyock, NC'],
                    ['name' => 'High Threat Security Operations', 'description' => 'Advanced security operations in hostile and high-threat environments.', 'location' => 'Moyock, NC'],
                ],
            ],
            [
                'name' => 'Firearms Training',
                'slug' => 'firearms-training',
                'anchor_id' => 'High_Risk_Live_Fire',
                'description' => 'Professional firearms instruction from basic marksmanship to advanced tactical shooting.',
                'sort_order' => 2,
                'courses' => [
                    ['name' => 'Handgun Fundamentals', 'description' => 'Foundation course in handgun safety, marksmanship, and defensive shooting techniques.', 'location' => 'Moyock, NC'],
                    ['name' => 'Carbine/Rifle Operations', 'description' => 'Tactical carbine and rifle training for military and law enforcement operators.', 'location' => 'Moyock, NC'],
                    ['name' => 'Shotgun Tactical', 'description' => 'Tactical shotgun employment and advanced engagement techniques.', 'location' => 'Moyock, NC'],
                ],
            ],
            [
                'name' => 'Counter Terrorist',
                'slug' => 'counter-terrorist',
                'anchor_id' => 'Counter_Terrorist',
                'description' => 'Counter-terrorism tactics, techniques, and procedures for security professionals.',
                'sort_order' => 3,
                'courses' => [
                    ['name' => 'Counter Terrorism Operations', 'description' => 'Advanced counter-terrorism training covering threat assessment, response tactics, and incident management.', 'location' => 'Moyock, NC'],
                ],
            ],
            [
                'name' => 'K9 Training',
                'slug' => 'k9-training',
                'anchor_id' => 'K9',
                'description' => 'Comprehensive K-9 handler and detection dog training programs.',
                'sort_order' => 4,
                'courses' => [
                    ['name' => 'Explosive Detection K-9 Handler', 'description' => 'Train as an explosive detection K-9 handler with AMK9 certified instructors.', 'location' => 'San Antonio, TX'],
                    ['name' => 'Narcotic Detection K-9 Handler', 'description' => 'Narcotic detection K-9 handler certification course.', 'location' => 'San Antonio, TX'],
                    ['name' => 'Patrol K-9 Operations', 'description' => 'Patrol dog handling, suspect apprehension, and area search techniques.', 'location' => 'San Antonio, TX'],
                ],
            ],
            [
                'name' => 'Basic & Advanced Driving',
                'slug' => 'basic-advanced-driving',
                'anchor_id' => 'Basic_Advanced_Driving',
                'description' => 'Defensive and evasive driving courses for security and executive protection professionals.',
                'sort_order' => 5,
                'courses' => [
                    ['name' => 'Evasive Driving', 'description' => 'Advanced evasive and tactical driving techniques for hostile environments.', 'location' => 'Moyock, NC'],
                    ['name' => 'Motorcade Operations', 'description' => 'Tactical motorcade driving, route selection, and convoy security.', 'location' => 'Moyock, NC'],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $courses = $catData['courses'];
            unset($catData['courses']);

            $category = TrainingCategory::create([...$catData, 'is_active' => true]);

            foreach ($courses as $i => $courseData) {
                $category->courses()->create([
                    ...$courseData,
                    'slug' => \Str::slug($courseData['name']),
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}
