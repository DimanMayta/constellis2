<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Security Services',
                'slug' => 'security-services',
                'description' => 'Comprehensive physical security solutions including armed and unarmed personnel, K-9 units, and command center operations.',
                'sort_order' => 1,
                'is_active' => true,
                'services' => [
                    ['name' => 'Armed/Unarmed Static & Mobile', 'slug' => 'armed-unarmed-static-mobile', 'short_description' => 'Professional armed and unarmed security personnel for static and mobile protective operations.'],
                    ['name' => 'Explosive/Narcotic/Patrol K9 Services', 'slug' => 'explosive-narcotic-patrol-k9-services', 'short_description' => 'World-class canine detection and patrol services for explosive, narcotic, and security screening operations.'],
                    ['name' => 'Command Center & Access Control', 'slug' => 'command-center-access-control', 'short_description' => 'Advanced command center operations and electronic access control solutions for facility security.'],
                ],
            ],
            [
                'name' => 'Intelligence Support',
                'slug' => 'intelligence-support',
                'description' => 'Advanced intelligence analysis, risk assessment, and national security services providing actionable insights.',
                'sort_order' => 2,
                'is_active' => true,
                'services' => [
                    ['name' => 'National Security Services', 'slug' => 'national-security-services', 'short_description' => 'Supporting national security missions with expert personnel, analysis, and operational capabilities.'],
                    ['name' => 'Analysis & Research', 'slug' => 'analysis-research', 'short_description' => 'Deep-dive analytical capabilities and research services for informed decision making.'],
                    ['name' => 'Risk Assessments & Investigations', 'slug' => 'risk-assessments-investigations', 'short_description' => 'Comprehensive risk assessment and investigation services for organizations worldwide.'],
                ],
            ],
            [
                'name' => 'Technology Services',
                'slug' => 'technology-services',
                'description' => 'Cutting-edge technology integration including sensors, UAS/cUAS systems, and API-driven security platforms.',
                'sort_order' => 3,
                'is_active' => true,
                'services' => [
                    ['name' => 'Sensors & Installation', 'slug' => 'sensors-installation', 'short_description' => 'Advanced sensor deployment and installation for perimeter security and threat detection.'],
                    ['name' => 'UAS & cUAS', 'slug' => 'uas-cuas', 'short_description' => 'Unmanned aircraft systems and counter-UAS solutions for airspace security and surveillance.'],
                    ['name' => 'API Integration', 'slug' => 'api-integration', 'short_description' => 'Seamless integration of security systems through advanced API connectivity and data platforms.'],
                ],
            ],
            [
                'name' => 'Contingency Operations',
                'slug' => 'contingency-operations',
                'description' => 'Rapid deployment capabilities for expeditionary, austere, and high-risk operational environments.',
                'sort_order' => 4,
                'is_active' => true,
                'services' => [
                    ['name' => 'Expeditionary Operations', 'slug' => 'expeditionary-operations', 'short_description' => 'Rapid deployment of personnel and assets to support expeditionary and forward-operating missions.'],
                    ['name' => 'Austere & High Risk Areas', 'slug' => 'austere-high-risk-areas', 'short_description' => 'Specialized operations in austere environments and high-risk theaters of operation.'],
                    ['name' => 'Deployable Advisors/Consultants', 'slug' => 'deployable-advisors-consultants', 'short_description' => 'Expert advisors and consultants deployable to challenging operational environments.'],
                ],
            ],
            [
                'name' => 'Humanitarian',
                'slug' => 'humanitarian',
                'description' => 'UXO mitigation, disaster response, and environmental remediation supporting communities in conflict-affected regions.',
                'sort_order' => 5,
                'is_active' => true,
                'services' => [
                    ['name' => 'Unexploded Ordnance (UXO) Mitigation & De-Mining', 'slug' => 'unexploded-ordnance-uxo-mitigation-de-mining', 'short_description' => 'Professional UXO clearance and humanitarian demining operations in affected regions worldwide.'],
                    ['name' => 'Emergency/Disaster Response, Relief, & Recovery', 'slug' => 'emergency-disaster-response-relief-recovery', 'short_description' => 'Rapid emergency and disaster response, relief operations, and long-term recovery support.'],
                    ['name' => 'Environmental Remediation', 'slug' => 'environmental-remediation', 'short_description' => 'Environmental cleanup, remediation services, and sustainable restoration projects.'],
                ],
            ],
            [
                'name' => 'Training Services',
                'slug' => 'training-services',
                'description' => 'Advanced security, military, and tactical training programs delivered at world-class facilities.',
                'sort_order' => 6,
                'is_active' => true,
                'services' => [
                    ['name' => 'Advanced Security & Military Training', 'slug' => 'advanced-security-military-training', 'short_description' => 'Elite-level training programs for security professionals and military personnel.'],
                    ['name' => 'Explosive/Narcotic/Patrol K-9s', 'slug' => 'explosive-narcotic-patrol-k-9s', 'short_description' => 'Comprehensive K-9 handler and detection dog training for explosive, narcotic, and patrol operations.'],
                    ['name' => 'UAS and cUAS', 'slug' => 'uas-cuas-training', 'short_description' => 'UAS operator certification and counter-UAS defensive training programs.'],
                ],
            ],
            [
                'name' => 'Facilities & Base Operations',
                'slug' => 'facilities-base-operations',
                'description' => 'Complete facility management, construction, and fleet operations for bases and installations.',
                'sort_order' => 7,
                'is_active' => true,
                'services' => [
                    ['name' => 'BOSS & Facilities Operations', 'slug' => 'boss-facilities-operations', 'short_description' => 'Base operations support services and comprehensive facilities management.'],
                    ['name' => 'Construction', 'slug' => 'construction', 'short_description' => 'Construction and infrastructure development for military and government installations.'],
                    ['name' => 'Fleet Management', 'slug' => 'fleet-management', 'short_description' => 'Vehicle fleet management, maintenance, and logistics support services.'],
                ],
            ],
            [
                'name' => 'Emergency Services',
                'slug' => 'emergency-services',
                'description' => 'Professional firefighting, investigation, and emergency medical services for critical infrastructure.',
                'sort_order' => 8,
                'is_active' => true,
                'services' => [
                    ['name' => 'Firefighter', 'slug' => 'firefighter', 'short_description' => 'Professional firefighting services for military installations and critical infrastructure.'],
                    ['name' => 'Investigator', 'slug' => 'investigator', 'short_description' => 'Specialized investigation services for security incidents and compliance matters.'],
                    ['name' => 'EMT/Medical', 'slug' => 'emt-medical', 'short_description' => 'Emergency medical technician and healthcare services for remote and austere locations.'],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $services = $catData['services'];
            unset($catData['services']);

            $category = ServiceCategory::create($catData);

            foreach ($services as $i => $serviceData) {
                $category->services()->create([
                    ...$serviceData,
                    'sort_order' => $i + 1,
                    'is_active' => true,
                    'content' => '<p>' . $serviceData['short_description'] . '</p><p>Constellis delivers this service with decades of operational experience, leveraging our global network of trained professionals and cutting-edge technologies to ensure mission success.</p>',
                ]);
            }
        }
    }
}
