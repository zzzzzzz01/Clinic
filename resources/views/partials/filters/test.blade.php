<!-- Test Filter Panel -->
<div class="filter-panel" id="testFilterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="testFilterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="testFilterForm" method="GET" action="{{ route('tests.index') }}">
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-search" style="color: #00BFFF;"></i>
                    @lang('words.search')
                </label>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="modern-input" name="search" id="testSearchInput" placeholder="@lang('words.search_by_test_name')" value="{{ request('search') }}">
                    <button type="button" class="clear-search" id="testClearSearch">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-stethoscope" style="color: #00BFFF;"></i>
                    @lang('words.status')
                </label>
                <div class="status-row">
                    <label class="radio-card">
                        <input type="radio" name="status" value="all" {{ request('status', 'all') == 'all' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-users"></i>
                            <span>@lang('words.all')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="available" {{ request('status') == 'available' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-check-circle" style="color: #27ae60;"></i>
                            <span>@lang('words.available')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="unavailable" {{ request('status') == 'unavailable' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-times-circle" style="color: #dc3545;"></i>
                            <span>@lang('words.unavailable')</span>
                        </span>
                    </label>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-dollar-sign" style="color: #00BFFF;"></i>
                    @lang('words.price_range')
                </label>
                <div class="price-range">
                    <div class="price-input-group">
                        <i class="fas fa-dollar-sign"></i>
                        <input type="number" class="modern-price-input" name="price_min" id="testPriceMin" placeholder="@lang('words.min_price')" value="{{ request('price_min') }}">
                    </div>
                    <span class="price-separator">—</span>
                    <div class="price-input-group">
                        <i class="fas fa-dollar-sign"></i>
                        <input type="number" class="modern-price-input" name="price_max" id="testPriceMax" placeholder="@lang('words.max_price')" value="{{ request('price_max') }}">
                    </div>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-sort-amount-up" style="color: #00BFFF;"></i>
                    @lang('words.sort')
                </label>
                <div class="modern-select">
                    <select name="sort" id="testSortFilter">
                        <option value="name_asc" {{ request('sort', 'name_asc') == 'name_asc' ? 'selected' : '' }}>@lang('words.sort_by_name_asc')</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>@lang('words.sort_by_name_desc')</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>@lang('words.sort_by_price_asc')</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>@lang('words.sort_by_price_desc')</option>
                        <option value="code_asc" {{ request('sort') == 'code_asc' ? 'selected' : '' }}>@lang('words.sort_by_code_asc')</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn-clear" id="testResetFilters">
                    <i class="fas fa-redo-alt"></i>
                    @lang('words.clear')
                </button>
                <button type="submit" class="btn-apply" id="testApplyFilters">
                    <i class="fas fa-check"></i>
                    @lang('words.apply')
                </button>
            </div>
        </form>
    </div>
</div>

<div class="filter-overlay" id="testFilterOverlay"></div>