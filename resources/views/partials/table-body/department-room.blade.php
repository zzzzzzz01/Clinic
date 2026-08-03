@forelse($rooms as $room)
    <tr class="room-row" data-room-id="{{ $room['id'] }}">
        <td class="row-number">{{ $room['counter'] }}</td>
        <td>
            <span class="room-number">{{ $room['number'] }}</span>
        </td>
        <td class="floor">{{ $room['floor'] }}<span>-@lang('words.floor')</span> </td>
        <td>
            <span class="badge {{ $room['badge_class'] }}">
                {{ $room['type_name'] }}
            </span>
        </td>
        <td>
            <span class="status-badge {{ $room['status']['class'] }}" 
                    style="background-color: {{ $room['status']['bg_color'] }}; color: {{ $room['status']['text_color'] }};">
                <i class="fas {{ $room['status']['icon'] }}"></i> 
                {{ $room['status']['text'] }}
            </span>
        </td>
        <td>
            <button class="btn-primary" 
                    onclick="openBedsModal('{{ $room['id'] }}')"
                    data-room-id="{{ $room['id'] }}">
                <i class="fas fa-eye"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" style="text-align: center; padding: 40px;">
            <i class="fas fa-door-closed" style="font-size: 48px; color: #cbd5e0; display: block; margin-bottom: 10px;"></i>
            <p style="color: #64748b;">Bu bo'limda xonalar mavjud emas</p>
        </td>
    </tr>
@endforelse