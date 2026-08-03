<x-layouts.main.website>
    <x-slot:title>
        @lang('words.edit')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/test-panel.css') }}" />
    
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
                        <a href="{{ route('tests.panels') }}">@lang('words.test_panels')</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $panel->name }}
                    </li>
                </ol>
            </nav>

            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="mb-0">{{ $panel->name }}</h4>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <form id="editTestForm" action="{{ route('test-panel.update', $panel) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="name_uz" class="form-label">
                                    <i class="fas fa-file-signature"></i> @lang('words.panel_name') (Узбекский)
                                </label>
                                <input type="text" name="name_uz" class="form-control" id="name_uz" value="{{ $panel->name_uz }}">
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label for="name_ru" class="form-label">
                                    <i class="fas fa-file-signature"></i> @lang('words.panel_name') (Русский)
                                </label>
                                <input type="text" name="name_ru" class="form-control" id="name_ru" value="{{ $panel->name_ru }}">
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label for="name_en" class="form-label">
                                    <i class="fas fa-file-signature"></i> @lang('words.panel_name') (Английский)
                                </label>
                                <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $panel->name_en }}">
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="code" class="form-label">
                                    <i class="fas fa-barcode"></i> @lang('words.code')
                                </label>
                                <input type="text" name="code" class="form-control" id="code" value="{{ $panel->code }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label for="department_id" class="form-label">
                                    <i class="fas fa-hospital"></i> @lang('words.department')
                                </label>
                                <select name="department_id" class="form-control" id="department_id">
                                    <option value="">@lang('words.select_department')</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $panel->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name_uz ?? $department->name_ru ?? $department->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label for="price" class="form-label">
                                    <i class="fas fa-money-bill-wave"></i> @lang('words.price') ($)
                                </label>
                                <input type="number" name="price" class="form-control" id="price" value="{{ $panel->price }}" min="0">
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label for="time" class="form-label">
                                    <i class="fas fa-clock"></i> @lang('words.time_hours_input')
                                </label>
                                <input type="number" name="time" class="form-control" id="time" value="{{ $panel->time }}" min="1">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="status" class="form-label">
                                    <i class="fas fa-power-off"></i> @lang('words.status')
                                </label>
                                <select name="status" class="form-control" id="status">
                                    <option value="1" {{ $panel->status == 1 ? 'selected' : '' }}>@lang('words.active')</option>
                                    <option value="0" {{ $panel->status == 0 ? 'selected' : '' }}>@lang('words.inactive')</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    
                    <div class="form-group">
                        <label for="description_uz" class="form-label">
                            <i class="fas fa-align-left"></i> @lang('words.description_uz')
                        </label>
                        <textarea name="description_uz" class="form-control" id="description_uz" rows="2">{{ $panel->description_uz }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="description_ru" class="form-label">
                            <i class="fas fa-align-left"></i> @lang('words.description_ru')
                        </label>
                        <textarea name="description_ru" class="form-control" id="description_ru" rows="2">{{ $panel->description_ru }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="description_en" class="form-label">
                            <i class="fas fa-align-left"></i> @lang('words.description_en')
                        </label>
                        <textarea name="description_en" class="form-control" id="description_en" rows="2">{{ $panel->description_en }}</textarea>
                    </div>
                </div> 
                
                <div class="search-card">
                    <div class="tests-header-stats">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fas fa-vial"></i></div>
                            <div class="stat-info">
                                <div class="stat-value" id="totalTestsCount">{{ $panelTests->count() }}</div>
                                <div class="stat-label">@lang('words.tests_count')</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon" style="background: var(--secondary-color);"><i class="fas fa-dollar-sign"></i></div>
                            <div class="stat-info">
                                <div class="stat-value" id="totalPrice">${{ number_format($panelTests->sum('price'), 2) }}</div>
                                <div class="stat-label">@lang('words.total_price')</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon" style="background: var(--warning-color);"><i class="fas fa-clock"></i></div>
                            <div class="stat-info">
                                <div class="stat-value" id="totalTime">{{ $panelTests->sum('duration') }} @lang('words.hours')</div>
                                <div class="stat-label">@lang('words.total_time')</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tests-main-section">
                    
                    <input type="hidden" name="selected_tests" id="selectedTestsInput" value="{{ $panelTests->pluck('id')->implode(',') }}">
                    
                    <div class="selected-tests-main">
                        <div class="selected-tests-header">
                            <h5>
                                <i class="fas fa-list-check"></i>
                                @lang('words.selected_tests_list')
                                <span class="selected-tests-count" id="selectedTestsCount">{{ $panelTests->count() }}</span>
                            </h5>
                            <div class="tests-section">
                                <div class="tests-actions">
                                    <button type="button" class="btn-primary" id="openTestModal">
                                        <i class="fas fa-plus-circle"></i> @lang('words.add_tests')
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="selected-tests-grid" id="selectedTestsContainer">
                            @foreach($panelTests as $test)
                                <div class="selected-test-card" data-test-id="{{ $test->id }}">
                                    <div class="selected-test-info">
                                        <div class="selected-test-header">
                                            <span class="selected-test-name">{{ $test->name_uz ?? $test->name_ru ?? $test->name_en }}</span>
                                            <span class="selected-test-code"><i class="fas fa-hashtag"></i> {{ $test->code }}</span>
                                            <div class="selected-test-price">${{ number_format($test->price, 2) }}</div>
                                        </div>
                                        <div class="selected-test-duration"><i class="fas fa-clock"></i> {{ $test->duration }} @lang('words.hours')</div>
                                        <div class="selected-test-meta">
                                            <div class="meta-item"><i class="fas fa-flask"></i> @lang('words.laboratory')</div>
                                            <div class="meta-item"><i class="fas fa-check-circle"></i> {{ $test->status == 1 ? __('words.active') : __('words.inactive') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($panelTests->count() === 0)
                                <div class="no-tests">
                                    <i class="fas fa-vial"></i>
                                    <h5>@lang('words.no_tests_added')</h5>
                                    <button type="button" class="btn btn-outline" id="openTestModal2">@lang('words.add_tests')</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="form-footer">
                    <div class="form-actions">
                        <a href="{{ route('tests.panels') }}" class="btn-secondary">
                            <i class="fas fa-times"></i> @lang('words.cancel')
                        </a>
                        <button type="submit" class="btn-primary" id="saveButton">
                           @lang('words.save')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TEST QO'SHISH MODALI -->
    @include('partials.modals.create-modals.test-panel-edit')

    <script src="{{ asset('temp2/js/test-panel.js') }}"></script>

</x-layouts.main.website>