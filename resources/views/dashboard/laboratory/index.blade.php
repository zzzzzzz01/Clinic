<x-layouts.main.website>
    <x-slot:title>
        @lang('words.laboratory')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/laboratory2.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main_page')
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @lang('words.laboratory')
                </li>
            </ol>
        </nav>

        <div class="search-card">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h4 class="mb-0">@lang('words.laboratory')</h4>
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
                    <span class="filter-count" id="filterCount">{{ $filter_count }}</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button> 
            </div>
            
            <div class="active-filters" id="activeFilters">
                @foreach($active_filters as $key => $value)
                    <span class="active-filter-badge">
                        {{ $value }}
                        <i class="fas fa-times" data-filter="{{ $key }}"></i>
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Filter Panel -->
        @include('partials.filters.laboratory')

        <!-- Cards Grid -->
        <div class="cards-grid" id="cards-grid">
            @forelse($items as $item)
            <div class="test-card">
                <div class="urgency-indicator">
                    <div class="urgency-bar" style="width: 100%"></div>
                </div>
                <div class="card-header">
                    <div class="test-id-container">
                        <div class="room-number">
                            <i class="fas fa-bed"></i>
                            @lang('words.room'): {{ $item['room_number'] }}
                        </div>
                        <div class="test-id">LAB-{{ str_pad($item['id'], 3, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="{{ $item['type_config']['class'] }}">{{ $item['type_config']['text'] }}</div>
                </div>
                <div class="card-content">
                    <div class="patient-info">
                        <div class="avatar">{{ $item['patient']['avatar'] }}</div>
                        <div class="name-details">
                            <div class="patient-name">{{ $item['patient']['name'] }}</div>
                            <div class="patient-id">@lang('words.patient') ID: PT-{{ $item['patient']['id'] }} • {{ $item['patient']['age'] }} @lang('words.year')</div>
                        </div>
                    </div>
                    
                    <div class="doctor-info">
                        <div class="doctor-avatar">{{ $item['doctor']['avatar'] }}</div>
                        <div class="doctor-details">
                            <div class="doctor-name">{{ $item['doctor']['name'] }}</div>
                            <div class="doctor-specialty">{{ $item['doctor']['specialty'] }}</div>
                        </div>
                    </div>
                    
                    <div class="test-info">
                        <div class="test-name">{{ $item['test']['name'] }}</div>
                        <!-- <div class="test-description">{{ Str::limit($item['test']['description'], 60) }}</div> -->
                    </div>

                    <div class="test-meta">
                        <div class="meta-item">
                            <span class="meta-label">
                                <i class="far fa-calendar"></i>
                                @lang('words.date')
                            </span>
                            <span class="meta-value">{{ $item['ordered_at'] }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">
                                <i class="far fa-clock"></i>
                                @lang('words.time')
                            </span>
                            <span class="meta-value">{{ $item['ordered_time'] }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">
                                <i class="fas fa-stopwatch"></i>
                                @lang('words.deadline')
                            </span>
                            <span class="meta-value">{{ $item['test']['duration'] }} soat</span>
                        </div>
                    </div>
                    
                    <div class="status-section">
                        <span class="{{ $item['status_config']['class'] }}">
                            <i class="{{ $item['status_config']['icon'] }}"></i>
                            {{ $item['status_config']['text'] }}
                        </span>

                        <span class="{{ $item['urgency_config']['class'] }}">
                            <i class="{{ $item['urgency_config']['icon'] }}"></i>
                            {{ $item['urgency_config']['text'] }}
                        </span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="deadline-info countdown"
                            data-finish="{{ $item['finish_at'] }}"
                            data-status="{{ $item['result_status'] }}">
                        <i class="fas fa-clock"></i>
                        <span class="time"></span>
                    </div>

                    <div class="laboratory-action-buttons">
                        <a href="{{ $item['view_url'] }}">
                            <button class="btn-action btn-view" title="Ko'rish">
                                <i class="far fa-eye"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-vial"></i>
                <p>@lang('words.no_data_found')</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @include('partials.paginations.laboratory')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Countdown timer
            document.querySelectorAll('.countdown').forEach(el => {
                const finishAt = new Date(el.dataset.finish).getTime();
                const status = el.dataset.status;
                const timeEl = el.querySelector('.time');

                function update() {
                    const now = Date.now();
                    let diff = Math.floor((finishAt - now) / 1000);

                    el.classList.remove('text-danger', 'text-warning', 'text-success');

                    if (status === 'ready') {
                        timeEl.textContent = '@lang('words.test_completed')';
                        el.classList.add('text-success');
                        return;
                    }

                    if (diff <= 0) {
                        timeEl.textContent = '@lang('words.expired')';
                        el.classList.add('text-danger');
                        return;
                    }

                    if (diff <= 3600 && diff > 600) {
                        el.classList.add('text-warning');
                    }

                    if (diff <= 600) {
                        el.classList.add('text-danger');
                    }

                    const h = Math.floor(diff / 3600);
                    const m = Math.floor((diff % 3600) / 60);
                    const s = diff % 60;

                    timeEl.textContent = String(h).padStart(2, '0') + ':' +
                                         String(m).padStart(2, '0') + ':' +
                                         String(s).padStart(2, '0');
                }

                update();
                setInterval(update, 1000);
            });
        });
    </script>
</x-layouts.main.website>