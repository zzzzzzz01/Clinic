<div class="stats-grid">
    
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Jami Bo'limlar</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card-stat ">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['active'] }}</div>
                <div class="stat-label">Faol Bo'limlar</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['inactive'] }}</div>
                <div class="stat-label">Nofaol Bo'limlar</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_beds'] }}</div>
                <div class="stat-label">Jami O'rinlar</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-bed"></i>
            </div>
        </div>
    </div>
</div>