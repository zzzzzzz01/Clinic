<x-layouts.main.website>
    <x-slot:title>
        @lang('words.sales_report')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/report-style.css') }}" />

    <div class="container-custom">
        {{-- Breadcrumb --}} 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.sales_report')
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.sales_report') (
                            @if($filterType == 'day')
                                {{ \Carbon\Carbon::parse($filterValue)->format('d.m.Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($filterValue . '-01')->format('F Y') }}
                            @endif
                            )
                        </h4>
                    </div>
                </div>
            </div>
        </div> 
 
        <div class="action-bar">
            <div class="left-actions">
                <button class="filter-toggle-btn" id="filterToggleBtn">
                    <i class="fas fa-sliders-h"></i>
                    <span>@lang('words.filters')</span>
                    <span class="filter-count" id="filterCount">0</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                
                <button class="btn-primary" id="printBtn">
                    <i class="fas fa-print"></i> @lang('words.print')
                </button> 
            </div>
            
            <div class="active-filters" id="activeFilters"></div>
        </div> 

        {{-- Filter Panel --}}
        @include('partials.filters.pharmacist-report') 

        {{-- Jadval --}} 
        <div class="report-table">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr style="border-bottom: 2px solid #e8edf2;">
                            @if($filterType == 'month')
                                <th style="width: 5%; border-bottom: 2px solid #e8edf2;">#</th>
                                <th style="width: 20%;">@lang('words.date')</th>
                                <th style="width: 30%;">@lang('words.total_sales')</th>
                                <th style="width: 25%;">@lang('words.total_revenue')</th>
                                <th style="width: 20%;">@lang('words.detail')</th>
                            @else
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">@lang('words.time')</th>
                                <th style="width: 44%;">@lang('words.products')</th>
                                <th >@lang('words.pharmacist.sales.payment_method')</th>
                                <th >@lang('words.total')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @include('partials.table-body.pharmacist-report')
                    </tbody> 
                </table>
            </div>
        </div> 

        <!-- Statistikalar -->
        @include('partials.stats.pharmacist-report') 
    </div>

    {{-- DAY DETAIL MODALS --}}
    @include('partials.modals.show-modals.report') 

    <script>
        // Blade dan JS ga ma'lumotlarni o'tkazish
        const lang = {
            day: '@lang('words.day')',
            month: '@lang('words.month')'
        };
        const defaultDate = '{{ date('Y-m-d') }}';
    </script>
    <script src="{{ asset('temp2/js/pharmacist-report.js') }}"></script>

</x-layouts.main.website>