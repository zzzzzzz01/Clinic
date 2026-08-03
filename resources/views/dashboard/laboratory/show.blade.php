<!-- resources/views/tests/combined/show.blade.php -->
<x-layouts.main.website >
    <x-slot:title>
    {{ $page_title }}
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/laboratory-show.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main_page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('laboratory.test') }}"> @lang('words.laboratory_tests') </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $test_name }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="main-content">
        <div class="test-header-card">
            <div class="test-header">
                <h1 class="test-title">
                    @if($is_panel)
                        <i class="fas fa-list"></i>
                        {{ $test_name }}
                        <span class="test-badge {{ $type_config['badge_class'] }}">
                            <i class="{{ $type_config['icon'] }}"></i> {{ $type_config['label'] }}
                        </span>
                    @else
                        <i class="fas fa-vial"></i>
                        {{ $test_name }}
                        <span class="test-badge {{ $type_config['badge_class'] }}">
                            <i class="{{ $type_config['icon'] }}"></i> {{ $type_config['label'] }}
                        </span>
                    @endif
                </h1>
                
                <span class="status-badge {{ $status_config['class'] }}">
                    {{ $status_config['text'] }}
                </span>
            </div>
            
            <div class="test-info">
                <div class="info-item">
                    <span class="info-label">@lang('words.order_date')</span>
                    <span class="info-value">{{ $ordered_at }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">@lang('words.ordered_by')</span>
                    <span class="info-value">
                        <span class="name-full">{{ $doctor_name }}</span>
                        <span class="name-short">{{ $doctor_short_name }}</span>
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">@lang('words.patient')</span>
                    <span class="info-value">
                        <span class="name-full">{{ $patient_name }}</span>
                        <span class="name-short">{{ $patient_short_name }}</span>
                    </span>
                </div>
                
                @if($room_number)
                <div class="info-item">
                    <span class="info-label">@lang('words.room')</span>
                    <span class="info-value">{{ $room_number }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Natijalar -->
        <div class="results-container">
            <div class="results-header">
                <h3>
                    <i class="fas fa-chart-bar"></i>
                    @lang('words.results')
                </h3>
                <div class="test-count">
                    @if($is_panel)
                        {{ $test_count }} @lang('words.tests')
                    @else
                        1 @lang('words.test')
                    @endif
                </div>
            </div>
            
            <div class="results-body">
                @if($has_results)
                    @if($is_panel)
                        <!-- PANEL TEST UCHUN JADVAL -->
                        <table class="panel-table">
                            <thead>
                                <tr>
                                    <th>@lang('words.test_name')</th>
                                    <th>@lang('words.result')</th>
                                    <th>@lang('words.normal_range')</th>
                                    <th>@lang('words.unit')</th>
                                    <th>@lang('words.status')</th>
                                    <th>@lang('words.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $result)
                                <tr class="{{ $result['row_class'] }}">
                                    <td>
                                        <div class="test-name">{{ $result['test_name'] }}</div>
                                        <div class="test-code">@lang('words.code'): {{ $result['test_code'] }}</div>
                                    </td>
                                    <td>
                                        <div class="result-value">
                                            {{ $result['value'] ?? '—' }}
                                            @if($result['value'] && $result['unit'])
                                            <span class="result-unit">{{ $result['unit'] }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if(!is_null($result['normal_min']) && !is_null($result['normal_max']))
                                        <div class="result-range">
                                            {{ $result['normal_min'] }} - {{ $result['normal_max'] }}
                                        </div>
                                        @else
                                        <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="result-unit">{{ $result['unit'] ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <span class="result-status {{ $result['status_class'] }}">
                                            {!! $result['status_icon'] !!} {{ $result['status_text'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-add" onclick="openResultModal(
                                            {{ $result['id'] }}, 
                                            '{{ addslashes($result['test_name']) }}', 
                                            '{{ $result['value'] ?? '' }}', 
                                            '{{ $result['normal_min'] ?? '' }}', 
                                            '{{ $result['normal_max'] ?? '' }}', 
                                            '{{ $result['unit'] ?? '' }}'
                                        )">
                                            @if($result['has_value'])
                                                <i class="fas fa-edit"></i>
                                            @else
                                                <i class="fas fa-plus"></i> 
                                            @endif
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <!-- YAKKA TEST UCHUN KARTACHKA -->
                        @php
                            $result = $results->first();
                        @endphp
                        <div class="single-result-card">
                            <button class="single-action-btn" onclick="openResultModal(
                                {{ $result['id'] }}, 
                                '{{ addslashes($result['test_name']) }}', 
                                '{{ $result['value'] ?? '' }}', 
                                '{{ $result['normal_min'] ?? '' }}', 
                                '{{ $result['normal_max'] ?? '' }}', 
                                '{{ $result['unit'] ?? '' }}'
                            )">
                                @if($result['has_value'])
                                    <i class="fas fa-edit"></i> @lang('words.edit_result')
                                @else
                                    <i class="fas fa-plus"></i> @lang('words.add_result')
                                @endif
                            </button>
                            
                            <div class="result-item {{ $result['row_class'] }}">
                                <div class="result-label">
                                    <i class="fas fa-vial"></i>
                                    @lang('words.test_name')
                                </div>
                                <div class="result-value">
                                    {{ $result['test_name'] }}
                                </div>
                            </div>
                            
                            <div class="result-item {{ $result['row_class'] }}">
                                <div class="result-label">
                                    <i class="fas fa-chart-line"></i>
                                    @lang('words.result')
                                </div>
                                <div class="result-value">
                                    {{ $result['value'] ?? '—' }}
                                    @if($result['value'] && $result['unit'])
                                    <span class="result-unit">{{ $result['unit'] }}</span>
                                    @endif
                                </div>
                                <span class="result-status {{ $result['status_class'] }}">
                                    {!! $result['status_icon'] !!}{{ $result['status_text'] }}
                                </span>
                            </div>
                            
                            @if(!is_null($result['normal_min']) && !is_null($result['normal_max']))
                            <div class="result-item">
                                <div class="result-label">
                                    <i class="fas fa-exchange-alt"></i>
                                    @lang('words.normal_range')
                                </div>
                                <div class="result-range">
                                    {{ $result['normal_min'] }} - {{ $result['normal_max'] }} {{ $result['unit'] ?? '' }}
                                </div>
                            </div>
                            @endif
                        </div>
                    @endif
                @else
                <div class="empty-state">
                    <i class="fas fa-vial"></i>
                    <h4>@lang('words.no_results_found')</h4>
                    <p>@lang('words.no_results_message')</p>
                </div>
                @endif
            </div>
        </div>

        <!-- PRINT UCHUN JADVAL -->
        <div class="print-table-container">
            <table class="print-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('words.test_name')</th>
                        <th>@lang('words.result')</th>
                        <th>@lang('words.normal_range')</th>
                        <th>@lang('words.unit')</th>
                        <th>@lang('words.status')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $result)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="test-name">{{ $result['test_name'] }}</div>
                            <div class="test-code">@lang('words.code'): {{ $result['test_code'] }}</div>
                        </td>
                        <td>
                            <div class="result-value">{{ $result['value'] ?? '—' }}</div>
                        </td>
                        <td>
                            @if(!is_null($result['normal_min']) && !is_null($result['normal_max']))
                            <div>{{ $result['normal_min'] }} - {{ $result['normal_max'] }}</div>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $result['unit'] ?? '—' }}</td>
                        <td>
                            @if($result['status_class'] == 'status-low')
                                <i class="fa-solid fa-arrow-down print-status-icon low"></i>
                            @elseif($result['status_class'] == 'status-high')
                                <i class="fa-solid fa-arrow-up print-status-icon high"></i>
                            @elseif($result['status_class'] == 'status-normal')
                                <i class="fa-solid fa-check print-status-icon normal"></i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="print-footer">
                <div class="print-footer-item">
                    <strong>@lang('words.patient'):</strong> {{ $patient_name }}
                </div>
                <div class="print-footer-item">
                    <strong>@lang('words.doctor'):</strong> {{ $doctor_name }}
                </div>
                <div class="print-footer-item">
                    <strong>@lang('words.date'):</strong> {{ $ordered_at }}
                </div>
                @if($is_panel)
                <div class="print-footer-item">
                    <strong>@lang('words.panel'):</strong> {{ $test_name }}
                </div>
                @endif
            </div>
        </div>
        
        <div class="actions-container">
            <button class="btn btn-primary" onclick="printTestResults()">
                <i class="fas fa-print"></i> @lang('words.print')
            </button>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay" id="resultModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">
                    <i class="fas fa-vial"></i>
                    @lang('words.test_result')
                </h3>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="test-details" id="testDetails"></div>
                
                <form id="resultForm" method="POST" action="{{ route('laboratory.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="result_id" id="resultId">
                    
                    <div class="form-group">
                        <label class="form-label" for="resultValue">
                            <i class="fas fa-chart-line"></i> @lang('words.result_value')
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="resultValue" 
                               name="value"
                               placeholder="@lang('words.result_placeholder')"
                               required>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal()">
                    <i class="fas fa-times"></i> @lang('words.cancel')
                </button>
                <button type="submit" form="resultForm" class="btn btn-primary">
                    <i class="fas fa-save"></i> @lang('words.save')
                </button>
            </div>
        </div>
    </div>
    
    <script>
        function printTestResults() {
            window.print();
        }

        function openResultModal(resultId, testName, currentValue, min, max, unit) {
            const modalTitle = document.getElementById('modalTitle');
            if (currentValue) {
                modalTitle.innerHTML = '<i class="fas fa-vial"></i> ' + testName + ' - @lang("words.edit_result")';
            } else {
                modalTitle.innerHTML = '<i class="fas fa-vial"></i> ' + testName + ' - @lang("words.add_result")';
            }
            
            const testDetails = document.getElementById('testDetails');
            let detailsHTML = `
                <div class="test-details-item">
                    <span class="test-details-label">@lang("words.test_name"):</span>
                    <span class="test-details-value">${escapeHtml(testName)}</span>
                </div>
            `;
            
            if (min && max) {
                detailsHTML += `
                    <div class="test-details-item">
                        <span class="test-details-label">@lang("words.normal_range"):</span>
                        <span class="test-details-value">${min} - ${max} ${unit ? unit : ''}</span>
                    </div>
                `;
            }
            
            if (unit) {
                detailsHTML += `
                    <div class="test-details-item">
                        <span class="test-details-label">@lang("words.unit"):</span>
                        <span class="test-details-value">${unit}</span>
                    </div>
                `;
            }
            
            testDetails.innerHTML = detailsHTML;
            
            document.getElementById('resultValue').value = currentValue || '';
            document.getElementById('resultId').value = resultId;
            
            const modal = document.getElementById('resultModal');
            modal.classList.add('active');
            document.body.classList.add('modal-open');
            
            setTimeout(() => {
                document.getElementById('resultValue').focus();
                document.getElementById('resultValue').select();
            }, 100);
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        function closeModal() {
            const modal = document.getElementById('resultModal');
            modal.classList.remove('active');
            document.body.classList.remove('modal-open');
            document.getElementById('resultValue').value = '';
            document.getElementById('resultId').value = '';
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('resultModal');
                if (modal.classList.contains('active')) {
                    closeModal();
                }
            }
        }); 
        
        document.getElementById('resultForm').addEventListener('submit', function(e) {
            const value = document.getElementById('resultValue').value.trim();
            if (!value) {
                e.preventDefault();
                alert('@lang("words.please_enter_result")');
                return false;
            }
            return true;
        });
    </script>
</x-layouts.main.website>