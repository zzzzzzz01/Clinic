<!-- Band slot modal (Qizil) -->
<dialog class="notification-modal" id="bookedModal">
    <div class="modal-header">
        <div class="d-flex align-items-center w-100">
            <div class="flex-grow-1">
                <h5 class="delete-modal-title text-white">@lang('words.booked') @lang('words.appointment')</h5>
            </div>
            <button type="button" class="close-btn" onclick="closeBookedModal()">✕</button>
        </div>
    </div>
    <div class="delete-modal-body">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">@lang('words.patient_info')</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.select_patient')</div>
                            <div class="detail-value" id="bookedPatientName">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.passport')</div>
                            <div class="detail-value" id="bookedPatientPassport">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.birth_date')</div>
                            <div class="detail-value" id="bookedPatientBirthDate">--</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.age')</div>
                            <div class="detail-value" id="bookedPatientAge">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.phone')</div>
                            <div class="detail-value" id="bookedPatientPhone">--</div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label">@lang('words.appointment_status')</div>
                            <span class="slot-status status-booked-slot" style="font-size: 11px;">@lang('words.booked')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">@lang('words.appointment_details')</h6>
            </div>
            <div class="card-body">
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.appointment_reason')</div>
                    <div class="detail-value" id="bookedReason">--</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.duration')</div>
                    <div class="detail-value" id="bookedDuration">--</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.time')</div>
                    <div class="detail-value" id="bookedSlotTime">--:-- - --:--</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.date')</div>
                    <div class="detail-value" id="bookedSlotDate">--.--.----</div>
                </div>
                <div class="detail-item mb-3">
                    <div class="detail-label">@lang('words.registered_at')</div>
                    <div class="detail-value" id="bookedCreatedAt">--</div>
                </div>
            </div>
        </div>
        <!-- <div class="alert-danger-custom mt-3" style="background: rgba(231, 76, 60, 0.1); border: 1px solid rgba(231, 76, 60, 0.3); border-radius: 12px; padding: 12px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 fs-5" style="color: #e74c3c;"></i>
                <div class="notification-message">
                    <strong>@lang('words.attention')</strong> @lang('words.appointment_booked_warning')
                </div>
            </div>
        </div> -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="cancelBookedBtn">
            <i class="fas fa-times-circle me-2"></i> @lang('words.cancel')
        </button>
    </div>
</dialog>