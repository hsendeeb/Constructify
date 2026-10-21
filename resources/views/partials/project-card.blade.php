@php
    $image = $project->imageUrl('image');
@endphp

<article class="project-card reveal">
    <div class="project-card__media">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $project->title }}" loading="lazy">
        @else
            <div class="project-card__placeholder" aria-hidden="true">
                <i class="bi bi-buildings"></i>
                <span>{{ $project->category?->name ?: 'VioletPro' }}</span>
            </div>
        @endif

        @if ($project->category)
            <span class="project-card__category">{{ $project->category->name }}</span>
        @endif
    </div>

    <div class="project-card__body">
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

        <h3>{{ $project->title }}</h3>

        @if ($project->description)
            <p>{{ $project->description }}</p>
        @endif
    </div>
</article>
