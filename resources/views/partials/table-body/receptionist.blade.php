@forelse($patients as $index => $patient)
    <tr>
        <td>{{ $pagination['first_item'] + $index }}</td>
        <td>
            <div class="patient-name">{{ $patient['name'] }}</div>
        </td>
        <td>{{ $patient['phone'] }}</td>
        <td>{{ $patient['birth_date'] }}</td>
        <td>{{ $patient['gender'] }}</td>
        <td>{{ $patient['last_visit'] }}</td>
        <td>
            <span class="badge-visits">{{ $patient['total_visits'] }}</span>
        </td>
        <td>
            <div class="action-dropdown">
                <span class="dropdown-btn" onclick="toggleDropdown(this)">
                    <i class="fas fa-ellipsis-v"></i>
                </span> 
                <div class="dropdown-menu">
                    <a href="{{ route('appointments.create', $patient['id']) }}" class="create-appointment">
                        <i class="fas fa-calendar-plus"></i> @lang('words.create_appointment')
                    </a>
                    <a href="#" class="create-appointment">
                        <i class="fas fa-eye"></i> @lang('words.detail')
                    </a>
                </div> 
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8">
            <div class="empty-state"> 
                <p>@lang('words.no_patients')</p>
            </div>
        </td>
    </tr>
@endforelse