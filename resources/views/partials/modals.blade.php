<!-- Feature uchun Tahrirlash dialogi (MOBILE) -->
<dialog class="notification-modal" id="editFeatureModal">
    <div class="modal-header">
        <h3>@lang('words.edit_feature')</h3>
        <button class="close-btn" onclick="closeDialog('editFeatureModal')">✕</button>
    </div>

    <form id="editFeatureForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <input type="hidden" id="modalFeatureId" name="id">
            
            <div class="form-group">
                <label>@lang('words.name_uz')</label>
                <input type="text" class="form-control" id="modalNameUz" name="name_uz" required>
            </div>

            <div class="form-group">
                <label>@lang('words.name_ru')</label>
                <input type="text" class="form-control" id="modalNameRu" name="name_ru" required>
            </div>

            <div class="form-group">
                <label>@lang('words.name_en')</label>
                <input type="text" class="form-control" id="modalNameEn" name="name_en" required>
            </div>
            
            <div class="form-group">
                <label>@lang('words.description_uz')</label>
                <textarea class="form-control" id="modalDescriptionUz" name="description_uz" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label>@lang('words.description_ru')</label>
                <textarea class="form-control" id="modalDescriptionRu" name="description_ru" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label>@lang('words.description_en')</label>
                <textarea class="form-control" id="modalDescriptionEn" name="description_en" rows="2"></textarea>
            </div>
            
            <div class="form-group">
                <label>@lang('words.status')</label>
                <select class="form-control" id="modalStatus" name="status" required>
                    <option value="1">@lang('words.active')</option>
                    <option value="0">@lang('words.inactive')</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDialog('editFeatureModal')">
                <i class="fas fa-times"></i> @lang('words.cancel')
            </button>
            <button type="submit" class="btn-primary">
                <i class="fas fa-check"></i> @lang('words.save')
            </button>
        </div>
    </form>
</dialog>

<!-- Feature uchun Qulaylik Yaratish dialogi (MOBILE) -->
<dialog class="notification-modal" id="createFeatureModal">
    <div class="modal-header">
        <h3>@lang('words.add_new_feature')</h3>
        <button class="close-btn" onclick="closeDialog('createFeatureModal')">✕</button>
    </div>

    <form id="createFeatureForm" method="POST" action="{{ route('features.store') }}">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label>@lang('words.name_uz')</label>
                <input type="text" class="form-control" name="name_uz" placeholder="@lang('words.example_wifi')" required>
            </div>

            <div class="form-group">
                <label>@lang('words.name_ru')</label>
                <input type="text" class="form-control" name="name_ru" placeholder="@lang('words.example_wifi_ru')" required>
            </div>

            <div class="form-group">
                <label>@lang('words.name_en')</label>
                <input type="text" class="form-control" name="name_en" placeholder="@lang('words.example_wifi_en')" required>
            </div>
            
            <div class="form-group">
                <label>@lang('words.description_uz')</label>
                <textarea class="form-control" name="description_uz" rows="2" placeholder="@lang('words.description_uz_placeholder')"></textarea>
            </div>

            <div class="form-group">
                <label>@lang('words.description_ru')</label>
                <textarea class="form-control" name="description_ru" rows="2" placeholder="@lang('words.description_ru_placeholder')"></textarea>
            </div>

            <div class="form-group">
                <label>@lang('words.description_en')</label>
                <textarea class="form-control" name="description_en" rows="2" placeholder="@lang('words.description_en_placeholder')"></textarea>
            </div>
            
            <div class="form-group">
                <label>@lang('words.status')</label>
                <select class="form-control" name="status" required>
                    <option value="1" selected>@lang('words.active')</option>
                    <option value="0">@lang('words.inactive')</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDialog('createFeatureModal')">
                <i class="fas fa-times"></i> @lang('words.cancel')
            </button>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> @lang('words.save')
            </button>
        </div>
    </form>
</dialog>

