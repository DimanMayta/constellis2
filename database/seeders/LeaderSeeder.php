<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;

class LeaderSeeder extends Seeder
{
    public function run(): void
    {
        $leaders = [
            [
                'name' => 'Dan Gelston',
                'title' => 'Chief Executive Officer',
                'slug' => 'dan-gelston',
                'bio' => 'Dan Gelston serves as the Chief Executive Officer of Constellis, overseeing all strategic and operational aspects of the company. With over 25 years of leadership experience in defense and security sectors, Dan has led organizations across multiple continents.',
                'full_resume' => 'Dan Gelston is a distinguished leader in the global security industry with a career spanning over 25 years. He has held senior executive positions in defense, intelligence, and private security organizations worldwide. His strategic vision has driven Constellis to become a premier provider of integrated security solutions.',
                'years_experience' => 25,
                'countries_served' => ['United States', 'Iraq', 'Afghanistan', 'Germany', 'United Kingdom', 'Saudi Arabia', 'UAE', 'Kuwait'],
                'is_veteran' => true,
                'military_branch' => 'U.S. Army',
                'rank' => 'Colonel (Ret.)',
                'specializations' => ['Strategic Leadership', 'Defense Operations', 'Risk Management'],
                'education' => ['MBA, Harvard Business School', 'BS, Engineering, West Point'],
                'certifications' => ['PMP', 'CPP', 'CSC'],
                'sort_order' => 1,
            ],
            [
                'name' => 'Joseph Zobro',
                'title' => 'Chief Legal & Compliance Officer',
                'slug' => 'joseph-zobro',
                'bio' => 'Joseph Zobro brings extensive legal expertise and compliance leadership to ensure Constellis maintains the highest ethical standards across all global operations.',
                'full_resume' => 'Joseph Zobro is a seasoned attorney with deep expertise in international law, government contracts, and corporate compliance. He oversees all legal affairs, regulatory compliance, and ethics programs for Constellis.',
                'years_experience' => 20,
                'countries_served' => ['United States', 'United Kingdom', 'Belgium', 'Germany', 'Japan'],
                'is_veteran' => true,
                'military_branch' => 'U.S. Marine Corps',
                'rank' => 'Major (Ret.)',
                'specializations' => ['International Law', 'Government Contracts', 'Corporate Compliance'],
                'education' => ['JD, Georgetown University Law Center', 'BA, Political Science, Princeton'],
                'certifications' => ['Bar Admission: DC, VA, NY'],
                'sort_order' => 2,
            ],
            [
                'name' => 'Michael Anderson',
                'title' => 'Chief Operating Officer',
                'slug' => 'michael-anderson',
                'bio' => 'Michael Anderson leads Constellis operations worldwide, ensuring seamless delivery of services across all divisions and geographic regions.',
                'full_resume' => 'Michael Anderson is a combat-decorated veteran with extensive operational leadership experience. He has managed security programs valued at over $1 billion and led teams of 5,000+ personnel across 20 countries.',
                'years_experience' => 28,
                'countries_served' => ['United States', 'Iraq', 'Afghanistan', 'Colombia', 'South Korea', 'Jordan', 'Israel', 'Philippines'],
                'is_veteran' => true,
                'military_branch' => 'U.S. Army Special Forces',
                'rank' => 'Lieutenant Colonel (Ret.)',
                'specializations' => ['Special Operations', 'Program Management', 'Crisis Response'],
                'education' => ['MS, Strategic Studies, U.S. Army War College', 'BS, Military Science, Norwich University'],
                'certifications' => ['PMP', 'Six Sigma Black Belt'],
                'sort_order' => 3,
            ],
            [
                'name' => 'Sarah Mitchell',
                'title' => 'Chief Financial Officer',
                'slug' => 'sarah-mitchell',
                'bio' => 'Sarah Mitchell oversees all financial operations, strategic planning, and fiscal management for the organization.',
                'full_resume' => 'Sarah Mitchell is a financial executive with 18 years of experience in defense industry financial management. She has led financial operations for organizations with annual revenues exceeding $2 billion.',
                'years_experience' => 18,
                'countries_served' => ['United States', 'United Kingdom', 'Germany', 'Australia'],
                'is_veteran' => false,
                'specializations' => ['Financial Strategy', 'M&A', 'Cost Optimization'],
                'education' => ['MBA, Wharton School of Business', 'BS, Accounting, UVA'],
                'certifications' => ['CPA', 'CFA'],
                'sort_order' => 4,
            ],
            [
                'name' => 'Robert Chen',
                'title' => 'SVP, Technology Services',
                'slug' => 'robert-chen',
                'bio' => 'Robert Chen leads technological innovation, driving the integration of advanced systems into security operations worldwide.',
                'full_resume' => 'Robert Chen brings cutting-edge technology expertise to Constellis. He has pioneered the integration of AI, drone technology, and advanced surveillance systems in the security industry.',
                'years_experience' => 22,
                'countries_served' => ['United States', 'Japan', 'South Korea', 'UAE', 'Qatar', 'Singapore'],
                'is_veteran' => true,
                'military_branch' => 'U.S. Navy',
                'rank' => 'Commander (Ret.)',
                'specializations' => ['AI & Machine Learning', 'UAS/cUAS', 'Cybersecurity', 'Surveillance Systems'],
                'education' => ['PhD, Computer Science, MIT', 'MS, Electrical Engineering, Stanford'],
                'certifications' => ['CISSP', 'CEH', 'AWS Solutions Architect'],
                'sort_order' => 5,
            ],
            [
                'name' => 'Patricia Torres',
                'title' => 'SVP, Human Resources',
                'slug' => 'patricia-torres',
                'bio' => 'Patricia Torres guides human capital strategy, talent acquisition, and organizational development across the enterprise.',
                'full_resume' => 'Patricia Torres has led HR transformation programs for Fortune 500 companies and government contractors, specializing in building high-performance cultures in complex, multi-national organizations.',
                'years_experience' => 15,
                'countries_served' => ['United States', 'Mexico', 'Colombia', 'Peru', 'Brazil'],
                'is_veteran' => true,
                'military_branch' => 'U.S. Air Force',
                'rank' => 'Captain (Ret.)',
                'specializations' => ['Talent Management', 'Organizational Development', 'Veteran Integration'],
                'education' => ['MS, Human Resources Management, Cornell', 'BA, Psychology, UCLA'],
                'certifications' => ['SHRM-SCP', 'PHR'],
                'sort_order' => 6,
            ],
            [
                'name' => 'James Walker',
                'title' => 'VP, Training Division',
                'slug' => 'james-walker',
                'bio' => 'James Walker oversees Constellis training programs and the operation of world-class training facilities.',
                'full_resume' => 'James Walker is a former Special Forces operator with extensive experience designing and implementing military and law enforcement training programs. He manages Constellis\' training facilities.',
                'years_experience' => 24,
                'countries_served' => ['United States', 'Iraq', 'Afghanistan', 'Kenya', 'Nigeria', 'Chad', 'Ukraine'],
                'is_veteran' => true,
                'military_branch' => 'U.S. Army Rangers',
                'rank' => 'Sergeant Major (Ret.)',
                'specializations' => ['Combat Training', 'Firearms Instruction', 'Tactical Medicine'],
                'education' => ['MS, Education & Training, Johns Hopkins', 'BS, Criminal Justice, Sam Houston State'],
                'certifications' => ['NRA Master Instructor', 'NREMT-P'],
                'sort_order' => 7,
            ],
            [
                'name' => 'Emily Richardson',
                'title' => 'VP, Business Development',
                'slug' => 'emily-richardson',
                'bio' => 'Emily Richardson leads strategic business development efforts, expanding Constellis capabilities and market presence globally.',
                'full_resume' => 'Emily Richardson has driven over $3 billion in contract wins during her career. She specializes in government contracting, strategic partnerships, and market expansion for defense and security organizations.',
                'years_experience' => 16,
                'countries_served' => ['United States', 'United Kingdom', 'Saudi Arabia', 'UAE', 'Japan', 'Australia', 'Italy'],
                'is_veteran' => true,
                'military_branch' => 'U.S. Army Intelligence',
                'rank' => 'Captain (Ret.)',
                'specializations' => ['Government Contracting', 'Strategic Partnerships', 'Market Analysis'],
                'education' => ['MBA, Columbia Business School', 'BA, International Relations, Georgetown'],
                'certifications' => ['CPCM', 'CFCM'],
                'sort_order' => 8,
            ],
        ];

        foreach ($leaders as $leader) {
            Leader::updateOrCreate(
                ['slug' => $leader['slug']],
                [...$leader, 'is_active' => true]
            );
        }
    }
}
