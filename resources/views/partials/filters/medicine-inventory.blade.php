<!-- Filter Panel -->
<div class="filter-panel" id="filterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="filterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="filterForm" method="GET" action="{{ route('medicine.inventory') }}">
            <!-- Search olib tashlandi -->
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-tags" style="color: #00BFFF;"></i>
                    @lang('words.category')
                </label>
                <div class="modern-select">
                    <select name="category" id="categorySelect">
                        <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>
                            @lang('words.all_categories')
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-boxes" style="color: #00BFFF;"></i>
                    @lang('words.stock_status')
                </label>
                <div class="status-row">
                    <label class="radio-card">
                        <input type="radio" name="stock_status" value="all" {{ request('stock_status') == 'all' || !request('stock_status') ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-boxes"></i>
                            <span>@lang('words.all')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="stock_status" value="in_stock" {{ request('stock_status') == 'in_stock' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-check-circle" style="color: #27ae60;"></i>
                            <span>@lang('words.in_stock')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="stock_status" value="low" {{ request('stock_status') == 'low' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-exclamation-triangle" style="color: #f39c12;"></i>
                            <span>@lang('words.low_stock')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="stock_status" value="out" {{ request('stock_status') == 'out' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-times-circle" style="color: #dc3545;"></i>
                            <span>@lang('words.out_of_stock')</span>
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