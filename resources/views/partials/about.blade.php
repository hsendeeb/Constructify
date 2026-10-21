@if ($section)
    <section id="about" class="section">
        <div class="container">
            <div class="about-grid">
                <div class="about-copy reveal">
                    @if ($section->eyebrow)
                        <span class="eyebrow">{{ $section->eyebrow }}</span>
                    @endif

                    <h2 class="section-title">
                        {{ $section->title }}@if ($section->title_highlight)
                            <span class="text-highlight">{{ $section->title_highlight }}</span>
                        @endif
                    </h2>

                    @if ($section->subtitle)
                        <p class="section-lead">{{ $section->subtitle }}</p>
                    @endif

                    @if ($section->imageUrl('image'))
                        <div class="about-image">
                            <img src="{{ $section->imageUrl('image') }}"
                                alt="{{ $section->image_caption ?: $section->title }}" loading="lazy">
                        </div>
                    @endif

                    @if ($section->primary_button_text)
                        <a class="btn-vp btn-vp-primary" href="{{ \App\Support\SiteLink::resolve($section->primary_button_url) }}">
                            {{ $section->primary_button_text }}
                            <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>

                @if ($aboutCounters->isNotEmpty())
                    <div class="stats-grid reveal">
                        @foreach ($aboutCounters as $counter)
                            <div class="stat-card">
                                <div class="stat-card__icon">
                                    @if ($counter->icon)
                                        @svg($counter->icon, 'stat-icon')
                                    @else
                                        <i class="bi bi-graph-up-arrow" aria-hidden="true"></i>
                                    @endif
                                </div>
                                <div class="stat-card__value">{{ $counter->value }}</div>
                                <div class="stat-card__label">{{ $counter->label }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
