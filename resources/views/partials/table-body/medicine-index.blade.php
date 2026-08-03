@foreach($medicines as $medicine)
    <tr class="medicine-row">
        <td class="row-number text-center">{{ $loop->iteration }}</td>
        <td>
            <div class="medicine-info">
                <div>
                    <div class="full-name">{{ $medicine->name }}</div>
                    <div class="login-display">{{ Str::limit($medicine->category->name, 20) }}</div>
                </div>
            </div>
        </td>
        <td class="text-center">
            <span class="type-badge">
                {{ $medicine->form ?? '-' }}
            </span>
        </td>
        <td class="text-center">
            <div class="quantity-display">
                <span class="full-name">{{ $medicine->strength_value }}</span>
                <span class="medicine-dose">{{ $medicine->strength_unit }}</span>
            </div>
        </td>
        <td class="text-center">
            <div class="quantity-display">
                <span class="full-name">{{ $medicine->units_per_box }}</span>
                <span class="medicine-dose">@lang('words.piece')</span>
            </div>
        </td>
        <td>
            <span class="address-text"> {{ $medicine->supplier->name }}</span>
        </td>
        <td class="text-center">
            <div class="total-quantity">
                <span class="price-text">{{ number_format($medicine->price, 0, '', ' ') }} $</span>
            </div>
        </td>
        <td class="text-center">
            <div class="action-dropdown" data-dropdown-id="dropdown-{{ $medicine->id }}">
                <span class="action-dots"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                <div class="dropdown-content" id="dropdown-{{ $medicine->id }}">
                    <a href="{{ route('medicines.show', $medicine) }}" class="text-primary">
                        <i class="fas fa-eye"></i> @lang('words.view')
                    </a>
                    @if(auth()->user()->hasRole('Admin'))
                    <a href="{{ route('medicines.edit', $medicine) }}" class="text-warning">
                        <i class="fas fa-edit"></i> @lang('words.edit')
                    </a>
                    <a href="javascript:void(0)" class="text-danger" onclick="openMedicineDeleteModal({{ $medicine->id }}, '{{ $medicine->name }}')">
                        <i class="fas fa-trash"></i> @lang('words.delete')
                    </a>
                    @endif
                </div>
            </div>
        </td>
    </tr>
@endforeach