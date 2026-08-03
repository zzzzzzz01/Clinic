<x-layouts.main.app>

<link href="{{ asset('temp/css/service-appointment.css') }}" rel="stylesheet">

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown">@lang('words.book_appointment')</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown">
            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main.page')</a></li>
            @if(isset($isFromServicesPage) && $isFromServicesPage)
                <li class="breadcrumb-item"><a href="{{ route('services.page') }}">@lang('words.services')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.detail', $department->slug) }}">{{ $department->name }}</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('doctors.service.index') }}">Shifokorlar</a></li>
            @endif
            <li class="breadcrumb-item active text-white">@lang('words.book_appointment')</li>
        </ol>    
    </div>
</div>
<!-- Header End -->

<div class="appointment-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto"> 
                <!-- Asosiy karta -->
                <div class="appointment-card">  
                    <!-- Shifokor ma'lumotlari -->
                    <div class="doctor-info">
                        <img src="{{ asset('storage/' . ($doctor->photo ?? 'default/doctor.png')) }}" 
                             alt="{{ $doctor->user->name }}">
                        <div>
                            <div class="doctor-name">Dr. {{ $doctor->user->name }} {{ $doctor->user->last_name }}</div>
                            <div class="doctor-specialty">{{ $department->name }}</div>
                        </div>
                    </div>

                    <!-- Sana tanlash -->
                    <div class="mb-4">
                        <label class="form-label-custom">@lang('words.select_date')</label>
                        <input type="date" 
                               id="dateInput"
                               class="form-control-custom" 
                               value="{{ $selectedDate }}"
                               min="{{ $today }}">
                    </div>

                    <!-- Qabul sababi -->
                    <div class="mb-4">
                        <label class="form-label-custom">@lang('words.appointment_reason')</label>
                        <textarea id="reasonInput" class="form-control-custom" rows="3" placeholder="@lang('words.enter_reason_placeholder')"></textarea>
                    </div>

                    <!-- Slotlar -->
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label-custom mb-0">@lang('words.available_time')</label>
                            <div class="status-indicator">
                                <span>
                                    <span class="status-dot available"></span> @lang('words.available')
                                </span>
                                <span>
                                    <span class="status-dot booked"></span> @lang('words.booked')
                                </span>
                            </div>
                        </div>
                        
                        @if($slots->isNotEmpty())
                            <div class="slot-grid">
                            @foreach($slots as $slot)

                                @if($slot->is_booked || $slot->is_passed)
                                    <div class="slot-btn booked {{ $slot->is_passed ? 'passed' : '' }}">
                                        {{ $slot->start }} - {{ $slot->end }}
                                    </div>
                                @else
                                    <div class="slot-btn available {{ $slot->is_selected ? 'selected' : '' }}"
                                        data-slot-id="{{ $slot->id }}"
                                        data-start="{{ $slot->start }}"
                                        data-end="{{ $slot->end }}"
                                        onclick="selectSlot(this)">
                                        {{ $slot->start }} - {{ $slot->end }}
                                    </div>
                                @endif

                                @endforeach
                            </div>
                        @else
                            <div class="no-slots">
                                <i class="far fa-clock"></i>
                                <h5>@lang('words.no_available_slots')</h5>
                                <p>@lang('words.select_another_date')</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tanlangan slot -->
                    @php
                        $selectedSlot = $slots->where('id', request('slot_id'))->first();
                    @endphp
                    <div id="selectedSlotInfo" class="selected-info mt-4" style="{{ request('slot_id') && $selectedSlot && $selectedSlot->status == 'available' ? 'display:block;' : 'display:none;' }}">
                        <strong>Tanlangan vaqt:</strong> 
                        <span id="selectedTime">
                            @if(request('slot_id') && $selectedSlot && $selectedSlot->status == 'available')
                                {{ \Carbon\Carbon::parse($selectedSlot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($selectedSlot->end_time)->format('H:i') }}
                            @endif
                        </span>
                        <br>
                        <strong>Sana:</strong> 
                        <span id="selectedDateDisplay">{{ \Carbon\Carbon::parse($selectedDate)->format('d.m.Y') }}</span>
                        <br>
                        <strong>Shifokor:</strong> 
                        <span>Dr. {{ $doctor->user->name }} {{ $doctor->user->last_name }}</span>
                    </div>

                    <!-- Qabulga yozilish tugmasi -->
                    <form id="appointmentForm" action="{{ route('appointment.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                        <input type="hidden" name="slot_id" id="slotIdInput" value="{{ request('slot_id') }}">
                        <input type="hidden" name="date" id="dateInputHidden" value="{{ $selectedDate }}">
                        <input type="hidden" name="department_id" value="{{ $department->id }}">
                        <input type="hidden" name="reason" id="reasonHidden">
                        
                        <button type="submit" class="btn-book" id="submitBtn" {{ request('slot_id') && $selectedSlot && $selectedSlot->status == 'available' ? '' : 'disabled' }}>
                            <i class="fas fa-check-circle me-2"></i>@lang('words.book_appointment')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectSlot(element) {
        // Barcha slotlardan selected klassini olib tashlash
        document.querySelectorAll('.slot-btn.available').forEach(btn => {
            btn.classList.remove('selected');
        });
        
        // Tanlangan slotga selected klassini qo'shish
        element.classList.add('selected');
        
        // Slot ID ni saqlash
        const slotId = element.dataset.slotId;
        const startTime = element.dataset.start;
        const endTime = element.dataset.end;
        
        // Tanlangan vaqtni ko'rsatish
        document.getElementById('selectedTime').textContent = startTime + ' - ' + endTime;
        document.getElementById('selectedSlotInfo').style.display = 'block';
        document.getElementById('slotIdInput').value = slotId;
        document.getElementById('submitBtn').disabled = false;
    }

    // Sana o'zgarganda sahifani yuklash
    document.getElementById('dateInput').addEventListener('change', function() {
        window.location.href = '{{ route("services.appointment", [$department->slug, $doctor->id]) }}?date=' + this.value;
    });

    // Form yuborishda sababni qo'shish
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        const reason = document.getElementById('reasonInput').value;
        if (!reason.trim()) {
            e.preventDefault();
            alert('Iltimos, qabul sababini kiriting!');
            return;
        }
        document.getElementById('reasonHidden').value = reason;
    });
</script>

</x-layouts.main.app>