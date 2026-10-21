@php
    $logoUrl = $siteSettings->imageUrl('logo');
    $phoneUrl = \App\Support\SiteLink::phone($siteSettings->phone);
    $isProjectsPage = request()->routeIs('projects.*');
@endphp

<header class="site-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand__mark">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $siteSettings->brand_name }}">
                    @else
                        <i class="bi bi-buildings" aria-hidden="true"></i>
                    @endif
                </span>
                <span class="brand__name">{{ $siteSettings->brand_name }}</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavigation"
                aria-controls="siteNavigation" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>

            <div class="collapse navbar-collapse" id="siteNavigation">
                <ul class="navbar-nav site-nav mx-auto">
                    @foreach ($navigationLinks as $link)
                        @php
                            $anchor = \App\Support\SiteLink::anchor($link->url);
                            $isActive = $isProjectsPage
                                ? str_contains($link->url, 'projects')
                                : (request()->routeIs('home') && str_contains($link->url, '#home'));
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{ $isActive ? 'active' : '' }}"
                                href="{{ \App\Support\SiteLink::resolve($link->url) }}"
                                @if ($anchor) data-nav-anchor="{{ $anchor }}" @endif
                                @if ($link->target === '_blank') target="_blank" rel="noopener noreferrer" @endif
                                @if ($isActive) aria-current="page" @endif>
                                {{ $link->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="header-actions">
                    @if ($phoneUrl)
                        <a class="header-phone" href="{{ $phoneUrl }}">
                            <i class="bi bi-telephone" aria-hidden="true"></i>
                            <span>{{ $siteSettings->phone }}</span>
                        </a>
                    @endif

                    @if ($siteSettings->header_cta_text)
                        <a class="btn-estimate" href="{{ \App\Support\SiteLink::resolve($siteSettings->header_cta_url) }}">
                            {{ $siteSettings->header_cta_text }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
