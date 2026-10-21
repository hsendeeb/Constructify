@if ($section)
    <section id="projects" class="section">
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
                <div class="title-rule"></div>
            </div>

            @if ($projects->isNotEmpty())
                <div class="projects-grid">
                    @foreach ($projects as $project)
                        @include('partials.project-card', ['project' => $project])
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <p class="mb-0">Projects will appear here once they are published.</p>
                </div>
            @endif

            @if ($section->primary_button_text)
                <div class="projects-footer reveal">
                    <a class="btn-vp btn-vp-primary" href="{{ \App\Support\SiteLink::resolve($section->primary_button_url) }}">
                        {{ $section->primary_button_text }}
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endif
