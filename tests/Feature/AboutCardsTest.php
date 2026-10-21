<?php

namespace Tests\Feature;

use App\Filament\Resources\Sections\Pages\EditSection;
use App\Filament\Resources\Sections\RelationManagers\CountersRelationManager;
use App\Models\Section;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AboutCardsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->actingAs(User::query()->firstOrFail());
    }

    public function test_about_card_headings_render_as_normal_headings(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<h3 class="stat-card__value">', false)
            ->assertSee('<p class="stat-card__label">', false);
    }

    public function test_about_section_renders_primary_and_secondary_images(): void
    {
        $about = Section::query()->where('key', 'about')->firstOrFail();

        $about->update([
            'image' => 'sections/about-primary.jpg',
            'secondary_image' => 'sections/about-secondary.jpg',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('about-media__primary', false)
            ->assertSee('about-media__secondary', false)
            ->assertSee('about-media__badge', false)
            ->assertSee('sections/about-primary.jpg')
            ->assertSee('sections/about-secondary.jpg')
            ->assertSee('25+ Years of Experience');
    }

    public function test_about_section_hides_the_media_column_without_images(): void
    {
        $about = Section::query()->where('key', 'about')->firstOrFail();

        $about->update([
            'image' => null,
            'secondary_image' => null,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('about-grid--text-only', false)
            ->assertDontSee('about-media__primary', false);
    }

    public function test_about_cards_are_editable_from_the_about_section(): void
    {
        $about = Section::query()->where('key', 'about')->firstOrFail();

        Livewire::test(EditSection::class, ['record' => $about->getRouteKey()])
            ->assertOk()
            ->assertSeeLivewire(CountersRelationManager::class);
    }

    public function test_about_cards_are_not_shown_on_other_sections(): void
    {
        $hero = Section::query()->where('key', 'hero')->firstOrFail();

        Livewire::test(EditSection::class, ['record' => $hero->getRouteKey()])
            ->assertOk()
            ->assertDontSeeLivewire(CountersRelationManager::class);
    }

    public function test_an_about_card_can_be_edited_from_the_about_section(): void
    {
        $about = Section::query()->where('key', 'about')->firstOrFail();
        $card = $about->counters()->orderBy('sort')->firstOrFail();

        Livewire::test(CountersRelationManager::class, [
            'ownerRecord' => $about,
            'pageClass' => EditSection::class,
        ])
            ->callAction(TestAction::make(EditAction::class)->table($card), [
                'value' => '999+',
                'label' => 'Projects Completed',
                'icon' => 'heroicon-o-trophy',
                'sort' => $card->sort,
                'is_active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('counters', [
            'id' => $card->getKey(),
            'section_key' => 'about',
            'value' => '999+',
            'label' => 'Projects Completed',
        ]);
    }

    public function test_an_about_card_can_be_created_from_the_about_section(): void
    {
        $about = Section::query()->where('key', 'about')->firstOrFail();

        Livewire::test(CountersRelationManager::class, [
            'ownerRecord' => $about,
            'pageClass' => EditSection::class,
        ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'value' => '40+',
                'label' => 'New Card',
                'icon' => 'heroicon-o-trophy',
                'sort' => 5,
                'is_active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('counters', [
            'section_key' => 'about',
            'value' => '40+',
            'label' => 'New Card',
        ]);
    }
}
