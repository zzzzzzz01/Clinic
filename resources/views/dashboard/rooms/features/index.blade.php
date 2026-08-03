<x-layouts.main.website>
    <x-slot:title>
        @lang('words.features_management') 
    </x-slot:title>

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
                        @lang('words.features_management')
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper"> 
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0"> @lang('words.all_features') </h4>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Chap qism -->
            <div class="col-lg-8">
                <div class="features-table-container">
                    <table class="features-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('words.name')</th>
                                <th>@lang('words.created_date')</th>
                                <th>@lang('words.status')</th>
                                <th>@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody id="featuresTableBody">
                        @foreach($formattedFeatures as $feature)
                        <tr onclick="handleRowClick(event, 
                            {{ $feature->id }}, 
                            '{{ addslashes($feature->name_uz) }}', 
                            '{{ addslashes($feature->name_ru) }}', 
                            '{{ addslashes($feature->name_en) }}', 
                            '{{ addslashes($feature->description_uz) }}', 
                            '{{ addslashes($feature->description_ru) }}', 
                            '{{ addslashes($feature->description_en) }}', 
                            {{ $feature->status }})"
                            data-id="{{ $feature->id }}"
                            style="cursor: pointer;">
                            <td class="row-number">{{ $loop->iteration }}</td>
                            <td>
                                <div class="department-name">{{ $feature->name }}</div>
                                <div class="department-floor">{{ $feature->description }}</div>
                            </td>
                            <td>
                                <div class="hite-date-main">
                                    <div class="hire-date">{{ \Carbon\Carbon::parse($feature->created_at)->format('d.m.Y') }}</div>
                                </div>
                            </td>
                            <td><span class="status-badge" style="color: {{ $feature->status_text_color }}; background-color: {{ $feature->status_bg_color }};"><i class="{{ $feature->status_icon }}"></i> {{ $feature->status_text }}</span></td>
                            <td>
                                <div class="action-dropdown" data-dropdown-id="dropdown-{{ $feature->id }}">

                                    <span class="action-dots" onclick="event.stopPropagation(); toggleDropdown(this, event)">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </span>

                                    <div class="dropdown-content" id="dropdown-{{ $feature->id }}">
                                        
                                        <a href="javascript:void(0)" class="text-primary" onclick="event.stopPropagation(); openEditFeatureModal(event, 
                                               {{ $feature->id }}, 
                                               '{{ addslashes($feature->name_uz) }}', 
                                               '{{ addslashes($feature->name_ru) }}', 
                                               '{{ addslashes($feature->name_en) }}', 
                                               '{{ addslashes($feature->description_uz) }}', 
                                               '{{ addslashes($feature->description_ru) }}', 
                                               '{{ addslashes($feature->description_en) }}', 
                                               {{ $feature->status }})">
                                            <i class="fas fa-edit"></i> Tahrirlash 
                                        </a>

                                        <a href="javascript:void(0)" 
                                            class="text-danger" 
                                            onclick="event.stopPropagation(); openFeatureDeleteModal(
                                                {{ $feature->id }},
                                                '{{ addslashes($feature->name_uz) }}',
                                                {{ $feature->status }}
                                            )">
                                                <i class="fas fa-trash"></i> @lang('words.delete')
                                            </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pagination">
                        <div class="pagination-info">
                            {{ $features->firstItem() }} - {{ $features->lastItem() }} @lang('words.from') {{ $features->total() }} @lang('words.records')
                        </div>
                        <div class="pagination-controls">
                            @if($features->onFirstPage())
                                <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                            @else
                                <a href="{{ $features->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                            @endif

                            @foreach(range(1, $features->lastPage()) as $page)
                                @if($page == $features->currentPage())
                                    <button class="page-btn active">{{ $page }}</button>
                                @else
                                    <a href="{{ $features->url($page) }}" class="page-btn">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($features->hasMorePages())
                                <a href="{{ $features->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                            @else
                                <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- O'ng qism -->
            <div class="col-lg-4">
                <div class="mobile-quick-actions">
                    <button class="btn-success w-100" style="display: flex; justify-content: center;" onclick="openCreateFeatureModal()">
                        <i class="fas fa-magic"></i>
                        @lang('words.create_new_feature')
                    </button>
                </div>
                <div class="departments-table-container">

                    <!-- EDIT FORM -->
                    <div class="desktop-form" id="featureEditFormContainer" style="display: none;">
                        <div class="desktop-form-header">
                            <h4>@lang('words.edit_feature')</h4>
                        </div>
                        <div class="desktop-form-body">
                            <form action="" method="POST" id="featureEditForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" id="featureId">
                                
                                <div class="form-group">
                                    <label class="notification-label">@lang('words.name_uz')</label>
                                    <input type="text" class="form-control" name="name_uz" id="featureNameUz" required>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.name_ru')</label>
                                    <input type="text" class="form-control" name="name_ru" id="featureNameRu" required>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.name_en')</label>
                                    <input type="text" class="form-control" name="name_en" id="featureNameEn" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="notification-label">@lang('words.description_uz')</label>
                                    <textarea class="form-control" name="description_uz" id="featureDescriptionUz" rows="2"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.description_ru')</label>
                                    <textarea class="form-control" name="description_ru" id="featureDescriptionRu" rows="2"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.description_en')</label>
                                    <textarea class="form-control" name="description_en" id="featureDescriptionEn" rows="2"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label class="notification-label">@lang('words.status')</label>
                                    <select class="form-control" name="status" id="featureStatus" required>
                                        <option value="1">{{ __('words.active') }}</option>
                                        <option value="0">{{ __('words.inactive') }}</option>
                                    </select>
                                </div>
                                
                                <div class="desktop-form-footer">
                                    <button type="button" class="btn-secondary" onclick="resetToCreateForm()">
                                        <i class="fas fa-times"></i> @lang('words.cancel')
                                    </button>
                                    <button type="submit" class="btn-primary">
                                        @lang('words.save')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- CREATE FORM -->
                    <div class="desktop-form" id="featureCreateFormContainer">
                        <div class="desktop-form-header">
                            <h4>@lang('words.add_new_feature')</h4>
                        </div>
                        <div class="desktop-form-body">
                            <form action="{{ route('features.store') }}" method="POST" id="featureCreateForm">
                                @csrf
                                
                                <div class="form-group">
                                    <label class="notification-label">@lang('words.name_uz')</label>
                                    <input type="text" class="form-control" name="name_uz" placeholder="@lang('words.example_wifi')" required>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.name_ru')</label>
                                    <input type="text" class="form-control" name="name_ru" placeholder="@lang('words.example_wifi_ru')" required>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.name_en')</label>
                                    <input type="text" class="form-control" name="name_en" placeholder="@lang('words.example_wifi_en')" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="notification-label">@lang('words.description_uz')</label>
                                    <textarea class="form-control" name="description_uz" rows="2" placeholder="@lang('words.description_uz_placeholder')"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.description_ru')</label>
                                    <textarea class="form-control" name="description_ru" rows="2" placeholder="@lang('words.description_ru_placeholder')"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="notification-label">@lang('words.description_en')</label>
                                    <textarea class="form-control" name="description_en" rows="2" placeholder="@lang('words.description_en_placeholder')"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label class="notification-label">@lang('words.status')</label>
                                    <select class="form-control" name="status" required>
                                        <option value="1" selected>{{ __('words.active') }}</option>
                                        <option value="0">{{ __('words.inactive') }}</option>
                                    </select>
                                </div>
                                
                                <div class="desktop-form-footer">
                                    <button type="submit" class="btn-primary" style="width: 100%;display: flex; justify-content: center;">
                                         @lang('words.save')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Statistika -->
                    <div class="glass-card">
                        <h5 class="mb-3">@lang('words.statistics')</h5>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="fw-bold text-primary">{{ $features->total() }}</div>
                                <small class="department-name"> @lang('words.total') </small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-success">{{ $features->where('status', 1)->count() }}</div>
                                <small class="department-name"> @lang('words.active') </small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-warning">{{ $features->where('status', 0)->count() }}</div>
                                <small class="department-name"> @lang('words.inactive') </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modallar -->
    @include('partials.modals')
    @include('partials.delete-modal')

</x-layouts.main.website>