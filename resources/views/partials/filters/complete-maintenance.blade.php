<div class="filter-panel" id="filterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="filterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="filterForm" method="GET" action="{{ route('room.index') }}">
            <!-- Qidiruv -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-search" style="color: #00BFFF;"></i>
                    @lang('words.search')
                </label>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="modern-input" name="search" id="searchInput" placeholder="@lang('words.search_by_room_number')" value="{{ request('search') }}">
                    <button type="button" class="clear-search" id="clearSearch" style="display: {{ request('search') ? 'block' : 'none' }};">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Xona holati -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-door-open" style="color: #00BFFF;"></i>
                    @lang('words.room_status')
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
                        <input type="radio" name="status" value="available" {{ request('status') == 'available' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-check-circle" style="color: #27ae60;"></i>
                            <span>@lang('words.available')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="empty" {{ request('status') == 'empty' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-door-open" style="color: #8B4513;"></i>
                            <span>@lang('words.empty')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="full" {{ request('status') == 'full' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-bed" style="color: #f59e0b;"></i>
                            <span>@lang('words.full')</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="maintenance" {{ request('status') == 'maintenance' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-tools" style="color: #dc3545;"></i>
                            <span>@lang('words.maintenance')</span>
                        </span>
                    </label>
                </div>
            </div>
            
            <!-- Bo'lim -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-building" style="color: #00BFFF;"></i>
                    @lang('words.department')
                </label>
                <div class="modern-select">
                    <select name="department" id="departmentSelect">
                        <option value="all" {{ request('department') == 'all' || !request('department') ? 'selected' : '' }}>@lang('words.all_departments')</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Qavat -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-layer-group" style="color: #00BFFF;"></i>
                    @lang('words.floor')
                </label>
                <div class="modern-select">
                    <select name="floor" id="floorSelect">
                        <option value="all" {{ request('floor') == 'all' || !request('floor') ? 'selected' : '' }}>@lang('words.all_floors')</option>
                        <option value="1" {{ request('floor') == '1' ? 'selected' : '' }}>@lang('words.floor_1')</option>
                        <option value="2" {{ request('floor') == '2' ? 'selected' : '' }}>@lang('words.floor_2')</option>
                        <option value="3" {{ request('floor') == '3' ? 'selected' : '' }}>@lang('words.floor_3')</option>
                        <option value="4" {{ request('floor') == '4' ? 'selected' : '' }}>@lang('words.floor_4')</option>
                    </select>
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