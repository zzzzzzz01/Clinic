<!-- Tugatish Dialogi -->
<dialog id="completeDialog" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.complete_procedure')</h3>
        <button class="close-btn" onclick="closeDialog('completeDialog')">✕</button>
    </div>
    <form id="completeForm" action="{{ route('hospitalization.procedure.administation.store') }}" method="POST">
        @csrf
        <input type="hidden" name="patient_id" id="completePatientId" value="{{ $hospitalization->appointment->patient->id }}">
        <input type="hidden" name="hospitalization_id" id="completeHospitalizationId" value="{{ $hospitalization->id }}">
        <input type="hidden" name="hospitalization_procedure_id" id="completeProcedureId">
        <div class="modal-body">
            <div class="info-banner">
                <i class="fas fa-info-circle"></i> <strong id="completeProcedureInfo"></strong>
            </div>
            <div class="info-banner">
                <i class="fas fa-user"></i> <strong id="completeMainInfo"></strong>
            </div>
            <div class="form-group" style="padding: 0;">
                <label class="notification-label">@lang('words.performed_by')</label>
                <select class="form-control" name="administered_by" required>
                    <option value="">@lang('words.select')...</option>
                    @foreach($hospitalizationStaff as $staff)
                        <option value="{{ strtolower(class_basename($staff->staff_type)) }}_{{ $staff->staff_id }}">
                            {{ $staff->staff->user->last_name }} {{ $staff->staff->user->name }} ({{ $staff->role }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="padding: 0;">
                <label class="notification-label">@lang('words.performed_time'):</label>
                <input type="datetime-local" name="administration_at" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group" style="padding: 0;">
                <label class="notification-label">@lang('words.description')</label>
                <textarea class="form-control" placeholder="@lang('words.enter_procedure_details')..." name="notes" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDialog('completeDialog')">@lang('words.cancel')</button>
            <button type="button" class="btn-primary" onclick="submitCompleteForm('save')">@lang('words.save')</button>
        </div>
    </form>
</dialog>