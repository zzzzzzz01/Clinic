<div class="stats-grid">
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $nurses->total() }}</div>
                <div class="stat-label">@lang('words.total')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $nurses->where('status', 'active')->count() }}</div>
                <div class="stat-label">@lang('words.active')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $nurses->where('status', 'on_leave')->count() }}</div>
                <div class="stat-label">@lang('words.on_leave')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-umbrella-beach"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $nurses->where('status', 'inactive')->count() }}</div>
                <div class="stat-label">@lang('words.inactive')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-slash"></i>
            </div>
        </div>
    </div>
</div>