<?php

namespace Tests\Feature;

use App\Filament\Resources\Sections\Pages\EditSection;
use App\Filament\Resources\Sections\RelationManagers\CountersRelationManager;
use App\Models\Counter;
use App\Models\Section;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TrackingRecordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->actingAs(User::query()->firstOrFail());
    }

    public function test_track_record_section_renders_its_content_and_counters(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="tracking-record"', false)
            ->assertSee('Numbers That Speak for')
            ->assertSee('Our Commitment')
            ->assertSee('View Our Projects')
            ->assertSee('tracking-card__value', false)
            ->assertSee('Projects Delivered')
            ->assertSee('Satisfied Clients')
            ->assertSee('Skilled Workers')
            ->assertSee('Industry Awards')
            ->assertDontSee('href="#tracking-record"', false);
    }

    public function test_inactive_track_record_counters_are_hidden(): void
    {
        Counter::query()
            ->where('section_key', 'tracking')
            ->where('label', 'Satisfied Clients')
            ->update(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<p class="tracking-card__label">Projects Delivered</p>', false)
            ->assertDontSee('<p class="tracking-card__label">Satisfied Clients</p>', false);
    }

    public function test_track_record_section_can_be_hidden(): void
    {
        Section::findByKey('tracking')->update(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('id="tracking-record"', false);
    }

    public function test_track_record_counters_are_editable_from_the_section(): void
    {
        $tracking = Section::findByKey('tracking');
        $card = $tracking->counters()->orderBy('sort')->firstOrFail();

        Livewire::test(EditSection::class, ['record' => $tracking->getRouteKey()])
            ->assertOk()
            ->assertSeeLivewire(CountersRelationManager::class);

        Livewire::test(CountersRelationManager::class, [
            'ownerRecord' => $tracking,
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
            'section_key' => 'tracking',
            'value' => '999+',
            'label' => 'Projects Completed',
        ]);
    }

    public function test_track_record_counters_can_be_added_and_removed(): void
    {
        $tracking = Section::findByKey('tracking');

        Livewire::test(CountersRelationManager::class, [
            'ownerRecord' => $tracking,
            'pageClass' => EditSection::class,
        ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'value' => '40+',
                'label' => 'Cities Served',
                'icon' => 'heroicon-o-trophy',
                'sort' => 5,
                'is_active' => true,
            ])
            ->assertHasNoFormErrors();

        $card = $tracking->counters()->where('label', 'Cities Served')->firstOrFail();

        Livewire::test(CountersRelationManager::class, [
            'ownerRecord' => $tracking,
            'pageClass' => EditSection::class,
        ])
            ->callAction(TestAction::make(DeleteAction::class)->table($card))
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('counters', [
            'id' => $card->getKey(),
        ]);
    }
}
