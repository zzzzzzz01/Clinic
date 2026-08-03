<x-layouts.main.website>
    <x-slot:title>
        @lang('words.schedule_settings_create_slot')
    </x-slot:title>

    <div class="container">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctors.index') }}">@lang('words.doctors.list')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctor.appointment.slots', $schedulable) }}">
                        {{ $schedulable->user->last_name }} {{ $schedulable->user->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active">@lang('words.create_slot')</li>
            </ol>
        </nav>

        {{-- Sarlavha --}}
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.appointment_slots')</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Qoidalar --}}
        <div class="rules-wrapper">
            <div class="rules-toggle">
                <input type="checkbox" id="rulesToggle" class="rules-toggle-input">
                <label for="rulesToggle" class="rules-toggle-label">
                    <span class="rules-title">
                        @lang('words.rules')
                    </span>
                    <span class="rules-icon">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </label>
                <div class="rules-content">
                    <div class="info-box">
                        <p>• <strong class="text-danger">@lang('words.switch_off_warning')</strong> @lang('words.no_slots_created')</p>
                        <p>• @lang('words.modal_red_warning') <strong class="text-danger">@lang('words.will_not_be_created')</strong></p>
                        <p>• @lang('words.unselected_slots_warning') <strong class="text-success">@lang('words.will_be_created')</strong></p>
                        <p>• @lang('words.no_selection_warning')</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Asosiy karta --}}
        <div class="card-body">

            {{-- Umumiy statistika --}}
            <div class="summary-section">
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-value summary-value-total" id="total-slots-summary">0</div>
                        <div class="summary-label">@lang('words.total_slots')</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value summary-value-excluded" id="excluded-slots-summary">0</div>
                        <div class="summary-label">@lang('words.not_created_slots')</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value summary-value-created" id="created-slots-summary">0</div>
                        <div class="summary-label">@lang('words.will_be_created_slots')</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="slots-table-wrapper">
                <form action="{{ route('appointment.slots.store', ['type' => $type, 'id' => $schedulable->id]) }}" method="POST" id="save-all-slots-form">
                    @csrf

                    <table class="slots-table">
                        <thead>
                            <tr>
                                <th>@lang('words.no')</th>
                                <th>@lang('words.date')</th>
                                <th>@lang('words.working_day')</th>
                                <th>@lang('words.slots_count')</th>
                                <th>@lang('words.duration')</th>
                                <th>@lang('words.start_time')</th>
                                <th>@lang('words.end_time')</th>
                                <th>@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($days as $index => $day)
                                @php 
                                    $modalId = 'modal-toggle-' . $index;
                                    $weekday = ucfirst($day['weekday']);
                                @endphp

                                <tr data-day-index="{{ $index }}" 
                                    data-date="{{ $day['date'] }}"
                                    class="{{ !$day['is_working'] ? 'disabled-row' : '' }}">
                                    
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        <div class="day-info-cell">
                                            <div class="day-details">
                                                <div class="day-name">{{ $weekday }}</div>
                                                <div class="date-display">{{ $day['date'] }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <label class="switch">
                                            <input type="checkbox"
                                                name="working_days[{{ $day['date'] }}]"
                                                value="1"
                                                class="day-switch"
                                                data-day-index="{{ $index }}"
                                                data-slot-count="{{ $day['slot_count'] }}"
                                                {{ $day['is_working'] ? 'checked' : '' }}
                                                {{ $day['is_working'] ? '' : 'disabled' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </td>

                                    <td>
                                        @if ($day['is_working'])
                                            <div class="slot-count-display" id="slot-count-{{ $index }}">
                                                <span class="total-slots">{{ $day['slot_count'] }}</span>
                                                <span class="excluded-badge" style="display:none;">
                                                    (-<span class="excluded-count">0</span>)
                                                </span>
                                            </div>
                                        @else
                                            <div class="slot-count-display" id="slot-count-{{ $index }}">
                                                <span class="total-slots">0</span>
                                                <span class="excluded-badge" style="display:inline;">
                                                    (-<span class="excluded-count">{{ $day['slot_count'] }}</span>)
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($day['is_working'])
                                            {{ $day['duration'] }} @lang('words.min')
                                        @else
                                            {{ $day['duration'] ?? '-' }} @lang('words.min')
                                        @endif
                                    </td>

                                    <td>
                                        @if ($day['is_working'])
                                            {{ \Carbon\Carbon::parse($day['start_time'])->format('H:i') }}
                                        @else
                                            {{ $day['start_time'] ? \Carbon\Carbon::parse($day['start_time'])->format('H:i') : '-' }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($day['is_working'])
                                            {{ \Carbon\Carbon::parse($day['end_time'])->format('H:i') }}
                                        @else
                                            {{ $day['end_time'] ? \Carbon\Carbon::parse($day['end_time'])->format('H:i') : '-' }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($day['is_working'])
                                            <button type="button" class="eye-btn"
                                                    data-day-index="{{ $index }}"
                                                    data-modal-id="{{ $modalId }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <input type="hidden"
                                           name="selected_slots[{{ $day['date'] }}]"
                                           id="selected-slot-{{ $index }}"
                                           value="">
                                </tr>

                                {{-- MODAL --}}
                                <input type="checkbox" id="{{ $modalId }}" class="modal-checkbox">
                                <div class="modal-overlay-dynamic">
                                    <div class="modal-container">
                                        <div class="modal-header">
                                            <h3>{{ $weekday }} ({{ $day['date'] }})</h3>
                                            <label for="{{ $modalId }}" class="close-btn">✕</label>
                                        </div>

                                        <div class="modal-body">
                                            <div class="slots-header">
                                                <div class="slots-title">
                                                    <span class="badge bg-info" id="slots-count-badge-{{ $index }}">
                                                        {{ $day['slot_count'] }} @lang('words.slots')
                                                    </span>
                                                    <span class="badge bg-warning ms-2" id="selected-count-badge-{{ $index }}">
                                                        <span id="selected-count-number-{{ $index }}">0</span> @lang('words.selected')
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="slots-grid" id="slots-grid-{{ $index }}" data-day-index="{{ $index }}">
                                                @if (!empty($day['slots']))
                                                    @foreach ($day['slots'] as $slot)
                                                        <button type="button"
                                                                class="slot-time-btn"
                                                                data-day-index="{{ $index }}"
                                                                data-slot-id="{{ $day['date'] }}_{{ $slot['start'] }}">
                                                            <div class="slot-label">{{ $slot['start'] }} - {{ $slot['end'] }}</div>
                                                        </button>
                                                    @endforeach
                                                @else
                                                    <p class="text-muted text-center">@lang('words.no_slots_available_for_day')</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <label for="{{ $modalId }}" class="btn-secondary">@lang('words.cancel')</label>
                                            <button type="button" class="btn-primary" onclick="saveModalSelection({{ $index }})">
                                                @lang('words.save')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination" style="justify-content: end;">
                        <button type="submit" class="btn-primary">
                            @lang('words.create_slots')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const selectedSlots = {};
        const totalSlots = {};
        let workingDays = {};

        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($days as $index => $day)
                selectedSlots[{{ $index }}] = [];
                totalSlots[{{ $index }}] = {{ $day['slot_count'] }};
                workingDays[{{ $index }}] = {{ $day['is_working'] ? 'true' : 'false' }};
            @endforeach

            updateGlobalSummary();
            attachEventHandlers();
        });

        function attachEventHandlers() {
            document.querySelectorAll('.slot-time-btn').forEach(btn => {
                btn.removeEventListener('click', slotClickHandler);
                btn.addEventListener('click', slotClickHandler);
            });

            document.querySelectorAll('.eye-btn').forEach(btn => {
                btn.removeEventListener('click', eyeClickHandler);
                btn.addEventListener('click', eyeClickHandler);
            });

            document.querySelectorAll('.day-switch').forEach(sw => {
                sw.removeEventListener('change', switchChangeHandler);
                sw.addEventListener('change', switchChangeHandler);
            });
        }

        function slotClickHandler(e) {
            const btn = e.currentTarget;
            const dayIndex = parseInt(btn.dataset.dayIndex);
            const slotId = btn.dataset.slotId;

            if (!workingDays[dayIndex]) {
                alert('@lang('words.day_disabled_alert')');
                return;
            }

            const idx = selectedSlots[dayIndex].indexOf(slotId);

            if (idx > -1) {
                selectedSlots[dayIndex].splice(idx, 1);
                btn.classList.remove('selected');
            } else {
                selectedSlots[dayIndex].push(slotId);
                btn.classList.add('selected');
            }

            updateDayData(dayIndex);
            updateModalDisplay(dayIndex);
            updateGlobalSummary();
        }

        function eyeClickHandler(e) {
            const btn = e.currentTarget;
            const dayIndex = parseInt(btn.dataset.dayIndex);
            const modalId = btn.dataset.modalId;

            if (!modalId) return;
            
            if (!workingDays[dayIndex]) {
                alert('@lang('words.day_disabled_view_alert')');
                return;
            }

            document.querySelectorAll(`.slot-time-btn[data-day-index="${dayIndex}"]`).forEach(slotBtn => {
                const slotId = slotBtn.dataset.slotId;
                if (selectedSlots[dayIndex]?.includes(slotId)) {
                    slotBtn.classList.add('selected');
                } else {
                    slotBtn.classList.remove('selected');
                }
            });

            updateModalDisplay(dayIndex);
            document.getElementById(modalId).checked = true;
        }

        function switchChangeHandler(e) {
            const dayIndex = parseInt(e.target.dataset.dayIndex);
            const slotCount = parseInt(e.target.dataset.slotCount);
            workingDays[dayIndex] = e.target.checked;
            
            const row = e.target.closest('tr');
            const slotCountDiv = document.getElementById(`slot-count-${dayIndex}`);
            
            if (!workingDays[dayIndex]) {
                row.classList.add('disabled-row');
                
                if (slotCountDiv) {
                    slotCountDiv.innerHTML = `
                        <span class="total-slots">0</span>
                        <span class="excluded-badge" style="display:inline;">
                            (-<span class="excluded-count">${slotCount}</span>)
                        </span>
                    `;
                }
                
                selectedSlots[dayIndex] = [];
                document.getElementById(`selected-slot-${dayIndex}`).value = '';
                
                document.querySelectorAll(`.slot-time-btn[data-day-index="${dayIndex}"]`).forEach(btn => {
                    btn.classList.remove('selected');
                });
            } else {
                row.classList.remove('disabled-row');
                
                if (slotCountDiv) {
                    slotCountDiv.innerHTML = `
                        <span class="total-slots">${slotCount}</span>
                        <span class="excluded-badge" style="display:none;">
                            (-<span class="excluded-count">0</span>)
                        </span>
                    `;
                }
            }
            
            updateDayData(dayIndex);
            updateModalDisplay(dayIndex);
            updateGlobalSummary();
        }

        function saveModalSelection(dayIndex) {
            document.getElementById(`selected-slot-${dayIndex}`).value = selectedSlots[dayIndex].join(',');
            updateDayData(dayIndex);
            updateModalDisplay(dayIndex);
            updateGlobalSummary();
            document.getElementById(`modal-toggle-${dayIndex}`).checked = false;
        }

        function updateDayData(dayIndex) {
            const excludedCount = selectedSlots[dayIndex]?.length || 0;
            
            const slotCountDiv = document.getElementById(`slot-count-${dayIndex}`);
            if (slotCountDiv && workingDays[dayIndex]) {
                const excludedBadge = slotCountDiv.querySelector('.excluded-badge');
                const excludedCountSpan = slotCountDiv.querySelector('.excluded-count');
                
                if (excludedCount > 0) {
                    if (excludedBadge) excludedBadge.style.display = 'inline';
                    if (excludedCountSpan) excludedCountSpan.textContent = excludedCount;
                } else {
                    if (excludedBadge) excludedBadge.style.display = 'none';
                }
            }
            
            document.getElementById(`selected-slot-${dayIndex}`).value = selectedSlots[dayIndex].join(',');
        }

        function updateModalDisplay(dayIndex) {
            const excludedCount = selectedSlots[dayIndex]?.length || 0;
            const total = totalSlots[dayIndex] || 0;
            const createdCount = workingDays[dayIndex] ? total - excludedCount : 0;
            
            const slotsBadge = document.getElementById(`slots-count-badge-${dayIndex}`);
            const selectedCountSpan = document.getElementById(`selected-count-number-${dayIndex}`);
            const selectedBadge = document.getElementById(`selected-count-badge-${dayIndex}`);
            
            if (slotsBadge) {
                slotsBadge.textContent = workingDays[dayIndex] ? `${createdCount} @lang('words.will_be_created')` : '@lang('words.day_disabled')';
                slotsBadge.className = workingDays[dayIndex] ? 'badge bg-info' : 'badge bg-secondary';
            }
            
            if (selectedCountSpan) {
                selectedCountSpan.textContent = excludedCount;
            }
            
            if (selectedBadge) {
                selectedBadge.className = workingDays[dayIndex] ? 'badge bg-warning ms-2' : 'badge bg-secondary ms-2';
            }
        }

        function updateGlobalSummary() {
            let totalAll = 0;
            let totalExcluded = 0;
            
            for (let dayIndex in totalSlots) {
                if (workingDays[dayIndex]) {
                    totalAll += totalSlots[dayIndex];
                    totalExcluded += (selectedSlots[dayIndex]?.length || 0);
                } else {
                    totalExcluded += totalSlots[dayIndex];
                }
            }
            
            let totalCreatedCorrect = 0;
            for (let dayIndex in totalSlots) {
                if (workingDays[dayIndex]) {
                    const excluded = selectedSlots[dayIndex]?.length || 0;
                    totalCreatedCorrect += totalSlots[dayIndex] - excluded;
                }
            }
            
            document.getElementById('total-slots-summary').textContent = totalAll;
            document.getElementById('excluded-slots-summary').textContent = totalExcluded;
            document.getElementById('created-slots-summary').textContent = totalCreatedCorrect;
        }

        function resetAllSelections() {
            if (!confirm('@lang('words.reset_all_confirm')')) return;

            for (const dayIndex in selectedSlots) {
                if (workingDays[dayIndex]) {
                    selectedSlots[dayIndex] = [];
                    document.getElementById(`selected-slot-${dayIndex}`).value = '';
                    updateDayData(dayIndex);
                    updateModalDisplay(dayIndex);
                }
            }

            document.querySelectorAll('.slot-time-btn').forEach(btn => btn.classList.remove('selected'));
            updateGlobalSummary();
        }

        document.getElementById('save-all-slots-form').addEventListener('submit', function (e) {
            for (const dayIndex in selectedSlots) {
                document.getElementById(`selected-slot-${dayIndex}`).value = selectedSlots[dayIndex].join(',');
            }

            const totalCreated = parseInt(document.getElementById('created-slots-summary').textContent);
            const totalExcluded = parseInt(document.getElementById('excluded-slots-summary').textContent);
            
            let message = `@lang('words.confirm_create_message', ['created' => '', 'excluded' => '']).replace('{created}', totalCreated).replace('{excluded}', totalExcluded)`;
            message = `${totalCreated} @lang('words.slots_will_be_created'), ${totalExcluded} @lang('words.slots_will_not_be_created')\n\n@lang('words.confirm_continue')`;

            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    </script>
</x-layouts.main.website>