<!-- Doctor uchun - Tugagan qabul modali -->
<dialog class="completed-modal" id="completedModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-white">@lang('words.completed_appointment_info')</h5>
            <button type="button" class="close-btn" onclick="closeModal('completedModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    <h6>@lang('words.patient_info')</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">@lang('words.full_name')</div>
                                <div class="detail-value" id="completedPatientName">--</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">@lang('words.passport')</div>
                                <div class="detail-value" id="completedPatientPassport">--</div>
                            </div>
                            <div class="detail-item">
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
                                <span class="slot-status status-completed-slot">@lang('words.completed')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">@lang('words.appointment_details')</h6>
                </div>
                <div class="card-body">
                    <div class="detail-item mb-3">
                        <div class="detail-label">@lang('words.appointment_reason')</div>
                        <div class="detail-value" id="completedReason">--</div>
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
            <div class="alert-secondary-custom mt-3" style="background: rgba(149, 165, 166, 0.1); border: 1px solid rgba(149, 165, 166, 0.3); border-radius: 12px; padding: 12px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar-check me-3 fs-5" style="color: #7f8c8d;"></i>
                    <div class="notification-message">
                        <strong>@lang('words.attention'):</strong> @lang('words.appointment_completed_warning')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('completedModal')">
                <i class="fas fa-times me-2"></i>@lang('words.close')
            </button>
        </div>
    </div>
</dialog>

<!-- Doctor uchun - Band qabul modali -->
<dialog class="delete-modal" id="bookedModal">
    <div class="modal-content">
        <div class="delete-modal-header" style=" background: linear-gradient(135deg, #00BFFF 0%, #1E90FF 100%);">
            <h3>@lang('words.appointment_booked')</h3>
            <button type="button" class="close-btn" onclick="closeModal('bookedModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">@lang('words.patient_info')</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item mb-3">
                                <div class="detail-label">@lang('words.full_name')</div>
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
                                <span class="slot-status status-booked-slot" style="font-size: 11px;">@lang('words.pending')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">@lang('words.appointment_details')</h6>
                </div>
                <div class="card-body">
                    <div class="detail-item mb-3">
                        <div class="detail-label">@lang('words.appointment_reason')</div>
                        <div class="detail-value" id="bookedReason">--</div>
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
            <div style="background: linear-gradient(135deg, rgba(0, 191, 255, 0.05), rgba(0, 191, 255, 0.08)); border: 1px solid rgba(0, 191, 255, 0.3); border-radius: 12px; padding: 12px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-5" style="color: #00BFFF;"></i>
                    <div class="notification-message">
                        <strong>@lang('words.attention'):</strong> @lang('words.appointment_booked_warning')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('bookedModal')">
                <i class="fas fa-times me-2"></i>@lang('words.close')
            </button>
            <button type="button" class="btn-primary" id="startConsultationLink">
                <i class="fas fa-check-circle me-2"></i> @lang('words.start')
            </button>
        </div>
    </div>
</dialog>

<!-- Test uchun - Ko'rish modali -->
<dialog id="viewTestModal">
    <div class="modal-header">
        <h3>@lang('words.test_information')</h3>
        <button class="close-btn" id="closeViewModalBtn">✕</button>
    </div>
    <div class="modal-body">
        <div class="info-row">
            <span class="info-label">@lang('words.test_id'):</span>
            <span class="info-value" id="viewTestId"></span>
        </div>
        <div class="info-row">
            <span class="info-label">@lang('words.test_code'):</span>
            <span class="info-value" id="viewTestCode"></span>
        </div>
        <div class="info-row">
            <span class="info-label">@lang('words.test_name'):</span>
            <span class="info-value" id="viewTestName"></span>
        </div>
        <div class="info-row">
            <span class="info-label">@lang('words.unit'):</span>
            <span class="info-value" id="viewTestUnit"></span>
        </div>
        <div class="info-row">
            <span class="info-label">@lang('words.price'):</span>
            <span class="info-value" id="viewTestPrice"></span>
        </div>
        <div class="info-row">
            <span class="info-label">@lang('words.normal_range'):</span>
            <span class="info-value" id="viewTestRange"></span>
        </div>
        <div class="info-row">
            <span class="info-label">@lang('words.status'):</span>
            <span class="info-value" id="viewTestStatus"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-primary" id="closeViewTestBtn">@lang('words.close')</button>
    </div>
