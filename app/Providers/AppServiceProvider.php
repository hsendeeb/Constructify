<?php

namespace App\Providers;

use App\Models\Counter;
use App\Models\FooterLinkGroup;
use App\Models\NavigationLink;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ViewFacade::composer(['layouts.app', 'home', 'projects.index'], function (View $view): void {
            $view->with([
                'siteSettings' => SiteSetting::current(),
                'navigationLinks' => NavigationLink::query()->active()->ordered()->get(),
                'socialLinks' => SocialLink::query()->active()->ordered()->get(),
                'footerLinkGroups' => FooterLinkGroup::query()
                    ->active()
                    ->ordered()
                    ->whereHas('links', fn (Builder $query) => $query->where('is_active', true))
                    ->with(['links' => fn ($query) => $query->active()])
                    ->get(),
                'contactCounters' => Counter::query()->active()->ordered()->forSection('contact')->get(),
            ]);
        });
    }
}
