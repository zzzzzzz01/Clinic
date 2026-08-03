@foreach($daySalesList ?? [] as $day => $sales)
    <dialog class="notification-modal" style="width: 96%;" id="dayModal_{{ str_replace(['.', '-'], '_', $day) }}"> 
        <div class="modal-header">
            <h3>{{ \Carbon\Carbon::createFromFormat('Y.m.d', $day)->format('d.m.Y') }}</h3>
            <button class="close-btn" onclick="document.getElementById('dayModal_{{ str_replace(['.', '-'], '_', $day) }}').close(); document.body.style.overflow = '';">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="report-table">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 15%;">@lang('words.time')</th>
                            <th style="width: 44%;">@lang('words.products')</th>
                            <th>@lang('words.pharmacist.sales.payment_method')</th>
                            <th>@lang('words.total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $index => $sale)
                            <tr>
                                <td class="row-number">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="time-badge">{{ isset($sale['created_at']) ? substr(explode(' ', $sale['created_at'])[1] ?? '--:--', 0, 5) : '--:--' }}</span>
                                </td>
                                <td class="products-cell">
                                    @foreach($sale['items'] ?? [] as $item)
                                        <span class="product-tag">
                                            {{ $item['medicine_name'] ?? 'Noma\'lum' }} 
                                            {{ $item['medicine_strength'] ?? '' }}
                                            <span class="product-qty">x {{ $item['quantity'] }} {{ $item['unit_label'] }}</span>
                                        </span>
                                    @endforeach
                                </td>
                                <td class="table-text">
                                    {{ $sale['payment_method_label'] ?? $sale['payment_method'] ?? 'Noma\'lum' }}
                                </td>
                                <td class="currency-usd">${{ number_format($sale['total_price'] ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>@lang('words.no_data_found')</h5>
                                        <p class="text-muted">@lang('words.no_sales_this_day')</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: 600;">@lang('words.total'):</td>
                            <td class="currency-usd" style="font-weight: 700;">
                                ${{ number_format(array_sum(array_column($sales, 'total_price')), 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="document.getElementById('dayModal_{{ str_replace(['.', '-'], '_', $day) }}').close(); document.body.style.overflow = '';">@lang('words.close')</button>
        </div> 
    </dialog>
@endforeach