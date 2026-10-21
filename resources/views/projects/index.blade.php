@extends('layouts.app')

@section('title', $section?->title ? $section->title.' — '.$siteSettings->brand_name : 'Projects — '.$siteSettings->brand_name)
@section('meta_description', $section?->subtitle ?? $siteSettings->meta_description)

@section('content')
    <section class="page-hero">
        <div class="container">
            <h1>{{ $section?->title ?: 'Our Projects' }}</h1>
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Projects</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head reveal">
                @if ($section?->eyebrow)
                    <span class="eyebrow eyebrow--center">{{ $section->eyebrow }}</span>
                @endif
                <h2 class="section-title">
                    {{ $section?->title ?: 'Our Projects' }}@if ($section?->title_highlight)
                        <span class="text-highlight">{{ $section->title_highlight }}</span>
                    @endif
                </h2>
                @if ($section?->subtitle)
                    <p class="section-lead">{{ $section->subtitle }}</p>
                @endif
                <div class="title-rule"></div>
            </div>

            @if ($categories->isNotEmpty())
                <div class="filter-pills reveal" aria-label="Filter projects by category">
                    <a class="filter-pill {{ $selectedCategory ? '' : 'is-active' }}"
                        href="{{ route('projects.index') }}"
                        @if (! $selectedCategory) aria-current="page" @endif>
                        All Projects
                    </a>

                    @foreach ($categories as $category)
                        <a class="filter-pill {{ $selectedCategory?->is($category) ? 'is-active' : '' }}"
                            href="{{ route('projects.index', ['category' => $category->slug]) }}"
                            @if ($selectedCategory?->is($category)) aria-current="page" @endif>
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($projects->isNotEmpty())
                <div class="projects-grid">
                    @foreach ($projects as $project)
                        @include('partials.project-card', ['project' => $project])
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <p class="mb-0">No projects match this category yet.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
