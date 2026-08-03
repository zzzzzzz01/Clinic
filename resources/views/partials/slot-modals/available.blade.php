<!--  Bo'sh slot modal (Yashil) - 3 QADAMLI TAKOMILLASHTIRILGAN -->
<dialog class="success-modal" id="availableModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>@lang('words.create_new_appointment')</h3>
                <button type="button" class="close-btn" onclick="closeAvailableModal()">✕</button>
            </div>
            
            <!-- Progress Steps -->
            <div class="steps">
                <div class="step-item" id="step1">
                    <div class="step-number">1</div>
                    <div class="step-label">@lang('words.time_date')</div>
                </div>

                <div class="step-item" id="step2">
                    <div class="step-number">2</div>
                    <div class="step-label">@lang('words.select_patient')</div>
                </div>

                <div class="step-item" id="step3">
                    <div class="step-number">3</div>
                    <div class="step-label">@lang('words.write_reason')</div>
                </div>
            </div>
            
            <div class="success-modal-body">

                <!-- Step 1 -->
                <div id="step1Content">
                    <div class="row">
                        
                        <div class="col-md-6">

                            <div class="detail-item mb-3">
                                <div class="detail-label">@lang('words.date')</div>
                                <div class="detail-value" id="availableModalDate">--</div>
                            </div>

                            <div class="detail-item mb-3">
                                <div class="detail-label">@lang('words.doctor')</div>

                                <div class="detail-value">
                                    <!-- Katta ekran -->
                                    <span class="d-none d-sm-inline">
                                        {{ $doctor->user->last_name }} {{ $doctor->user->name }}
                                    </span>

                                    <!-- Kichik ekran -->
                                    <span class="d-sm-none">
                                        {{ $doctor->user->last_name }} {{ mb_substr($doctor->user->name, 0, 1) }}.
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="detail-item mb-3">
                                <div class="detail-label">@lang('words.time')</div>
                                <div class="detail-value" id="availableModalTime">--</div>
                            </div>

                            <div class="detail-item mb-3">
                                <div class="detail-label">@lang('words.status')</div>
                                <div class="detail-value">@lang('words.available')</div>
                            </div>

                        </div>
                    </div>

                    <div class="alert-info-custom">
                        <div class="d-flex" style="align-items: center;">
                            
                            <i class="fas fa-info-circle me-3"
                               style="color: #2ecc71; font-size: 1.2rem;">
                            </i>

                            <div class="notification-message">
                                <strong>@lang('words.attention')</strong>
                                @lang('words.next_step_info')
                            </div>

                        </div>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div id="step2Content" style="display: none;">

                    <div class="search-section">

                        <div class="search-tabs">

                            <button class="search-tab active"
                                    data-type="passport"
                                    onclick="switchSearchTab('passport')">

                                @lang('words.search_by_passport')
                            </button>

                            <button class="search-tab"
                                    data-type="name"
                                    onclick="switchSearchTab('name')">

                                @lang('words.search_by_name')
                            </button>

                        </div>
                        
                        <!-- Pasport qidiruv -->
                        <div id="passportSearch">

                            <div class="search-fields">

                                <div>
                                    <input type="text"
                                           id="passportSeries"
                                           placeholder="@lang('words.passport_series_placeholder')"
                                           maxlength="2"
                                           style="text-transform:uppercase">

                                    <div class="invalid-feedback" id="passportSeriesError"></div>
                                </div>

                                <div>
                                    <input type="text"
                                           id="passportNumber"
                                           placeholder="@lang('words.passport_number_placeholder')"
                                           maxlength="20">

                                    <div class="invalid-feedback" id="passportNumberError"></div>
                                </div>

                            </div>

                        </div>
                        
                        <!-- Ism/Familiya -->
                        <div id="nameSearch" style="display: none;">

                            <div class="search-fields full-width">

                                <div>
                                    <input type="text"
                                           id="patientName"
                                           placeholder="@lang('words.patient_name_placeholder')">

                                    <div class="invalid-feedback" id="patientNameError"></div>
                                </div>

                            </div>

                        </div>
                        
                        <button class="search-btn"
                                onclick="searchPatientsBackend()"
                                id="searchBtn">

                            <i class="fas fa-search me-2"></i>
                            @lang('words.search')
                        </button>

                    </div>
                    
                    <div id="searchLoader"
                         style="display: none; text-align: center; padding: 20px;">

                        <i class="fas fa-spinner fa-spin fa-2x"
                           style="color: #2ecc71;">
                        </i>

                        <p class="mt-2">@lang('words.searching')</p>

                    </div>
                    
                    <div id="patientResults" class="patient-results"></div>
                </div>
                
                <!-- Step 3 -->
                <div id="step3Content" style="display: none;">
                    
                    <!-- Selected Patient -->
                    <div class="selected-patient" id="selectedPatientCard">

                        <div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="detail-item mb-3">
                                        <div class="detail-label">@lang('words.patient')</div>
                                        <div class="detail-value" id="displayPatientName">---</div>
                                    </div>

                                    <div class="detail-item mb-3">
                                        <div class="detail-label">@lang('words.passport')</div>
                                        <div class="detail-value" id="displayPatientPassport">---</div>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="detail-item mb-3">
                                        <div class="detail-label">@lang('words.phone')</div>
                                        <div class="detail-value" id="displayPatientPhone">---</div>
                                    </div>

                                    <div class="detail-item mb-3">
                                        <div class="detail-label">@lang('words.birth_date')</div>

                                        <div class="detail-value">
                                            <span id="displayPatientBirth">---</span>

                                            (<span id="displayPatientAge">?</span>
                                            @lang('words.years_old'))
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-12">

                                    <button onclick="changeSelectedPatient()"
                                            class="btn btn-warning btn-sm"
                                            style="margin-top: 5px;">

                                        <i class="fas fa-exchange-alt"></i>
                                        @lang('words.change')
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>
                    
                    <!-- Reason -->
                    <div class="reason-section" style="margin-top: 15px;">

                        <div class="mb-3">

                            <label style="font-weight: 500;
                                          font-size: 0.85rem;
                                          margin-bottom: 6px;
                                          display: block;">

                                @lang('words.appointment_reason')
                            </label>

                            <input type="text"
                                   id="reasonText"
                                   class="form-control"
                                   placeholder="@lang('words.patient_complaint_placeholder')">

                        </div>
                        
                        <div class="mb-3">

                            <label style="font-weight: 500;
                                          font-size: 0.85rem;
                                          margin-bottom: 6px;
                                          display: block;">

                                @lang('words.additional_information')
                            </label>

                            <textarea id="additionalInfo"
                                      class="form-control"
                                      rows="3"
                                      placeholder="@lang('words.additional_information_placeholder')"></textarea>

                        </div>

                    </div>
                    
                </div>
            </div>
            
            <div class="modal-footer">

                <button type="button"
                        class="btn-outline-secondary"
                        id="backBtn"
                        onclick="prevStep()"
                        style="display: none;">

                    ← @lang('words.back')
                </button>

                <button type="button"
                        class="btn-success"
                        id="nextBtn"
                        onclick="nextStep()">

                    @lang('words.next') →
                </button>

                <button type="button"
                        class="btn-primary"
                        id="saveBtn"
                        onclick="saveAppointment()"
                        style="display: none;
                               background: linear-gradient(135deg, #2ecc71, #27ae60);">

                    @lang('words.create_appointment')
                </button>

            </div>
        </div>
    </div>
</dialog>