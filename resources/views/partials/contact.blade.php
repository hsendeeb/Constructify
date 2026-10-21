@if ($section)
    @php
        $contactPhoneUrl = \App\Support\SiteLink::phone($siteSettings->phone);
        $contactPhoneSecondaryUrl = \App\Support\SiteLink::phone($siteSettings->phone_secondary);
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

                    @if ($section->primary_button_text || $section->secondary_button_text)
                        <div class="contact-actions">
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

                <div class="reveal">
                    <div class="contact-cards">
                        @if ($contactPhoneUrl)
                            <div class="contact-card">
                                <div class="contact-card__icon"><i class="bi bi-telephone" aria-hidden="true"></i></div>
                                <div class="contact-card__label">Call us</div>
                                <a href="{{ $contactPhoneUrl }}">{{ $siteSettings->phone }}</a>
                                @if ($contactPhoneSecondaryUrl)
                                    <a href="{{ $contactPhoneSecondaryUrl }}">{{ $siteSettings->phone_secondary }}</a>
                                @endif
                            </div>
                        @endif

                        @if ($siteSettings->email)
                            <div class="contact-card">
                                <div class="contact-card__icon"><i class="bi bi-envelope" aria-hidden="true"></i></div>
                                <div class="contact-card__label">Email us</div>
                                <a href="mailto:{{ $siteSettings->email }}">{{ $siteSettings->email }}</a>
                            </div>
                        @endif

                        @if ($siteSettings->address)
                            <div class="contact-card">
                                <div class="contact-card__icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></div>
                                <div class="contact-card__label">Visit us</div>
                                <span>{{ $siteSettings->address }}</span>
                            </div>
                        @endif

                        @if ($siteSettings->working_hours)
                            <div class="contact-card">
                                <div class="contact-card__icon"><i class="bi bi-clock" aria-hidden="true"></i></div>
                                <div class="contact-card__label">Working hours</div>
                                <span>{{ $siteSettings->working_hours }}</span>
                            </div>
                        @endif
                    </div>

                    @if ($siteSettings->map_embed_url)
                        <div class="contact-map">
                            <iframe src="{{ $siteSettings->map_embed_url }}" title="Office location" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
