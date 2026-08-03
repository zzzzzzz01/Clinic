<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">@lang('words.total')</div>
            </div>
            <div class="stat-icon"><i class="fas fa-door-closed"></i></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['available'] }}</div>
                <div class="stat-label">@lang('words.available')</div>
            </div>
            <div class="stat-icon"><i class="fas fa-check"></i></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['full'] }}</div>
                <div class="stat-label">@lang('words.full')</div>
            </div>
            <div class="stat-icon"><i class="fas fa-bed"></i></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['maintenance'] }}</div>
                <div class="stat-label">@lang('words.maintenance')</div>
            </div>
            <div class="stat-icon"><i class="fas fa-tools"></i></div>
        </div>
    </div>
</div>