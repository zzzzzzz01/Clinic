<!-- Doctor filter -->
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
                    <i class="fas fa-search" style="color: #00BFFF;"></i>
                    @lang('words.search')
                </label>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="modern-input" name="search" id="searchInput" 
                           placeholder="@lang('words.search_by_name_phone')" 
                           value="{{ request('search') }}">
                    <button type="button" class="clear-search" id="clearSearch" 
                            style="display: {{ request('search') ? 'block' : 'none' }};">
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
                        <input type="radio" name="status" value="all" {{ request('status') == 'all' || !request('status') ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-users"></i>
                            <span>@lang('words.all')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="active" {{ request('status') == 'active' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-circle-check" style="color: #27ae60;"></i>
                            <span>@lang('words.active')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="on_leave" {{ request('status') == 'on_leave' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-umbrella-beach" style="color: #f39c12;"></i>
                            <span>@lang('words.on_leave')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="inactive" {{ request('status') == 'inactive' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-circle-xmark" style="color: #dc3545;"></i>
                            <span>@lang('words.inactive')</span>
                        </span>
                    </label>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-clinic-medical" style="color: #00BFFF;"></i>
                    @lang('words.department')
                </label>
                <div class="modern-select">
                    <select name="department" id="departmentSelect">
                        <option value="all" {{ request('department') == 'all' || !request('department') ? 'selected' : '' }}>
                            @lang('words.all_departments')
                        </option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-calendar-alt" style="color: #00BFFF;"></i>
                    @lang('words.hired_date')
                </label>
                <div class="date-range">
                    <div class="date-input-group">
                        <i class="fas fa-calendar-day"></i>
                        <input type="date" class="modern-date-input" name="date_from" id="startDate" 
                               value="{{ request('date_from') }}" placeholder="@lang('words.from')">
                    </div>
                    <span class="date-separator">—</span>
                    <div class="date-input-group">
                        <i class="fas fa-calendar-day"></i>
                        <input type="date" class="modern-date-input" name="date_to" id="endDate" 
                               value="{{ request('date_to') }}" placeholder="@lang('words.to')">
                    </div>
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