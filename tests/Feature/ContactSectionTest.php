<?php

namespace Tests\Feature;

use App\Models\Counter;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactSectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_all_contact_links_follow_the_contact_cards(): void
    {
        Counter::query()
            ->where('section_key', 'contact')
            ->where('value', 'Call us')
            ->update([
                'label' => '+1 (555) 000-1111',
                'link_url' => 'tel:+15550001111',
            ]);

        Counter::query()
            ->where('section_key', 'contact')
            ->where('value', 'Email us')
            ->update([
                'label' => 'contact@example.com',
                'link_url' => 'mailto:contact@example.com',
            ]);

        Section::findByKey('contact')->update([
            'primary_button_url' => 'tel:+999 999 9999',
            'secondary_button_url' => 'mailto:stale@example.com',
        ]);

        $html = $this->get(route('home'))
            ->assertOk()
            ->assertSee('tel:+15550001111', false)
            ->assertSee('mailto:contact@example.com', false)
            ->assertSee('+1 (555) 000-1111')
            ->assertSee('contact@example.com')
            ->assertDontSee('+999 999 9999')
            ->assertDontSee('stale@example.com')
            ->getContent();

        $header = substr($html, 0, (int) strpos($html, '<main'));
        $footer = substr($html, (int) strpos($html, '<footer'));

        $this->assertStringContainsString('+1 (555) 000-1111', $header);
        $this->assertStringContainsString('contact@example.com', $footer);
    }

    public function test_header_phone_is_hidden_without_a_phone_card(): void
    {
        Counter::query()
            ->where('section_key', 'contact')
            ->where('link_url', 'like', 'tel:%')
            ->update(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('header-phone', false)
            ->assertDontSee('href="tel:+15552346789"', false);
    }

    public function test_contact_map_uses_the_contact_section_setting(): void
    {
        $mapUrl = 'https://www.google.com/maps/embed?pb=test';

        Section::findByKey('contact')->update(['map_embed_url' => $mapUrl]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('src="'.$mapUrl.'"', false);
    }

    public function test_contact_buttons_keep_links_that_are_not_phone_or_email_links(): void
    {
        Section::findByKey('contact')->update([
            'primary_button_url' => '/projects',
            'secondary_button_url' => '#services',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="'.url('/projects').'"', false)
            ->assertSee('href="#services"', false);
    }
}
