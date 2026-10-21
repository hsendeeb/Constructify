<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Project;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the dynamically managed home page.
     */
    public function __invoke(): View
    {
        $sections = Section::query()
            ->active()
            ->ordered()
            ->get()
            ->keyBy('key');

        return view('home', [
            'sections' => $sections,
            'heroCounters' => Counter::query()->active()->ordered()->forSection('hero')->get(),
            'aboutCounters' => Counter::query()->active()->ordered()->forSection('about')->get(),
            'services' => Service::query()->active()->ordered()->get(),
            'featuredProjects' => Project::query()
                ->with('category')
                ->active()
                ->featured()
                ->ordered()
                ->limit(3)
                ->get(),
        ]);
    }
}
