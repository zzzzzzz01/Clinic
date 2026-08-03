@foreach($hospitalizations ?? [] as $hospitalization)
<tr>
    <td class="row-number">{{ $loop->iteration }}</td>
    <td>
        <div class="patient-info">
            <div class="patient-avatar">
                {{ strtoupper(substr($hospitalization->appointment?->patient?->user?->name ?? 'N', 0, 1)) }}
            </div>
            <div>
                <div style="font-weight: 600;">
                    {{ $hospitalization->appointment?->patient?->user?->name ?? __('words.unknown') }} 
                    {{ $hospitalization->appointment?->patient?->user?->last_name ?? '' }}
                </div>
                <div class="login-display">
                    @lang('words.login'): {{ $hospitalization->appointment?->patient?->user?->login ?? '--' }} 
                </div>
            </div>
        </div>
    </td>
    <td>{{ $hospitalization->appointment?->patient?->birth_date ? \Carbon\Carbon::parse($hospitalization->appointment->patient->birth_date)->age : '-' }} @lang('words.years_old')</td>
    <td>{{ $hospitalization->department->name ?? '-' }}</td>
    <td>{{ $hospitalization->hospitalizationRooms->last()?->bed?->room?->number ?? '-' }}</td>
    <td>
        @if($hospitalization->status == 'under_treatment')
            <span class="status-badge status-under_treatment"><i class="fas fa-heartbeat"></i> @lang('words.under_treatment')</span>
        @elseif($hospitalization->status == 'waiting_for_bed')
            <span class="status-badge status-waiting_for_bed"><i class="fas fa-clock"></i> @lang('words.waiting_for_bed')</span>
        @elseif($hospitalization->status == 'discharged')
            <span class="status-badge discharged"><i class="fas fa-house-user"></i> @lang('words.discharged')</span>
        @else
            <span class="status-badge">-</span>
        @endif
    </td>
    <td>
        <div class="action-dropdown" data-dropdown-id="hospitalization-dropdown-{{ $hospitalization->id }}">
            <span class="action-dots"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            <div class="dropdown-content" id="hospitalization-dropdown-{{ $hospitalization->id }}">
                <a href="{{ route('hospitalizations.show', $hospitalization) }}" class="text-primary">
                    <i class="fas fa-eye"></i> @lang('words.view')
                </a>
                <a href="#" class="text-warning edit-patient-btn" data-id="{{ $hospitalization->id }}">
                    <i class="fas fa-edit"></i> @lang('words.edit')
                </a>
                <a href="#" class="text-success assign-doctor-btn" data-id="{{ $hospitalization->id }}" data-name="{{ $hospitalization->appointment?->patient?->user?->name ?? '' }}">
                    <i class="fas fa-user-md"></i> @lang('words.assign_doctor')
                </a>
                @if(auth()->user()->hasRole('Admin'))
                <a href="javascript:void(0)" class="text-danger" onclick="deleteHospitalization({{ $hospitalization->id }})">
                    <i class="fas fa-trash"></i> @lang('words.delete')
                </a>
                @endif
            </div>
        </div>
    </td>
</tr>
@endforeach