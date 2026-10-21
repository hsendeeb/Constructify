<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeProjectsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_home_projects_section_lists_all_active_projects_with_category_filters(): void
    {
        Project::query()
            ->where('slug', 'skyline-residences')
            ->update(['image' => 'projects/skyline-residences.jpg']);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('data-project-filter', false)
            ->assertSee('data-project-filter-value="residential"', false)
            ->assertSee('data-project-filter-value="commercial"', false)
            ->assertSee('data-project-filter-value="infrastructure"', false)
            ->assertSee('data-project-category="residential"', false)
            ->assertSee('data-project-lightbox', false)
            ->assertSee('data-project-lightbox-open', false)
            ->assertSee('data-project-lightbox-close', false)
            ->assertSee('aria-label="View all projects"', false)
            ->assertSee('aria-label="Close full screen image"', false)
            ->assertSee('Skyline Residences')
            ->assertSee('Harbourview Apartments')
            ->assertSee('The Vista Offices')
            ->assertSee('Riverside Waterworks');
    }

    public function test_home_projects_section_excludes_inactive_projects_and_categories(): void
    {
        Project::factory()->inactive()->create(['title' => 'Hidden Project']);
        ProjectCategory::factory()->inactive()->create([
            'name' => 'Hidden Category',
            'slug' => 'hidden-category',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Hidden Project')
            ->assertDontSee('Hidden Category')
            ->assertDontSee('data-project-filter-value="hidden-category"', false);
    }
}
