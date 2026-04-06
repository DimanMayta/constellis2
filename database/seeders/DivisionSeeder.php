<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            ['name' => 'Triple Canopy', 'slug' => 'triple-canopy', 'description' => 'Elite protective services and security solutions for government and commercial clients operating in complex environments.', 'sort_order' => 1],
            ['name' => 'Centerra', 'slug' => 'centerra', 'description' => 'Comprehensive security services protecting critical infrastructure, government facilities, and high-value assets.', 'sort_order' => 2],
            ['name' => 'AMK9', 'slug' => 'amk9', 'description' => 'World-class explosive and narcotic detection K-9 services for military, government, and commercial operations globally.', 'sort_order' => 3],
            ['name' => 'Olive Group', 'slug' => 'olive-group', 'description' => 'International security consulting and risk management for organizations operating in challenging global environments.', 'sort_order' => 4],
            ['name' => 'Omniplex', 'slug' => 'omniplex', 'description' => 'Specialized investigation, compliance, and security clearance services for federal agencies and defense contractors.', 'sort_order' => 5],
            ['name' => 'TDI', 'slug' => 'tdi', 'description' => 'Explosive ordnance disposal, demining, and environmental remediation services supporting humanitarian operations.', 'sort_order' => 6],
            ['name' => 'Academi', 'slug' => 'academi', 'description' => 'Advanced training and education programs for security, defense, and law enforcement professionals at world-class facilities.', 'sort_order' => 7],
        ];

        foreach ($divisions as $division) {
            Division::create([...$division, 'is_active' => true]);
        }
    }
}
