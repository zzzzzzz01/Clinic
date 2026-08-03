<div class="stats-grid">
    <!-- 1. Jami dorilar -->
    <div class="stat-card-stat stat-total">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $totalMedicines ?? 0 }}</div>
                <div class="stat-label">@lang('words.total_medicines')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-pills"></i>
            </div>
        </div>
    </div>

    <!-- 2. Zaxirada bor -->
    <div class="stat-card-stat stat-in-stock">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $inStockCount ?? 0 }}</div>
                <div class="stat-label">@lang('words.in_stock')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <!-- 3. Zaxirada kam -->
    <div class="stat-card-stat stat-low-stock">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $lowStockCount ?? 0 }}</div>
                <div class="stat-label">@lang('words.low_stock')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <!-- 4. Zaxirada yo'q -->
    <div class="stat-card-stat stat-out-of-stock">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $outOfStockCount ?? 0 }}</div>
                <div class="stat-label">@lang('words.out_of_stock')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>
</div>