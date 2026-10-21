@if ($section)
    @php
        $servicesImage = $section->imageUrl('image');
    @endphp

    <section id="services" class="section section--cream">
        <div class="container">
            <div class="section-head reveal">
                @if ($section->eyebrow)
                    <span class="eyebrow eyebrow--center">{{ $section->eyebrow }}</span>
                @endif
                <h2 class="section-title">
                    {{ $section->title }}@if ($section->title_highlight)
                        <span class="text-highlight">{{ $section->title_highlight }}</span>
                    @endif
                </h2>
                @if ($section->subtitle)
                    <p class="section-lead">{{ $section->subtitle }}</p>
                @endif
            </div>

            <div class="services-layout">
                <div class="services-visual {{ $servicesImage ? 'services-visual--image' : '' }} reveal"
                    @if ($servicesImage) style="--services-image: url('{{ $servicesImage }}')" @endif>
                    <div class="services-visual__content">
                        <div class="services-visual__rule"></div>
                        <h3>{{ $section->image_caption ?: $section->title }}</h3>
                    </div>
                </div>

                <div class="services-grid">
                    @foreach ($services as $service)
                        <article class="service-card reveal">
                            <div class="service-card__icon">
                                @if ($service->icon)
                                    @svg($service->icon, 'service-icon')
                                @else
                                    <i class="bi bi-buildings" aria-hidden="true"></i>
                                @endif
                            </div>
                            <h3>{{ $service->title }}</h3>
                            @if ($service->description)
                                <p>{{ $service->description }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
