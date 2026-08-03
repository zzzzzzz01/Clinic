<div class="stats-grid">
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_patients'] ?? 0 }}</div>
                <div class="stat-label">@lang('words.total_patients')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div> 
        </div>
    </div>

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['active_patients'] ?? 0 }}</div>
                <div class="stat-label">@lang('words.active_patients')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div> 
        </div>
    </div> 

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['today_appointments'] ?? 0 }}</div>
                <div class="stat-label">@lang('words.today_appointments')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div> 
        </div>
    </div>  

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['pending_appointments'] ?? 0 }}</div>
                <div class="stat-label">@lang('words.pending_appointments')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div> 
        </div>
    </div>   
</div>