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
                    <input type="text" class="modern-input" name="search" id="searchInput" placeholder="Bemor nomi, test nomi..." value="{{ request('search') }}">
                    <button type="button" class="clear-search" id="clearSearch" style="display: {{ request('search') ? 'block' : 'none' }};">
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
                        <input type="radio" name="status" value="pending" {{ request('status') == 'pending' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-clock" style="color: #f39c12;"></i>
                            <span>@lang('words.pending')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="inprogress" {{ request('status') == 'inprogress' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-spinner" style="color: #00BFFF;"></i>
                            <span>@lang('words.in_progress')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="completed" {{ request('status') == 'completed' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-check-circle" style="color: #27ae60;"></i>
                            <span>@lang('words.ready')</span>
                        </span>
                    </label>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-tag" style="color: #00BFFF;"></i>
                    @lang('words.type')
                </label>
                <div class="modern-select">
                    <select name="type" id="typeSelect">
                        <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }}>@lang('words.ready')</option>
                        <option value="test" {{ request('type') == 'test' ? 'selected' : '' }}>@lang('words.test')</option>
                        <option value="panel" {{ request('type') == 'panel' ? 'selected' : '' }}>@lang('words.panel')</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-bolt" style="color: #00BFFF;"></i>
                    @lang('words.urgency')
                </label>
                <div class="modern-select">
                    <select name="urgency" id="urgencySelect">
                        <option value="all" {{ request('urgency') == 'all' || !request('urgency') ? 'selected' : '' }}>@lang('words.all')</option>
                        <option value="emergency" {{ request('urgency') == 'emergency' ? 'selected' : '' }}>@lang('words.emergency')</option>
                        <option value="urgent" {{ request('urgency') == 'urgent' ? 'selected' : '' }}>@lang('words.urgent')</option>
                        <option value="normal" {{ request('urgency') == 'normal' ? 'selected' : '' }}>@lang('words.normal')</option>
                    </select>
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