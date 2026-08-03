<x-layouts.main.website>
    <x-slot:title>@lang('words.department_management')</x-slot:title>

    <div class="main-content">
        <div class="container pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main_page')
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" style="color: #808080;">@lang('words.department_management')</a> 
                    </li>
                </ol>
            </nav>
            
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.department_management')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="departmentFilterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filter')</span> 
                        <span class="filter-count" id="departmentFilterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>

                    <a href="{{ route('department.create') }}" class="add-nurse-btn">
                        <i class="fas fa-plus"></i> @lang('words.new_department')
                    </a> 
                </div>
            </div>

            @include('partials.filters.department')
            
            <div class="departments-table-container">
                <div class="table-header">
                    <div class="table-actions">
                        <div class="action-right">
                            <div class="search-wrapper">
                                <input type="text" class="modern-input-max" id="departmentTableSearchInput" placeholder="@lang('words.search_by_department')">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('words.department_name')</th>
                                <th>@lang('words.head_doctor')</th>
                                <th>@lang('words.rooms') / @lang('words.beds')</th>
                                <th style="text-align: center">@lang('words.staff')</th>
                                <th>@lang('words.status')</th>
                                <th>@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('partials.table-body.department')
                        </tbody>
                    </table>
                </div> 

                @include('partials.paginations.department')

            </div>
            
            @include('partials.stats.department-index')
        </div>
    </div> 

    <!-- O'chirish dialogi -->
    @include('partials.modals.delete-modals.department')

    <!-- Bo'limni Tahrirlash Modal Oynasi -->
    @include('partials.modals.edit-modals.department')

    <!-- Xodimlar Modal --> <!-- Xodimlar Modal --> 
    @include('partials.modals.show-modals.department')


    <script>
        // Laravel til xabarlarini JS ga uzatish
        const lang = {
            loading: '@lang('words.loading')',
            no_staff: '@lang('words.no_staff')',
            error_occurred: '@lang('words.error_occurred')',
            deleting: '@lang('words.deleting')',
            saving: '@lang('words.saving')'
        };
    </script>
    <script src="{{ asset('temp2/js/department.js') }}"></script>

</x-layouts.main.website>