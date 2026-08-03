@if(isset($stats) && count($stats) > 0)
<div class="stats-grid">
    @foreach($stats as $stat)
    <div class="stat-card-stat {{ $stat['class'] ?? '' }}">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stat['value'] }}</div>
                <div class="stat-label">{{ $stat['label'] }}</div>
            </div>
            @if(isset($stat['icon']))
            <div class="stat-icon">
                <i class="{{ $stat['icon'] }}"></i>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif