<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\Project;
use App\Models\JobPosting;
use App\Models\StoreCategory;
use App\Models\StoreProduct;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──
        User::updateOrCreate(['email' => 'admin@constellis.com'], [
            'name' => 'System Admin',
            'password' => Hash::make('constellis2026'),
            'role' => 'admin',
            'department' => 'IT',
            'employee_code' => 'CON-ADMIN-001',
            'access_level' => 'full',
            'is_active' => true,
        ]);

        User::updateOrCreate(['email' => 'employee@constellis.com'], [
            'name' => 'John Employee',
            'password' => Hash::make('employee2026'),
            'role' => 'employee',
            'department' => 'Operations',
            'employee_code' => 'CON-EMP-001',
            'access_level' => 'elevated',
            'is_active' => true,
        ]);

        User::updateOrCreate(['email' => 'contractor@constellis.com'], [
            'name' => 'Jane Contractor',
            'password' => Hash::make('contractor2026'),
            'role' => 'contractor',
            'department' => 'External',
            'employee_code' => 'CON-CTR-001',
            'access_level' => 'basic',
            'is_active' => true,
        ]);

        // ── Partners ──
        $partners = [
            ['name' => 'Northrop Grumman', 'slug' => 'northrop-grumman', 'website_url' => 'https://www.northropgrumman.com', 'description' => 'Global aerospace and defense technology company.', 'partnership_type' => 'strategic'],
            ['name' => 'L3Harris Technologies', 'slug' => 'l3harris', 'website_url' => 'https://www.l3harris.com', 'description' => 'Leading provider of defense and commercial electronics.', 'partnership_type' => 'technology'],
            ['name' => 'BAE Systems', 'slug' => 'bae-systems', 'website_url' => 'https://www.baesystems.com', 'description' => 'International defense, security, and aerospace company.', 'partnership_type' => 'strategic'],
            ['name' => 'Palantir Technologies', 'slug' => 'palantir', 'website_url' => 'https://www.palantir.com', 'description' => 'Advanced data analytics and AI platforms.', 'partnership_type' => 'technology'],
            ['name' => 'SOS International', 'slug' => 'sosi', 'website_url' => 'https://www.sosi.com', 'description' => 'Intelligence and language solutions for defense.', 'partnership_type' => 'strategic'],
            ['name' => 'Leidos', 'slug' => 'leidos', 'website_url' => 'https://www.leidos.com', 'description' => 'Fortune 500 information technology and defense company.', 'partnership_type' => 'technology'],
        ];
        foreach ($partners as $i => $p) {
            Partner::updateOrCreate(['slug' => $p['slug']], [...$p, 'sort_order' => $i + 1, 'is_active' => true]);
        }

        // ── Projects ──
        $projects = [
            ['name' => 'Sentinel Shield', 'slug' => 'sentinel-shield', 'code_name' => 'SS-2024', 'description' => 'Embassy security program providing comprehensive protection for U.S. diplomatic missions.', 'status' => 'active', 'progress_percentage' => 75, 'location' => 'Middle East', 'country' => 'Iraq', 'client' => 'U.S. Department of State', 'budget' => 45000000, 'start_date' => '2024-01-15', 'details' => 'Full-spectrum security operations including static guard services, mobile security teams, and emergency response capabilities for 12 diplomatic facilities across the region.'],
            ['name' => 'Operation Overwatch', 'slug' => 'operation-overwatch', 'code_name' => 'OW-2024', 'description' => 'Advanced intelligence and surveillance support for multinational coalition operations.', 'status' => 'active', 'progress_percentage' => 60, 'location' => 'Central Asia', 'country' => 'Afghanistan', 'client' => 'NATO', 'budget' => 32000000, 'start_date' => '2024-03-01', 'details' => 'Intelligence collection, analysis, and dissemination support utilizing cutting-edge technology platforms and experienced analysts.'],
            ['name' => 'Guardian Eagle', 'slug' => 'guardian-eagle', 'code_name' => 'GE-2024', 'description' => 'Critical infrastructure protection for major energy installations.', 'status' => 'active', 'progress_percentage' => 85, 'location' => 'Arabian Peninsula', 'country' => 'Saudi Arabia', 'client' => 'Saudi Aramco', 'budget' => 78000000, 'start_date' => '2023-06-01', 'details' => 'Integrated security solution encompassing physical security, cybersecurity, and UAV monitoring for critical oil and gas infrastructure.'],
            ['name' => 'Project Ironclad', 'slug' => 'project-ironclad', 'code_name' => 'IC-2024', 'description' => 'K-9 explosive detection and security patrol program.', 'status' => 'active', 'progress_percentage' => 90, 'location' => 'Domestic', 'country' => 'United States', 'client' => 'Department of Homeland Security', 'budget' => 22000000, 'start_date' => '2023-01-01', 'details' => 'Deployment and management of specialized K-9 teams for explosive detection at 45 federal facilities and transportation hubs.'],
            ['name' => 'Blue Horizon', 'slug' => 'blue-horizon', 'code_name' => 'BH-2025', 'description' => 'Maritime security and anti-piracy operations in the Gulf of Aden.', 'status' => 'active', 'progress_percentage' => 40, 'location' => 'East Africa', 'country' => 'Djibouti', 'client' => 'Combined Maritime Forces', 'budget' => 18000000, 'start_date' => '2025-01-01', 'details' => 'Maritime domain awareness, vessel escort operations, and port facility security in high-threat maritime corridors.'],
            ['name' => 'Fortress Digital', 'slug' => 'fortress-digital', 'code_name' => 'FD-2025', 'description' => 'Cybersecurity operations center establishment and management.', 'status' => 'planning', 'progress_percentage' => 15, 'location' => 'Europe', 'country' => 'Germany', 'client' => 'European Defense Agency', 'budget' => 28000000, 'start_date' => '2025-06-01', 'details' => 'Design, build, and operate a state-of-the-art Security Operations Center (SOC) with 24/7 monitoring capabilities.'],
            ['name' => 'Echo Valley Training', 'slug' => 'echo-valley-training', 'code_name' => 'EV-2024', 'description' => 'Advanced tactical training program for foreign military personnel.', 'status' => 'active', 'progress_percentage' => 70, 'location' => 'North America', 'country' => 'United States', 'client' => 'Department of Defense', 'budget' => 15000000, 'start_date' => '2024-02-01', 'details' => 'Comprehensive training curriculum including small arms proficiency, tactical movement, medical response, and leadership development.'],
            ['name' => 'Phoenix Restore', 'slug' => 'phoenix-restore', 'code_name' => 'PR-2024', 'description' => 'Humanitarian UXO clearance and community rehabilitation program.', 'status' => 'completed', 'progress_percentage' => 100, 'location' => 'Southeast Asia', 'country' => 'Laos', 'client' => 'UNDP', 'budget' => 8000000, 'start_date' => '2023-01-01', 'end_date' => '2024-12-31', 'details' => 'Complete clearance of unexploded ordnance across 500 hectares, enabling safe community development and agricultural use.'],
            ['name' => 'Citadel Americas', 'slug' => 'citadel-americas', 'code_name' => 'CA-2025', 'description' => 'Regional security consulting and training for Latin American allies.', 'status' => 'active', 'progress_percentage' => 55, 'location' => 'South America', 'country' => 'Colombia', 'client' => 'Multiple Government Partners', 'budget' => 12000000, 'start_date' => '2024-07-01', 'details' => 'Security sector reform advisory, military training programs, and counter-narcotics operational support.'],
            ['name' => 'Titan Shield Asia', 'slug' => 'titan-shield-asia', 'code_name' => 'TS-2025', 'description' => 'Integrated facility security for high-value corporate clients.', 'status' => 'planning', 'progress_percentage' => 10, 'location' => 'East Asia', 'country' => 'Japan', 'client' => 'Major Technology Corporation', 'budget' => 35000000, 'start_date' => '2025-09-01', 'details' => 'Design and implementation of comprehensive security architecture including access control, surveillance, and executive protection.'],
        ];
        foreach ($projects as $i => $p) {
            Project::updateOrCreate(['slug' => $p['slug']], [
                ...$p,
                'access_code' => 'constellis2026', // Will be hashed by mutator
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        // ── Job Postings ──
        $jobs = [
            ['title' => 'Senior Security Specialist', 'slug' => 'senior-security-specialist', 'description' => 'Lead security operations at high-profile government facilities.', 'requirements' => "- 8+ years security experience\n- Active Secret clearance\n- Strong leadership skills\n- Veteran preferred", 'responsibilities' => "- Manage daily security operations\n- Supervise security personnel\n- Develop security protocols\n- Liaise with clients", 'location' => 'Washington, DC', 'country' => 'United States', 'employment_type' => 'full-time', 'clearance_level' => 'Secret', 'salary_range' => '$85,000 - $110,000', 'department' => 'Security'],
            ['title' => 'Intelligence Analyst', 'slug' => 'intelligence-analyst', 'description' => 'Provide actionable intelligence analysis for global security operations.', 'requirements' => "- 5+ years SIGINT/HUMINT experience\n- TS/SCI clearance required\n- Strong analytical skills\n- Degree in relevant field", 'responsibilities' => "- Conduct threat assessments\n- Produce intelligence briefs\n- Support operational planning\n- Maintain intelligence databases", 'location' => 'Reston, VA', 'country' => 'United States', 'employment_type' => 'full-time', 'clearance_level' => 'TS/SCI', 'salary_range' => '$95,000 - $130,000', 'department' => 'Intelligence'],
            ['title' => 'K-9 Handler', 'slug' => 'k9-handler', 'description' => 'Join our elite AMK9 division providing explosive detection services.', 'requirements' => "- Military/LE K-9 experience\n- Physical fitness standards\n- Ability to travel extensively\n- Clean driving record", 'responsibilities' => "- Handle trained detection K-9\n- Conduct sweeps of facilities\n- Maintain K-9 readiness\n- Complete daily reports", 'location' => 'Multiple Locations', 'country' => 'United States', 'employment_type' => 'full-time', 'clearance_level' => 'Secret', 'salary_range' => '$65,000 - $85,000', 'department' => 'Operations'],
            ['title' => 'Cybersecurity Engineer', 'slug' => 'cybersecurity-engineer', 'description' => 'Design and implement advanced cybersecurity solutions.', 'requirements' => "- CISSP or CEH certification\n- 5+ years cybersecurity experience\n- Cloud security expertise\n- Programming skills", 'responsibilities' => "- Monitor network security\n- Conduct penetration testing\n- Design security architecture\n- Incident response", 'location' => 'Remote / Stuttgart, Germany', 'country' => 'Germany', 'employment_type' => 'full-time', 'clearance_level' => 'NATO Secret', 'salary_range' => '$100,000 - $140,000', 'department' => 'Technology'],
            ['title' => 'Training Instructor - Firearms', 'slug' => 'firearms-instructor', 'description' => 'Deliver world-class firearms instruction at our training facilities.', 'requirements' => "- NRA instructor certification\n- 10+ years relevant experience\n- Combat veteran preferred\n- First aid certified", 'responsibilities' => "- Conduct firearms courses\n- Develop training materials\n- Maintain range safety\n- Evaluate student performance", 'location' => 'Moyock, NC', 'country' => 'United States', 'employment_type' => 'full-time', 'salary_range' => '$70,000 - $90,000', 'department' => 'Training'],
        ];
        foreach ($jobs as $i => $j) {
            JobPosting::updateOrCreate(['slug' => $j['slug']], [
                ...$j,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        // ── Store Categories & Products ──
        $apparel = StoreCategory::updateOrCreate(['slug' => 'apparel'], ['name' => 'Apparel', 'description' => 'Branded clothing and uniforms', 'icon' => 'tshirt', 'sort_order' => 1, 'is_active' => true]);
        $gear = StoreCategory::updateOrCreate(['slug' => 'gear'], ['name' => 'Gear & Equipment', 'description' => 'Professional gear and accessories', 'icon' => 'gear', 'sort_order' => 2, 'is_active' => true]);
        $office = StoreCategory::updateOrCreate(['slug' => 'office'], ['name' => 'Office Supplies', 'description' => 'Branded stationery and desk accessories', 'icon' => 'briefcase', 'sort_order' => 3, 'is_active' => true]);

        $storeProducts = [
            ['store_category_id' => $apparel->id, 'name' => 'Constellis Tactical Polo', 'slug' => 'tactical-polo', 'description' => 'Premium moisture-wicking polo with embroidered Constellis logo. Perfect for field and office wear.', 'price' => 45.00, 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'colors' => ['Navy Blue', 'Black', 'Olive'], 'inventory' => 200, 'sku' => 'APP-POLO-001'],
            ['store_category_id' => $apparel->id, 'name' => 'Constellis Operator Cap', 'slug' => 'operator-cap', 'description' => 'Structured tactical cap with velcro patch panel and Constellis branding.', 'price' => 28.00, 'sizes' => ['One Size'], 'colors' => ['Navy', 'Black', 'Coyote Brown'], 'inventory' => 350, 'sku' => 'APP-CAP-001'],
            ['store_category_id' => $apparel->id, 'name' => 'Constellis Softshell Jacket', 'slug' => 'softshell-jacket', 'description' => 'Windproof, water-resistant softshell with concealed carry pockets and embroidered logo.', 'price' => 89.00, 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'colors' => ['Black', 'Dark Navy'], 'inventory' => 100, 'sku' => 'APP-JKT-001'],
            ['store_category_id' => $apparel->id, 'name' => 'Constellis Performance T-Shirt', 'slug' => 'performance-tee', 'description' => 'Lightweight, breathable athletic tee with screen-printed Constellis logo.', 'price' => 25.00, 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'colors' => ['Heather Grey', 'Navy', 'Black'], 'inventory' => 500, 'sku' => 'APP-TEE-001'],
            ['store_category_id' => $gear->id, 'name' => 'Constellis Tactical Backpack', 'slug' => 'tactical-backpack', 'description' => '35L MOLLE-compatible tactical backpack with padded laptop compartment and Constellis patch.', 'price' => 120.00, 'sizes' => null, 'colors' => ['Black', 'Coyote'], 'inventory' => 75, 'sku' => 'GR-PACK-001'],
            ['store_category_id' => $gear->id, 'name' => 'Constellis Water Bottle', 'slug' => 'water-bottle', 'description' => '32oz double-walled stainless steel bottle with laser-engraved Constellis logo.', 'price' => 32.00, 'sizes' => null, 'colors' => ['Matte Black', 'Navy'], 'inventory' => 200, 'sku' => 'GR-BTL-001'],
            ['store_category_id' => $gear->id, 'name' => 'Challenge Coin - Anniversary Edition', 'slug' => 'challenge-coin', 'description' => 'Limited edition die-cast challenge coin commemorating 20+ years of excellence.', 'price' => 18.00, 'sizes' => null, 'colors' => null, 'inventory' => 500, 'sku' => 'GR-COIN-001'],
            ['store_category_id' => $office->id, 'name' => 'Constellis Executive Notebook', 'slug' => 'executive-notebook', 'description' => 'Leather-bound A5 notebook with embossed logo, 200 lined pages.', 'price' => 22.00, 'sizes' => null, 'colors' => ['Navy', 'Black'], 'inventory' => 300, 'sku' => 'OF-NOTE-001'],
            ['store_category_id' => $office->id, 'name' => 'Constellis Desk Plaque', 'slug' => 'desk-plaque', 'description' => 'Solid walnut desk plaque with brass nameplate and Constellis emblem.', 'price' => 55.00, 'sizes' => null, 'colors' => null, 'inventory' => 50, 'sku' => 'OF-PLQ-001'],
        ];
        foreach ($storeProducts as $i => $p) {
            StoreProduct::updateOrCreate(['slug' => $p['slug']], [...$p, 'sort_order' => $i + 1, 'is_active' => true]);
        }
    }
}
