<!-- DORI QO'SHISH MODALI -->
<dialog class="notification-modal" id="medicationModal">
    <div class="modal-header">
        <div class="header-left">
            <h3>@lang('words.add_new_medicine')</h3>
        </div>
        <button type="button" class="close-btn" id="closeMedicationModalBtn"> ✕ </button>
    </div>
    
    <form id="medicationsForm" method="POST" action="{{ route('hospitalization.prescriptions.store', $hospitalization) }}" onsubmit="return validateMedicationForm()">
        @csrf
        <input type="hidden" name="hospitalization_id" value="{{ $hospitalization->id }}">
        <input type="hidden" name="patient_id" value="{{ $hospitalization->appointment->patient->id }}">
        
        <div class="modal-body"> 
            <div class="form-row">
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label required">@lang('words.medicine_name')</label>
                    <div class="select-wrapper">
                        <select class="form-control medicine-select" name="medicine_id" onchange="updateMedicationDetails()" required>
                            <option value="">@lang('words.select_medicine')...</option>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}" data-strength="{{ $medicine->strength_value ?? '200' }} {{ $medicine->strength_unit ?? 'mg' }}" data-form="{{ $medicine->form ?? 'tabletka' }}">{{ $medicine->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="error-message" id="medicineError"></div>
                </div>
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label">@lang('words.dosage')</label>
                    <input type="text" class="form-control" name="dosage" id="dosageInput" placeholder="200mg" readonly>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label">@lang('words.form')</label>
                    <input type="text" class="form-control" name="form" id="formInput" placeholder="tabletka" readonly>
                </div>
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label required">@lang('words.frequency_type')</label>
                    <div class="select-wrapper">
                        <select class="form-control frequency-type" name="frequency_type" onchange="updateFrequencyFields()" required>
                            <option value="">@lang('words.select')...</option>
                            <option value="daily">@lang('words.daily')</option>
                            <option value="hourly">@lang('words.hourly')</option>
                            <option value="weekly">@lang('words.weekly')</option>
                            <option value="interval">@lang('words.interval')</option>
                            <option value="once">@lang('words.once')</option>
                            <option value="as_needed">@lang('words.as_needed')</option>
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="error-message" id="frequencyTypeError"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group" style="padding: 0;" id="frequencyContainer">
                    <label class="notification-label required">&nbsp;</label>
                    <div class="placeholder-box">@lang('words.select_type_first')</div>
                </div>
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label required">@lang('words.dosage_amount')</label>
                    <input type="text" class="form-control" name="dosage_amount" placeholder="--" required>
                    <div class="error-message" id="dosageAmountError"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label required">@lang('words.duration_days')</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="duration_days" min="1" placeholder="--" required>
                    </div>
                    <div class="error-message" id="durationError"></div>
                </div>
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label required">@lang('words.prescribed_by')</label>
                    <input type="hidden" name="prescribed_by_type" id="prescribedByType">
                    <input type="hidden" name="prescribed_by_id" id="prescribedById">
                    <div class="select-wrapper">
                        <select class="form-control prescribed-by-select" onchange="updatePrescribedByFields()" required>
                            <option value="">@lang('words.select_doctor')...</option>
                            @foreach($hospitalizationStaff as $staff)
                                <option value="{{ strtolower(class_basename($staff->staff_type)) }}_{{ $staff->staff_id }}" data-type="{{ strtolower(class_basename($staff->staff_type)) }}" data-id="{{ $staff->staff_id }}">
                                    {{ $staff->staff->user->last_name }} {{ $staff->staff->user->name }} ({{ $staff->role }})
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="error-message" id="prescribedByError"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label required">@lang('words.start_date')</label>
                    <input type="date" class="form-control" name="start_at" value="{{ date('Y-m-d') }}" required>
                    <div class="error-message" id="startDateError"></div>
                </div>
                <div class="form-group" style="padding: 0;">
                    <label class="notification-label">@lang('words.note')</label>
                    <textarea class="form-control" name="note" rows="3" placeholder="@lang('words.additional_notes')..."></textarea>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn-secondary" id="cancelMedicationBtn">
                <i class="fas fa-times"></i> @lang('words.cancel')
            </button>
            <button type="submit" class="btn-primary">@lang('words.save')</button>
        </div>
    </form>
</dialog> 