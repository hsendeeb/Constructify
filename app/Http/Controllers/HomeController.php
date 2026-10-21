<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Project;
use App\Models\ProjectCategory;
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
            'projectCategories' => ProjectCategory::query()->active()->ordered()->get(),
            'projects' => Project::query()
                ->with('category')
                ->active()
                ->ordered()
                ->get(),
        ]);
    }
}
