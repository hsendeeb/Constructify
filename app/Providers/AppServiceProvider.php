<?php

namespace App\Providers;

use App\Models\NavigationLink;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
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
                'footerServices' => Service::query()->active()->ordered()->limit(4)->get(),
            ]);
        });
    }
}
