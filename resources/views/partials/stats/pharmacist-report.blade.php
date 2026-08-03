<div class="stats-grid"> 
    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $totalSales }}</div>
                <div class="stat-label">@lang('words.total_sales')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                <div class="stat-label">@lang('words.total_revenue')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $totalItems }}</div>
                <div class="stat-label">@lang('words.total_items')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>

    <div class="stat-card-stat">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $totalCustomers }}</div>
                <div class="stat-label">@lang('words.total_customers')</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div> 
</div> 