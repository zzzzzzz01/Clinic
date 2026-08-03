<!-- partials.hospitalization-modals.as-needed -->
<style>
    @media (max-width: 575px) 
    {
        .btn-primary{
            /* flex: 1;
            min-width: 100%; */
            padding: 8px 10px;
            font-size: 10px;
            justify-content: center;
            white-space: nowrap;
        }

        .text-muted {
            display: none;
        }

        .admin-action-row {
            background-color: #f8f9fa;
        }

        .admin-action-cell {
            padding: 12px;
        }

        .admin-action-wrapper {
            display: flex;
            justify-content: flex-end;
        }
    }
</style>

<dialog class="notification-modal" id="medicationModal{{ $modalItem['id'] }}">
    <div class="modal-header">
        <h3>{{ $modalItem['medicine_name'] }} - Ma'lumotlari</h3>
        <button class="close-btn" data-id="{{ $modalItem['id'] }}">✕</button>
    </div>
    
    <div class="modal-body">
        <div class="info-card info-card-warning">
            <div class="grid-2">
                <div class="full-width">
                    <div class="warning-label">Ehtiyoj Bo'lganda Beriladi:</div>
                    <div class="warning-note">Faqat og'riq paytida ishlating. Har bir doza orasida kamida 4 soat bo'lishi kerak.</div>
                </div>
            </div>
        </div>
        <div class="grid-2">
            <div class="info-card info-card-white">
                <div class="doctor-info">
                    <div class="doctor-avatar">{{ substr($modalItem['prescribedBy'], 0, 1) }}</div>
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
        
        <div class="info-card info-card-white">
            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <strong>{{ $modalItem['scheduleInfo'] }}</strong>
            </div>
            <div class="info-banner">
                <i class="fa-solid fa-capsules"></i>
                <strong>{{ $modalItem['mainInfo'] }}</strong>
            </div>
            <div class="table-wrapper"> 
                <table class="admin-table">
                    <thead>
                        <th class="text-center">#</th>
                        <th>Sana</th>
                        <th>Vaqt</th>
                        <th>Sabab/Sharh</th>
                        <th>Shifokor</th>
                    </thead>
                    <tbody>
                        @foreach($modalItem['administeredHistory'] as $index => $history)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $history['date'] }}</td>
                                <td>{{ $history['time'] }}</td>
                                <td>
                                    <strong>{{ $history['reason'] }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $history['notes'] }}</small>
                                </td>
                                <td>{{ $history['administered_by'] }}</td>
                            </tr>
                        @endforeach
                        <!-- <tr class="bg-light">
                            <td colspan="5" class="add-action-cell">
                                <div class="flex-between">
                                    <button type="button" class="btn-primary" data-id="{{ $modalItem['id'] }}">
                                        <i class="fas fa-syringe"></i> Berish
                                    </button>
                                </div>
                            </td>
                        </tr> -->

                        <tr class="admin-action-row">
                            <td colspan="5" class="add-action-cell">
                                <div class="admin-action-wrapper">
                                    <button
                                        type="button"
                                        class="btn-primary"
                                        data-id="{{ $modalItem['id'] }}"
                                    >
                                        <i class="fas fa-syringe"></i>
                                        Berish
                                    </button>
                                </div>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>
            <div id="asNeededAdministerForm{{ $modalItem['id'] }}" class="administer-form" style="display: none;">
                <h4>
                    <i class="fas fa-syringe"></i> Yangi Berish Qo'shish
                </h4>
                <form action="{{ route('hospitalization.prescription.administrations.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="hospitalization_prescription_item_id" value="{{ $modalItem['id'] }}">
                    <input type="hidden" name="status" value="given">
                    <div class="grid-3">
                        <div>
                            <label class="form-label-sm">Berilgan sana:</label>
                            <input type="date" class="form-input-sm" value="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="form-label-sm">Berilgan vaqt:</label>
                            <input type="time" class="form-input-sm" value="{{ date('H:i') }}">
                        </div>
                        <div>
                            <label class="form-label-sm">Sabab:</label>
                            <input type="text" class="form-input-sm" placeholder="Og'riq paytida">
                        </div>
                        <div class="full-width">
                            <label class="form-label-sm">Sharh:</label>
                            <textarea class="form-textarea-sm" rows="2" placeholder="Qo'shimcha sharh..."></textarea>
                        </div>
                    </div>
                    <div class="flex-end gap-10">
                        <button type="button" class="btn-outline-sm" data-id="{{ $modalItem['id'] }}">Bekor qilish</button>
                        <button type="submit" class="btn-secondary-sm">
                            <i class="fas fa-save"></i> Saqlash
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="medication-modal-footer">
        <button type="button" class="btn-cancel-modal" data-id="{{ $modalItem['id'] }}">
            <i class="fas fa-times"></i> Bekor qilish
        </button>
    </div>
</dialog>