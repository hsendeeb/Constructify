<?php

namespace Tests\Feature;

use App\Filament\Resources\Sections\Pages\EditSection;
use App\Filament\Resources\Sections\RelationManagers\CountersRelationManager;
use App\Models\Counter;
use App\Models\Section;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactCardsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->actingAs(User::query()->firstOrFail());
    }

    public function test_contact_cards_render_from_the_database(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<div class="contact-card__label">Call us</div>', false)
            ->assertSee('+1 (555) 234-6789')
            ->assertSee('href="tel:+15552346789"', false)
            ->assertSee('Email us')
            ->assertSee('href="mailto:hello@constructify.com"', false)
            ->assertSee('Visit us')
            ->assertSee('Working hours');
    }

    public function test_inactive_contact_cards_are_not_shown(): void
    {
        Counter::query()->where('section_key', 'contact')->update(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('contact-cards', false);
    }

    public function test_contact_cards_are_editable_from_the_contact_section(): void
    {
        $contact = Section::findByKey('contact');
        $card = $contact->counters()->orderBy('sort')->firstOrFail();

        Livewire::test(EditSection::class, ['record' => $contact->getRouteKey()])
            ->assertOk()
            ->assertSeeLivewire(CountersRelationManager::class);

        Livewire::test(CountersRelationManager::class, [
            'ownerRecord' => $contact,
            'pageClass' => EditSection::class,
        ])
            ->callAction(TestAction::make(EditAction::class)->table($card), [
                'value' => 'Call our team',
                'label' => '+1 (555) 999-0000',
                'icon' => 'bi-telephone',
                'link_url' => 'tel:+15559990000',
                'sort' => $card->sort,
                'is_active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('counters', [
            'id' => $card->getKey(),
            'section_key' => 'contact',
            'value' => 'Call our team',
            'label' => '+1 (555) 999-0000',
            'link_url' => 'tel:+15559990000',
        ]);
    }

    public function test_a_contact_card_can_be_created_from_the_contact_section(): void
    {
        $contact = Section::findByKey('contact');

        Livewire::test(CountersRelationManager::class, [
            'ownerRecord' => $contact,
            'pageClass' => EditSection::class,
        ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'value' => 'WhatsApp',
                'label' => 'Chat with our team',
                'icon' => 'bi-whatsapp',
                'link_url' => 'https://wa.me/15552346789',
                'sort' => 5,
                'is_active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('counters', [
            'section_key' => 'contact',
            'value' => 'WhatsApp',
            'label' => 'Chat with our team',
            'link_url' => 'https://wa.me/15552346789',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('WhatsApp')
            ->assertSee('Chat with our team')
            ->assertSee('https://wa.me/15552346789', false);
    }

    public function test_footer_contact_details_follow_the_contact_cards(): void
    {
        Counter::query()
            ->where('section_key', 'contact')
            ->where('value', 'Visit us')
            ->update(['label' => 'Beirut - Hamra']);

        $html = $this->get(route('home'))->assertOk()->getContent();
        $footer = substr($html, (int) strpos($html, '<footer'));

        $this->assertStringContainsString('Beirut - Hamra', $footer);
        $this->assertStringContainsString('tel:+15552346789', $footer);
        $this->assertStringNotContainsString('1200 Harbor Avenue', $footer);
    }

    public function test_contact_cards_are_not_shown_on_other_sections(): void
    {
        $hero = Section::findByKey('hero');

        Livewire::test(EditSection::class, ['record' => $hero->getRouteKey()])
            ->assertOk()
            ->assertDontSeeLivewire(CountersRelationManager::class);
    }
}
