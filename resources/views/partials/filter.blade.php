 







<!-- Filter Panel -->
<div class="filter-panel" id="roomFilterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> Filtrlar</h3>
        <button class="filter-close-btn" id="roomFilterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="roomFilterForm" method="GET" action="{{ route('room.index') }}">
            <!-- Qidiruv -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-search" style="color: #00BFFF;"></i>
                    Qidiruv
                </label>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="modern-input" name="search" id="roomSearchInput" placeholder="Xona raqami..." value="{{ request('search') }}">
                    <button type="button" class="clear-search" id="roomClearSearch" style="display: {{ request('search') ? 'block' : 'none' }};">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Xona holati -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-door-open" style="color: #00BFFF;"></i>
                    Xona holati
                </label>
                <div class="status-row">
                    <label class="radio-card">
                        <input type="radio" name="status" value="all" {{ request('status') == 'all' || !request('status') ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-building"></i>
                            <span>Barcha</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="available" {{ request('status') == 'available' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-check-circle" style="color: #27ae60;"></i>
                            <span>Mavjud</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="empty" {{ request('status') == 'empty' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-door-open" style="color: #8B4513;"></i>
                            <span>Bo'sh</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="full" {{ request('status') == 'full' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-bed" style="color: #f59e0b;"></i>
                            <span>To'liq</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="status" value="maintenance" {{ request('status') == 'maintenance' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-tools" style="color: #dc3545;"></i>
                            <span>Ta'mirda</span>
                        </span>
                    </label>
                </div>
            </div>
            
            <!-- Bo'lim -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-building" style="color: #00BFFF;"></i>
                    Bo'lim
                </label>
                <div class="modern-select">
                    <select name="department" id="roomDepartmentSelect">
                        <option value="all" {{ request('department') == 'all' || !request('department') ? 'selected' : '' }}>Barcha bo'limlar</option>
                        @foreach($options as $option)
                        <option value="{{ $option->id }}" {{ request('department') == $option->id ? 'selected' : '' }}>
                            {{ $option->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Qavat -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-layer-group" style="color: #00BFFF;"></i>
                    Qavat
                </label>
                <div class="modern-select">
                    <select name="floor" id="roomFloorSelect">
                        <option value="all" {{ request('floor') == 'all' || !request('floor') ? 'selected' : '' }}>Barcha qavatlar</option>
                        <option value="1" {{ request('floor') == '1' ? 'selected' : '' }}>1-qavat</option>
                        <option value="2" {{ request('floor') == '2' ? 'selected' : '' }}>2-qavat</option>
                        <option value="3" {{ request('floor') == '3' ? 'selected' : '' }}>3-qavat</option>
                        <option value="4" {{ request('floor') == '4' ? 'selected' : '' }}>4-qavat</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn-clear" id="roomResetFilters">
                    <i class="fas fa-redo-alt"></i>
                    Tozalash
                </button>
                <button type="submit" class="btn-apply">
                    <i class="fas fa-check"></i>
                    Qo'llash
                </button>
            </div>
        </form>
    </div>
</div>

<div class="filter-overlay" id="roomFilterOverlay"></div>


 







