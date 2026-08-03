<x-layouts.main.website>
    <x-slot:title>
        @lang('words.patients_list')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/receptionist.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main_page')
                    </a>
                </li>
                <li class="breadcrumb-item active">@lang('words.patients')</li>
            </ol>
        </nav>

        <!-- Search Card -->
        <div class="search-card mb-2">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0">@lang('words.patients_list')</h4>
                </div>
            </div>
        </div>
 
        <div class="action-bar">
            <div class="left-actions">
                <button class="filter-toggle-btn" id="filterToggleBtn">
                    <i class="fas fa-sliders-h"></i>
                    <span>@lang('words.filters')</span>
                    <span class="filter-count" id="filterCount">{{ $filter_count ?? 0 }}</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                
                <a href="{{ route('patient.create') }}" class="add-nurse-btn">
                    <i class="fas fa-plus"></i> @lang('words.add_patient')
                </a>
            </div>
        </div>  

        <!-- Filter Panel -->
        @include('partials.filters.receptionist')

        <div class="patients-table-container">
            <div class="table-wrapper">
                <div class="table-header">
                    <div class="table-actions">
                        <div class="action-right">
                            <div class="search-wrapper">
                                <form method="GET" action="{{ route('receptionist.index') }}" class="d-flex gap-2" style="position: relative;">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('words.search_by_name_phone')" value="{{ request('search') }}" style="padding-right: 80px;">
                                    @if(request('search'))
                                        <a href="{{ route('receptionist.index') }}" class="search-clear">
                                            ✕
                                        </a>
                                    @endif
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>@lang('words.patients')</th>
                            <th>@lang('words.phone')</th>
                            <th>@lang('words.birth_date')</th>
                            <th>@lang('words.gender')</th>
                            <th>@lang('words.last_visit')</th>
                            <th>@lang('words.visits')</th>
                            <th style="width: 80px;">@lang('words.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('partials.table-body.receptionist')
                    </tbody>
                </table> 
            </div>
                @include('partials.paginations.receptionist')
        </div>

        <!-- Stats -->
        @include('partials.stats.receptionist') 
    </div>

    <script src="{{ asset('temp2/js/receptionist.js') }}"></script>
</x-layouts.main.website>