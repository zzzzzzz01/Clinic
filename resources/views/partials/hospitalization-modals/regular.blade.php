<!-- partials.hospitalization-modals.regular -->

<dialog class="notification-modal" id="medicationModal{{ $modalItem['id'] }}">
    <div class="modal-header">
        <h3>{{ $modalItem['medicine_name'] }} - Ma'lumotlari</h3>
        <button class="close-btn" data-id="{{ $modalItem['id'] }}">✕</button>
    </div>
    
    <div class="modal-body">
        <div class="grid-2">
            <div class="info-card info-card-white">
                <div class="doctor-info">
                    <div class="doctor-avatar">{{ substr($modalItem['prescribedBy'] ?? '', 0, 1) }}</div>
                    <div>
                        <div class="doctor-name">{{ $modalItem['prescribedBy'] }}</div>
                        <div class="doctor-title">{{ $modalItem['prescribedByRole'] }}</div>
                    </div>
                </div>
            </div>
            <div class="info-card info-card-white">
                <div class="status-info">
                    <div class="status-icon" style="background: {{ $modalItem['statusColor'] }};">
                        <i class="{{ $modalItem['statusIcon'] }}"></i>
                    </div>
                    <div>
                        <div class="status-text" style="color: {{ $modalItem['statusColor'] }};">{{ $modalItem['statusText'] }}</div>
                        <div class="status-date">{{ $modalItem['start_date_format'] }} - {{ $modalItem['end_at_format'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="info-banner">
            <i class="fas fa-info-circle"></i>
            <strong>{{ $modalItem['scheduleInfo'] }}</strong>
        </div>
        <div class="info-banner">
            <i class="fa-solid fa-capsules"></i>
            <strong>{{ $modalItem['mainInfo'] }}</strong>
        </div>
        <div class="table-wrapper">
            <form id="slotForm{{ $modalItem['id'] }}" action="{{ route('hospitalization.prescription.administrations.store') }}" method="POST">
                @csrf
                @method('POST')
                <table class="admin-table">
                    <thead>
                        <th class="text-center">#</th>
                        <th>Sana</th>
                        <th>Vaqt</th>
                        <th>Holati</th>
                        <th>Harakatlar</th>
                    </thead>
                    <tbody>
                        @foreach($modalItem['slots'] as $slot)
                            <tr>
                                <td class="text-center">{{ $slot['slot_order'] }}</td>
                                <td>{{ $slot['scheduled_date'] }}</td>
                                <td>{{ $slot['scheduled_time'] }}</td>
                                <td>
                                    <span class="status-badge-sm" style="background-color: {{ $slot['bgColor'] }}; color: {{ $slot['textColor'] }};">
                                        {{ $slot['statusText'] }}
                                    </span>
                                </td>
                                <td class="{{ $slot['isSelectDisabled'] ? 'border-left-status' : '' }}" style="{{ $slot['isSelectDisabled'] ? 'border-left-color: ' . $slot['bgColor'] . ';' : '' }}">
                                    <input type="hidden" name="slots[{{ $slot['id'] }}][hospitalization_prescription_item_id]" value="{{ $modalItem['id'] }}">
                                    <input type="hidden" name="slots[{{ $slot['id'] }}][slot_id]" value="{{ $slot['id'] }}">
                                    @if($slot['isSelectDisabled'])
                                        <input type="hidden" name="slots[{{ $slot['id'] }}][status]" value="{{ $slot['status'] }}">
                                        <div class="status-display" style="background-color: {{ $slot['bgColor'] }}20; color: {{ $slot['bgColor'] }};">
                                            {{ $slot['statusText'] }}
                                        </div>
                                        @if($slot['skip_reason'])
                                            <input type="hidden" name="slots[{{ $slot['id'] }}][skip_reason]" value="{{ $slot['skip_reason'] }}">
                                            <div class="skip-reason-text">
                                                <strong>Sabab:</strong> {{ $slot['skip_reason'] }}
                                            </div>
                                        @endif
                                    @else
                                        <select name="slots[{{ $slot['id'] }}][status]" class="status-select" data-slot-id="{{ $slot['id'] }}">
                                            <option value="pending" {{ $slot['status'] == 'pending' ? 'selected' : '' }}>Kutilmoqda</option>
                                            <option value="given" {{ $slot['status'] == 'given' ? 'selected' : '' }}>Berildi ✓</option>
                                            <option value="skipped" {{ $slot['status'] == 'skipped' ? 'selected' : '' }}>O'tkazib yuborildi</option>
                                            <option value="stopped" {{ $slot['status'] == 'stopped' ? 'selected' : '' }}>Bekor qilish</option>
                                            @if($modalItem['isItemStopped'] && !$modalItem['hasResumedRecord'])
                                                <option value="resumed" {{ $slot['status'] == 'resumed' ? 'selected' : '' }}>Davom etildi</option>
                                            @endif
                                        </select>
                                        <div id="skipReasonContainer{{ $slot['id'] }}" class="skip-reason-container" style="display: {{ in_array($slot['status'], ['skipped', 'stopped', 'resumed']) ? 'block' : 'none' }};">
                                            <input type="text" name="slots[{{ $slot['id'] }}][skip_reason]" class="skip-reason-input" placeholder="Sabab..." value="{{ $slot['skip_reason'] }}">
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    
    <div class="medication-modal-footer">
        <button type="button" class="btn-cancel-modal" data-id="{{ $modalItem['id'] }}">
            <i class="fas fa-times"></i> Bekor qilish
        </button>
        <button type="submit" form="slotForm{{ $modalItem['id'] }}" class="btn-save-modal">Saqlash</button>
    </div>
</dialog>