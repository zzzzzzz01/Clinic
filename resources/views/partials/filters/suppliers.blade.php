<!-- Supplier Filter Panel -->
<div class="filter-panel" id="supplierFilterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="supplierFilterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="supplierFilterForm" method="GET" action="{{ url()->current() }}">
            <!-- Turi -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-tag" style="color: #00BFFF;"></i>
                    @lang('words.type')
                </label>
                <div class="modern-select">
                    <select name="type" id="supplierTypeSelect">
                        <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }}>@lang('words.filter_type_all')</option>
                        <option value="lokal" {{ request('type') == 'lokal' ? 'selected' : '' }}>@lang('words.local')</option>
                        <option value="xalqaro" {{ request('type') == 'xalqaro' ? 'selected' : '' }}>@lang('words.international')</option>
                    </select>
                </div>
            </div>
            
            <!-- Holati -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-toggle-on" style="color: #00BFFF;"></i>
                    @lang('words.status')
                </label>
                <div class="modern-select">
                    <select name="status" id="supplierStatusSelect">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>@lang('words.all')</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>@lang('words.active')</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>@lang('words.inactive')</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn-clear" id="supplierResetFilters">
                    <i class="fas fa-redo-alt"></i>
                    @lang('words.clear')
                </button>
                <button type="submit" class="btn-apply" id="supplierApplyFilters">
                    <i class="fas fa-check"></i>
                    @lang('words.apply')
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Supplier Filter Panel -->
<div class="filter-overlay" id="supplierFilterOverlay"></div>