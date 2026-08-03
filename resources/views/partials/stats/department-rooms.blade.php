<div class="stats-grid">
    
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">@lang('words.total.room')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-door-open"></i>
            </div>
        </div>
    </div>

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['available'] }}</div>
                <div class="stat-label">@lang('words.available.room')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['occupied'] }}</div>
                <div class="stat-label">@lang('words.occupied.room')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-injured"></i>
            </div>
        </div>
    </div>

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['maintenance'] }}</div>
                <div class="stat-label">@lang('words.maintenance.room')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-tools"></i>
            </div>
        </div>
    </div>
</div>