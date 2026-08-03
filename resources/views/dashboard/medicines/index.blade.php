<x-layouts.main.website>
    <x-slot:title>
        @lang('words.medicines_list')
    </x-slot:title>

    <div class="main-content">
        <div class="container pt-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none"> 
                            <i class="fas fa-home"></i> @lang('words.main.page')
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" style="color: #808080;" class="text-decoration-none">
                            @lang('words.medicines_list')
                        </a>
                    </li>
                </ol>
            </nav>
            
            <!-- Search -->
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.medicines_list')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="medicineFilterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filters')</span>
                        <span class="filter-count" id="medicineFilterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    
                    @if(auth()->user()->hasRole('Admin'))
                    <a href="{{ route('medicines.create') }}" class="add-nurse-btn">
                        <i class="fas fa-plus"></i> @lang('words.new_medicine')
                    </a>
                    @endif
                </div>
                
                <div class="active-filters" id="medicineActiveFilters"></div>
            </div>

            <!-- Filter Panel -->
            @include('partials.filters.medicine')
            
            <div class="medicine-table-container">

                <div class="table-header">
                    <div class="table-actions">
                        <div class="action-right">
                            <div class="search-wrapper">
                                <input type="text" class="modern-input-max" id="medicineMainSearchInput" placeholder="@lang('words.search_medicine_placeholder')">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th style="width: 0;">@lang('words.name')</th>
                                <th class="text-center">@lang('words.medicine_type')</th>
                                <th class="text-center">@lang('words.dose')</th>
                                <th class="text-center">@lang('words.unit')</th>
                                <th style="width: 0;">@lang('words.supplier')</th>
                                <th class="text-center">@lang('words.price')</th>
                                <th class="text-center">@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody id="medicinesTableBody">
                        @include('partials.table-body.medicine-index')
                        </tbody>
                    </table>
                </div>
                
                @include('partials.pagination', ['paginator' => $medicines])
            </div>
            
            <!-- Stats Grid - Alohida include qilindi -->
            @include('partials.stats', ['stats' => $stats])
        </div>
    </div>

    <!-- O'chirish modali -->
    @include('partials.delete-modal')
</x-layouts.main.website>