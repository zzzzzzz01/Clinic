<!-- Ko'rish Dialogi -->
<dialog id="viewDialog" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.procedure_details')</h3>
        <button class="close-btn" onclick="closeDialog('viewDialog')">✕</button>
    </div>
    <div class="modal-body">
        <div class="info-section">
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">@lang('words.procedure_name'):</span>
                    <span class="info-value" id="viewProcedureName"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">@lang('words.duration'):</span>
                    <span class="info-value" id="viewDuration"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">@lang('words.room'):</span>
                    <span class="info-value" id="viewRoom"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">@lang('words.staff'):</span>
                    <span class="info-value" id="viewStaff"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">@lang('words.assigned_time'):</span>
                    <span class="info-value" id="viewAssignedAt"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">@lang('words.patient'):</span>
                    <span class="info-value" id="viewPatient"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">@lang('words.status'):</span>
                    <span class="info-value" id="viewStatus"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-secondary" onclick="closeDialog('viewDialog')">@lang('words.close')</button>
    </div>
</dialog>