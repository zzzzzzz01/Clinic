@foreach($suppliers as $supplier)
<tr class="supplier-row">
    <td class="row-number text-center">{{ $loop->iteration }}</td>
    <td>
        <div class="full-name">{{ Str::limit($supplier['name'], 11) }}</div>
        <div class="description">{{ Str::limit($supplier['description'] ?? '-', 50) }}</div>
    </td>
    <td class="text-center">
        <span class="type-badge">{{ $supplier['type'] ?? __('words.local') }}</span>
    </td>
    <td class="text-center">
        <div class="contact-info">
            <span class="contact-email">{{ $supplier['email'] }}</span>
            <span class="contact-phone">{{ $supplier['phone'] }}</span>
        </div>
    </td>
    <td class="text-center">
        <span class="address-text">{{ Str::limit($supplier['address'], 20) }}</span>
    </td>
    <td class="text-center">
        <span class="status-badge {{ $supplier['status_class'] }}">
            <i class="fas {{ $supplier['status_icon'] }}"></i>
            {{ $supplier['status_text'] }}
        </span>
    </td>
    <td class="text-center">
        <div class="action-dropdown" data-dropdown-id="dropdown-{{ $supplier['id'] }}">
            <span class="action-dots"><i class="fa-solid fa-ellipsis-vertical"></i></span>
            <div class="dropdown-content" id="dropdown-{{ $supplier['id'] }}">
                <a href="{{ route('suppliers.show', $supplier['id']) }}" class="text-primary">
                    <i class="fas fa-eye"></i> @lang('words.view')
                </a>
                <a href="{{ route('suppliers.edit', $supplier['id']) }}" class="text-warning">
                    <i class="fas fa-edit"></i> @lang('words.edit')
                </a>
                <a href="javascript:void(0)" class="text-danger" onclick="openSupplierDeleteModal({{ $supplier['id'] }}, '{{ $supplier['name'] }}')">
                    <i class="fas fa-trash"></i> @lang('words.delete')
                </a>
            </div>
        </div>
    </td>
</tr>
@endforeach