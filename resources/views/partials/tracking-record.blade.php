@if ($section)
    <section id="tracking-record" class="section tracking-record">
        <div class="container">
            <div class="tracking-record__layout">
                <div class="tracking-record__copy reveal">
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

                    @if ($section->primary_button_text)
                        <a class="tracking-record__link"
                            href="{{ \App\Support\SiteLink::resolve($section->primary_button_url) }}">
                            {{ $section->primary_button_text }}
                            <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>

                @if ($trackingCounters->isNotEmpty())
                    <div class="tracking-record__grid">
                        @foreach ($trackingCounters as $counter)
                            <div class="tracking-card reveal">
                                <div class="tracking-card__icon">
                                    @if ($counter->icon)
                                        @svg($counter->icon, 'tracking-icon')
                                    @else
                                        <i class="bi bi-graph-up-arrow" aria-hidden="true"></i>
                                    @endif
                                </div>
                                <div class="tracking-card__body">
                                    <h3 class="tracking-card__value">{{ $counter->value }}</h3>
                                    <p class="tracking-card__label">{{ $counter->label }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
