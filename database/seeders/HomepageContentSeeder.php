<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use App\Models\AboutSection;
use App\Models\HomepageEvent;
use App\Models\Testimonial;
use App\Models\HomepageClient;
use Illuminate\Database\Seeder;

class HomepageContentSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // HERO SLIDES (8 slides)
        // ============================================================
        HeroSlide::truncate();

        $slides = [
            [
                'badge_en' => 'Global Security Solutions', 'badge_es' => 'Soluciones de Seguridad Global',
                'title_a_en' => 'Freedom Through', 'title_a_es' => 'Libertad A Través',
                'title_b_en' => 'Strength', 'title_b_es' => 'De La Fuerza',
                'description_en' => 'A network of over 72,000 professionals working to safeguard freedom, democracy, and the rule of law worldwide.',
                'description_es' => 'Una red de más de 72,000 profesionales trabajando para salvaguardar la libertad, la democracia y el estado de derecho en todo el mundo.',
                'cta_en' => 'Learn More', 'cta_es' => 'Más Información',
                'cta_link' => '#about', 'sort_order' => 1,
            ],
            [
                'badge_en' => 'Training & Development', 'badge_es' => 'Entrenamiento y Desarrollo',
                'title_a_en' => 'World-Class', 'title_a_es' => 'Entrenamiento',
                'title_b_en' => 'Training', 'title_b_es' => 'De Clase Mundial',
                'description_en' => 'Custom solutions while cultivating education, professionalism, trust, honor and pride.',
                'description_es' => 'Soluciones personalizadas fomentando la educación, el profesionalismo, la confianza, el honor y el orgullo.',
                'cta_en' => 'Our Services', 'cta_es' => 'Nuestros Servicios',
                'cta_link' => '#services', 'sort_order' => 2,
            ],
            [
                'badge_en' => 'Global Operations', 'badge_es' => 'Operaciones Globales',
                'title_a_en' => 'Veterans For', 'title_a_es' => 'Veteranos Para',
                'title_b_en' => 'Veterans', 'title_b_es' => 'Veteranos',
                'description_en' => 'Military and First Responders are the core of our workforce. Providing the highest quality professionals in the world.',
                'description_es' => 'El personal militar y rescatistas constituyen el núcleo de nuestra fuerza laboral. Proporcionando los profesionales de más alta calidad.',
                'cta_en' => 'Contact Us', 'cta_es' => 'Contáctenos',
                'cta_link' => '#contact', 'sort_order' => 3,
            ],
            [
                'badge_en' => 'National Defense', 'badge_es' => 'Defensa Nacional',
                'title_a_en' => 'Protecting', 'title_a_es' => 'Protegiendo',
                'title_b_en' => 'Nations', 'title_b_es' => 'Naciones',
                'description_en' => 'Safeguard National Security, Modernize & Train Security Forces, Strengthen Intelligence Agencies and Prepare National Defense Forces to be Mission Ready.',
                'description_es' => 'Protección de la Seguridad Nacional, Modernización y Entrenamiento de Fuerzas de Seguridad, Fortalecimiento de Agencias de Inteligencia y Preparación de Fuerzas de Defensa Nacional para estar Listos para la Misión.',
                'cta_en' => 'Learn More', 'cta_es' => 'Más Información',
                'cta_link' => '#services', 'sort_order' => 4,
            ],
            [
                'badge_en' => 'Intelligence Operations', 'badge_es' => 'Operaciones de Inteligencia',
                'title_a_en' => 'Strategic', 'title_a_es' => 'Inteligencia',
                'title_b_en' => 'Intelligence', 'title_b_es' => 'Estratégica',
                'description_en' => 'Advanced intelligence analysis, risk assessment, and national security solutions for allied nations.',
                'description_es' => 'Análisis avanzado de inteligencia, evaluación de riesgos y soluciones de seguridad nacional para naciones aliadas.',
                'cta_en' => 'Our Services', 'cta_es' => 'Nuestros Servicios',
                'cta_link' => '#services', 'sort_order' => 5,
            ],
            [
                'badge_en' => 'Counter Terrorism', 'badge_es' => 'Contraterrorismo',
                'title_a_en' => 'Counter', 'title_a_es' => 'Contrarrestar',
                'title_b_en' => 'Threats', 'title_b_es' => 'Amenazas',
                'description_en' => 'Advise and Support Critical Decision-making to Counter Global Threats across all domains.',
                'description_es' => 'Asesoramiento y apoyo en la toma de decisiones críticas para contrarrestar amenazas globales.',
                'cta_en' => 'Learn More', 'cta_es' => 'Más Información',
                'cta_link' => '#about', 'sort_order' => 6,
            ],
            [
                'badge_en' => 'Humanitarian Aid', 'badge_es' => 'Ayuda Humanitaria',
                'title_a_en' => 'Saving The', 'title_a_es' => 'Salvando A Los',
                'title_b_en' => 'Innocent', 'title_b_es' => 'Inocentes',
                'description_en' => 'Global operations to free the oppressed and save the innocent in conflict zones worldwide.',
                'description_es' => 'Operaciones globales para liberar a los oprimidos y proteger a los inocentes en zonas de conflicto.',
                'cta_en' => 'Testimonials', 'cta_es' => 'Testimonios',
                'cta_link' => '#testimonials', 'sort_order' => 7,
            ],
            [
                'badge_en' => 'Join Our Team', 'badge_es' => 'Únete a Nuestro Equipo',
                'title_a_en' => 'Career', 'title_a_es' => 'Oportunidades',
                'title_b_en' => 'Opportunities', 'title_b_es' => 'Profesionales',
                'description_en' => 'Join 72,000+ professionals making a global impact across security, intelligence, and defense.',
                'description_es' => 'Únete a más de 72,000 profesionales generando un impacto global en seguridad, inteligencia y defensa.',
                'cta_en' => 'View Positions', 'cta_es' => 'Ver Posiciones',
                'cta_link' => '#opportunities', 'sort_order' => 8,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::create(array_merge($slide, ['is_active' => true]));
        }

        // ============================================================
        // ABOUT SECTIONS (3 tabs)
        // ============================================================
        AboutSection::truncate();

        AboutSection::create([
            'tab_key' => 'who',
            'label_en' => 'Who We Are',
            'label_es' => 'Quiénes Somos',
            'content_en' => '<p>We are a network of over <strong>72,000 people</strong> working together to assist in the assessment, planification, organization and development of freedom, democracy, rule of law, national order, national defense, new international allies and the development of third world countries and/or developed nations that are undergoing political duress and instability.</p><p>Our organization alongside our network of partner companies has a proven and successful record helping various Host Nations. We do this through extremely experienced individuals ranging in various fields such as former dignitaries, diplomats, senators, house representatives, federal agents, law enforcement professionals, university professors, Supreme Court judges, vast range of experts in the field of international law, medical experts, national defense experts, intelligence agencies experts, engineers and soldiers.</p><p>In order to bring the very best in expertise and support to our given tasks we contract some of the world\'s most prestigious organizations to work alongside the local residents of Host Nations. We all work together to bring freedom, democracy, rule of law, order and development to the Oppressed people throughout the world, thus providing new opportunities in the development of Host Nations.</p>',
            'content_es' => '<p>Somos una red de más de <strong>72,000 personas</strong> que trabajan de manera conjunta para asistir en la evaluación, planificación, organización y desarrollo de la libertad, la democracia, el estado de derecho, el orden nacional, la defensa nacional, la generación de nuevas alianzas internacionales y el desarrollo de países del tercer mundo y/o naciones desarrolladas que atraviesan situaciones de presión política e inestabilidad.</p><p>Nuestra organización, junto con nuestra red de empresas asociadas, cuenta con un historial comprobado de éxito ayudando a diversos países anfitriones. Esto lo logramos a través de profesionales altamente experimentados en múltiples campos, tales como ex dignatarios, diplomáticos, senadores, representantes legislativos, agentes federales, profesionales de las fuerzas del orden, profesores universitarios, jueces de tribunales supremos, expertos en derecho internacional, especialistas médicos, expertos en defensa nacional, especialistas en agencias de inteligencia, ingenieros y personal militar.</p><p>Con el fin de ofrecer el más alto nivel de experiencia y apoyo en nuestras operaciones, contratamos a algunas de las organizaciones más prestigiosas del mundo para trabajar junto con las comunidades locales de los países anfitriones. Todos colaboramos para promover la libertad, la democracia, el estado de derecho, el orden y el desarrollo de los pueblos oprimidos alrededor del mundo, generando así nuevas oportunidades para el desarrollo de estas naciones.</p>',
            'video_url' => 'https://www.youtube.com/embed/Tu_3BNY2dGg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        AboutSection::create([
            'tab_key' => 'vision',
            'label_en' => 'Vision',
            'label_es' => 'Visión',
            'icon_svg' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
            'content_en' => '<p>Become a key global partner so that all nations may have the best opportunity for a democratic governance with rule of law, national order, fair justice, equal opportunities and individual as well as global development of their country.</p><p>This in order to create a better platform for global peace, unity, financial stability, open and fair trade, better health and functional collaboration in all aspects of global issues.</p>',
            'content_es' => '<p>Convertirnos en un socio global clave para que todas las naciones tengan la mejor oportunidad de alcanzar una gobernanza democrática con estado de derecho, orden nacional, justicia equitativa, igualdad de oportunidades y desarrollo tanto individual como global.</p><p>Esto con el propósito de crear una mejor plataforma para la paz mundial, la unidad, la estabilidad financiera, el comercio abierto y justo, una mejor salud y una colaboración funcional en todos los aspectos de los desafíos globales.</p>',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        AboutSection::create([
            'tab_key' => 'mission',
            'label_en' => 'Mission',
            'label_es' => 'Misión',
            'icon_svg' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'content_en' => '<p>Use real world expertise in order to evaluate, recommend and create solutions as your end-to-end partner, while we also help to execute on the recommendations of our team of Global Experts.</p><p>To train and develop custom solutions while cultivating education, professionalism, trust, honor and pride thus the Host Nations empowerment of common global as well as individual success.</p>',
            'content_es' => '<p>Aplicar experiencia del mundo real para evaluar, recomendar y desarrollar soluciones como su socio integral, además de colaborar en la ejecución de las recomendaciones de nuestro equipo global de expertos.</p><p>Capacitar y desarrollar soluciones personalizadas, fomentando la educación, el profesionalismo, la confianza, el honor y el orgullo, promoviendo así el empoderamiento de los países anfitriones hacia el éxito global e individual.</p>',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // ============================================================
        // HOMEPAGE EVENTS (4 events)
        // ============================================================
        HomepageEvent::truncate();

        $events = [
            ['name_en' => 'Ukraine', 'name_es' => 'Ucrania', 'emoji' => '🇺🇦', 'gradient_classes' => 'bg-gradient-to-br from-blue-600 to-yellow-400', 'sort_order' => 1],
            ['name_en' => 'Afghanistan', 'name_es' => 'Afganistán', 'emoji' => '🇦🇫', 'gradient_classes' => 'bg-gradient-to-br from-slate-800 to-green-700', 'sort_order' => 2],
            ['name_en' => 'Venezuela', 'name_es' => 'Venezuela', 'emoji' => '🇻🇪', 'gradient_classes' => 'bg-gradient-to-br from-yellow-500 via-blue-600 to-red-600', 'sort_order' => 3],
            ['name_en' => 'El Salvador', 'name_es' => 'El Salvador', 'emoji' => '🇸🇻', 'gradient_classes' => 'bg-gradient-to-br from-blue-600 to-blue-800', 'sort_order' => 4],
        ];

        foreach ($events as $event) {
            HomepageEvent::create(array_merge($event, ['is_active' => true]));
        }

        // ============================================================
        // TESTIMONIALS (1 testimonial — Sayed story)
        // ============================================================
        Testimonial::truncate();

        Testimonial::create([
            'country_en' => 'Afghanistan',
            'country_es' => 'Afganistán',
            'country_emoji' => '🇦🇫',
            'content_en' => '<p><strong>Sayed</strong> was an ANA Special Forces Sergeant that worked with US Special Operations Forces as well as OGA. He was heavily hunted by the Taliban after the fall of Kabul. He was separated from his family for months and was the most difficult to evacuate due to his family being in two different geographic locations.</p><p>The entire family was successfully evacuated to a friendly country where they are now safe from the Taliban persecution. He is grateful to Innovation Unlimited Consulting, Long Range Training and Development Group, and the ground team that evacuated them.</p><p><em><strong>Mutasim</strong> is Sayed\'s eldest son, the rest of Sayed\'s children are also in the video. They are all happy to finally be together as a family once again.</em></p>',
            'content_es' => '<p><strong>Sayed</strong> fue un sargento de Fuerzas Especiales del Ejército Nacional Afgano (ANA) que trabajó con las Fuerzas de Operaciones Especiales de Estados Unidos, así como con otras agencias gubernamentales (OGA). Fue intensamente perseguido por los talibanes tras la caída de Kabul. Permaneció separado de su familia durante meses y su evacuación fue especialmente compleja debido a que sus familiares se encontraban en dos ubicaciones geográficas distintas.</p><p>Finalmente, toda su familia fue evacuada con éxito a un país aliado, donde ahora se encuentran a salvo de la persecución talibán. Él expresa su agradecimiento a Innovation Unlimited Consulting, Long Range Training and Development Group y al equipo en terreno que hizo posible la evacuación.</p><p><em><strong>Mutasim</strong> es el hijo mayor de Sayed; el resto de sus hijos también aparecen en el video. Todos se encuentran felices de estar reunidos nuevamente como familia.</em></p>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // ============================================================
        // HOMEPAGE CLIENTS (20 clients — bilingual)
        // ============================================================
        HomepageClient::truncate();

        $clients = [
            ['Special Operations Command (SOCOM)', 'Special Operations Command (SOCOM)'],
            ['Joint Special Operations Command (JSOC)', 'Joint Special Operations Command (JSOC)'],
            ['Army Special Forces Command (USASFC)', 'Army Special Forces Command (USASFC)'],
            ['Army Rangers (Rangers)', 'Army Rangers (Rangers)'],
            ['US Army Conventional Forces (USA)', 'US Army Conventional Forces (USA)'],
            ['Marine Special Operations Command (MARSOC)', 'Marine Special Operations Command (MARSOC)'],
            ['US Marine Corps Conventional Forces (USMC)', 'US Marine Corps Conventional Forces (USMC)'],
            ['Marine Force Reconnaissance (FoRecon)', 'Marine Force Reconnaissance (FoRecon)'],
            ['Marine Reconnaissance (Recon)', 'Marine Reconnaissance (Recon)'],
            ['Marine CounterIntelligence / Human Intelligence (CI/HUMINT)', 'Marine CounterIntelligence / Human Intelligence (CI/HUMINT)'],
            ['Expeditionary Operations Training Group (EOTG)', 'Expeditionary Operations Training Group (EOTG)'],
            ['Chemical Biological Incident Response Force', 'Chemical Biological Incident Response Force'],
            ['Naval Special Warfare (NSW)', 'Naval Special Warfare (NSW)'],
            ['Air Force Special Operations Command (AFSOC)', 'Air Force Special Operations Command (AFSOC)'],
            ['US Air Force Conventional Forces (USAF)', 'US Air Force Conventional Forces (USAF)'],
            ['US Coast Guard (USCG)', 'US Coast Guard (USCG)'],
            ['US Marshals Service (US Marshals)', 'US Marshals Service (US Marshals)'],
            ['US Customs & Border Patrol (CBP)', 'US Customs & Border Patrol (CBP)'],
            ['Ministry of Government of Bolivia', 'Ministerio de Gobierno de Bolivia'],
            ['Ministry of Defense of Bolivia', 'Ministerio de Defensa de Bolivia'],
        ];

        foreach ($clients as $i => $c) {
            HomepageClient::create([
                'name' => $c[0],
                'name_en' => $c[0],
                'name_es' => $c[1],
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Homepage content seeded successfully!');
    }
}
