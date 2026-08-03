<x-layouts.main.website>
    <x-slot:title>
        @lang('words.nurses_list')
    </x-slot:title>

    
<style>
    @media (max-width: 576px) {
        .phone-display {
            display: none !important; 
        }
    }
</style>



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
                            @lang('words.nurses_list')
                        </a>
                    </li>
                </ol>
            </nav>
            <!-- Search -->
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.nurses_list')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="nurseFilterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filters')</span>
                        <span class="filter-count" id="nurseFilterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    
                    <a href="{{ route('nurses.create') }}" class="add-nurse-btn">
                        <i class="fas fa-plus"></i> @lang('words.add_new_nurse')
                    </a>
                </div>
                
                <div class="active-filters" id="nurseActiveFilters"></div>
            </div>

            <!-- FILTER PANEL -->
            @include('partials.filters.nurses')
            
            <div class="patients-table-container">
                <div class="table-header">
                    <div class="table-actions">
                    </div>
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
                        @include('partials.table-body.nurses')
                        </tbody>
                    </table>
                </div>
                
                @include('partials.paginations.nurses')
            </div>
            
            <!-- NURSE STATS -->
            @include('partials.stats.nurses')
        </div>
    </div>

    <!-- MODALLAR -->
    @include('partials.delete-modal')
    @include('partials.notification-modal')
    @include('partials.alert')
    
</x-layouts.main.website>