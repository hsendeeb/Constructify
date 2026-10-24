<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Seed the editable page sections.
     */
    public function run(): void
    {
        $sections = [
            [
                'key' => 'hero',
                'label' => 'Home / Hero',
                'eyebrow' => null,
                'title' => "Building Tomorrow's Infrastructure",
                'title_highlight' => 'Today',
                'subtitle' => 'For over two decades, Constructify has partnered with communities and businesses to deliver durable, thoughtful construction — from first sketch to final handover.',
                'badge_text' => 'Trusted Construction Partner Since 1998',
                'badge_icon' => 'heroicon-o-building-office-2',
                'primary_button_text' => 'Explore Our Projects',
                'primary_button_url' => '/projects',
                'secondary_button_text' => 'Request a Quote',
                'secondary_button_url' => '#contact',
                'sort' => 1,
            ],
            [
                'key' => 'about',
                'label' => 'About',
                'eyebrow' => 'About Constructify',
                'title' => 'We Build With Precision,',
                'title_highlight' => 'Passion & Purpose',
                'subtitle' => 'Since 1998, we have been delivering world class construction services across residential, commercial, and infrastructure sectors. Our commitment to quality craftsmanship and client satisfaction drives everything we do.',
                'image' => null,
                'secondary_image' => null,
                'image_caption' => null,
                'badge_text' => '25+ Years of Experience',
                'primary_button_text' => 'View Our Projects',
                'primary_button_url' => '/projects',
                'sort' => 2,
            ],
            [
                'key' => 'services',
                'label' => 'Services',
                'eyebrow' => 'What We Do',
                'title' => 'We Deliver Excellence in Every Project',
                'title_highlight' => null,
                'subtitle' => 'From groundworks to final finishes, our teams cover the full construction lifecycle with one point of accountability.',
                'image' => null,
                'image_caption' => 'We Deliver Excellence in Every Project',
                'sort' => 3,
            ],
            [
                'key' => 'tracking',
                'label' => 'Track Record',
                'eyebrow' => 'Our Track Record',
                'title' => 'Numbers That Speak for',
                'title_highlight' => 'Our Commitment',
                'subtitle' => 'Every project we hand over adds to a record built on trust, craftsmanship, and measurable results. Here is what that commitment looks like in numbers.',
                'primary_button_text' => 'View Our Projects',
                'primary_button_url' => '/projects',
                'sort' => 4,
            ],
            [
                'key' => 'projects',
                'label' => 'Projects',
                'eyebrow' => 'Our Portfolio',
                'title' => 'Our Projects',
                'title_highlight' => null,
                'subtitle' => 'A selection of residential, commercial, and infrastructure work delivered by Constructify teams across the region.',
                'primary_button_text' => 'View All Projects',
                'primary_button_url' => '/projects',
                'sort' => 5,
            ],
            [
                'key' => 'contact',
                'label' => 'Contact',
                'eyebrow' => 'Get In Touch',
                'title' => 'Let\'s Build Something',
                'title_highlight' => 'Together',
                'subtitle' => 'Tell us about your site, your timeline, and your ambitions. Our team will get back to you with a clear next step.',
                'primary_button_text' => 'Call Our Team',
                'primary_button_url' => 'tel:+15552346789',
                'secondary_button_text' => 'Send an Email',
                'secondary_button_url' => 'mailto:hello@constructify.com',
                'sort' => 6,
            ],
        ];

        foreach ($sections as $section) {
            Section::query()->updateOrCreate(
                ['key' => $section['key']],
                [...$section, 'is_active' => true],
            );
        }
    }
}
