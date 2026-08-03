<div class="filter-panel" id="hospitalizationFilterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="hospitalizationFilterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="hospitalizationFilterForm" method="GET" action="">
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-search" style="color: #00BFFF;"></i>
                    @lang('words.search')
                </label>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="modern-input" name="search" id="hospitalizationSearchInput" placeholder="@lang('words.search_by_patient_name')" value="{{ request('search') }}">
                    <button type="button" class="clear-search" id="clearHospitalizationSearch" style="display: {{ request('search') ? 'block' : 'none' }};">
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
                            <i class="fas fa-building"></i>
                            <span>@lang('words.all')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="under_treatment" {{ request('status') == 'under_treatment' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-heartbeat" style="color: #27ae60;"></i>
                            <span>@lang('words.under_treatment')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="waiting_for_bed" {{ request('status') == 'waiting_for_bed' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-clock" style="color: #f59e0b;"></i>
                            <span>@lang('words.waiting_for_bed')</span>
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
                    <select name="department" id="hospitalizationDepartmentSelect">
                        <option value="all" {{ request('department') == 'all' || !request('department') ? 'selected' : '' }}>@lang('words.all_departments')</option>
                        @foreach($departments ?? [] as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn-clear" id="resetHospitalizationFilters">
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

<div class="filter-overlay" id="hospitalizationFilterOverlay"></div>