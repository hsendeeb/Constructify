<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display the filterable project portfolio.
     */
    public function index(Request $request): View
    {
        $categories = ProjectCategory::query()
            ->active()
            ->ordered()
            ->get();

        $selectedCategory = $categories->firstWhere('slug', $request->query('category'));

        $projects = Project::query()
            ->with('category')
            ->active()
            ->ordered()
            ->when(
                $selectedCategory,
                fn ($query) => $query->where('project_category_id', $selectedCategory->id),
            )
            ->get();

        return view('projects.index', [
            'section' => Section::findByKey('projects'),
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'projects' => $projects,
        ]);
    }
}
