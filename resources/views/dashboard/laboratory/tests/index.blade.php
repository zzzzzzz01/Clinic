<x-layouts.main.website>
    <x-slot:title>@lang('words.tests_list')</x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/laboratory.css') }}" />

    <div class="main-content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main.page')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('words.tests_list')</li>
                </ol>
            </nav>

            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="mb-0">@lang('words.tests_list')</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="testFilterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filters')</span>
                        <span class="filter-count" id="testFilterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    
                    <button class="add-nurse-btn" id="openTestCreateModal">
                        <i class="fas fa-plus"></i> @lang('words.create_new_test')
                    </button>
                </div>
            </div>

            @include('partials.filters.test')  
            
            <div class="tests-container">
                @foreach($tests as $test)
                <div class="test-card" 
                     data-id="{{ $test->id }}" 
                     data-code="{{ $test->code }}" 
                     data-name="{{ $test->name }}" 
                     data-unit="{{ $test->unit }}" 
                     data-low="{{ $test->normal_min }}" 
                     data-high="{{ $test->normal_max }}" 
                     data-price="{{ $test->price }}" 
                     data-duration="{{ $test->duration }}"
                     data-status="{{ $test->is_active }}">
                    
                    <div class="test-card-header">
                        <div class="test-card-title">{{ $test->name }}</div>
                        <div class="test-code">{{ $test->code }}</div>
                    </div>
                    
                    <div class="test-card-body">
                        <div class="test-info-row">
                            <span class="test-info-label">@lang('words.price'):</span>
                            <span class="test-info-value">{{ $test->price }} $</span>
                        </div>
                        
                        <div class="test-info-row">
                            <span class="test-info-label">@lang('words.unit'):</span>
                            <span class="test-info-value">{{ $test->unit }}</span>
                        </div>

                        <div class="test-info-row">
                            <span class="test-info-label">@lang('words.duration'):</span>
                            <span class="test-info-value">{{ $test->duration }} @lang('words.hours')</span>
                        </div>
                        
                        <div class="normal-range">
                            <div class="range-title">
                                <i class="fas fa-chart-line"></i> @lang('words.normal_range'):
                            </div>
                            <div class="range-values">
                                <span class="range-value">{{ $test->normal_min }}</span>
                                <span class="range-separator">—</span>
                                <span class="range-value">{{ $test->normal_max }}</span>
                            </div>
                        </div>
                        
                        <div class="test-info-row">
                            <span class="test-info-label">@lang('words.status'):</span>
                            <span class="test-status {{ $test->is_active == 1 ? 'status-available' : 'status-unavailable' }}">
                                <i class="fas {{ $test->is_active == 1 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $test->is_active == 1 ? __('words.available') : __('words.unavailable') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="test-actions">
                        <button class="btn btn-primary btn-sm" onclick="viewTest(this)">
                            <i class="fas fa-eye"></i> @lang('words.view')
                        </button>
                        <button class="btn btn-warning btn-sm" onclick="openUpdateModal(this)">
                            <i class="fas fa-edit"></i> @lang('words.edit')
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="openTestDeleteModal(this)">
                            <i class="fas fa-trash"></i> @lang('words.delete')
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            @include('partials.pagination', ['paginator' => $tests])
        </div>
    </div>

    <!-- Ko'rish modal -->
    @include('partials.modals')

    <!-- O'chirish modali -->
    @include('partials.delete-modal')

    <script src="{{ asset('temp2/js/laboratory.js') }}"></script>
    
</x-layouts.main.website>