<x-layouts.main.website>
    <x-slot:title>
        @lang('words.suppliers')
    </x-slot:title>

    <div class="main-content">
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
                            @lang('words.suppliers')
                        </a>
                    </li>
                </ol>
            </nav>
            
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.suppliers_list')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="supplierFilterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filters')</span>
                        <span class="filter-count" id="filterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    
                    <a href="{{ route('suppliers.create') }}" class="add-nurse-btn">
                        <i class="fas fa-plus"></i> @lang('words.add_supplier')
                    </a>
                </div>
                
                <div class="active-filters" id="activeFilters"></div>
            </div>

            <!-- Filter Panel -->
            @include('partials.filters.suppliers')
            
            <div class="suppliers-table-container">

                <div class="table-header">
                    <div class="table-actions">
                        <div class="action-right">
                            <div class="search-wrapper">
                                <input type="text" class="modern-input-max" id="supplierMainSearchInput" placeholder="@lang('words.search_supplier')">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-wrapper">
                    <table class="suppliers-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>@lang('words.supplier')</th>
                                <th class="text-center">@lang('words.type')</th>
                                <th class="text-center">@lang('words.contact')</th>
                                <th class="text-center">@lang('words.address')</th>
                                <th class="text-center">@lang('words.status')</th>
                                <th class="text-center">@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody id="suppliersTableBody">
                        @include('partials.table-body.suppliers')
                        </tbody>
                    </table>
                </div>
                
                @include('partials.pagination', ['paginator' => $paginator])
            </div>
            
            @include('partials.stats', ['stats' => $stats])
        </div>
    </div>

    <!-- Modallar -->
    @include('partials.delete-modal')

</x-layouts.main.website>