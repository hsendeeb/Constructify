@php
    $footerLogo = $siteSettings->imageUrl('logo');
    $footerPhoneUrl = \App\Support\SiteLink::phone($siteSettings->phone);
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a class="brand" href="{{ route('home') }}">
                    <span class="brand__mark">
                        @if ($footerLogo)
                            <img src="{{ $footerLogo }}" alt="{{ $siteSettings->brand_name }}">
                        @else
                            <i class="bi bi-buildings" aria-hidden="true"></i>
                        @endif
                    </span>
                    <span class="brand__name">{{ $siteSettings->brand_name }}</span>
                </a>

                @if ($siteSettings->footer_text)
                    <p class="footer-about">{{ $siteSettings->footer_text }}</p>
                @endif

                @if ($socialLinks->isNotEmpty())
                    <div class="social-links">
                        @foreach ($socialLinks as $social)
                            <a class="social-link" href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                                aria-label="{{ $social->platform }}">
                                <i class="bi {{ $social->icon ?: 'bi-globe2' }}" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <h2 class="footer-title">Quick Links</h2>
                <ul class="footer-links">
                    @foreach ($navigationLinks as $link)
                        <li>
                            <a href="{{ \App\Support\SiteLink::resolve($link->url) }}"
                                @if ($link->target === '_blank') target="_blank" rel="noopener noreferrer" @endif>
                                {{ $link->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="footer-title">Services</h2>
                <ul class="footer-links">
                    @forelse ($footerServices as $service)
                        <li>
                            <a href="{{ \App\Support\SiteLink::resolve('#services') }}">{{ $service->title }}</a>
                        </li>
                    @empty
                        <li><span>Services will appear here.</span></li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h2 class="footer-title">Contact</h2>
                <ul class="footer-contact">
                    @if ($siteSettings->address)
                        <li>
                            <i class="bi bi-geo-alt" aria-hidden="true"></i>
                            <span>{{ $siteSettings->address }}</span>
                        </li>
                    @endif
                    @if ($footerPhoneUrl)
                        <li>
                            <i class="bi bi-telephone" aria-hidden="true"></i>
                            <a href="{{ $footerPhoneUrl }}">{{ $siteSettings->phone }}</a>
                        </li>
                    @endif
                    @if ($siteSettings->email)
                        <li>
                            <i class="bi bi-envelope" aria-hidden="true"></i>
                            <a href="mailto:{{ $siteSettings->email }}">{{ $siteSettings->email }}</a>
                        </li>
                    @endif
                    @if ($siteSettings->working_hours)
                        <li>
                            <i class="bi bi-clock" aria-hidden="true"></i>
                            <span>{{ $siteSettings->working_hours }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>{{ $siteSettings->copyright ?: '© '.date('Y').' '.$siteSettings->brand_name.'. All rights reserved.' }}</span>
            @if ($siteSettings->tagline)
                <span>{{ $siteSettings->tagline }}</span>
            @endif
        </div>
    </div>
</footer>
