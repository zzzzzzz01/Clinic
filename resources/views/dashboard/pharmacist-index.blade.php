<x-layouts.main.website>
    <x-slot:title>
        @lang('words.pharmacist_dashboard')
    </x-slot:title>

<link rel="stylesheet" href="{{ asset('temp2/css/pharmacist-index.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>  
            </ol>
        </nav>

        <div class="search-card">
            <div class="search-card-inner">
                <h4 class="mb-0">@lang('words.pharmacist_dashboard')</h4>
                <div class="dashboard-date">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->format('l, F d, Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-wrapper">
        <div class="dashboard-container">
            <!-- 1-QATOR: Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($stats['total_medicines']) }}</h3>
                        <p class="stat-label">@lang('words.total_medicines')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($stats['low_stock']) }}</h3>
                        <p class="stat-label">@lang('words.low_stock')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-prescription"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($stats['today_usages']) }}</h3>
                        <p class="stat-label">@lang('words.today_usages')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        <p class="stat-label">@lang('words.total_revenue')</p> 
                    </div>
                </div>
            </div>

            <!-- 2-QATOR: Charts -->
            <div class="dashboard-grid-charts">
                <!-- Daily Box Usages Chart -->
                <div class="dashboard-card card-chart">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-bar card-icon"></i>
                            <h5 class="card-title">@lang('words.daily_box_usages_7_days')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-info">{{ $currentMonth }}</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="boxUsagesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Revenue Chart -->
                <div class="dashboard-card card-chart">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-line card-icon"></i>
                            <h5 class="card-title">@lang('words.revenue_7_days')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-success">{{ $currentMonth }}</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3-QATOR: Selected Date Prescriptions & Calendar -->
            <div class="dashboard-grid-prescriptions">
                <!-- Selected Date Prescriptions -->
                <div class="dashboard-card card-prescriptions">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-prescription card-icon"></i>
                            <h5 class="card-title">@lang('words.prescriptions_for') {{ $selectedDateLabel }}</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary">{{ count($selectedPrescriptions) }}</span>
                            <a href="{{ route('pharmacist.report') }}" class="btn btn-sm btn-outline-primary">@lang('words.view_all')</a>
                        </div>
                    </div>
                    <div class="dashboard-card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-appointments">
                                <thead>
                                    <tr>
                                        <th>@lang('words.time')</th>
                                        <th>@lang('words.employee')</th>
                                        <th>@lang('words.medicines')</th>
                                        <th>@lang('words.total')</th>
                                        <th>@lang('words.payment')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($selectedPrescriptions as $prescription)
                                        <tr>
                                            <td><span class="appointment-time">{{ $prescription['time'] }}</span></td>
                                            <td><span class="patient-name">{{ $prescription['pharmacist'] }}</span></td>
                                            <td class="products-cell">
                                                @foreach($prescription['items'] as $item)
                                                    <span class="payment-badge">
                                                        <div class="medicine-item-text">{{ $item['display_text'] }}</div>
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td><span class="price-text">${{ number_format($prescription['total_price'], 2) }}</span></td>
                                            <td><span class="payment-badge">{{ $prescription['payment_method'] }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4"> 
                                                @lang('words.no_prescriptions_for_date')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Mini Calendar -->
                <div class="dashboard-card card-calendar">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-calendar-alt card-icon"></i>
                            <h5 class="card-title">@lang('words.calendar')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-info">{{ $currentMonth }}</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="mini-calendar">
                            <div class="calendar-header">
                                <a href="{{ route('pharmacist.dashboard', ['date' => $prevMonth]) }}" class="calendar-nav">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <span class="calendar-month">{{ $currentMonth }}</span>
                                <a href="{{ route('pharmacist.dashboard', ['date' => $nextMonth]) }}" class="calendar-nav">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                            <div class="calendar-weekdays">
                                <span>Mon</span>
                                <span>Tue</span>
                                <span>Wed</span>
                                <span>Thu</span>
                                <span>Fri</span>
                                <span>Sat</span>
                                <span>Sun</span>
                            </div>
                            <div class="calendar-days">
                                @foreach($calendarDays as $day)
                                    <a href="{{ route('pharmacist.dashboard', ['date' => $day['date']]) }}" 
                                       class="calendar-day 
                                              {{ $day['isToday'] ? 'today' : '' }} 
                                              {{ $day['isSelected'] ? 'selected' : '' }} 
                                              {{ $day['hasEvent'] ? 'has-event' : '' }}
                                              {{ !$day['isCurrentMonth'] ? 'other-month' : '' }}">
                                        {{ $day['day'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4-QATOR: Low Stock, Pharmacy Overview, Categories -->
            <div class="dashboard-grid-bottom">
                <!-- Low Stock Medicines -->
                <div class="dashboard-card card-low-stock">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-exclamation-circle card-icon"></i>
                            <h5 class="card-title">@lang('words.low_stock_medicines')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-danger">{{ count($lowStockMedicines) }}</span>
                            <a href="{{ route('medicines.index') }}" class="btn btn-sm btn-outline-primary">@lang('words.view_all')</a>
                        </div>
                    </div>
                    <div class="dashboard-card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-low-stock">
                                <thead>
                                    <tr>
                                        <th>@lang('words.medicine')</th>
                                        <th>@lang('words.stock_units')</th>
                                        <th>@lang('words.min_stock')</th>
                                        <!-- <th>@lang('words.boxes')</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowStockMedicines as $medicine)
                                        <tr>
                                            <td><span class="medicine-name">{{ $medicine['name'] }}</span></td>
                                            <td><span class="stock-value">{{ $medicine['stock_units'] }}</span></td>
                                            <td><span class="min-stock-value">{{ $medicine['min_stock'] }}</span></td>
                                            <!-- <td><span class="box-value">{{ $medicine['stock_boxes'] }}</span></td> -->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4"> 
                                                @lang('words.no_low_stock_medicines')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pharmacy Overview -->
                <div class="dashboard-card card-overview">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-pie card-icon"></i>
                            <h5 class="card-title">@lang('words.pharmacy_overview')</h5>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-container" style="height: 220px;">
                            <canvas id="overviewChart"></canvas>
                        </div>
                        <div class="overview-legend">
                            @foreach($pharmacyOverview['labels'] as $index => $label)
                                <div class="legend-item">
                                    <span class="legend-color" style="background: {{ $pharmacyOverview['colors'][$index] }};"></span>
                                    <span class="legend-label">{{ $label }}</span>
                                    <span class="legend-value">{{ $pharmacyOverview['data'][$index] }}%</span>
                                    <span class="legend-count">({{ $pharmacyOverview['totals'][$index] }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Medicine Categories -->
                <div class="dashboard-card card-categories">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-tags card-icon"></i>
                            <h5 class="card-title">@lang('words.medicine_categories')</h5>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-container" style="height: 220px;">
                            <canvas id="categoriesChart"></canvas>
                        </div>
                        <div class="category-legend">
                            @foreach($categoryStats as $category)
                                <div class="category-item">
                                    <span class="category-name">{{ $category['category'] }}</span>
                                    <div class="category-bar">
                                        <div class="category-bar-fill" style="width: {{ $category['percentage'] }}%; background: {{ ['#3498db', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6', '#1abc9c', '#e67e22', '#34495e'][$loop->index % 8] }};"></div>
                                    </div>
                                    <span class="category-percent">{{ $category['percentage'] }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weeklyData = @json($weeklyData);
            const pharmacyOverview = @json($pharmacyOverview);
            const categoryStats = @json($categoryStats);
            const totalMedicines = @json($totalMedicines);

            // Box Usages Chart - Bar
            const ctx1 = document.getElementById('boxUsagesChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: weeklyData.box_usages.map(item => item.day),
                    datasets: [{
                        label: 'Boxes Used',
                        data: weeklyData.box_usages.map(item => item.count),
                        backgroundColor: 'rgba(13, 202, 240, 0.7)',
                        borderColor: 'rgba(13, 202, 240, 1)',
                        borderWidth: 2,
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { size: 11 } },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });

            // Revenue Chart - Line
            const ctx2 = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: weeklyData.revenues.map(item => item.day),
                    datasets: [{
                        label: 'Revenue',
                        data: weeklyData.revenues.map(item => item.amount),
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                font: { size: 11 },
                                callback: function(value) {
                                    return '$' + value;
                                }
                            },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });

            // Pharmacy Overview - Doughnut with center text
            const ctx3 = document.getElementById('overviewChart').getContext('2d');
            new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: pharmacyOverview.labels,
                    datasets: [{
                        data: pharmacyOverview.data,
                        backgroundColor: pharmacyOverview.colors,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '75%'
                },
                plugins: [{
                    id: 'centerText',
                    afterDraw: function(chart) {
                        const { width, height, ctx } = chart;
                        ctx.save();
                        const centerX = width / 2;
                        const centerY = height / 2;
                        
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        
                        ctx.font = 'bold 20px sans-serif';
                        ctx.fillStyle = '#1a2332';
                        ctx.fillText(totalMedicines, centerX, centerY - 8);
                        
                        ctx.font = '11px sans-serif';
                        ctx.fillStyle = '#6c757d';
                        ctx.fillText('@lang('words.total')', centerX, centerY + 18);
                        
                        ctx.restore();
                    }
                }]
            });

            // Medicine Categories - Doughnut
            const ctx4 = document.getElementById('categoriesChart').getContext('2d');
            const categoryColors = ['#3498db', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6', '#1abc9c', '#e67e22', '#34495e'];
            new Chart(ctx4, {
                type: 'doughnut',
                data: {
                    labels: categoryStats.map(item => item.category),
                    datasets: [{
                        data: categoryStats.map(item => item.percentage),
                        backgroundColor: categoryColors.slice(0, categoryStats.length),
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>

    
</x-layouts.main.website>