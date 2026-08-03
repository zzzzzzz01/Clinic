<x-layouts.main.website>
    <x-slot:title>
    @lang('words.doctors.list')
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
                            @lang('words.doctors.list')
                        </a>
                    </li>
                </ol>
            </nav>
            
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.doctors.list')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="filterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filters')</span>
                        <span class="filter-count" id="filterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    
                    <a href="{{ route('doctors.create') }}" class="add-nurse-btn">
                        <i class="fas fa-plus"></i> @lang('words.create_new')
                    </a>
                </div>
                
                <div class="active-filters" id="activeFilters"></div>
            </div>

            <!-- FILTER PANEL -->
            @include('partials.filters.doctors')

            <div class="patients-table-container">
                <div class="table-header">
                    <div class="table-actions"></div>
                </div>
                
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('words.full_name')</th>
                                <th>@lang('words.department')</th>
                                <th>@lang('words.experience')</th>
                                <th>@lang('words.phone')</th>
                                <th>
                                    <span class="full-text">@lang('words.hired_date')</span>
                                    <span class="short-text">@lang('words.short_date')</span>
                                </th>
                                <th>@lang('words.status')</th>
                                <th>@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @include('partials.table-body.doctors')
                        </tbody>
                    </table>
                </div>
                
                @include('partials.paginations.doctors')
            </div>
            
            <!-- Stats Grid -->
            @include('partials.stats.doctors')
        </div>
    </div>

    <!-- MODALLAR -->
    @include('partials.delete-modal')
    @include('partials.notification-modal')  
</x-layouts.main.website>