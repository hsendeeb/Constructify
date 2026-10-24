<?php

namespace Tests\Feature;

use App\Filament\Resources\FooterLinkGroups\Pages\CreateFooterLinkGroup;
use App\Filament\Resources\FooterLinkGroups\Pages\EditFooterLinkGroup;
use App\Filament\Resources\FooterLinkGroups\RelationManagers\FooterLinksRelationManager;
use App\Models\FooterLink;
use App\Models\FooterLinkGroup;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FooterLinksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->actingAs(User::query()->firstOrFail());

        FooterLinkGroup::query()->delete();
    }

    public function test_footer_renders_managed_collections_and_links(): void
    {
        $group = FooterLinkGroup::factory()->create(['title' => 'Quick Links', 'sort' => 1]);

        FooterLink::factory()->for($group, 'group')->create([
            'label' => 'Warranty',
            'url' => '/warranty',
            'sort' => 1,
        ]);

        FooterLink::factory()->for($group, 'group')->create([
            'label' => 'Careers',
            'url' => '/careers',
            'target' => '_blank',
            'sort' => 2,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Quick Links')
            ->assertSee('Warranty')
            ->assertSee('href="'.url('/warranty').'"', false)
            ->assertSee('Careers')
            ->assertSee('href="'.url('/careers').'"', false)
            ->assertSee('target="_blank" rel="noopener noreferrer"', false);
    }

    public function test_collections_follow_their_sort_order(): void
    {
        $second = FooterLinkGroup::factory()->create(['title' => 'Second Column', 'sort' => 2]);
        FooterLink::factory()->for($second, 'group')->create(['label' => 'Second link']);

        $first = FooterLinkGroup::factory()->create(['title' => 'First Column', 'sort' => 1]);
        FooterLink::factory()->for($first, 'group')->create(['label' => 'First link']);

        $html = $this->get(route('home'))->assertOk()->getContent();

        $this->assertLessThan(
            strpos($html, 'Second Column'),
            strpos($html, 'First Column'),
        );
    }

    public function test_inactive_collections_and_links_are_hidden(): void
    {
        $hiddenGroup = FooterLinkGroup::factory()->inactive()->create(['title' => 'Hidden Collection']);
        FooterLink::factory()->for($hiddenGroup, 'group')->create(['label' => 'Hidden Link']);

        $visibleGroup = FooterLinkGroup::factory()->create(['title' => 'Visible Collection']);
        FooterLink::factory()->for($visibleGroup, 'group')->inactive()->create(['label' => 'Inactive Link']);
        FooterLink::factory()->for($visibleGroup, 'group')->create(['label' => 'Active Link']);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Hidden Collection')
            ->assertDontSee('Hidden Link')
            ->assertSee('Visible Collection')
            ->assertDontSee('Inactive Link')
            ->assertSee('Active Link');
    }

    public function test_empty_collections_do_not_render_a_column(): void
    {
        FooterLinkGroup::factory()->create(['title' => 'Empty Collection']);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Empty Collection');
    }

    public function test_a_collection_can_be_created_edited_and_deleted(): void
    {
        Livewire::test(CreateFooterLinkGroup::class)
            ->fillForm([
                'title' => 'Company',
                'sort' => 3,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $group = FooterLinkGroup::query()->where('title', 'Company')->firstOrFail();

        Livewire::test(EditFooterLinkGroup::class, ['record' => $group->getRouteKey()])
            ->fillForm(['title' => 'Company Info'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('footer_link_groups', [
            'id' => $group->getKey(),
            'title' => 'Company Info',
        ]);

        Livewire::test(EditFooterLinkGroup::class, ['record' => $group->getRouteKey()])
            ->callAction(TestAction::make(DeleteAction::class))
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('footer_link_groups', [
            'id' => $group->getKey(),
        ]);
    }

    public function test_links_can_be_added_edited_and_removed_from_a_collection(): void
    {
        $group = FooterLinkGroup::factory()->create(['title' => 'Quick Links']);

        Livewire::test(FooterLinksRelationManager::class, [
            'ownerRecord' => $group,
            'pageClass' => EditFooterLinkGroup::class,
        ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'label' => 'Support',
                'url' => '/support',
                'target' => '_self',
                'sort' => 1,
                'is_active' => true,
            ])
            ->assertHasNoFormErrors();

        $link = $group->links()->where('label', 'Support')->firstOrFail();

        Livewire::test(FooterLinksRelationManager::class, [
            'ownerRecord' => $group,
            'pageClass' => EditFooterLinkGroup::class,
        ])
            ->callAction(TestAction::make(EditAction::class)->table($link), [
                'label' => 'Help Center',
                'url' => '/help',
                'target' => '_blank',
                'sort' => 1,
                'is_active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('footer_links', [
            'id' => $link->getKey(),
            'label' => 'Help Center',
            'url' => '/help',
            'target' => '_blank',
        ]);

        Livewire::test(FooterLinksRelationManager::class, [
            'ownerRecord' => $group,
            'pageClass' => EditFooterLinkGroup::class,
        ])
            ->callAction(TestAction::make(DeleteAction::class)->table($link))
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('footer_links', [
            'id' => $link->getKey(),
        ]);
    }

    public function test_deleting_a_collection_removes_its_links(): void
    {
        $group = FooterLinkGroup::factory()->create(['title' => 'Temporary']);
        $link = FooterLink::factory()->for($group, 'group')->create();

        $group->delete();

        $this->assertDatabaseMissing('footer_links', [
            'id' => $link->getKey(),
        ]);
    }
}
