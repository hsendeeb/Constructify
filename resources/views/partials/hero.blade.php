@if ($section)
    @php
        $background = $section->imageUrl('background_image');
    @endphp

    <section id="home" class="hero {{ $background ? 'hero--image' : '' }}"
        @if ($background) style="--hero-image: url('{{ $background }}')" @endif>
        <div class="hero__bg" aria-hidden="true"></div>

        <div class="container">
            <div class="hero__inner">
                @if ($section->badge_text)
                    <div class="hero__badge">
                        @if ($section->badge_icon)
                            @svg($section->badge_icon, 'hero-badge-icon')
                        @else
                            <i class="bi bi-buildings" aria-hidden="true"></i>
                        @endif
                        <span>{{ $section->badge_text }}</span>
                    </div>
                @endif

                <h1>
                    {{ $section->title }}@if ($section->title_highlight)
                        <span class="text-highlight">{{ $section->title_highlight }}</span>
                    @endif
                </h1>

                @if ($section->subtitle)
                    <p>{{ $section->subtitle }}</p>
                @endif

                @if ($section->primary_button_text || $section->secondary_button_text)
                    <div class="hero__actions">
                        @if ($section->primary_button_text)
                            <a class="btn-vp btn-vp-primary" href="{{ \App\Support\SiteLink::resolve($section->primary_button_url) }}">
                                {{ $section->primary_button_text }}
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        @endif

                        @if ($section->secondary_button_text)
                            <a class="btn-vp btn-vp-outline" href="{{ \App\Support\SiteLink::resolve($section->secondary_button_url) }}">
                                {{ $section->secondary_button_text }}
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
