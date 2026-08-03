<x-layouts.main.website>
    <x-slot:title>Qabul yaratish</x-slot:title>
 
 

    <link rel="stylesheet" href="{{ asset('temp2/css/receptionist.css') }}" />

    

    <!-- Breadcrumb -->
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('receptionist.index') }}" class="text-decoration-none">
                        @lang('words.patients')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.create_appointment')
                    </a>
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.create_appointment')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('receptionist.appointments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            <!-- Form Wrapper --> 
            <div class="info-section">  

                <!-- Patient Info -->
                <div class="patient-info-grid">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.patient')</label>
                        <input type="text" class="form-control" value="{{ $patient->user->last_name }} {{ $patient->user->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="notification-label">@lang('words.phone')</label>
                        <input type="text" class="form-control" value="{{ $patient->user->phone ?? '-' }}" readonly>
                    </div>
                </div>

                <!-- Department -->
                <div class="patient-info-grid">
                    <div class="form-group">
                        <label class="notification-label"> @lang('words.department') <span class="text-danger">*</span></label>
                        <select name="department_id" id="department_id" class="form-control" required>
                            <option value="">@lang('words.select_department')</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name ?? $dept->name_uz }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Doctor -->
                    <div class="form-group">
                        <label class="notification-label">@lang('words.doctor')  <span class="text-danger">*</span></label>
                        <select name="doctor_id" id="doctor_id" class="form-control" required>
                            <option value="">@lang('words.select_department') </option>
                        </select>
                    </div>
                </div>

                <!-- Date -->
                <div class="form-group">
                    <label class="notification-label">@lang('words.date')  <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $today }}" min="{{ $today }}" required>
                </div>

                <!-- Slot Section (Alohida qism) -->
                <div class="form-group">
                    <div class="slot-label-wrapper">
                        <label class="notification-label">@lang('words.time')  <span class="text-danger">*</span></label>
                        <span class="slot-count" id="slot-count">0</span>
                    </div>
                    <div class="slot-section">
                        <div id="slot-container">
                            <div class="slot-empty">@lang('words.select_doctor_date')</div>
                        </div>
                        <input type="hidden" name="slot_id" id="slot_id" required>
                    </div>
                </div>

                <!-- Reason -->
                <div class="form-group">
                    <label class="notification-label">@lang('words.reason') </label>
                    <input type="text" name="reason" class="form-control" placeholder="@lang('words.enter_reason_placeholder')">
                </div>

            </div> 
            <!-- Actions -->
            <div class="submit-section">
                <div class="submit-actions">
                    <a href="{{ route('receptionist.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> @lang('words.cancel')
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-check"></i> @lang('words.create')
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department_id');
            const doctorSelect = document.getElementById('doctor_id');
            const dateInput = document.getElementById('date');
            const slotContainer = document.getElementById('slot-container');
            const slotIdInput = document.getElementById('slot_id');
            const slotCount = document.getElementById('slot-count');

            // Doctorlarni olish
            departmentSelect.addEventListener('change', function() {
                const deptId = this.value;
                doctorSelect.innerHTML = '<option value="">Doctor tanlang</option>';

                if (deptId) {
                    fetch(`/receptionist/doctors-by-department/${deptId}`)
                        .then(res => res.json())
                        .then(doctors => {
                            doctors.forEach(doc => {
                                const opt = document.createElement('option');
                                opt.value = doc.id;
                                opt.textContent = doc.name;
                                doctorSelect.appendChild(opt);
                            });
                        })
                        .catch(err => {
                            console.error('Xatolik:', err);
                        });
                }
            });

            // Slotlarni olish
            function loadSlots() {
                const doctorId = doctorSelect.value;
                const date = dateInput.value;

                if (!doctorId || !date) {
                    slotContainer.innerHTML = '<div class="slot-empty">Doctor va sanani tanlang</div>';
                    slotIdInput.value = '';
                    slotCount.textContent = '0 ta vaqt';
                    return;
                }

                fetch(`/receptionist/slots-by-doctor-date?doctor_id=${doctorId}&date=${date}`)
                    .then(res => res.json())
                    .then(slots => {
                        // Debug uchun konsolga chiqarish
                        console.log('Slots from server:', slots);
                        
                        if (slots.length === 0) {
                            slotContainer.innerHTML = '<div class="slot-empty">Bu kunga bo\'sh vaqtlar yo\'q</div>';
                            slotIdInput.value = '';
                            slotCount.textContent = '0 ta vaqt';
                            return;
                        }

                        let html = '<div class="slot-list">';
                        let availableCount = 0;

                        slots.forEach(slot => {
                            let statusClass = '';
                            let isDisabled = false;
                            let statusText = '';

                            // Slot statusini tekshirish
                            // Agar status 'booked' bo'lsa - disabled
                            // Agar status 'completed' bo'lsa - disabled
                            // Boshqa hollarda - available
                            if (slot.status === 'booked') {
                                statusClass = 'slot-booked';
                                isDisabled = true;
                                statusText = 'Band';
                            } else if (slot.status === 'completed') {
                                statusClass = 'slot-completed';
                                isDisabled = true;
                                statusText = 'Tugallangan';
                            } else {
                                // Agar status 'available' yoki boshqa bo'lsa
                                availableCount++;
                                statusText = 'Bo\'sh';
                            }

                            // Onclick handler - faqat disabled bo'lmasa
                            const onclickHandler = !isDisabled ? `selectSlot(this, '${slot.id}')` : '';

                            html += `
                                <div class="slot-item ${statusClass}" 
                                    data-id="${slot.id}" 
                                    data-status="${slot.status || 'available'}"
                                    onclick="${onclickHandler}"
                                    title="${statusText}">
                                    ${slot.start_time} - ${slot.end_time}
                                </div>
                            `;
                        });

                        html += '</div>';
                        slotContainer.innerHTML = html;
                        slotIdInput.value = '';
                        slotCount.textContent = `${availableCount} ta vaqt`;

                        if (availableCount === 0) {
                            slotCount.style.color = '#e53e3e';
                        } else {
                            slotCount.style.color = '#718096';
                        }
                    })
                    .catch(err => {
                        console.error('Xatolik:', err);
                        slotContainer.innerHTML = '<div class="slot-empty" style="color:#e53e3e;">❌ Xatolik yuz berdi</div>';
                    });
            }

            doctorSelect.addEventListener('change', loadSlots);
            dateInput.addEventListener('change', loadSlots);

            window.selectSlot = function(el, slotId) {
                // Agar slot disabled bo'lsa hech narsa qilma
                if (el.classList.contains('slot-disabled') || 
                    el.classList.contains('slot-booked') || 
                    el.classList.contains('slot-completed')) {
                    return;
                }

                document.querySelectorAll('.slot-item').forEach(item => {
                    item.classList.remove('active');
                });
                el.classList.add('active');
                document.getElementById('slot_id').value = slotId;
            };
        });
    </script>
</x-layouts.main.website>