<!-- Tugagan slot modal (Kul rang) -->
<dialog class="secondary-modal" id="completedModal">
    <div class="secondary-modal-header">
        <div class="d-flex align-items-center w-100">
            <div class="flex-grow-1">
                <h5 class="secondary-modal-title text-white">@lang('words.completed_appointment')</h5>
            </div>
            <button type="button" class="close-btn" onclick="closeCompletedModal()">✕</button>
        </div>
    </div>
    <div class="secondary-modal-body">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="card-title"><i class="fas fa-user-injured me-2"></i>@lang('words.patient_info')</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.patient_full_name')</div>
                            <div class="detail-value" id="completedPatientName">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.passport')</div>
                            <div class="detail-value" id="completedPatientPassport">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.birth_date')</div>
                            <div class="detail-value" id="completedPatientBirthDate">--</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.age')</div>
                            <div class="detail-value" id="completedPatientAge">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.phone')</div>
                            <div class="detail-value" id="completedPatientPhone">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.appointment_status')</div>
                            <span class="slot-status status-completed-slot" style="font-size: 11px;">@lang('words.completed')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-stethoscope me-2"></i>@lang('words.appointment_details')</h6>
            </div>
            <div class="card-body">
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.appointment_reason')</div>
                    <div class="detail-value" id="completedReason">--</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.duration')</div>
                    <div class="detail-value" id="completedDuration">--</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.time')</div>
                    <div class="detail-value" id="completedSlotTime">--:-- - --:--</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.date')</div>
                    <div class="detail-value" id="completedSlotDate">--.--.----</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.registered_at')</div>
                    <div class="detail-value" id="completedCreatedAt">--</div>
                </div>
            </div>
        </div>
        <div class="alert-secondary-custom mt-3" style="background: rgba(108, 117, 125, 0.1); border: 1px solid rgba(108, 117, 125, 0.3); border-radius: 12px; padding: 12px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-calendar-check me-3 fs-5" style="color: #6c757d;"></i>
                <div class="notification-message">
                    <strong>@lang('words.attention')</strong> @lang('words.appointment_completed_warning')
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeCompletedModal()">
            <i class="fas fa-times me-2"></i>@lang('words.close')
        </button>
    </div>
</dialog>