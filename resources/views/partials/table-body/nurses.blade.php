@foreach($nursesWithStatus as $index => $nurse)
<tr>
    <td class="row-number">{{ $index + 1 }}</td>
    <td>
        <div class="patient-info">
            <div class="patient-avatar">{{ $nurse['user']['avatar'] }}</div>
            <div>
                <div class="full-name">{{ $nurse['user']['name'] }} {{ $nurse['user']['last_name'] }}</div>
                <div class="short-name">{{ $nurse['user']['last_name'] }} {{ substr($nurse['user']['name'], 0, 1) }}.</div>
                <div class="login-display">@lang('words.login'): {{ $nurse['user']['login'] }}</div>
                <div class="phone-display">{{ $nurse['user']['phone'] }}</div>
            </div>
        </div>
    </td>
    <td>{{ $nurse['department'] ?? __('words.no_department_assigned') }}</td>
    <td>{{ $nurse['experience_years'] }} @lang('words.years')</td>
    <td>{{ $nurse['user']['phone'] }}</td>
    <td>
        <div style="font-size: 11px">
            <div style="font-weight: 600;">{{ $nurse['created_at']['formatted'] }}</div>
            <div style="color: var(--gray-color);">{{ $nurse['created_at']['diff'] }}</div>
        </div>
    </td>
    <td>
        <span class="status-badge" style="color: {{ $nurse['status_text_color'] }}; background-color: {{ $nurse['status_bg_color'] }};">
            <i class="{{ $nurse['status_icon'] }}"></i> {{ $nurse['status_text'] }}
        </span>
    </td>
    <td>
        <div class="action-dropdown" data-dropdown-id="dropdown-{{ $nurse['id'] }}">
            <span class="action-dots"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            <div class="dropdown-content" id="dropdown-{{ $nurse['id'] }}">
                <a href="{{ route('schedule.show', ['type' => 'nurse', 'id' => $nurse['id']]) }}" class="text-primary">
                    <i class="fa-solid fa-calendar-days"></i> @lang('words.schedule')
                </a>
                <a href="{{ route('nurses.show', ['nurse' => $nurse['id']]) }}" class="text-primary">
                    <i class="fas fa-eye"></i> @lang('words.view')
                </a>
                <a href="{{ route('nurses.edit', ['nurse' => $nurse['id']]) }}" class="text-warning">
                    <i class="fas fa-edit"></i> @lang('words.edit')
                </a>
                <a href="javascript:void(0)" class="text-success" onclick="openNurseNotificationModal({{ $nurse['id'] }}, '{{ $nurse['user']['name'] }}', '{{ $nurse['user']['last_name'] }}', '{{ $nurse['role'] }}', {{ $nurse['unread_notifications'] }})">
                    <i class="fas fa-bell"></i> @lang('words.notifications')
                </a>
                <a href="javascript:void(0)" class="text-danger" onclick="openNurseDeleteModal({{ $nurse['id'] }}, '{{ $nurse['user']['name'] }}', '{{ $nurse['user']['last_name'] }}', '{{ $nurse['user']['middle_name'] }}', '{{ $nurse['role'] }}')">
                    <i class="fas fa-trash"></i> @lang('words.delete')
                </a>
            </div>
        </div>
    </td>
</tr>
@endforeach