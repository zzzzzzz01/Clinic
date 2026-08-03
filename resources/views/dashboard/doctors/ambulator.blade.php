<x-layouts.main.website>
    <x-slot:title>{{ $doctor->user->name }} {{ $doctor->user->last_name }} - Qabullar</x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/doctorAppointment.css') }}" />

    <div class="container pt-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}"><i class="fas fa-home"></i> @lang('words.main.page')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctors.index') }}"> @lang('words.doctors.list') </a>
                </li>
                <li class="breadcrumb-item active"> @lang('words.admissions') </li>
            </ol>
        </nav>
        
        {{-- Header --}}
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4>
                            @if(app()->getLocale() == 'uz')
                                {{ $doctor->user->last_name }} {{ $doctor->user->name }} qabullari ro'yxati
                            @elseif(app()->getLocale() == 'ru')
                                Список приёмов {{ $doctor->user->last_name }} {{ $doctor->user->name }}
                            @elseif(app()->getLocale() == 'en')
                                {{ $doctor->user->last_name }} {{ $doctor->user->name }} appointments list
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics --}}
        <!-- <div class="search-wrapper">
            <div class="search-card">
                <div class="quick-stats">
                    <div class="quick-stat">
                        <i class="fas fa-calendar-check"></i>
                        <span>{{ $stats['total'] }}</span> Jami
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-clock"></i>
                        <span>{{ $stats['today'] }}</span> Bugun
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-hourglass-half"></i>
                        <span>{{ $stats['pending'] }}</span> Kutilayotgan
                    </div>
                </div>
            </div>
        </div> -->

        {{-- Date Navigation --}}
        <div class="date-navigation">
            <div class="date-header">
                <div class="left-group">
                    <a href="javascript:void(0)" class="today-button" onclick="openDatePicker()">
                        <i class="fas fa-calendar-day"></i> {{ $selectedDateInfo['button_text'] }}
                    </a>
                </div>
            </div>
            
            <div class="date-buttons-container">
                @foreach($dateButtons as $btn)
                    <a href="{{ route('ambulator.doctor', ['doctor' => $doctor->id, 'date' => $btn['full_date']]) }}"
                    class="date-button {{ $btn['class'] }}"
                    title="{{ $btn['day_name'] }}">
                        
                        @if($btn['show_today_badge'])
                            <div class="today-badge"><i class="fas fa-star"></i></div>
                        @endif
                        
                        @if($btn['show_current_day'])
                            <div class="current-day-indicator"><i class="fas fa-star"></i> Bugun</div>
                        @endif
                        
                        {{-- Hozirgi til bo'yicha qisqa nom --}}
                        <div class="day-name">
                            <span class="d-none d-md-inline">{{ $btn['day_name'] }}</span>
                            <span class="d-inline d-md-none">{{ $btn['day_name_short'] }}</span>
                        </div>
                        
                        {{-- 3 til to'liq (data attribute da) --}}
                        <div class="d-none" 
                            data-uz="{{ $btn['uz_full'] }}"
                            data-ru="{{ $btn['ru_full'] }}"
                            data-en="{{ $btn['en_full'] }}">
                        </div>
                        
                        <div class="date-number">{{ $btn['date_number'] }}</div>
                        <div class="month-name">{{ $btn['month_name'] }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Date Picker Modal --}}
        <div class="date-picker-modal" id="datePickerModal" onclick="if(event.target === this) closeDatePicker()">
            <div class="date-picker-content">
                <div class="date-picker-header">
                    <h4>Sana tanlang</h4>
                    <button class="close-btn" onclick="closeDatePicker()">✕</button>
                </div>
                <input type="date" class="date-picker-input" id="selectedDateInput" value="{{ $selectedDate }}">
                <div class="date-picker-actions">
                    <button class="date-picker-btn cancel" onclick="closeDatePicker()">Bekor qilish</button>
                    <button class="date-picker-btn apply" onclick="goToSelectedDate()">Tanlash</button>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="appointments-header">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all"><i class="fas fa-list"></i> @lang('words.all')</button>
                <!-- <button class="filter-tab" data-filter="pending"><i class="fas fa-hourglass-half"></i> Kutilayotgan</button> -->
                <button class="filter-tab" data-filter="completed"><i class="fas fa-check-circle"></i> @lang('words.completed')</button>
                <button class="filter-tab" data-filter="booked"><i class="fas fa-bookmark"></i> @lang('words.booked')</button>
            </div>
        </div>

        {{-- Time Slots --}}
        <div class="time-slots-container" id="timeSlotsContainer">
            @forelse($doctorSlots as $slot)
                <div class="time-slot-card {{ $slot['status_class'] }}" 
                     data-status="{{ $slot['status'] }}" 
                     data-slot-id="{{ $slot['id'] }}"
                     onclick="openAppointmentModal({{ $slot['id'] }}, {{ json_encode($slot) }})">
                    
                    <div class="time-range">
                        <i class="far fa-clock"></i>
                        {{ $slot['start_time'] }} - {{ $slot['end_time'] }}
                    </div>
                    
                    <span class="slot-status status-{{ $slot['status_class'] }}-slot">{{ $slot['status_text'] }}</span>
                    
                    @if($slot['status'] !== 'available' && $slot['patient'])
                        <div class="patient-info-small">
                            <strong>{{ Str::limit($slot['patient']['name'], 15) }}</strong>
                            @if($slot['patient']['phone'])
                                <div class="patient-phone"><i class="fas fa-phone"></i> {{ $slot['patient']['phone'] }}</div>
                            @endif
                            @if($slot['patient']['reason'])
                                <div class="patient-reason"><i class="fas fa-notes-medical"></i> {{ Str::limit($slot['patient']['reason'], 20) }}</div>
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
                    <h4>Bu kunda qabullar mavjud emas</h4>
                    <p>Ushbu sana uchun hech qanday qabul topilmadi</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- ==================== MODALLAR ==================== -->
    
    @include('partials.slot-modals.available')

    @include('partials.slot-modals.completed')

    @include('partials.slot-modals.booked')

    <!-- Toast Message -->
    <div class="toast-message" id="toast"></div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('temp2/js/doctor-appointments.js') }}"></script>

    <script>
        const doctorRoute = "{{ route('ambulator.doctor', ['doctor' => $doctor->id]) }}"; 
    </script>

</x-layouts.main.website>