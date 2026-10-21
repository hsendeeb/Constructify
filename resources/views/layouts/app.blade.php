<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings->meta_title ?: $siteSettings->brand_name)</title>
    <meta name="description" content="@yield('meta_description', $siteSettings->meta_description ?? '')">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', $siteSettings->meta_title ?: $siteSettings->brand_name)">
    <meta property="og:description" content="@yield('meta_description', $siteSettings->meta_description ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($siteSettings->imageUrl('logo'))
        <meta property="og:image" content="{{ $siteSettings->imageUrl('logo') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/site.css', 'resources/js/site.js'])

    <script>document.documentElement.classList.add('js');</script>
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <button type="button" class="back-to-top" aria-label="Back to top">
        <i class="bi bi-arrow-up" aria-hidden="true"></i>
    </button>
</body>
</html>
