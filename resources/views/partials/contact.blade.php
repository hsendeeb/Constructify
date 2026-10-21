@if ($section)
    @php
        $phoneCard = \App\Support\ContactDetails::phone($contactCounters);
        $emailCard = \App\Support\ContactDetails::email($contactCounters);

        $primaryButtonUrl = str_starts_with((string) $section->primary_button_url, 'tel:')
            ? $phoneCard?->link_url
            : $section->primary_button_url;

        $secondaryButtonUrl = str_starts_with((string) $section->secondary_button_url, 'mailto:')
            ? $emailCard?->link_url
            : $section->secondary_button_url;
    @endphp

    <section id="contact" class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <div class="reveal">
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

                    @if (($section->primary_button_text && $primaryButtonUrl) || ($section->secondary_button_text && $secondaryButtonUrl))
                        <div class="contact-actions">
                            @if ($section->primary_button_text && $primaryButtonUrl)
                                <a class="btn-vp btn-vp-primary" href="{{ \App\Support\SiteLink::resolve($primaryButtonUrl) }}">
                                    {{ $section->primary_button_text }}
                                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($section->secondary_button_text && $secondaryButtonUrl)
                                <a class="btn-vp btn-vp-outline" href="{{ \App\Support\SiteLink::resolve($secondaryButtonUrl) }}">
                                    {{ $section->secondary_button_text }}
                                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="reveal">
                    @if ($contactCounters->isNotEmpty())
                        <div class="contact-cards">
                            @foreach ($contactCounters as $card)
                                <div class="contact-card">
                                    <div class="contact-card__icon">
                                        <i class="bi {{ $card->icon ?: 'bi-info-circle' }}" aria-hidden="true"></i>
                                    </div>
                                    <div class="contact-card__label">{{ $card->value }}</div>
                                    @if ($card->link_url)
                                        <a href="{{ \App\Support\SiteLink::resolve($card->link_url) }}">{{ $card->label }}</a>
                                    @else
                                        <span>{{ $card->label }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($section->map_embed_url)
                        <div class="contact-map">
                            <iframe src="{{ $section->map_embed_url }}" title="Office location" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
