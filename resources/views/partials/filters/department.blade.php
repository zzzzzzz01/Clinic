<div class="filter-panel" id="departmentFilterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> Filtrlar</h3>
        <button class="filter-close-btn" id="departmentFilterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="departmentFilterForm" method="GET" action="{{ url()->current() }}">
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-search" style="color: #00BFFF;"></i>
                    Qidiruv
                </label>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="modern-input" name="department_search" id="departmentSearchInput" placeholder="Bo'lim nomi..." value="{{ request('department_search') }}">
                    <button type="button" class="clear-search" id="departmentClearSearch" style="display: {{ request('department_search') ? 'block' : 'none' }};">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Holati -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-toggle-on" style="color: #00BFFF;"></i>
                    Holati
                </label>
                <div class="status-row">
                    <label class="radio-card">
                        <input type="radio" name="department_status" value="all" {{ request('department_status') == 'all' || !request('department_status') ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-building"></i>
                            <span>Barcha</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="department_status" value="active" {{ request('department_status') == 'active' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-check-circle" style="color: #27ae60;"></i>
                            <span>Faol</span>
                        </span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="department_status" value="inactive" {{ request('department_status') == 'inactive' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <i class="fas fa-times-circle" style="color: #dc3545;"></i>
                            <span>Nofaol</span>
                        </span>
                    </label>
                </div>
            </div>
            
            <!-- Qavat -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-layer-group" style="color: #00BFFF;"></i>
                    Qavat
                </label>
                <div class="modern-select">
                    <select name="department_floor" id="departmentFloorSelect">
                        <option value="all" {{ request('department_floor') == 'all' || !request('department_floor') ? 'selected' : '' }}>Barcha qavatlar</option>
                        <option value="1" {{ request('department_floor') == '1' ? 'selected' : '' }}>1-qavat</option>
                        <option value="2" {{ request('department_floor') == '2' ? 'selected' : '' }}>2-qavat</option>
                        <option value="3" {{ request('department_floor') == '3' ? 'selected' : '' }}>3-qavat</option>
                        <option value="4" {{ request('department_floor') == '4' ? 'selected' : '' }}>4-qavat</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn-clear" id="departmentResetFilters">
                    <i class="fas fa-redo-alt"></i>
                    Tozalash
                </button>
                <button type="submit" class="btn-apply" id="departmentApplyFilters">
                    <i class="fas fa-check"></i>
                    Qo'llash
                </button>
            </div>
        </form>
    </div>
</div>

<div class="filter-overlay" id="departmentFilterOverlay"></div>