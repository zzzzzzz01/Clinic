<!-- Medicine Filter Panel -->
<div class="filter-panel" id="medicineFilterPanel">
    <div class="filter-panel-header">
        <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
        <button class="filter-close-btn" id="medicineFilterCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="filter-panel-body">
        <form id="medicineFilterForm" method="GET" action="{{ url()->current() }}">
            <!-- Turi (Form) -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-capsules" style="color: #00BFFF;"></i>
                    @lang('words.medicine_type')
                </label>
                <div class="modern-select">
                    <select name="form" id="medicineFormSelect">
                        <option value="all" {{ request('form') == 'all' || !request('form') ? 'selected' : '' }}>@lang('words.all_types')</option>
                        <option value="tabletka" {{ request('form') == 'tabletka' ? 'selected' : '' }}>@lang('words.tablets')</option>
                        <option value="kapsula" {{ request('form') == 'kapsula' ? 'selected' : '' }}>@lang('words.capsules')</option>
                        <option value="sirop" {{ request('form') == 'sirop' ? 'selected' : '' }}>@lang('words.syrups')</option>
                        <option value="maz" {{ request('form') == 'maz' ? 'selected' : '' }}>@lang('words.ointments')</option>
                        <option value="in'ektsiya" {{ request('form') == 'in\'ektsiya' ? 'selected' : '' }}>@lang('words.injections')</option>
                    </select>
                </div>
            </div>
            
            <!-- Kategoriya -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-tag" style="color: #00BFFF;"></i>
                    @lang('words.category')
                </label>
                <div class="modern-select">
                    <select name="category" id="medicineCategorySelect">
                        <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>@lang('words.all_categories')</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Narx oralig'i -->
            <div class="filter-section">
                <label class="filter-label">
                    <i class="fas fa-dollar-sign" style="color: #00BFFF;"></i>
                    @lang('words.price_range')
                </label>
                <div class="price-range">
                    <div class="price-input-group">
                        <i class="fas fa-dollar-sign"></i>
                        <input type="number" class="modern-price-input" name="min_price" id="medicineMinPrice" value="{{ request('min_price') }}" placeholder="@lang('words.min_price')">
                    </div>
                    <span class="price-separator">—</span>
                    <div class="price-input-group">
                        <i class="fas fa-dollar-sign"></i>
                        <input type="number" class="modern-price-input" name="max_price" id="medicineMaxPrice" value="{{ request('max_price') }}" placeholder="@lang('words.max_price')">
                    </div>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn-clear" id="medicineResetFilters">
                    <i class="fas fa-redo-alt"></i>
                    @lang('words.clear')
                </button>
                <button type="submit" class="btn-apply" id="medicineApplyFilters">
                    <i class="fas fa-check"></i>
                    @lang('words.apply')
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Medicine Filter Panel -->
<div class="filter-overlay" id="medicineFilterOverlay"></div>