</dialog>

<!-- Test uchun - Store modali -->
<dialog id="createTestModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.create_new_test')</h3>
        <button class="close-btn" id="closeCreateModalBtn">✕</button>
    </div>

    <div class="modal-body">
        <form id="createTestForm" method="POST" action="{{ route('tests.store') }}">
            @csrf
            
            <div class="form-group">
                <label>@lang('words.test_code') *</label>
                <input type="text" class="form-control" name="code" required>
            </div>

            <div class="form-group">
                <label>@lang('words.test_name') *</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
                <label>@lang('words.unit') *</label>
                <input type="text" class="form-control" name="unit" required> 
            </div>

            <div class="form-group">
                <label>@lang('words.price') *</label>
                <input type="number" class="form-control" name="price" min="0">
            </div>

            <div class="form-group">
                <label>@lang('words.duration') *</label>
                <input type="number" class="form-control" name="duration" min="1">
            </div>

            <div class="form-group">
                <label>@lang('words.normal_low')</label>
                <input type="number" class="form-control" name="normal_min">
            </div>

            <div class="form-group">
                <label>@lang('words.normal_high')</label>
                <input type="number" class="form-control" name="normal_max">
            </div>

            <div class="form-group">
                <label>@lang('words.status')</label>
                <select class="form-control" name="is_active">
                    <option value="1">@lang('words.available')</option>
                    <option value="0">@lang('words.unavailable')</option>
                </select>
            </div>
        </form>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn-secondary" id="cancelCreateModalBtn">@lang('words.cancel')</button>
        <button type="submit" form="createTestForm" class="btn-primary">@lang('words.create')</button>
    </div>
</dialog>

<!-- Test uchun - Update modali -->
<dialog id="updateTestModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.edit_test')</h3>
        <button class="close-btn" id="closeUpdateModalBtn">✕</button>
    </div>

    <div class="modal-body">
        <form id="updateTestForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="updateTestId" name="test_id">
            
            <div class="form-group">
                <label>@lang('words.test_code') *</label>
                <input type="text" class="form-control" id="updateTestCode" name="code" required>
            </div>

            <div class="form-group">
                <label>@lang('words.test_name') *</label>
                <input type="text" class="form-control" id="updateTestName" name="name" required>
            </div>

            <div class="form-group">
                <label>@lang('words.unit') *</label>
                <input type="text" class="form-control" id="updateTestUnit" name="unit" required>
            </div>

            <div class="form-group">
                <label>@lang('words.price') *</label>
                <input type="number" class="form-control" id="updateTestPrice" name="price" required step="0.01" min="0">
            </div>

            <div class="form-group">
                <label>@lang('words.duration') *</label>
                <input type="number" class="form-control" id="updateTestDuration" name="duration" min="1"> @lang('words.hours')
            </div>

            <div class="form-group">
                <label>@lang('words.normal_low')</label>
                <input type="number" class="form-control" id="updateTestLow" name="normal_min" step="0.01">
            </div>

            <div class="form-group">
                <label>@lang('words.normal_high')</label>
                <input type="number" class="form-control" id="updateTestHigh" name="normal_max" step="0.01">
            </div>

            <div class="form-group">
                <label>@lang('words.status')</label>
                <select class="form-control" id="updateTestStatus" name="is_active">
                    <option value="1">@lang('words.available')</option>
                    <option value="0">@lang('words.unavailable')</option>
                </select>
            </div>
        </form>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn-secondary" id="cancelUpdateModalBtn">@lang('words.cancel')</button>
        <button type="submit" form="updateTestForm" class="btn-success">@lang('words.update')</button>
    </div>
</dialog>
