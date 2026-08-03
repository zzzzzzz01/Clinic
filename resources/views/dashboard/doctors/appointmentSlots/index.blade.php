<x-layouts.main.website>
    <x-slot:title>
        @lang('words.appointment_slots_list')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/doctorAppointment.css') }}" /> 

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctors.index') }}">@lang('words.doctors.list')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        {{ $doctor->user->last_name }} {{ $doctor->user->name }}
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.appointment_slots')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content-container">
        <div class="date-navigation">
            <div class="date-nav-header">
                <div class="nav-buttons">
                    <button class="nav-btn" onclick="changeDate(-1)">
                        <i class="fas fa-chevron-left"></i> @lang('words.previous')
                    </button>
                    <button class="selected-date-btn" onclick="openDatePicker()">
                        <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($selectedDate)->format('d.m.Y') }}
                    </button>
                    <button class="nav-btn" onclick="changeDate(1)">
                        @lang('words.next') <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
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

        <!-- Yangi slot qo'shish modal oynasi -->
        <div class="create-slot-modal" id="createSlotModal">
            <div class="create-slot-content">
                <div class="create-slot-header">
                    <h4>@lang('words.create_new_slot')</h4>
                    <button class="close-btn" onclick="closeCreateSlotModal()">✕</button>
                </div>
                
                <div class="create-slot-body">
                    <div class="date-range-container">
                        <div class="date-input-wrapper">
                            <div class="date-label">
                                <span>@lang('words.start_date')</span>
                            </div>
                            <input type="date" class="date-input" id="startDate" name="start_date" min="{{ date('Y-m-d') }}">
                        </div>
                        
                        <div class="date-input-wrapper">
                            <div class="date-label">
                                <span>@lang('words.end_date')</span>
                            </div>
                            <input type="date" class="date-input" id="endDate" name="end_date" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                
                <div class="create-slot-footer">
                    <button class="btn-secondary" onclick="closeCreateSlotModal()">
                        <i class="fas fa-times"></i>
                        @lang('words.cancel')
                    </button>
                    <button class="btn-primary" onclick="redirectToCreatePage()">
                        <i class="fas fa-plus-circle"></i>
                        @lang('words.create_slot')
                    </button>
                </div>
            </div>
        </div>
        
        <div class="appointments-header">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all"><i class="fas fa-list"></i> @lang('words.all')</button>
                <button class="filter-tab" data-filter="pending"><i class="fas fa-hourglass-half"></i> @lang('words.pending')</button>
                <button class="filter-tab" data-filter="completed"><i class="fas fa-check-circle"></i> @lang('words.completed')</button>
                <button class="filter-tab" data-filter="booked"><i class="fas fa-bookmark"></i> @lang('words.booked')</button>
            </div>
        </div>
        
        <div class="slots-table-container">
            <div class="table-header">
                <div class="table-actions">
                    <button class="btn btn-outline" onclick="openCreateSlotModal()">
                        <i class="fas fa-plus"></i> @lang('words.add_new_slot')
                    </button>
                </div>
            </div>
            
            <div class="table-responsive-wrapper">
                <table class="desktop-table">
                    <thead>
                        <tr>
                            <th>@lang('words.no')</th>
                            <th>@lang('words.doctor')</th>
                            <th>@lang('words.patient')</th>
                            <th>@lang('words.time')</th>
                            <th>@lang('words.duration')</th>
                            <th>@lang('words.status')</th>
                        </tr>
                    </thead>
                    <tbody id="desktopTableBody">
                        @foreach($formattedSlots as $slot)
                        <tr data-status="{{ $slot['status'] }}" 
                            data-slot-id="{{ $slot['id'] }}"
                            data-start-time="{{ $slot['start_time'] }}"
                            data-end-time="{{ $slot['end_time'] }}"
                            data-patient-name="{{ $slot['patient']['full_name'] ?? '' }}">
                            
                            <td>{{ $slot['index'] }}</td>
                            
                            <td>
                                <div class="doctor-info">
                                    <div class="doctor-avatar">{{ $slot['doctor_avatar'] }}</div>
                                    <div class="doctor-details">
                                        <div class="doctor-name">{{ $slot['doctor_name'] }}</div>
                                        <div class="doctor-specialty">{{ $slot['doctor_specialty'] }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td>
                                @if($slot['is_available'])
                                    <div style="color: var(--gray-color); font-style: italic; font-size: 13px;">
                                        <i class="fas fa-user-slash"></i> @lang('words.no_patient')
                                    </div>
                                @else
                                    <div class="patient-info">
                                        <div class="patient-avatar">{{ $slot['patient']['avatar'] ?? null }}</div>
                                        <div class="patient-details">
                                            <div class="patient-name">
                                                <span class="full-text">{{ $slot['patient']['full_name'] ?? null }}</span>
                                                <span class="short-text">{{ $slot['patient']['short_name'] ?? null }}</span>
                                            </div>
                                            <div class="patient-phone">{{ $slot['patient']['birth_date'] ?? null }}</div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            
                            <td>
                                <span class="time-slot">
                                    <span class="full-time">{{ $slot['start_time'] }} - {{ $slot['end_time'] }}</span>
                                    <span class="short-time">{{ $slot['start_time'] }}<br>{{ $slot['end_time'] }}</span>
                                </span>
                            </td>
                            
                            <td>{{ $slot['duration'] }} @lang('words.min')</td>
                            
                            <td>
                                <span class="status-badge {{ $slot['status_badge']->class }}">
                                    <i class="fas {{ $slot['status_badge']->icon }}"></i> {{ $slot['status_badge']->text }}
                                </span>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($formattedSlots->isEmpty())
                <div class="empty-state">
                    <p>@lang('words.no_slots_available')</p>
                </div>
                @endif
            </div>

            <div class="pagination">
                <div class="pagination-info">
                    {{ $doctorSlots->firstItem() }} - {{ $doctorSlots->lastItem() }} / {{ $doctorSlots->total() }} @lang('words.records')
                </div>
                <div class="pagination-controls">
                    @if($doctorSlots->onFirstPage())
                        <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                    @else
                        <a href="{{ $doctorSlots->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                    @endif

                    @foreach(range(1, $doctorSlots->lastPage()) as $page)
                        @if($page == $doctorSlots->currentPage())
                            <button class="page-btn active">{{ $page }}</button>
                        @else
                            <a href="{{ $doctorSlots->url($page) }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($doctorSlots->hasMorePages())
                        <a href="{{ $doctorSlots->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number">{{ $stats->total }}</div>
                <div class="stat-label">@lang('words.total_slots')</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats->available }}</div>
                <div class="stat-label">@lang('words.available_slots')</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats->booked }}</div>
                <div class="stat-label">@lang('words.booked_slots')</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats->pending }}</div>
                <div class="stat-label">@lang('words.pending_slots')</div>
            </div>
        </div>
    </div>

    @include('partials.alert')

    <script>
        function changeDate(days) {
            const currentDate = new Date('{{ $selectedDate }}');
            currentDate.setDate(currentDate.getDate() + days);
            window.location.href = '?date=' + currentDate.toISOString().split('T')[0];
        }
        
        const datePickerModal = document.getElementById('datePickerModal');
        
        function openDatePicker() {
            datePickerModal.classList.add('show');
            document.body.classList.add('modal-open');
        }
        
        function closeDatePicker() {
            datePickerModal.classList.remove('show');
            document.body.classList.remove('modal-open');
        }
        
        function goToSelectedDate() {
            const selectedDate = document.getElementById('selectedDateInput').value;
            if (selectedDate) {
                window.location.href = '?date=' + selectedDate;
            }
            closeDatePicker();
        }
        
        const createSlotModal = document.getElementById('createSlotModal');
        
        function openCreateSlotModal() {
            document.getElementById('startDate').value = '{{ $selectedDate }}';
            document.getElementById('endDate').value = '{{ $selectedDate }}';
            createSlotModal.classList.add('show');
            document.body.classList.add('modal-open');
        }
        
        function closeCreateSlotModal() {
            createSlotModal.classList.remove('show');
            document.body.classList.remove('modal-open');
        }
        
        function redirectToCreatePage() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (!startDate || !endDate) {
                alert(@json(__('words.please_select_dates')));
                return;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                alert(@json(__('words.start_date_less_than_end_date')));
                return;
            }
            
            const url = `{{ route('appointmentSlots.create', ['type' => 'doctor', 'id' => $doctor->id]) }}?start_date=${startDate}&end_date=${endDate}`;
            window.location.href = url;
        }
        
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const filter = this.dataset.filter;
                document.querySelectorAll('#desktopTableBody tr').forEach(row => {
                    row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
                });
            });
        });
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (createSlotModal.classList.contains('show')) {
                    closeCreateSlotModal();
                }
                if (datePickerModal.classList.contains('show')) {
                    closeDatePicker();
                }
            }
        });
    </script>
</x-layouts.main.website>