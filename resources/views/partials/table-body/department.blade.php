@foreach($departmentData as $index => $department) 
<tr class="department-row">
    <td class="row-number">{{ $departments->firstItem() + $index }}</td>
    <td>
        <div class="department-info">
            <div>
                <div class="department-name">{{ $department['name'] }}</div>
                <div class="department-floor">@lang('words.floor'): {{ $department['floor'] }}</div>
            </div>
        </div>
    </td>
    <td>
        <div class="doctor-info"style="flex-direction: column;">
            <div class="doctor-name">{{ $department['head_doctor_name'] }}</div>
            <div class="doctor-specialty">{{ $department['head_doctor_specialty'] }}</div>
        </div>
    </td>
    <td>
        <div class="beds-info">
            <div class="beds-count">@lang('words.rooms_and_beds', ['rooms' => $department['rooms_count'], 'beds' => $department['total_beds']])</div>
            <div class="beds-progress">
                <div class="progress">
                    <div class="progress-bar" style="width: {{ $department['occupancy_percent'] }}%"></div>
                </div>
                <div class="occupancy-rate">{{ $department['occupied_beds'] }}/{{ $department['total_beds'] }} @lang('words.occupied') ({{ $department['occupancy_percent'] }}%)</div>
            </div>
        </div>
    </td>
    <td class="text-center">
        <div class="fw-bold">{{ $department['total_staff'] }} @lang('words.staff')</div>
        <div class="text-muted small">{{ $department['doctor_count'] }} @lang('words.doctors'), {{ $department['nurse_count'] }} @lang('words.nurses')</div>
    </td>
    <td>
        <span class="status-badge {{ $department['status_class'] }}"
            style="color: {{ $department['status_text_color'] }};
                    background-color: {{ $department['status_bg_color'] }};">
            <i class="fas {{ $department['status_icon'] }}"></i> {{ $department['status_text'] }}
        </span>
    </td>
    <td>
        <div class="action-dropdown" data-dropdown-id="dropdown-{{ $department['id'] }}">
            <span class="action-dots"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            <div class="dropdown-content" id="dropdown-{{ $department['id'] }}">
                <a href="#" class="text-primary edit-department-btn"
                    data-id="{{ $department['id'] }}"
                    data-name-uz="{{ $department['name_uz'] }}"
                    data-name-ru="{{ $department['name_ru'] }}"
                    data-name-en="{{ $department['name_en'] }}"
                    data-head_doctor="{{ $department['head_doctor_id'] }}"
                    data-floor="{{ $department['floor'] }}"
                    data-description-uz="{{ $department['description_uz'] ?? '' }}"
                    data-description-ru="{{ $department['description_ru'] ?? '' }}"
                    data-description-en="{{ $department['description_en'] ?? '' }}"
                    data-status="{{ $department['status'] }}"
                    data-doctor_count="{{ $department['doctor_count'] }}"
                    data-nurse_count="{{ $department['nurse_count'] }}"
                    data-room_count="{{ $department['rooms_count'] }}"
                    data-bed_count="{{ $department['total_beds'] }}">
                    <i class="fas fa-edit"></i> @lang('words.edit')
                </a>
                <a href="#" class="text-primary view-staff-btn" 
                    data-department-id="{{ $department['id'] }}"
                    data-department-name="{{ $department['name'] }}">
                    <i class="fas fa-user-group"></i> @lang('words.staff')
                </a>
                <a href="{{ route('departments.rooms', $department['id']) }}" class="text-primary">
                    <i class="fas fa-bed"></i> @lang('words.rooms')
                </a>
                <a href="#" class="text-danger delete-department-btn"
                    data-id="{{ $department['id'] }}"
                    data-name="{{ $department['name'] }}">
                    <i class="fas fa-trash"></i> @lang('words.delete')
                </a>
            </div>
        </div>
    </td>
</tr>
@endforeach