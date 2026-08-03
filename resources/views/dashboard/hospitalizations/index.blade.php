<x-layouts.main.website>
    <x-slot:title>
        @lang('words.inpatients')
    </x-slot:title>

    <style>
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    @lang('words.inpatients')
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.inpatients')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="action-bar">
            <div class="left-actions">
                <button class="filter-toggle-btn" id="hospitalizationFilterToggleBtn">
                    <i class="fas fa-sliders-h"></i>
                    <span>@lang('words.filters')</span>
                    <span class="filter-count" id="hospitalizationFilterCount">0</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                @if(auth()->user()->hasRole('Admin'))
                <a href="" class="add-nurse-btn">
                    <i class="fas fa-plus"></i> @lang('words.add_new_patient')
                </a>
                @endif
            </div>
        </div>

        @include('partials.filters.statsional-patient')
        
        <div class="patients-table-container">
            <div class="table-header">
                <div class="table-actions"></div>
            </div>
            <div class="table-wrapper">
                <table class="patients-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('words.patient_name')</th>
                            <th>@lang('words.age')</th>
                            <th>@lang('words.department')</th>
                            <th>@lang('words.room')</th>
                            <th>@lang('words.status')</th>
                            <th>@lang('words.actions')</th>
                        </tr>
                    </thead>
                    <tbody id="hospitalizationsTableBody">
                    @include('partials.table-body.statsional-patient')
                    </tbody>
                </table>
            </div>
            
            @include('partials.pagination', ['paginator' => $hospitalizations])
        </div>

        @include('partials.stats', ['stats' => $stats])
    </div>

    <script src="{{ asset('temp2/js/statsional-patient.js') }}"></script>
    
</x-layouts.main.website>