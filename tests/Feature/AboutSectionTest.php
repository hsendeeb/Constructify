<?php

namespace Tests\Feature;

use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutSectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_about_section_renders_its_primary_and_secondary_buttons(): void
    {
        Section::findByKey('about')->update([
            'primary_button_text' => 'View Our Projects',
            'primary_button_url' => '/projects',
            'secondary_button_text' => 'View our work',
            'secondary_button_url' => '#projects',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('about-actions', false)
            ->assertSee('View Our Projects')
            ->assertSee('href="'.url('/projects').'"', false)
            ->assertSee('View our work')
            ->assertSee('href="#projects"', false);
    }

    public function test_about_section_hides_buttons_without_button_text(): void
    {
        Section::findByKey('about')->update([
            'primary_button_text' => null,
            'secondary_button_text' => null,
        ]);

        $html = $this->get(route('home'))
            ->assertOk()
            ->getContent();

        $aboutStart = (int) strpos($html, 'id="about"');
        $aboutSection = substr($html, $aboutStart, (int) strpos($html, 'id="services"') - $aboutStart);

        $this->assertStringNotContainsString('about-actions', $aboutSection);
        $this->assertStringNotContainsString('View Our Projects', $aboutSection);
    }
}
