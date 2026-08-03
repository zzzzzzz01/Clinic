@if($filterType == 'month')
    @forelse($filteredSales as $index => $dayData)
        <tr>
            <td class="row-number">{{ $loop->iteration }}</td>
            <td>
                <span class="time-badge"> 
                    {{ \Carbon\Carbon::createFromFormat('Y.m.d', $dayData['date'])->format('d.m.Y') }}
                </span>
            </td>
            <td>
                <span class="product-tag">
                    <i class="fas fa-shopping-cart"></i> {{ $dayData['count'] }} @lang('words.pcs')
                </span>
            </td>
            <td class="currency-usd">${{ number_format($dayData['total'], 2) }}</td>
            <td>
                <button class="btn-primary" onclick="openDayDetail('{{ $dayData['date'] }}')">
                    <i class="fas fa-eye"></i>
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center py-4">
                <div class="empty-state"> 
                    <p class="text-muted">@lang('words.no_sales_this_month')</p>
                </div>
            </td>
        </tr>
    @endforelse
@else
    @php $totalSum = 0; @endphp
    @forelse($filteredSales as $index => $sale)
        @php $totalSum += $sale['total_price']; @endphp
        <tr>
            <td class="row-number">{{ $loop->iteration }}</td>
            <td>
                <span class="time-badge"> 
                    {{ substr(explode(' ', $sale['created_at'])[1] ?? '00:00:00', 0, 5) }}
                </span>
            </td>
            <td class="products-cell">
                @foreach($sale['items'] as $item)
                    <span class="product-tag">
                        {{ $item['medicine_name'] }} {{ $item['medicine_strength'] }}
                        <span class="product-qty">x {{ $item['quantity'] }} {{ $item['unit_label'] }}</span>
                    </span>
                    @if(!$loop->last) @endif
                @endforeach
            </td>
            <td class="table-text">{{ $sale['payment_method_label'] ?? $sale['payment_method'] }}</td>
            <td class="currency-usd">${{ number_format($sale['total_price'], 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center py-4">
                <div class="empty-state">  
                    <p class="text-muted">@lang('words.no_sales_this_day')</p>
                </div>
            </td>
        </tr>
    @endforelse
    @if(count($filteredSales) > 0)
        <tr class="total-row">
            <td colspan="4" style="text-align: right; font-weight: 700; font-size: 15px; color: #1a2332; padding: 12px 14px; border-top: 2px solid #e8edf2;">
                @lang('words.total'):
            </td>
            <td class="currency-usd" style="font-weight: 700; font-size: 16px; border-top: 2px solid #e8edf2;">
                ${{ number_format($totalSum, 2) }}
            </td>
        </tr>
    @endif
@endif