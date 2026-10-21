@if ($section)
    @php
        $primaryImage = $section->imageUrl('image');
        $secondaryImage = $section->imageUrl('secondary_image');
    @endphp

    <section id="about" class="section">
        <div class="container">
            <div class="about-grid {{ $primaryImage || $secondaryImage ? '' : 'about-grid--text-only' }}">
                @if ($primaryImage || $secondaryImage)
                    <div class="about-media reveal {{ $primaryImage ? '' : 'about-media--secondary-only' }}">
                        @if ($primaryImage)
                            <div class="about-media__primary">
                                <img src="{{ $primaryImage }}"
                                    alt="{{ $section->image_caption ?: $section->title }}" loading="lazy">
                            </div>
                        @endif

                        @if ($section->badge_text)
                            <span class="about-media__badge">{{ $section->badge_text }}</span>
                        @endif

                        @if ($secondaryImage)
                            <div class="about-media__secondary">
                                <img src="{{ $secondaryImage }}"
                                    alt="{{ $section->image_caption ?: $section->title }}" loading="lazy">
                            </div>
                        @endif
                    </div>
                @endif

                <div class="about-copy reveal">
                    <h2 class="section-title">
                        {{ $section->title }}@if ($section->title_highlight)
                            <span class="text-highlight">{{ $section->title_highlight }}</span>
                        @endif
                    </h2>

                    @if ($section->subtitle)
                        <p class="section-lead">{{ $section->subtitle }}</p>
                    @endif

                    @if ($aboutCounters->isNotEmpty())
                        <div class="stats-grid about-cards">
                            @foreach ($aboutCounters as $counter)
                                <div class="stat-card">
                                    <div class="stat-card__icon">
                                        @if ($counter->icon)
                                            @svg($counter->icon, 'stat-icon')
                                        @else
                                            <i class="bi bi-graph-up-arrow" aria-hidden="true"></i>
                                        @endif
                                    </div>
                                    <h3 class="stat-card__value">{{ $counter->value }}</h3>
                                    <p class="stat-card__label">{{ $counter->label }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
