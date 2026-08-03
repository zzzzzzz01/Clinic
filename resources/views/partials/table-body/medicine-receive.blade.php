@forelse($pendingStocks as $stock)
<tr class="medicine-row" data-index="{{ $loop->index }}" data-id="{{ $stock->id }}">
    <td class="row-number">{{ $loop->iteration }}</td>
    <td>
        <div class="medicine-text">{{ $stock->medicine->name }}</div>
        @if($stock->medicine->strength_value)
        <div class="login-display">{{ $stock->medicine->strength_value }} {{ $stock->medicine->strength_unit }}</div>
        @endif
    </td>
    <td class="table-text">{{ $stock->quantity_boxes }}</td>
    <td class="table-text">{{ $stock->pieces_per_box }}</td>
    <td class="table-text">{{ $stock->total_pieces }}</td>
    <td class="table-text">{{ \Carbon\Carbon::parse($stock->receive_date)->format('d.m.Y') }}</td>
    <td>
        <span class="status-badge status-pending">
            <i class="fa-solid fa-clock"></i>
            @lang('words.pending_status')
        </span>
    </td>
    <td>
        <div class="action-dropdown" data-dropdown-id="dropdown-{{ $loop->index }}">
            <span class="action-dots">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </span>
            <div class="dropdown-content" id="dropdown-{{ $loop->index }}">
                <a href="javascript:void(0)" class="text-primary" onclick="openEditDialog(this)">
                    <i class="fas fa-edit"></i> @lang('words.edit')
                </a>
                <a href="javascript:void(0)" class="text-danger" onclick="openDeleteDialog(this)">
                    <i class="fas fa-trash-alt"></i> @lang('words.delete')
                </a>
                <a href="javascript:void(0)" class="text-primary" onclick="openViewDialog(this)">
                    <i class="fas fa-info-circle"></i> @lang('words.view_details')
                </a>
            </div>
        </div>
    </td>
</tr>
<!-- Hidden input for stock ids -->
<input type="hidden" name="stock_ids[]" value="{{ $stock->id }}">
@empty
<tr>
    <td colspan="8" class="text-center py-4">@lang('words.no_pending_medicines')</td>
</tr>
@endforelse