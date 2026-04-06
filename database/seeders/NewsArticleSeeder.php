<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Constellis Strengthens Executive Team with Addition of Joseph Zobro as Chief Legal and Compliance Officer',
                'slug' => 'constellis-addition-of-joseph-zobro-as-chief-legal-and-compliance-officer',
                'excerpt' => 'Constellis announces the appointment of Joseph Zobro as Chief Legal and Compliance Officer, strengthening the executive leadership team.',
                'content' => '<p>Constellis, a leading provider of security solutions and services, today announced the appointment of Joseph Zobro as Chief Legal and Compliance Officer.</p><p>In this role, Zobro will oversee all legal, compliance, and risk management functions for the organization, ensuring adherence to the highest ethical and regulatory standards across global operations.</p>',
                'published_at' => now()->subDays(5),
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Constellis Appoints Executive Vice President of LEXSO™ to Lead Strategic Growth and Accelerate Deployment',
                'slug' => 'news-constellis-appoints-executive-vice-president-of-lexso',
                'excerpt' => 'New EVP appointment signals accelerated growth strategy for LEXSO™ law enforcement technology platform.',
                'content' => '<p>Constellis has appointed a new Executive Vice President to lead the strategic growth and accelerated deployment of LEXSO™, the company\'s innovative law enforcement and security operations platform.</p><p>This appointment underscores Constellis\' commitment to delivering cutting-edge technology solutions for law enforcement agencies and security organizations.</p>',
                'published_at' => now()->subDays(12),
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Constellis\' AMK9 to Donate K9 Officer to Currituck County Sheriff\'s Office',
                'slug' => 'news-constellis-amk9-donate-k9-officer-to-currituck-county-sheriffs-office',
                'excerpt' => 'AMK9, a Constellis company, demonstrates community commitment through K9 donation to local law enforcement.',
                'content' => '<p>AMK9, a division of Constellis and world leader in contract working dog services, today announced it will donate a trained K9 officer to the Currituck County Sheriff\'s Office in North Carolina.</p><p>This donation reflects Constellis\' deep commitment to supporting local communities and law enforcement partnerships.</p>',
                'published_at' => now()->subDays(20),
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Orion Nuclear Energy Corporation and Constellis Announce Strategic Collaboration to Advance Security Standards',
                'slug' => 'news-orion-constellis-strategic-collaboration-announcement',
                'excerpt' => 'Strategic partnership focuses on advancing security standards for nuclear and critical infrastructure facilities.',
                'content' => '<p>Orion Nuclear Energy Corporation and Constellis have announced a strategic collaboration to advance security standards for nuclear energy facilities and critical infrastructure.</p><p>The partnership combines Constellis\' decades of security expertise with Orion\'s nuclear energy innovation to establish new benchmarks in facility protection.</p>',
                'published_at' => now()->subDays(30),
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Constellis and Vector Announce Teaming Agreement to Enhance Tactical Small-UAS Training',
                'slug' => 'news-constellis-vector-suas-teaming-agreement-announcement',
                'excerpt' => 'New partnership advances tactical small-UAS training capabilities for military and security professionals.',
                'content' => '<p>Constellis and Vector have announced a teaming agreement to enhance tactical small Unmanned Aircraft Systems (sUAS) training for military, law enforcement, and security professionals.</p><p>This collaboration leverages Vector\'s advanced UAS technology with Constellis\' operational training expertise to deliver next-generation aerial capabilities training.</p>',
                'published_at' => now()->subDays(45),
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Constellis Holdings Announces Appointment of Dan Gelston as Chief Executive Officer',
                'slug' => 'news-dan-gelston-ceo-announcement',
                'excerpt' => 'Dan Gelston appointed as CEO to lead Constellis into its next chapter of growth and innovation.',
                'content' => '<p>Constellis Holdings today announced the appointment of Dan Gelston as Chief Executive Officer, effective immediately.</p><p>Gelston brings extensive experience in security services and defense operations, and will lead Constellis\' continued evolution as a premier global security and risk management provider.</p>',
                'published_at' => now()->subDays(60),
                'is_published' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($articles as $article) {
            NewsArticle::create($article);
        }
    }
}
