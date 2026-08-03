<x-layouts.main.website>
    <x-slot:title>
    @lang('words.medications')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/treatment-sheet.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @lang('words.medications')
                </li>
            </ol>
        </nav>

        <div class="search-card">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h4 class="mb-0">@lang('words.medications'). (@lang('words.short_days.today'): {{ \Carbon\Carbon::now()->translatedFormat('d F') }})</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Desktop Table View -->
        <div class="table-container patients-table-container">
            <form method="POST" action="{{ route('nurse-treatment-sheets.saveStatus') }}">
                @csrf
                
                <div class="table-wrapper" style="font-size: 13px;">
                    <table>
                        <thead>
                            <tr>
                                <th>@lang('words.time')</th>
                                <th>@lang('words.room_big')</th>
                                <th>@lang('words.patient')</th>
                                <th>@lang('words.type')</th>
                                <th>@lang('words.name')</th>
                                <th>@lang('words.quantity')</th>
                                <th>@lang('words.status')</th>
                                <th>@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formattedTreatments as $item)
                            <tr>
                                <td>{{ $item['time'] }}</td>
                                <td>{{ $item['room_bed'] }}</td>
                                <td>{{ $item['patient_name'] }}</td>
                                <td>{{ $item['type_text'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['dose'] }}</td>
                                <td>
                                    <span style="background-color: {{ $item['status_bg_color'] }}; color: {{ $item['status_text_color'] }}; padding: 3px 8px; border-radius: 4px;">
                                        {{ $item['status_text'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($item['is_select_disabled'])
                                        <input type="hidden" name="slots[{{ $item['id'] }}][status]" value="{{ $item['status'] }}">
                                        <div style="background-color: {{ $item['status_bg_color'] }}20; color: {{ $item['status_color'] }}; padding: 4px 8px; border-radius: 4px; border-left: 3px solid {{ $item['status_color'] }};">
                                            {{ $item['status_text'] }}
                                        </div>
                                        @if($item['skip_reason'])
                                            <input type="hidden" name="slots[{{ $item['id'] }}][skip_reason]" value="{{ $item['skip_reason'] }}">
                                            <div style="margin-top: 5px; font-size: 0.7rem; background: #f8f9fa; padding: 4px 8px; border-radius: 3px;">
                                                <strong>@lang('words.reason'):</strong> {{ $item['skip_reason'] }}
                                            </div>
                                        @endif
                                    @else
                                    <div class="select-check-container">
                                        <select name="slots[{{ $item['id'] }}][status]"
                                                class="status-select"
                                                data-slot-id="{{ $item['id'] }}"
                                                onchange="toggleCheckButton(this, '{{ $item['id'] }}')"
                                                {{ $item['status'] !== 'pending' ? 'disabled' : '' }}>
                                            <option value="pending" {{ $item['status'] == 'pending' ? 'selected' : '' }}>@lang('words.pending')</option>
                                            @if($item['type'] == 'procedure')
                                                <option value="completed" {{ $item['status'] == 'completed' ? 'selected' : '' }}>
                                                    Bajarildi
                                                </option>
                                            @else
                                                <option value="given" {{ $item['status'] == 'given' ? 'selected' : '' }}>
                                                    Berildi
                                                </option>
                                            @endif
                                            <option value="skipped" {{ $item['status'] == 'skipped' ? 'selected' : '' }}>O'tkazib yuborildi</option>
                                            <option value="stopped" {{ $item['status'] == 'stopped' ? 'selected' : '' }}>To'xtatildi</option>
                                            <option value="resumed" {{ $item['status'] == 'resumed' ? 'selected' : '' }}>Davom etildi</option>
                                        </select>

                                        @if($item['status'] === 'pending')
                                            <button type="submit"
                                                    name="check_slot"
                                                    value="{{ $item['id'] }}"
                                                    class="check-status-btn">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </div>
                                        <div id="skipReasonContainer{{ $item['id'] }}" class="skip-reason-container">
                                            <input type="text" 
                                                class="skip-reason-input"
                                                name="slots[{{ $item['id'] }}][skip_reason]" 
                                                placeholder="Sabab..."
                                                value="{{ $item['skip_reason'] }}">
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <input type="hidden" name="slots[{{ $item['id'] }}][type]" value="{{ $item['type'] }}">
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
            
            <!-- Pagination --> 
            <div class="pagination">
                <div class="pagination-info">
                    {{ $treatments->firstItem() }} - {{ $treatments->lastItem() }} / {{ $treatments->total() }} @lang('words.records')
                </div>
                <div class="pagination-controls">
                    @if($treatments->onFirstPage())
                        <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                    @else
                        <a href="{{ $treatments->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                    @endif

                    @foreach(range(1, $treatments->lastPage()) as $page)
                        @if($page == $treatments->currentPage())
                            <button class="page-btn active">{{ $page }}</button>
                        @elseif($page >= $treatments->currentPage() - 2 && $page <= $treatments->currentPage() + 2)
                            <a href="{{ $treatments->url($page) }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($treatments->hasMorePages())
                        <a href="{{ $treatments->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card View for Mobile -->
        <div class="cards-container">
            <form method="POST" action="{{ route('nurse-treatment-sheets.saveStatus') }}">
                @csrf
                
                @foreach($formattedTreatments as $item)
                <div class="card">
                    <div class="card-header">
                        <div class="card-time">{{ $item['time'] }}</div>
                        <div class="card-status" style="background-color: {{ $item['status_bg_color'] }}; color: {{ $item['status_text_color'] }};">
                            {{ $item['status_text'] }}
                        </div>
                    </div>
                    
                    <div class="card-row">
                        <span class="card-label">@lang('words.room_big'):</span>
                        <span class="card-value">{{ $item['room_bed'] }}</span>
                    </div>
                    
                    <div class="card-row">
                        <span class="card-label">@lang('words.patient'):</span>
                        <span class="card-value">{{ $item['patient_name'] }}</span>
                    </div>
                    
                    <div class="card-row">
                        <span class="card-label">@lang('words.type'):</span>
                        <span class="card-value">{{ $item['name'] }}</span>
                    </div>
                    
                    <div class="card-row">
                        <span class="card-label">@lang('words.quantity'):</span>
                        <span class="card-value">{{ $item['dose'] }}</span>
                    </div>
                    
                    <div class="card-row">
                        <span class="card-label">@lang('words.strength'):</span>
                        <span class="card-value">{{ $item['strength'] }}</span>
                    </div>
                    
                    <div class="card-row">
                        <span class="card-label">@lang('words.status')</span>
                        <span class="card-value">
                            @if($item['is_select_disabled'])
                                <input type="hidden" name="slots[{{ $item['id'] }}][status]" value="{{ $item['status'] }}">
                                <div style="background-color: {{ $item['status_bg_color'] }}20; color: {{ $item['status_color'] }}; padding: 4px 8px; border-radius: 4px; border-left: 3px solid {{ $item['status_color'] }}; text-align: center;">
                                    {{ $item['status_text'] }}
                                </div>
                                @if($item['skip_reason'])
                                    <input type="hidden" name="slots[{{ $item['id'] }}][skip_reason]" value="{{ $item['skip_reason'] }}">
                                    <div style="margin-top: 5px; font-size: 0.7rem; background: #f8f9fa; padding: 4px 8px; border-radius: 3px;">
                                        <strong>@lang('words.reason'):</strong> {{ $item['skip_reason'] }}
                                    </div>
                                @endif
                            @else
                                <div class="select-check-container">
                                    <select name="slots[{{ $item['id'] }}][status]" 
                                            class="status-select"
                                            data-slot-id="{{ $item['id'] }}"
                                            onchange="toggleCheckButtonMobile(this, '{{ $item['id'] }}')">
                                        <option value="pending" {{ $item['status'] == 'pending' ? 'selected' : '' }}>@lang('words.pending')</option>
                                        @if($item['type'] == 'procedure')
                                                <option value="completed" {{ $item['status'] == 'completed' ? 'selected' : '' }}>
                                                    Bajarildi
                                                </option>
                                            @else
                                                <option value="given" {{ $item['status'] == 'given' ? 'selected' : '' }}>
                                                    Berildi
                                                </option>
                                            @endif
                                        <option value="skipped" {{ $item['status'] == 'skipped' ? 'selected' : '' }}>O'tkazib yuborildi</option>
                                        <option value="stopped" {{ $item['status'] == 'stopped' ? 'selected' : '' }}>To'xtatildi</option>
                                        <option value="resumed" {{ $item['status'] == 'resumed' ? 'selected' : '' }}>Davom etildi</option>
                                    </select>
                                    <button type="submit" 
                                            name="check_slot" 
                                            value="{{ $item['id'] }}"
                                            class="check-status-btn">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <div id="skipReasonContainerMobile{{ $item['id'] }}" class="skip-reason-container">
                                    <input type="text" 
                                        class="skip-reason-input"
                                        name="slots[{{ $item['id'] }}][skip_reason]" 
                                        placeholder="Sabab..."
                                        value="{{ $item['skip_reason'] }}">
                                </div>
                                <input type="hidden" name="slots[{{ $item['id'] }}][type]" value="{{ $item['type'] }}">
                            @endif
                        </span>
                    </div>
                </div>
                @endforeach
                
            </form>
            
            <!-- Pagination for mobile -->
            <div class="pagination">
                <div class="pagination-info">
                    {{ $treatments->firstItem() ?? 0 }} - {{ $treatments->lastItem() ?? 0 }} / {{ $treatments->total() ?? 0 }} yozuvlar
                </div>
                <div class="pagination-controls">
                    @if($treatments->onFirstPage())
                        <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                    @else
                        <a href="{{ $treatments->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                    @endif

                    @foreach(range(1, $treatments->lastPage()) as $page)
                        @if($page == $treatments->currentPage())
                            <button class="page-btn active">{{ $page }}</button>
                        @else
                            <a href="{{ $treatments->url($page) }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($treatments->hasMorePages())
                        <a href="{{ $treatments->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
            </div>

        </div>
    </div> 

    <script>
        function toggleCheckButton(selectElement, slotId) {
            const wrapper = selectElement.closest('.select-check-container');
            const checkBtn = wrapper.querySelector('.check-status-btn');
            const reasonContainer = document.getElementById('skipReasonContainer' + slotId);
            
            if (selectElement.value !== 'pending') {
                selectElement.classList.add('selected');
                checkBtn.classList.add('show');
                
                if (selectElement.value === 'skipped' || selectElement.value === 'stopped' || selectElement.value === 'resumed') {
                    reasonContainer.style.display = 'block';
                    reasonContainer.classList.add('show');
                } else {
                    reasonContainer.style.display = 'none';
                    reasonContainer.classList.remove('show');
                }
            } else {
                selectElement.classList.remove('selected');
                checkBtn.classList.remove('show');
                reasonContainer.style.display = 'none';
                reasonContainer.classList.remove('show');
            }
        }
        
        function toggleCheckButtonMobile(selectElement, slotId) {
            const wrapper = selectElement.closest('.select-check-container');
            const checkBtn = wrapper.querySelector('.check-status-btn');
            const reasonContainer = document.getElementById('skipReasonContainerMobile' + slotId);
            
            if (selectElement.value !== 'pending') {
                selectElement.classList.add('selected');
                checkBtn.classList.add('show');
                
                if (selectElement.value === 'skipped' || selectElement.value === 'stopped' || selectElement.value === 'resumed') {
                    reasonContainer.style.display = 'block';
                    reasonContainer.classList.add('show');
                } else {
                    reasonContainer.style.display = 'none';
                    reasonContainer.classList.remove('show');
                }
            } else {
                selectElement.classList.remove('selected');
                checkBtn.classList.remove('show');
                reasonContainer.style.display = 'none';
                reasonContainer.classList.remove('show');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const desktopSelects = document.querySelectorAll('.table-container .status-select');
            desktopSelects.forEach(select => {
                const slotId = select.dataset.slotId;
                const originalValue = select.value;
                
                if (originalValue !== 'pending') {
                    select.classList.add('selected');
                    const wrapper = select.closest('.select-check-container');
                    const checkBtn = wrapper.querySelector('.check-status-btn');
                    const reasonContainer = document.getElementById('skipReasonContainer' + slotId);
                    
                    if (checkBtn) checkBtn.classList.add('show');
                    if (reasonContainer && (originalValue === 'skipped' || originalValue === 'stopped' || originalValue === 'resumed')) {
                        reasonContainer.style.display = 'block';
                        reasonContainer.classList.add('show');
                    }
                }
            });
            
            const mobileSelects = document.querySelectorAll('.cards-container .status-select');
            mobileSelects.forEach(select => {
                const slotId = select.dataset.slotId;
                const originalValue = select.value;
                
                if (originalValue !== 'pending') {
                    select.classList.add('selected');
                    const wrapper = select.closest('.select-check-container');
                    const checkBtn = wrapper.querySelector('.check-status-btn');
                    const reasonContainer = document.getElementById('skipReasonContainerMobile' + slotId);
                    
                    if (checkBtn) checkBtn.classList.add('show');
                    if (reasonContainer && (originalValue === 'skipped' || originalValue === 'stopped' || originalValue === 'resumed')) {
                        reasonContainer.style.display = 'block';
                        reasonContainer.classList.add('show');
                    }
                }
            });
        });
    </script>

</x-layouts.main.website>