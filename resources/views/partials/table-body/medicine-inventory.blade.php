@foreach($tableData as $row)
    <tr class="medicine-row">
        <td>{{ $row['rowNumber'] }}</td>
        <td class="procedure-name">
            <div class="medicine-info">
                <div class="full-name">{{ $row['name'] }}</div>
                @if($row['strength'])
                    <span class="description">{{ $row['strength'] }}</span>
                @endif
            </div>
        </td>
        <td class="medicine-category">{{ $row['category'] }}</td>
        <td class="table-text">{{ $row['supplier'] }}</td>
        <td class="stock-cell">
            <span class="stock-value">{{ $row['stockBoxes'] }}</span>
        </td>
        <td class="table-text">{{ $row['form'] }}</td>
        <td>
            <span class="status-badge" style="background: {{ $row['statusBg'] }}; color: {{ $row['statusColor'] }};">
                {{ $row['statusText'] }}
            </span>
        </td>
        <td>
            <div class="action-dropdown" data-dropdown-id="{{ $row['dropdownId'] }}">
                <span class="action-dots">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </span>
                <div class="dropdown-content" id="{{ $row['dropdownId'] }}">
                <a href="{{ route('medicine.history', $row['id']) }}" class="text-primary">
                    <i class="fas fa-history"></i> @lang('words.history')
                </a>
                </div>
            </div>
        </td>
    </tr>
@endforeach

@if($tableData->isEmpty())
    <tr class="empty-row">
        <td colspan="8" class="empty-cell text-center">@lang('words.no_medicines')</td>
    </tr>
@endif