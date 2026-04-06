<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = [
            ['name' => 'GSA Schedule 84', 'slug' => 'gsa-schedule-84', 'contract_number' => 'GS-07F-0546V', 'entity' => 'General Services Administration', 'description' => 'Total Solutions for Law Enforcement, Security, Facility Management, and Fire Prevention.', 'categories' => ['Security', 'Law Enforcement', 'Facility Management'], 'sort_order' => 1],
            ['name' => 'OASIS SB Pool 1', 'slug' => 'oasis-sb-pool-1', 'contract_number' => '47QRAA19D00CS', 'entity' => 'General Services Administration', 'description' => 'One Acquisition Solution for Integrated Services supporting complex professional service requirements.', 'categories' => ['Professional Services', 'Consulting'], 'sort_order' => 2],
            ['name' => 'DHS PACTS II', 'slug' => 'dhs-pacts-ii', 'contract_number' => 'HSHQDC-16-J-00380', 'entity' => 'Department of Homeland Security', 'description' => 'Program Management, Administrative, Clerical, and Technical Services supporting DHS missions.', 'categories' => ['Program Management', 'Technical Services'], 'sort_order' => 3],
            ['name' => 'Army IDIQ SAQUAS', 'slug' => 'army-idiq-saquas', 'entity' => 'U.S. Army', 'description' => 'Security services and guard services for U.S. Army installations and critical infrastructure.', 'categories' => ['Security', 'Guard Services', 'Military'], 'sort_order' => 4],
            ['name' => 'DOS WPPS III', 'slug' => 'dos-wpps-iii', 'entity' => 'Department of State', 'description' => 'Worldwide Protective Services providing security to U.S. diplomatic missions and personnel globally.', 'categories' => ['Protective Services', 'Diplomatic Security'], 'sort_order' => 5],
            ['name' => 'DOE Protective Forces', 'slug' => 'doe-protective-forces', 'entity' => 'Department of Energy', 'description' => 'Protective force services for DOE nuclear facilities and critical energy infrastructure.', 'categories' => ['Nuclear Security', 'Protective Forces'], 'sort_order' => 6],
        ];

        foreach ($contracts as $contract) {
            Contract::create([...$contract, 'is_active' => true]);
        }
    }
}
