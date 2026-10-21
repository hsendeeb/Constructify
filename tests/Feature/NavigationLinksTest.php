<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationLinksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_navigation_anchors_scroll_within_the_home_page(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('href="#home"', false)
            ->assertSee('href="#about"', false)
            ->assertSee('href="#services"', false)
            ->assertSee('href="#projects"', false)
            ->assertSee('href="#contact"', false);
    }

    public function test_navigation_anchors_point_back_to_the_home_page_from_other_pages(): void
    {
        $homeUrl = rtrim(route('home'), '/');

        $response = $this->get(route('projects.index'));

        $response->assertOk()
            ->assertSee('href="'.$homeUrl.'/#about"', false)
            ->assertSee('href="'.$homeUrl.'/#services"', false)
            ->assertSee('href="'.$homeUrl.'/#projects"', false)
            ->assertSee('href="'.$homeUrl.'/#contact"', false);
    }
}
