<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\ContactOffice;
use App\Models\Certification;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // CMS Pages
        Page::create([
            'title' => 'Who We Serve',
            'slug' => 'who-we-serve',
            'meta_title' => 'Who We Serve — Constellis',
            'meta_description' => 'Constellis serves government agencies, commercial organizations, and international clients worldwide.',
            'hero_title' => 'Who We <span class="gradient-text-accent">Serve</span>',
            'hero_subtitle' => 'Trusted by government agencies, commercial enterprises, and international organizations worldwide.',
            'content' => '<h2>Government</h2><p>Constellis provides comprehensive security and training services to U.S. federal agencies including the Department of Defense, Department of State, Department of Homeland Security, Department of Energy, and the Intelligence Community.</p><h2>Commercial</h2><p>Our commercial clients include Fortune 500 companies, critical infrastructure operators, and organizations requiring specialized security and risk management solutions.</p><h2>International</h2><p>We serve international governments and organizations across 35+ countries, delivering tailored security solutions aligned with local requirements and international standards.</p>',
            'template' => 'generic',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Page::create([
            'title' => 'LEXSO™',
            'slug' => 'lexso',
            'meta_title' => 'LEXSO™ — Law Enforcement & Security Operations Platform',
            'meta_description' => 'LEXSO™ is a cutting-edge platform modernizing law enforcement and security operations.',
            'hero_title' => '<span class="gradient-text-accent">LEXSO™</span>',
            'hero_subtitle' => 'A revolutionary platform modernizing law enforcement and security operations.',
            'content' => '<h2>Modernizing Law Enforcement</h2><p>LEXSO™ is Constellis\' innovative technology platform designed to modernize and optimize law enforcement and security operations through advanced data analytics, real-time monitoring, and integrated communication systems.</p><h2>Key Features</h2><ul><li>Real-time operational monitoring and analytics</li><li>Integrated communication and dispatch capabilities</li><li>Advanced data visualization and reporting</li><li>Mobile-optimized field operations support</li><li>Scalable architecture for agencies of all sizes</li></ul><h2>Deployment</h2><p>LEXSO™ is being deployed to law enforcement agencies and security organizations nationwide, transforming how security operations are managed and executed.</p>',
            'template' => 'generic',
            'is_published' => true,
            'sort_order' => 2,
        ]);

        // Site Settings
        $settings = [
            ['key' => 'phone_toll_free', 'value' => '+1 866 349 1506', 'type' => 'text', 'group' => 'contact', 'label' => 'Toll-Free Phone'],
            ['key' => 'phone_direct', 'value' => '+1 703 673 5000', 'type' => 'text', 'group' => 'contact', 'label' => 'Direct Phone'],
            ['key' => 'email', 'value' => 'info@constellis.com', 'type' => 'text', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'linkedin', 'value' => 'https://www.linkedin.com/company/constellis', 'type' => 'url', 'group' => 'social', 'label' => 'LinkedIn'],
            ['key' => 'twitter', 'value' => 'https://twitter.com/constellis', 'type' => 'url', 'group' => 'social', 'label' => 'X (Twitter)'],
            ['key' => 'facebook', 'value' => 'https://www.facebook.com/constellis', 'type' => 'url', 'group' => 'social', 'label' => 'Facebook'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }

        // Contact Offices
        ContactOffice::create([
            'name' => 'Corporate Headquarters',
            'address' => '12018 Sunrise Valley Drive, Suite 140, Reston, VA 20191',
            'phone' => '+1 703 673 5000',
            'phone_secondary' => '+1 866 349 1506',
            'email' => 'info@constellis.com',
            'country' => 'United States',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        ContactOffice::create([
            'name' => 'Training Center',
            'address' => 'Moyock, North Carolina',
            'phone' => '+1 252 435 2488',
            'country' => 'United States',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Certifications
        $certs = [
            ['name' => 'ISO 9001:2015', 'description' => 'Quality Management System certification ensuring consistent, high-quality service delivery across all operations.'],
            ['name' => 'ISO 14001:2015', 'description' => 'Environmental Management System demonstrating our commitment to environmental responsibility.'],
            ['name' => 'ISO 45001:2018', 'description' => 'Occupational Health & Safety Management certification ensuring the safety and well-being of our workforce.'],
            ['name' => 'ANAB Accredited', 'description' => 'ANSI National Accreditation Board recognition for conformity assessment and professional standards.'],
            ['name' => 'PSC.1 Certified', 'description' => 'Private Security Company Operations certified under international standards for responsible security services.'],
            ['name' => 'ICoCA Member', 'description' => 'International Code of Conduct Association membership ensuring adherence to responsible security governance.'],
        ];

        foreach ($certs as $i => $cert) {
            Certification::create([...$cert, 'sort_order' => $i + 1, 'is_active' => true]);
        }
    }
}
