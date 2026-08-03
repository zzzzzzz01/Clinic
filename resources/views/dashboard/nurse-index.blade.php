<x-layouts.main.website>
    <x-slot:title>
        @lang('words.nurse_dashboard')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/nurse-index.css') }}" />

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
                <h4 class="mb-0">@lang('words.nurse_dashboard')</h4>
                <div class="dashboard-date">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->format('l, F d, Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-wrapper">
        <div class="dashboard-container">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($stats['total_medications']) }}</h3>
                        <p class="stat-label">@lang('words.total_medications')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-prescription"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($stats['today_medications']) }}</h3>
                        <p class="stat-label">@lang('words.today_medications')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-syringe"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($stats['total_procedures']) }}</h3>
                        <p class="stat-label">@lang('words.total_procedures')</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($stats['today_procedures']) }}</h3>
                        <p class="stat-label">@lang('words.today_procedures')</p> 
                    </div>
                </div>
            </div>

            <!-- Medications & Procedures Chart -->
            <div class="dashboard-card card-chart">
                <div class="dashboard-card-header">
                    <div class="card-header-left">
                        <i class="fas fa-chart-line card-icon"></i>
                        <h5 class="card-title">@lang('words.medications_procedures_7_days')</h5>
                    </div>
                </div>
                <div class="dashboard-card-body">
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Calendar & Today's Lists -->
            <div class="dashboard-grid-nurse">
                <!-- Today's Medications -->
                <div class="dashboard-card card-medications">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-pills card-icon"></i>
                            <h5 class="card-title">
                                @lang('words.todays_medications')
                                @if($selectedDate->isToday())
                                    <span class="text-muted ms-2" style="font-size: 14px; font-weight: normal;">({{ $selectedDate->format('d.m.Y') }})</span>
                                @else
                                    <span class="text-muted ms-2" style="font-size: 14px; font-weight: normal;">({{ $selectedDate->format('d.m.Y') }})</span>
                                @endif
                            </h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary">{{ count($todayMedications) }}</span>
                            <a href="{{ route('nurse.treatment.sheets') }}" class="btn btn-sm btn-outline-primary">@lang('words.view_all')</a>
                        </div>
                    </div>
                    <div class="dashboard-card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-appointments">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">@lang('words.time')</th>
                                        <th style="width: 25%;">@lang('words.patient')</th>
                                        <th style="width: 15%;">@lang('words.room_bed')</th>
                                        <th style="width: 25%;">@lang('words.medicine_dose')</th>
                                        <th style="width: 20%;">@lang('words.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todayMedications as $med)
                                        <tr>
                                            <td><span class="appointment-time">{{ $med['time'] }}</span></td>
                                            <td><span class="patient-name">{{ $med['patient'] }}</span></td>
                                            <td><span class="room-badge">{{ $med['room'] }} | {{ $med['bed'] }}</span></td>
                                            <td>
                                                <span class="medicine-name">{{ $med['medicine'] }}</span>
                                                <small class="dose-text">{{ $med['dose'] }}</small>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $med['status_config']['class'] }}">
                                                    {{ $med['status_config']['text'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4"> 
                                                @lang('words.no_medications_today')
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
                                <a href="{{ route('nurse.dashboard', ['date' => $prevMonth]) }}" class="calendar-nav">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <span class="calendar-month">{{ $currentMonth }}</span>
                                <a href="{{ route('nurse.dashboard', ['date' => $nextMonth]) }}" class="calendar-nav">
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
                                    <a href="{{ route('nurse.dashboard', ['date' => $day['date']]) }}" 
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

            <!-- Today's Procedures -->
            <div class="dashboard-grid-procedures">
                <div class="dashboard-card card-procedures">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-syringe card-icon"></i>
                            <h5 class="card-title">@lang('words.todays_procedures')</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-success">{{ count($todayProcedures) }}</span>
                            <a href="{{ route('nurse.treatment.sheets') }}" class="btn btn-sm btn-outline-primary">@lang('words.view_all')</a>
                        </div>
                    </div>
                    <div class="dashboard-card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-appointments">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">@lang('words.time')</th>
                                        <th style="width: 25%;">@lang('words.patient')</th>
                                        <th style="width: 15%;">@lang('words.room')</th>
                                        <th style="width: 25%;">@lang('words.procedure')</th>
                                        <th style="width: 20%;">@lang('words.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todayProcedures as $proc)
                                        <tr>
                                            <td><span class="appointment-time">{{ $proc['time'] }}</span></td>
                                            <td><span class="patient-name">{{ $proc['patient'] }}</span></td>
                                            <td><span class="room-badge">{{ $proc['room'] }}</span></td>
                                            <td>
                                                <span class="procedure-name">{{ $proc['procedure'] }}</span>
                                                <small class="duration-text">{{ $proc['duration'] }}</small>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $proc['status_config']['class'] }}">
                                                    {{ $proc['status_config']['text'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4"> 
                                                @lang('words.no_procedures_today')
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
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weeklyData = @json($weeklyData);
            
            // Weekly Chart - Line Chart
            const ctx = document.getElementById('weeklyChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: weeklyData.medications.map(item => item.day),
                    datasets: [
                        {
                            label: 'Medications',
                            data: weeklyData.medications.map(item => item.count),
                            backgroundColor: 'rgba(13, 202, 240, 0.2)',
                            borderColor: 'rgba(13, 202, 240, 1)',
                            borderWidth: 3,
                            pointBackgroundColor: 'rgba(13, 202, 240, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Procedures',
                            data: weeklyData.procedures.map(item => item.count),
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
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: { size: 12 },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                stepSize: 1, 
                                font: { size: 11 } 
                            },
                            grid: { 
                                color: 'rgba(0,0,0,0.05)' 
                            }
                        },
                        x: {
                            grid: { 
                                display: false 
                            },
                            ticks: { 
                                font: { size: 11 } 
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        });
    </script>

     
</x-layouts.main.website>