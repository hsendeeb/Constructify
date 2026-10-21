@if ($heroCounters->isNotEmpty())
    <div class="stats-ribbon-wrap">
        <div class="container">
            <div class="stats-ribbon">
                @foreach ($heroCounters as $counter)
                    <div class="stat">
                        <div class="stat__value">{{ $counter->value }}</div>
                        <div class="stat__label">{{ $counter->label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
