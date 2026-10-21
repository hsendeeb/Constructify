@extends('layouts.app')

@section('title', $siteSettings->meta_title ?: $siteSettings->brand_name)
@section('meta_description', $siteSettings->meta_description)

@section('content')
    @if ($sections->get('hero'))
        @include('partials.hero', ['section' => $sections->get('hero')])
        @include('partials.stats-ribbon')
    @endif

    @include('partials.about', [
        'section' => $sections->get('about'),
        'aboutCounters' => $aboutCounters,
    ])

    @include('partials.services', [
        'section' => $sections->get('services'),
        'services' => $services,
    ])

    @include('partials.projects-home', [
        'section' => $sections->get('projects'),
        'projects' => $featuredProjects,
    ])

    @include('partials.contact', [
        'section' => $sections->get('contact'),
        'contactCounters' => $contactCounters,
    ])
@endsection
