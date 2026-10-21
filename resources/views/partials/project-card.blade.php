@php
    $image = $project->imageUrl('image');
@endphp

<article class="project-card reveal"
    data-project-card
    data-project-category="{{ $project->category?->slug }}">
    <div class="project-card__media">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $project->title }}" loading="lazy">
        @else
            <div class="project-card__placeholder" aria-hidden="true">
                <i class="bi bi-buildings"></i>
                <span>{{ $project->category?->name ?: 'Constructify' }}</span>
            </div>
        @endif
    </div>

    <div class="project-card__content">
        @if ($project->category)
            <span class="project-card__category">{{ $project->category->name }}</span>
        @endif

        <h3>{{ $project->title }}</h3>

        @if ($project->location || $project->year)
            <div class="project-card__meta">
                @if ($project->location)
                    <span><i class="bi bi-geo-alt" aria-hidden="true"></i>{{ $project->location }}</span>
                @endif
                @if ($project->year)
                    <span><i class="bi bi-calendar3" aria-hidden="true"></i>{{ $project->year }}</span>
                @endif
            </div>
        @endif

        @if ($project->description)
            <p>{{ $project->description }}</p>
        @endif
    </div>

    <div class="project-card__actions">
        @if ($image)
            <button type="button" class="project-card__action"
                data-project-lightbox-open
                data-project-lightbox-src="{{ $image }}"
                data-project-lightbox-alt="{{ $project->title }}"
                aria-label="View {{ $project->title }} image full screen"
                title="View full screen">
                <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
            </button>
        @endif

        <a class="project-card__action"
            href="{{ route('projects.index') }}"
            aria-label="View all projects"
            title="View all projects">
            <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
        </a>
    </div>
</article>
