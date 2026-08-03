<dialog class="notification-modal" id="historyModal"> 
    <div class="modal-header">
        <h3>@lang('words.pharmacist.sales.sales_history') <span class="history-date-badge" id="historyDate">{{ now()->format('d.m.Y') }}</span></h3> 
        <button class="close-btn" id="historyCloseBtn">✕</button>
    </div>
    <div class="modal-body" id="historyBody">
        <div class="history-table">
            <div class="table-wrapper"> 
                <div id="historyContent">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('words.pharmacist.sales.time')</th>
                                <th>@lang('words.pharmacist.sales.products')</th>
                                <th>@lang('words.pharmacist.sales.payment_type')</th>
                                <th>@lang('words.pharmacist.sales.total_price')</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todaySales as $index => $sale)
                                <tr>
                                    <td class="row-number">{{ $index + 1 }}</td>
                                    <td class="table-text">{{ \Carbon\Carbon::parse($sale['created_at'])->format('H:i') }}</td>
                                    <td class="table-text">
                                        @foreach($sale['items'] as $item)
                                            {{ $item['medicine_name'] }} {{ $item['medicine_strength'] }} x{{ $item['quantity'] }} {{ $item['unit'] }}@if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td class="table-text"> {{ $sale['payment_method'] }} 
                                    </td>
                                    <td class="currency-usd history-total">{{ $sale['total_price'] }} $</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 20px;">@lang('words.pharmacist.sales.no_sales')</td>
                                </tr>
                            @endforelse
                        </tbody> 
                    </table>
                </div> 
            </div>
        </div>
    </div> 
    <div class="modal-footer">
        <span><strong>@lang('words.pharmacist.sales.total_sales'):</strong> {{ count($todaySales) }} ta</span>
        <span class="currency-usd" style="font-weight: 700; font-size: 16px;">
            {{ array_sum(array_column($todaySales, 'total_price')) }} $
        </span>
    </div>
</dialog> 