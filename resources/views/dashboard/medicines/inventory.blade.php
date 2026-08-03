<x-layouts.main.website>
    <x-slot:title>
        @lang('words.pharmacy_inventory')
    </x-slot:title>

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.pharmacy_inventory')
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.pharmacy_inventory')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-4">
        <div class="action-bar">
            <div class="left-actions">
                <button class="filter-toggle-btn" id="filterToggleBtn">
                    <i class="fas fa-sliders-h"></i>
                    <span>@lang('words.filters')</span>
                    <span class="filter-count" id="filterCount">0</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                @if(auth()->user()->hasRole('Admin'))
                <a href="{{ route('medicine.receive') }}" class="add-nurse-btn">
                    <i class="fas fa-plus"></i> @lang('words.medication_intake')
                </a>
                @endif
            </div>
        </div>

        @include('partials.filters.medicine-inventory')

        <div class="inventory-table-container">
            <div class="table-header">
                <div class="table-actions">
                    <div class="action-right">
                        <div class="search-wrapper">
                            {{-- SEARCH FORM --}}
                            <form id="searchForm" method="GET" action="{{ route('medicine.inventory') }}" style="display: flex; width: 100%; position: relative;">
                                <i class="fas fa-search search-icon" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa; z-index: 1;"></i>
                                
                                <input type="text" name="search" class="modern-input-max" 
                                       placeholder="@lang('words.search_by_medicine_name')" 
                                       value="{{ $filterParams['search'] ?? '' }}"
                                       style="padding-left: 40px; padding-right: 40px; width: 100%;"
                                       id="tableSearchInput">
                                
                                @if($filterParams['hasSearch'] ?? false)
                                    <a href="{{ route('medicine.inventory', request()->except(['search', 'page'])) }}" 
                                       class="clear-search-table" 
                                       style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #999; cursor: pointer; z-index: 1; text-decoration: none;">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                                
                                @if($filterParams['hasCategory'] ?? false)
                                    <input type="hidden" name="category" value="{{ $filterParams['category'] }}">
                                @endif
                                
                                @if($filterParams['hasStockStatus'] ?? false)
                                    <input type="hidden" name="stock_status" value="{{ $filterParams['stockStatus'] }}">
                                @endif

                                <button type="submit" style="display: none;">Qidirish</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-wrapper">
                <table id="inventoryTable">
                    <thead>
                        <tr>
                            <th class="table-text">#</th>
                            <th class="table-text">@lang('words.name')</th>
                            <th class="table-text">@lang('words.category')</th>
                            <th class="table-text">@lang('words.manufacturer')</th>
                            <th class="table-text">@lang('words.stock_boxes')</th>
                            <th class="table-text">@lang('words.unit')</th>
                            <th class="table-text">@lang('words.status')</th>
                            <th class="table-text">@lang('words.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('partials.table-body.medicine-inventory')
                    </tbody>
                </table>
            </div>

            @include('partials.paginations.medicine-inventory')

        </div>
    </div> 

    <div class="container">
        @include('partials.stats.medicine-inventory')
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search input Enter bosilganda submit qilish
            var searchInput = document.getElementById('tableSearchInput');
            var searchForm = document.getElementById('searchForm');
            
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchForm.submit();
                    }
                });
            }
        });
    </script>
</x-layouts.main.website>