<div class="filter-panel" id="filterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="filterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="filterForm" method="GET" action="{{ url()->current() }}">
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-calendar-alt" style="color: #00BFFF;"></i>
                    @lang('words.time_date')
                </label>
                <div class="filter-type-row">
                    <label class="radio-card {{ $filterType == 'day' ? 'active' : '' }}">
                        <input type="radio" name="filter_type" value="day" {{ $filterType == 'day' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-sun"></i>
                            <span>@lang('words.day')</span>
                        </span>
                    </label>
                    <label class="radio-card {{ $filterType == 'month' ? 'active' : '' }}">
                        <input type="radio" name="filter_type" value="month" {{ $filterType == 'month' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-calendar-alt"></i>
                            <span>@lang('words.month')</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-clock" style="color: #00BFFF;"></i>
                    <span id="filterValueLabel">
                        @if($filterType == 'day') @lang('words.day')
                        @else @lang('words.month')
                        @endif
                    </span>
                </label>
                <div class="filter-value-wrapper">
                    @if($filterType == 'day')
                        <input type="date" class="modern-input" name="filter_value" value="{{ $filterValue }}" id="filterValueInput">
                    @else
                        <select class="modern-select" name="filter_value" id="filterValueInput">
                            @foreach($monthOptions as $monthVal)
                                <option value="{{ $monthVal }}" {{ $filterValue == $monthVal ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($monthVal . '-01')->format('F Y') }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-credit-card" style="color: #00BFFF;"></i>
                    @lang('words.pharmacist.sales.payment_method')
                </label>
                <div class="payment-type-row">
                    <label class="radio-card {{ $paymentMethod == 'all' ? 'active' : '' }}">
                        <input type="radio" name="payment_method" value="all" {{ $paymentMethod == 'all' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-list"></i>
                            <span>@lang('words.all')</span>
                        </span>
                    </label>
                    <label class="radio-card {{ $paymentMethod == 'cash' ? 'active' : '' }}">
                        <input type="radio" name="payment_method" value="cash" {{ $paymentMethod == 'cash' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-money-bill-wave" style="color: #27ae60;"></i>
                            <span>@lang('words.pharmacist.sales.cash')</span>
                        </span>
                    </label>
                    <label class="radio-card {{ $paymentMethod == 'card' ? 'active' : '' }}">
                        <input type="radio" name="payment_method" value="card" {{ $paymentMethod == 'card' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-credit-card" style="color: #1976d2;"></i>
                            <span>@lang('words.pharmacist.sales.card')</span>
                        </span>
                    </label>
                    <label class="radio-card {{ $paymentMethod == 'transfer' ? 'active' : '' }}">
                        <input type="radio" name="payment_method" value="transfer" {{ $paymentMethod == 'transfer' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-university" style="color: #f57c00;"></i>
                            <span>@lang('words.pharmacist.sales.transfer')</span>
                        </span>
                    </label> 
                </div>
            </div>

            <div class="filter-actions">
                <button type="button" class="btn-clear" id="resetFilters">
                    <i class="fas fa-redo-alt"></i>
                    @lang('words.clear')
                </button>
                <button type="submit" class="btn-apply">
                    <i class="fas fa-check"></i>
                    @lang('words.apply')
                </button>
            </div>
        </form>
    </div>
</div>

<div class="filter-overlay" id="filterOverlay"></div>