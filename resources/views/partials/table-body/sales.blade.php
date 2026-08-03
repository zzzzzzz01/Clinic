@forelse($data as $index => $medicine) 
<tr data-medicine-id="{{ $medicine['medicine_id'] }}"
    data-name="{{ $medicine['name'] }}"
    data-strength="{{ $medicine['generic_name'] ?? '' }}"
    data-price="{{ $medicine['selling_price'] ?? $medicine['price'] }}"
    data-stock="{{ $medicine['stock_boxes'] }}"
    data-pieces-per-box="{{ $medicine['units_per_boxes'] ?? 1 }}">
    <td class="row-number">{{ $index + 1 }}</td>
    <td>
        <strong class="medicine-name">{{ $medicine['name'] }}</strong>
        <small class="medicine-strength">{{ $medicine['generic_name'] ?? '' }}</small>
    </td>
    <td class="table-text">{{ $medicine['form'] ?? 'N/A' }}</td>
    <td>
        <span class="status-badge"
            style="color: {{ $medicine['status']['text_color'] }};
                    background-color: {{ $medicine['status']['bg_color'] }};">
            <i class="{{ $medicine['status']['icon'] }}"></i>
            {{ $medicine['status']['text'] }}
        </span>
    </td>
    <td class="currency-usd">
        ${{ number_format($medicine['selling_price'] ?? $medicine['price'] ?? 0, 2) }}
    </td>
    <td>
        <button class="btn-add-simple open-modal-btn"
                data-id="{{ $medicine['medicine_id'] }}"
                data-name="{{ $medicine['name'] }}"
                data-strength="{{ $medicine['generic_name'] ?? '' }}"
                data-price="{{ $medicine['selling_price'] ?? $medicine['price'] }}"
                data-stock="{{ $medicine['stock_boxes'] }}"
                data-pieces-per-box="{{ $medicine['units_per_box'] }}"
                {{ $medicine['stock_boxes'] <= 0 ? 'disabled' : '' }}>
            <i class="fas fa-plus"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-3"> 
        @lang('words.pharmacist.sales.no_medicines')
    </td>
</tr>
@endforelse