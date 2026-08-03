@foreach($formattedDoctors as $index => $doctor)
<tr> 
    <td class="row-number">{{ ($doctors->currentPage() - 1) * $doctors->perPage() + $loop->iteration }}</td>
    <td>
        <div class="patient-info">
            <div class="patient-avatar">

                @if($doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}"
                        alt="{{ $doctor->user->name ?? '' }}"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    {{ mb_substr($doctor->user->name ?? '', 0, 1) }}
                    {{ mb_substr($doctor->user->last_name ?? '', 0, 1) }}
                @endif

            </div>
            <div>
                <div class="full-name">
                    {{ $doctor->user->name ?? '' }} {{ $doctor->user->last_name ?? '' }}
                </div>

                <div class="short-name">
                    {{ $doctor->user->last_name ?? '' }}
                    {{ mb_substr($doctor->user->name ?? '', 0, 1) }}.
                </div>

                <div class="login-display">
                    Login: {{ $doctor->user->login ?? '-' }}
                </div>

                <!-- <div class="phone-display">
                    {{ $doctor->user->phone ?? '-' }}
                </div> -->
            </div>
        </div>
    </td>
    <td>{{ $doctor->department_name ?? '-' }}</td>
    <td>{{ $doctor->experience_years ?? 0 }} @lang('words.years')</td>
    <td>{{ $doctor->user->phone ?? '-' }}</td>
    <td>
        <div class="hire-date-main">
            <div class="hire-date">
                {{ \Carbon\Carbon::parse($doctor->created_at)->format('d.m.Y') }}
            </div>

            <div class="hire-day" style="color: var(--gray-color);">
                {{ \Carbon\Carbon::parse($doctor->created_at)->diffForHumans() }}
            </div>
        </div>
    </td>
    <td>
        <span class="status-badge"
            style="color: {{ $doctor->status_text_color }};
                    background-color: {{ $doctor->status_bg_color }};">
            <i class="{{ $doctor->status_icon }}"></i>
            {{ $doctor->status_text }}
        </span>
    </td>
    <td>
        <div class="action-dropdown" data-dropdown-id="dropdown-{{ $doctor->id }}">

            <span class="action-dots">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </span>

            <div class="dropdown-content" id="dropdown-{{ $doctor->id }}">

                <a href="{{ route('schedule.show', ['type' => 'doctor', 'id' => $doctor->id]) }}" class="text-primary">
                    <i class="fa-solid fa-calendar-days"></i> @lang('words.schedule')
                </a>

                <a href="{{ route('doctors.show', $doctor->id) }}" class="text-primary">
                    <i class="fas fa-id-card"></i> @lang('words.view')
                </a>

                <a href="{{ route('ambulator.doctor', $doctor->id) }}" class="text-primary">
                    <i class="fas fa-users"></i> @lang('words.admissions')
                </a>

                <a href="{{ route('doctor.appointment.slots', $doctor->id) }}" class="text-primary">
                    <i class="fas fa-clock"></i> @lang('words.appointment_slots')
                </a>

                <a href="{{ route('doctors.edit', $doctor->id) }}" class="text-primary">
                    <i class="fas fa-edit"></i> @lang('words.edit')
                </a>

                <a href="javascript:void(0)"
                    class="text-primary"
                    onclick="openDoctorNotificationModal(
                            {{ $doctor->id }},
                            '{{ $doctor->user->name ?? '' }}',
                            '{{ $doctor->user->last_name ?? '' }}',
                            '{{ $doctor->role ?? '' }}',
                            {{ $doctor->has_unread_notifications ?? 0 }}
                    )">
                    <i class="fas fa-bell"></i> @lang('words.notifications')
                </a>

                <a href="javascript:void(0)"
                    class="text-danger"
                    onclick="openDoctorDeleteModal(
                            {{ $doctor->id }},
                            '{{ $doctor->user->name ?? '' }}',
                            '{{ $doctor->user->last_name ?? '' }}',
                            '{{ $doctor->user->middle_name ?? '' }}',
                            '{{ $doctor->role ?? '' }}'
                    )">
                    <i class="fas fa-trash"></i> @lang('words.delete')
                </a>

            </div>
        </div>
    </td>
</tr>
@endforeach