<div class="filter-panel" id="testPanelFilterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="testPanelFilterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="testPanelFilterForm" method="GET" action="{{ url()->current() }}">
            <div class="filter-section">
                <label class="filter-label"><i class="fas fa-search"></i> @lang('words.search')</label>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="modern-input" name="search" id="testPanelSearchInput" placeholder="@lang('words.search_placeholder')" value="{{ request('search') }}">
                    <button type="button" class="clear-search" id="testPanelClearSearch"><i class="fas fa-times"></i></button>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label"><i class="fas fa-chart-line"></i> @lang('words.status')</label>
                <div class="status-row">
                    <label class="radio-card">
                        <input type="radio" name="status" value="all" {{ request('status') == 'all' || !request('status') ? 'checked' : '' }}>
                        <span class="radio-content"><span>@lang('words.all')</span><i class="fas fa-list"></i></span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="active" {{ request('status') == 'active' ? 'checked' : '' }}>
                        <span class="radio-content"><i class="fas fa-check-circle" style="color: #27ae60;"></i><span>@lang('words.active')</span></span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="inactive" {{ request('status') == 'inactive' ? 'checked' : '' }}>
                        <span class="radio-content"><i class="fas fa-times-circle" style="color: #dc3545;"></i><span>@lang('words.inactive')</span></span>
                    </label>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label"><i class="fas fa-clinic-medical"></i> @lang('words.department')</label>
                <div class="modern-select">
                    <select name="department" id="testPanelDepartmentSelect">
                        <option value="all">@lang('words.all_departments')</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label"><i class="fas fa-sort-amount-up"></i> @lang('words.sort')</label>
                <div class="status-row">
                    <label class="radio-card">
                        <input type="radio" name="sort" value="name" checked>
                        <span class="radio-content"><i class="fas fa-font"></i><span>@lang('words.sort_by_name')</span></span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="sort" value="price">
                        <span class="radio-content"><i class="fas fa-dollar-sign"></i><span>@lang('words.sort_by_price')</span></span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="sort" value="time">
                        <span class="radio-content"><i class="fas fa-clock"></i><span>@lang('words.sort_by_time')</span></span>
                    </label>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn-clear" id="testPanelResetFilters"><i class="fas fa-redo-alt"></i> @lang('words.clear')</button>
                <button type="submit" class="btn-apply"><i class="fas fa-check"></i> @lang('words.apply')</button>
            </div>
        </form>
    </div>
</div>

<div class="filter-overlay" id="testPanelFilterOverlay"></div>