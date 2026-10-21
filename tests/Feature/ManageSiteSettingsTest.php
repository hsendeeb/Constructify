<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSiteSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ManageSiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->actingAs(User::query()->firstOrFail());
    }

    public function test_site_settings_can_be_saved(): void
    {
        Livewire::test(ManageSiteSettings::class)
            ->fillForm([
                'brand_name' => 'Updated Brand',
                'tagline' => 'Updated tagline',
                'footer_text' => 'Updated footer text.',
                'meta_title' => 'Updated meta title',
            ], 'form')
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('site_settings', [
            'brand_name' => 'Updated Brand',
            'tagline' => 'Updated tagline',
            'footer_text' => 'Updated footer text.',
            'meta_title' => 'Updated meta title',
        ]);
    }

    public function test_logo_upload_is_saved_and_rendered(): void
    {
        Storage::fake('public');

        Livewire::test(ManageSiteSettings::class)
            ->fillForm([
                'brand_name' => 'Logo Brand',
                'logo' => UploadedFile::fake()->image('logo.png', 200, 100),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $settings = SiteSetting::current();

        $this->assertNotNull($settings->logo);
        Storage::disk('public')->assertExists($settings->logo);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($settings->imageUrl('logo'));
    }

    public function test_saved_site_settings_are_reflected_on_the_website(): void
    {
        SiteSetting::current()->update([
            'brand_name' => 'Synced Brand',
            'footer_text' => 'Synced footer text.',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Synced Brand')
            ->assertSee('Synced footer text.');
    }
}
