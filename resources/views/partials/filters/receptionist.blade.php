<div class="filter-panel" id="filterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="filterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="filterForm" method="GET" action="{{ route('receptionist.index') }}">
            <!-- Jinsi -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-venus-mars" style="color: #00BFFF;"></i>
                    @lang('words.gender')
                </label>
                <div class="status-row">
                    <label class="radio-card">
                        <input type="radio" name="gender" value="all" {{ request('gender') == 'all' || !request('gender') ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-users"></i>
                            <span>@lang('words.all')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="gender" value="male" {{ request('gender') == 'male' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-mars" style="color: #3498db;"></i>
                            <span>@lang('words.male')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="gender" value="female" {{ request('gender') == 'female' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-venus" style="color: #e74c3c;"></i>
                            <span>@lang('words.female')</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Tug'ilgan sana -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-calendar-alt" style="color: #00BFFF;"></i>
                    @lang('words.birth_date_range')
                </label>
                <div class="date-range-wrapper">
                    <div class="date-input-group"> 
                        <input type="date" name="birth_date_from" class="modern-input" placeholder="@lang('words.from')" value="{{ request('birth_date_from') }}">
                    </div>
                    <div class="date-input-group"> 
                        <input type="date" name="birth_date_to" class="modern-input" placeholder="@lang('words.to')" value="{{ request('birth_date_to') }}">
                    </div>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn-clear" id="resetFilters">
                    <i class="fas fa-redo-alt"></i>
                    @lang('words.clear')
                </button>
                <button type="submit" class="btn-apply" id="applyFilters">
                    <i class="fas fa-check"></i>
                    @lang('words.apply')
                </button>
            </div>
        </form>
    </div>
</div>

<div class="filter-overlay" id="filterOverlay"></div>