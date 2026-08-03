<x-layouts.main.website>
    <x-slot:title>
        Dashboard
    </x-slot:title>
    
    <link rel="stylesheet" href="{{ asset('temp2/css/dashboard.css') }}" />

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
                <h4 class="mb-0">@lang('words.dashboard')</h4>
                <div class="dashboard-date">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->format('l, F d, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-wrapper">
        <div class="dashboard-container">
            <!-- 1-QATOR: Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalPatients) }}</h3>
                        <p class="stat-label">@lang('words.patients')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalDoctors) }}</h3>
                        <p class="stat-label">@lang('words.doctors')</p>  
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalAppointments) }}</h3>
                        <p class="stat-label">@lang('words.appointments')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalDepartments) }}</h3>
                        <p class="stat-label">@lang('words.departments')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-danger">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalMedicines) }}</h3>
                        <p class="stat-label">@lang('words.medicines')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-secondary">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalRooms) }}</h3>
                        <p class="stat-label">@lang('words.rooms')</p> 
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="dashboard-grid">
                <!-- Today's Appointments -->
                <div class="dashboard-card card-appointments">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-calendar-day card-icon"></i>
                            <h5 class="card-title">@lang('words.today_appointments')</h5> 
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary">{{ count($todayAppointmentsList) }} @lang('words.today')</span>
                            <!-- <a href="#" class="btn btn-sm btn-outline-primary">@lang('words.view_all')</a> -->
                        </div>
                    </div>
                    <div class="dashboard-card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-appointments">
                                <thead>
                                    <tr>
                                        <th style="width: 12%;">@lang('words.time')</th>
                                        <th style="width: 28%;">@lang('words.patient')</th>
                                        <th style="width: 28%;">@lang('words.doctor')</th>
                                        <th style="width: 20%;">@lang('words.department')</th>
                                        <th style="width: 12%;" class="text-end">@lang('words.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todayAppointmentsList as $appointment)
                                        <tr>
                                            <td style="width: 12%;"><span class="appointment-time">{{ $appointment['time'] }}</span></td>
                                            <td style="width: 28%;"><span class="patient-name">{{ $appointment['patient'] }}</span></td>
                                            <td style="width: 28%;"><span class="doctor-name">{{ $appointment['doctor'] }}</span></td>
                                            <td style="width: 20%;"><span class="doctor-name">{{ $appointment['department'] }}</span></td>
                                            <td style="width: 12%;" class="text-end">
                                                <a href="{{ route('doctor.consultation', $appointment['id']) }}" class="text-primary view-icon">
                                                    <i class="fa-regular fa-circle-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4"> 
                                                @lang('words.no_appointments_today')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-card card-actions">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-bolt card-icon"></i>
                            <h5 class="card-title">@lang('words.quick_actions')</h5>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="quick-actions-grid">
                            <a href="{{ route('hospitalizations.index') }}" class="quick-action-btn bg-primary">
                                <i class="fas fa-user-plus"></i>
                                <span>@lang('words.patients')</span>
                            </a>
                            <a href="{{ route('nurses.index') }}" class="quick-action-btn bg-success">
                                <i class="fas fa-user-nurse"></i>
                                <span>@lang('words.appointments')</span>
                            </a>
                            <a href="{{ route('medicines.index') }}" class="quick-action-btn bg-warning">
                                <i class="fas fa-prescription"></i>
                                <span>@lang('words.medicines')</span>
                            </a>
                            <a href="{{ route('doctors.index') }}" class="quick-action-btn bg-info">
                                <i class="fas fa-user-md"></i>
                                <span>@lang('words.doctors')</span>
                            </a>
                            <a href="{{ route('department.index') }}" class="quick-action-btn bg-danger">
                                <i class="fas fa-building"></i>
                                <span>@lang('words.departments')</span>
                            </a>
                            <a href="{{ route('room.index') }}" class="quick-action-btn bg-secondary">
                                <i class="fas fa-door-open"></i>
                                <span>@lang('words.rooms')</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Charts Row -->
            <div class="dashboard-grid-appointments">
                <!-- Appointments Chart (Last 10 Days) -->
                <div class="dashboard-card card-chart">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-bar card-icon"></i>
                            <h5 class="card-title">@lang('words.appointments_10_days')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-info">{{ $totalAppointments }} @lang('words.total')</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-container">
                            <canvas id="appointmentsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Appointments by Status -->
                <div class="dashboard-card card-status">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-pie card-icon"></i>
                            <h5 class="card-title">@lang('words.appointments_by_status')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-success">@lang('words.active')</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="status-list">
                            <div class="status-item">
                                <div class="status-info">
                                    <span class="status-dot bg-warning"></span>
                                    <span class="status-name">@lang('words.pending') ({{ $statusCounts['pending'] ?? 0 }})</span>
                                </div>
                                <div class="status-bar">
                                    <div class="status-bar-fill bg-warning" style="width: {{ $statusPercentages['pending'] ?? 0 }}%;"></div>
                                </div>
                                <span class="status-percent">{{ $statusPercentages['pending'] ?? 0 }}%</span>
                            </div>
                            <div class="status-item">
                                <div class="status-info">
                                    <span class="status-dot bg-info"></span>
                                    <span class="status-name">@lang('words.completed') ({{ $statusCounts['completed'] ?? 0 }})</span>
                                </div>
                                <div class="status-bar">
                                    <div class="status-bar-fill bg-info" style="width: {{ $statusPercentages['completed'] ?? 0 }}%;"></div>
                                </div>
                                <span class="status-percent">{{ $statusPercentages['completed'] ?? 0 }}%</span>
                            </div>
                            <div class="status-item">
                                <div class="status-info">
                                    <span class="status-dot bg-danger"></span>
                                    <span class="status-name">@lang('words.cancelled') ({{ $statusCounts['cancelled'] ?? 0 }})</span>
                                </div>
                                <div class="status-bar">
                                    <div class="status-bar-fill bg-danger" style="width: {{ $statusPercentages['cancelled'] ?? 0 }}%;"></div>
                                </div>
                                <span class="status-percent">{{ $statusPercentages['cancelled'] ?? 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicine Stats Row -->
            <div class="dashboard-grid-medicine">
                <!-- Daily Medicine Sales (Last 7 Days) -->
                <div class="dashboard-card card-medicine-chart">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-line card-icon"></i>
                            <h5 class="card-title">@lang('words.daily_medicine_sales')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-warning">${{ number_format($totalMedicinesSold, 2) }} @lang('words.total')</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="medicineSalesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top Selling Medicines -->
                <div class="dashboard-card card-medicines">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-pills card-icon"></i>
                            <h5 class="card-title">@lang('words.top_selling_medicines')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-danger">{{ $totalMedicinesSold }} @lang('words.total_sold')</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="medicine-list">
                            @forelse($topMedicines as $medicine)
                                <div class="medicine-item">
                                    <div class="medicine-info">
                                        <span class="medicine-name">{{ $medicine['name'] }}</span>
                                        <span class="medicine-stock">
                                            <i class="fas fa-boxes"></i> {{ $medicine['stock'] }}
                                        </span>
                                    </div>
                                    <div class="medicine-sold">
                                        <span class="medicine-count">{{ $medicine['total_sold'] }}</span>
                                        <span class="medicine-label">@lang('words.sold')</span>
                                        <span class="medicine-revenue">${{ number_format($medicine['revenue'], 2) }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4"> 
                                    @lang('words.no_medicine_sales')
                                </div>
                            @endforelse
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
            // Appointments Chart (Last 10 Days)
            const ctx1 = document.getElementById('appointmentsChart').getContext('2d');
            const chartData1 = @json($appointmentsLast10Days);

            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: chartData1.map(item => item.day),
                    datasets: [{
                        label: 'Appointments',
                        data: chartData1.map(item => item.count),
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

            // Medicine Sales Chart (Last 7 Days)
            const ctx2 = document.getElementById('medicineSalesChart').getContext('2d');
            const chartData2 = @json($dailyMedicineSales);

            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: chartData2.map(item => item.day),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: chartData2.map(item => item.revenue || item.count), // revenue bo'lmasa count
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
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
                                stepSize: 200, 
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
        });
    </script>

</x-layouts.main.website>