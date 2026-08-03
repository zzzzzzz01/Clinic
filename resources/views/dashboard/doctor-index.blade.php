<x-layouts.main.website>
    <x-slot:title>
        @lang('words.doctor_dashboard')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/doctor-index.css') }}" />

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
                <h4 class="mb-0">@lang('words.doctor_dashboard')</h4>
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
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalAppointments) }}</h3>
                        <p class="stat-label">@lang('words.total_appointments')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($todayAppointments) }}</h3>
                        <p class="stat-label">@lang('words.today_appointments')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-prescription"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalPrescriptions) }}</h3>
                        <p class="stat-label">@lang('words.prescriptions')</p> 
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="dashboard-grid-doctor">
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
                                <a href="{{ route('doctor.dashboard', ['date' => $prevMonth]) }}" class="calendar-nav">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <span class="calendar-month">{{ $currentMonth }}</span>
                                <a href="{{ route('doctor.dashboard', ['date' => $nextMonth]) }}" class="calendar-nav">
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
                                    <a href="{{ route('doctor.dashboard', ['date' => $day['date']]) }}" 
                                       class="calendar-day 
                                              {{ $day['isToday'] ? 'today' : '' }} 
                                              {{ $day['isSelected'] ? 'selected' : '' }} 
                                              {{ $day['hasAppointment'] ? 'has-appointment' : '' }}
                                              {{ !$day['isCurrentMonth'] ? 'other-month' : '' }}">
                                        {{ $day['day'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointments by Date -->
                <div class="dashboard-card card-appointments">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-calendar-day card-icon"></i>
                            <h5 class="card-title">@lang('words.appointments_for') {{ $selectedDate->format('d.m.Y') }}</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary">{{ count($appointmentsByDate) }} @lang('words.appointments')</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-appointments">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">@lang('words.time')</th>
                                        <th style="width: 50%;">@lang('words.patient')</th>
                                        <th style="width: 30%;">@lang('words.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointmentsByDate as $appointment)
                                        <tr>
                                            <td><span class="appointment-time">{{ $appointment['time'] }}</span></td>
                                            <td><span class="patient-name">{{ $appointment['patient'] }}</span></td> 

                                            <td>
                                                <span class="status-badge"
                                                    style="color: {{ $appointment['status_config']['text_color'] }};
                                                            background-color: {{ $appointment['status_config']['bg_color'] }};">
                                                    <i class="{{ $appointment['status_config']['icon'] }}"></i>
                                                    {{ $appointment['status_config']['text'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4"> 
                                                @lang('words.no_appointments_for_date')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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

            <!-- Last 10 Days Appointments List -->
            <div class="dashboard-card card-last-appointments">
                <div class="dashboard-card-header">
                    <div class="card-header-left">
                        <i class="fas fa-clock card-icon"></i>
                        <h5 class="card-title">@lang('words.appointments_10_days')</h5>
                    </div>
                    <div class="card-header-right">
                        <span class="badge bg-primary">{{ count($last10DaysAppointments ?? []) }} @lang('words.appointments')</span> 
                    </div>
                </div>
                <div class="dashboard-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-appointments">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">@lang('words.date')</th>
                                    <th style="width: 15%;">@lang('words.time')</th>
                                    <th style="width: 35%;">@lang('words.patient')</th>
                                    <th style="width: 20%;">@lang('words.status')</th>
                                    <th style="width: 15%;" class="text-end">@lang('words.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($last10DaysAppointments ?? [] as $appointment)
                                    <tr>
                                        <td><span class="appointment-date">{{ $appointment['date'] }}</span></td>
                                        <td><span class="appointment-time">{{ $appointment['time'] }}</span></td>
                                        <td><span class="patient-name">{{ $appointment['patient'] }}</span></td>
                                        <td>
                                            <span class="status-badge"
                                                style="color: {{ $appointment['status_config']['text_color'] }};
                                                        background-color: {{ $appointment['status_config']['bg_color'] }};">
                                                <i class="{{ $appointment['status_config']['icon'] }}"></i>
                                                {{ $appointment['status_config']['text'] }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('doctor.consultation', $appointment['id']) }}" class="text-primary view-icon">
                                                <i class="fa-regular fa-circle-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4"> 
                                            @lang('words.no_appointments')
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
        });
    </script>

</x-layouts.main.website>