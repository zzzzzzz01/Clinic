<div class="room-card" 
    data-floor="{{ $room->floor }}" 
    data-status="{{ $room->status }}" 
    data-department="{{ $room->department_id }}"
    data-room-id="{{ $room->id }}">

    <!-- Chap qism (faqat mobil versiyada ko'rinadi) -->
    <div class="room-card-left">
        <div class="room-number">{{ $room->number }}</div>
        @if($room->status === 'empty')
            <span class="badge bg-secondary">@lang('words.empty')</span>
        @elseif($room->status === 'available')
            <span class="badge bg-success">@lang('words.available')</span>
        @elseif($room->status === 'full')
            <span class="badge bg-warning">@lang('words.full')</span>
        @elseif($room->status === 'maintenance')
            <span class="badge bg-danger">@lang('words.maintenance')</span>
        @endif
    </div>

    <!-- O'ng qism (barcha ma'lumotlar) -->
    <div class="room-card-right">
        <!-- Status -->
        <div class="room-status">
            @if($room->status === 'empty')
                <span class="badge bg-secondary">@lang('words.empty')</span>
            @elseif($room->status === 'available')
                <span class="badge bg-success">@lang('words.available')</span>
            @elseif($room->status === 'full')
                <span class="badge bg-warning">@lang('words.full')</span>
            @elseif($room->status === 'maintenance')
                <span class="badge bg-danger">@lang('words.maintenance')</span>
            @endif
        </div>

        <!-- Room Info -->
        <div class="room-number">{{ $room->number }}</div>
        
        <!-- Bo'lim va qulayliklar -->
        <div class="room-department-features">
            <div class="room-department" title="{{ $room->department->name }}">
                {{ $room->department->name }}
            </div>

            <!-- Features -->
            <div class="room-features">
                <button class="feature-btn" onclick="toggleFeatures(this)">
                    <i class="fas fa-star"></i>
                    <span>{{ $room->features->count() }} @lang('words.features')</span>
                    <i class="fas fa-chevron-down"></i>
                </button>

                @if($room->features->count() > 0)
                <div class="features-list" id="features-{{ $room->id }}">
                    @foreach($room->features as $feature)
                        <div class="feature-item">
                            <i class="{{ $feature->icon ?? 'fas fa-check-circle' }}"></i>
                            {{ $feature->name }}
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div class="room-details">
            <div class="detail-item">
                <div class="detail-label">@lang('words.daily')</div>
                <div class="detail-value price">{{ number_format($room->price) }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">@lang('words.capacity')</div>
                <div class="detail-value">{{ $room->roomBeds->where('status', 'occupied')->count() }}/{{ $room->capacity }}</div>
            </div>
        </div>

        @php
            $patients = [];

            foreach ($room->roomBeds as $bed) {
                $activeRooms = $bed->hospitalizationRooms
                    ->whereNull('unassigned_at');

                foreach ($activeRooms as $activeHospitalizationRoom) {
                    $hospitalization = $activeHospitalizationRoom->hospitalization;

                    if (!$hospitalization || !$hospitalization->appointment?->patient?->user) {
                        continue;
                    }

                    $patientUser = $hospitalization->appointment->patient->user;

                    $selectedDoctor = null;
                    $priorityRoles = [
                        'Asosiy shifokor',
                        'Yordamchi shifokor',
                        'Konsultant',
                        'Kunduzgi_smena',
                        'Kechki_smena',
                    ];

                    $staff = $hospitalization->hospitalizationStaff;

                    if ($staff && $staff->count()) {
                        foreach ($priorityRoles as $role) {
                            $found = $staff->firstWhere('role', $role);
                            if ($found) {
                                $selectedDoctor = $found->doctor?->user;
                                break;
                            }
                        }
                    }

                    $patients[] = [
                        'id' => $hospitalization->id,
                        'hospitalization_id' => $hospitalization->id,
                        'patient' => $patientUser ? [
                            'id' => $patientUser->id,
                            'name' => $patientUser->name,
                            'last_name' => $patientUser->last_name,
                            'middle_name' => $patientUser->middle_name,
                        ] : null,
                        'patient_name' => $patientUser
                            ? trim($patientUser->last_name.' '.$patientUser->name.' '.$patientUser->middle_name)
                            : __("words.unknown"),
                        'doctor' => $selectedDoctor ? [
                            'id' => $selectedDoctor->id,
                            'name' => $selectedDoctor->name,
                            'last_name' => $selectedDoctor->last_name,
                        ] : null,
                        'doctor_name' => $selectedDoctor
                            ? $selectedDoctor->last_name.' '.mb_substr($selectedDoctor->name,0,1).'.'
                            : __('words.doctor_not_assigned'),
                        'bed_id' => $bed->id,
                        'bed_number' => $bed->number,
                        'admission_date' => $activeHospitalizationRoom->assigned_at ?? $hospitalization->created_at,
                        'created_at' => $hospitalization->created_at,
                        'hospitalization_room' => [
                            'id' => $activeHospitalizationRoom->id,
                            'bed' => [
                                'id' => $bed->id,
                                'number' => $bed->number,
                            ]
                        ],
                        'hospitalizationRooms' => [
                            $activeHospitalizationRoom->id => [
                                'id' => $activeHospitalizationRoom->id,
                                'bed' => [
                                    'id' => $bed->id,
                                    'number' => $bed->number,
                                ]
                            ]
                        ]
                    ];
                }
            }
        @endphp

        @foreach($patients as $item)
            <div class="patient-info">
                <strong>
                    {{ strtoupper(substr($item['patient']['name'] ?? '', 0, 1)) }}
                    {{ $item['patient']['last_name'] ?? '' }}
                </strong>

                @if($item['doctor'])
                    <small>
                        ({{ $item['doctor']['last_name'] ?? '' }}
                        {{ strtoupper(substr($item['doctor']['name'] ?? '', 0, 1)) }}.)
                    </small>
                @endif
            </div>
        @endforeach

        @if($room->status === 'maintenance' && $room->maintenance_start)
            <div class="maintenance-info">
                <i class="fas fa-calendar-alt"></i>
                {{ $room->maintenance_start }} - {{ $room->maintenance_end }}
            </div>
        @endif

        <!-- Actions -->
        <div class="action-buttons">
            <a href="{{ route('room.show', $room) }}"><button class="btn-icon"><i class="fas fa-eye"></i></button></a>
            <a href="{{ route('room.edit', $room) }}"><button class="btn-icon"><i class="fas fa-edit"></i></button></a>
            
            @if($room->status === 'empty')
                <button class="action-btn success assign-patient-btn" data-room-id="{{ $room->id }}" data-room-number="{{ $room->number }}">
                    <i class="fas fa-user-plus"></i> <span>@lang('words.patient')</span>
                </button>
            @elseif($room->status === 'available')
                <button class="action-btn success assign-patient-btn" data-room-id="{{ $room->id }}" data-room-number="{{ $room->number }}">
                    <i class="fas fa-user-plus"></i> <span>@lang('words.patient')</span>
                </button>
                <button class="action-btn warning discharge-room-btn" 
                        onclick='openDischargePatientModal("{{ $room->id }}", "{{ $room->number }}", {{ json_encode($patients) }})'>
                    <i class="fas fa-sign-out-alt"></i> <span>@lang('words.discharge')</span>
                </button>
            @elseif($room->status === 'full')
                <button class="action-btn warning discharge-room-btn" 
                        onclick='openDischargePatientModal("{{ $room->id }}", "{{ $room->number }}", {{ json_encode($patients) }})'>
                    <i class="fas fa-sign-out-alt"></i> <span>@lang('words.discharge')</span>
                </button>
            @elseif($room->status === 'maintenance')
                <button class="action-btn danger complete-maintenance-btn" 
                        data-room-id="{{ $room->id }}" 
                        data-room-number="{{ $room->number }}"
                        onclick="openCompleteMaintenanceModal('{{ $room->id }}', '{{ $room->number }}')">
                    <i class="fas fa-check"></i> <span>@lang('words.complete')</span>
                </button>
            @endif
        </div>
    </div>
</div>