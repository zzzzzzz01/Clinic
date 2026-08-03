<x-layouts.main.website>
    <x-slot:title>
        {{ $doctorData['full_name'] }} - @lang('words.admissions')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/doctorAppointment.css') }}" />

    <div class="container pt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">@lang('words.admissions')</a>
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $doctorData['full_name'] }} @lang('words.admissions')</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="date-navigation">
            <div class="date-header">
                <div class="left-group">
                    <a href="javascript:void(0)" class="today-button" onclick="openDatePicker()">
                        <i class="fas fa-calendar-day"></i> {{ $buttonData['buttonText'] }}
                    </a>
                </div>
            </div>
            
            <div class="date-buttons-container">
                @foreach($datesData as $dateData)
                    <a href="{{ route('doctor.appointments', ['doctor' => $doctorData['id'], 'date' => $dateData['fullDate']]) }}"
                       class="date-button {{ $dateData['dayClass'] }} {{ $dateData['isActive'] ? 'active' : '' }}">
                        
                        @if($dateData['isToday'] && !$dateData['isActive'])
                            <div class="today-badge">
                                <i class="fas fa-star"></i>
                            </div>
                        @endif
                        
                        @if($dateData['isToday'] && $dateData['isActive'])
                            <div class="current-day-indicator">
                                <i class="fas fa-star"></i> @lang('words.short_days.today')
                            </div>
                        @endif
                        
                        <div class="day-name">{{ $dateData['dayName'] }}</div>
                        <div class="date-number">{{ $dateData['dateNumber'] }}</div>
                        <div class="month-name">{{ $dateData['monthName'] }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="date-picker-modal" id="datePickerModal" onclick="if(event.target === this) closeDatePicker()">
            <div class="date-picker-content">
                <div class="date-picker-header">
                    <h4>@lang('words.select_date')</h4>
                    <button class="close-btn" onclick="closeDatePicker()">✕</button>
                </div>
                <input type="date" class="date-picker-input" id="selectedDateInput" value="{{ $selectedDate }}">
                <div class="date-picker-actions">
                    <button class="date-picker-btn cancel" onclick="closeDatePicker()">@lang('words.cancel')</button>
                    <button class="date-picker-btn apply" onclick="goToSelectedDate()">@lang('words.select')</button>
                </div>
            </div>
        </div>

        <div class="time-slots-container" id="timeSlotsContainer">
            @forelse($appointments as $appointment)
                <div class="time-slot-card {{ $appointment['statusClass'] }}" 
                     data-status="{{ $appointment['status'] }}" 
                     data-slot-id="{{ $appointment['id'] }}"
                     onclick="openAppointmentModal({{ $appointment['id'] }}, {{ $appointment['jsonData'] }})">
                    
                    <div class="time-range">
                        <i class="far fa-clock"></i>
                        {{ $appointment['start_time'] }} - {{ $appointment['end_time'] }}
                    </div>
                    
                    <span class="slot-status status-{{ $appointment['statusClass'] }}-slot">{{ $appointment['statusText'] }}</span>
                    
                    @if($appointment['status'] != 'available')
                        <div class="patient-info-small">
                            <strong>{{ $appointment['patientNameShort'] }}</strong>
                            @if($appointment['patientPhone'])
                                <div class="patient-phone">
                                    <i class="fas fa-phone"></i> {{ $appointment['patientPhone'] }}
                                </div>
                            @endif
                            @if($appointment['patientReason'])
                                <div class="patient-reason">
                                    <i class="fas fa-notes-medical"></i> {{ $appointment['patientReasonShort'] }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="patient-info-small text-muted">
                            <i class="fas fa-plus-circle"></i> @lang('words.available')
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h4>@lang('words.no_slots_available')</h4>
                    <p>@lang('words.no_slots_available_desc')</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- MODALLAR -->
    @include('partials.modals')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('temp2/js/doctor-visit-appointments.js') }}"></script>

    <script>
        const doctorRoute = "{{ route('doctor.appointments', ['doctor' => $doctorData['id']]) }}";
    </script>
</x-layouts.main.website>