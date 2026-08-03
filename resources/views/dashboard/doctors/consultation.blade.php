<x-layouts.main.website>
    <x-slot:title>
    {{ $appointment->patient->user->name }} {{ $appointment->patient->user->last_name }}     
    </x-slot:title>
    

    <link rel="stylesheet" href="{{ asset('temp2/css/consultation.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
        @php
            $previousUrl = url()->previous();
        @endphp

        <ol class="breadcrumb">

            @if($previousUrl === route('doctor.dashboard'))
                <li class="breadcrumb-item">
                    <a href="{{ route('doctor.dashboard') }}">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    @lang('words.treatment')
                    ({{ $appointment->patient->user->last_name }} {{ $appointment->patient->user->name }})
                </li>

            @elseif($previousUrl === route('doctor.appointments'))
                <li class="breadcrumb-item">
                    <a href="{{ route('doctor.dashboard') }}">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctor.appointments') }}">
                        @lang('words.admissions')
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    @lang('words.treatment')
                </li>
            @endif

        </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.patient_treatment')</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="patient-card">
            <h2><i class="fas fa-user-injured"></i> @lang('words.patient_info')</h2>
            <div class="patient-details-grid">
                <div class="detail-item">
                    <div class="detail-label"><i class="fas fa-user"></i> @lang('words.full_name')</div>
                    <div class="detail-value">{{ $appointment->patient->user->last_name }} {{ $appointment->patient->user->name }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label"><i class="fas fa-birthday-cake"></i> @lang('words.age')</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->patient->birth_date)->age }} @lang('words.years_old')</div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <!-- 1. Dori yozish -->
            <div class="section-card medication">
                <div class="section-header">
                    <h3><i class="fas fa-pills"></i> @lang('words.write_prescription')</h3>
                    <button type="button" class="btn-view-prescriptions" id="viewPrescriptionsBtn" style="display: none;">
                        @lang('words.prescriptions') (<span id="prescriptionsCount">0</span>)
                    </button>
                    <div class="section-number">1</div>
                </div>
                
                <div id="medicationsList">
                    <table class="medications-table" id="medicationsTable" style="display: none;">
                        <thead>
                            <tr>
                                <th>@lang('words.name')</th>
                                <th>@lang('words.form')</th>
                                <th>@lang('words.usage')</th>
                                <th>@lang('words.time')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="medicationsTableBody"></tbody>
                    </table>
                    <div id="noMedicationsText" class="no-medications">
                        @lang('words.no_medications')<br>@lang('words.click_add_medicine')
                    </div>
                </div>
                
                <div class="button-group" id="buttonGroup">
                    <button type="button" class="btn-primary" id="openMedicationBtn">
                        <i class="fas fa-plus"></i> @lang('words.add_medicine')
                    </button>
                    <button type="button" class="btn-success" id="printPrescriptionBtn" style="display: none;">
                        <i class="fas fa-print"></i> @lang('words.print')
                    </button>
                </div>
            </div>

            <!-- 2. Tashxis qo'yish -->
            <div class="section-card">
                <div class="section-header">
                    <h3><i class="fas fa-diagnoses"></i> @lang('words.make_diagnosis')</h3>
                    <div class="section-number">2</div>
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-search"></i> @lang('words.main_diagnosis')</label>    
                    <input type="text" class="form-control" id="diagnosisField" placeholder="@lang('words.enter_main_diagnosis')">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-comment-medical"></i> @lang('words.full_description')</label>
                    <textarea class="form-control" id="fullDiagnosisField" rows="4" placeholder="@lang('words.enter_full_diagnosis')"></textarea>
                </div>
            </div>

            <!-- 3. Davolash turi -->
            <div class="section-card hospitalization">
                <div class="section-header">
                    <h3><i class="fas fa-hospital"></i> @lang('words.treatment_type')</h3>
                    <div class="section-number">3</div>
                </div>

                <div class="hospitalization-options">
                    <div class="hospitalization-option selected" id="outpatientOption">
                        <div class="option-icon outpatient"><i class="fas fa-home"></i></div>
                        <h4 class="option-title">@lang('words.outpatient')</h4>
                    </div>
                    <div class="hospitalization-option" id="inpatientOption">
                        <div class="option-icon hospitalization"><i class="fas fa-procedures"></i></div>
                        <h4 class="option-title">@lang('words.inpatient')</h4>
                    </div>
                </div>

                <div class="referral-form" id="referralForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">@lang('words.required_department')</label>
                            <select class="form-control" id="departmentField">
                                <option value="">@lang('words.select')...</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('words.urgency')</label>
                            <select class="form-control" id="urgencyField">
                                <option value="normal">@lang('words.normal')</option>
                                <option value="urgent">@lang('words.urgent')</option>
                                <option value="emergency">@lang('words.emergency')</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('words.reason_for_admission')</label>
                        <textarea class="form-control" id="referralReasonField" rows="3" placeholder="@lang('words.enter_reason')"></textarea>
                    </div>
                </div>
            </div>

            <!-- 4. Qo'shimcha Tavsiyalar -->
            <div class="section-card recommendations" id="recommendationsSection">
                <div class="section-header">
                    <h3><i class="fas fa-clipboard-check"></i> @lang('words.additional_recommendations')</h3>
                    <div class="section-number">4</div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="recommendationsField" rows="3" placeholder="@lang('words.enter_recommendations')"></textarea>
                </div>
            </div>
        </div>
        
        <div class="submit-section">
            <div class="submit-actions">
                <button type="button" class="btn-secondary" onclick="window.history.back();">
                    <i class="fas fa-times"></i> @lang('words.cancel')
                </button>
                <button type="button" class="btn-primary" id="submitAllBtn">
                    <i class="fas fa-check-circle"></i> @lang('words.complete')
                </button>
            </div>
        </div>
    </div>

    <!-- Dori qo'shish MODAL -->
    <dialog id="medicationModal" class="notification-modal">
        <div class="modal-header">
            <h3><i class="fas fa-prescription"></i> @lang('words.add_new_medicine')</h3>
            <button type="button" class="close-modal" id="closeModalBtn">✕</button>
        </div>
        <div class="modal-body">
            <div id="medicationFormsContainer">
                <div class="medication-form-group" data-index="0">
                    <div class="medication-header"><h4><i class="fas fa-pills"></i> @lang('words.medicine') 1</h4></div>
                    <div class="form-group">
                        <label class="form-label">@lang('words.medicine_name')</label>
                        <select class="form-control medication-name" id="medNameSelect_0">
                            <option value="">@lang('words.select')...</option>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}" data-dosage="{{ $medicine->strength_value }} {{ $medicine->strength_unit }}" data-form="{{ $medicine->form }}">{{ $medicine->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">@lang('words.dosage')</label>
                            <input type="text" class="form-control medication-dosage" id="dosageInput0" readonly style="background:#e9ecef;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('words.form')</label>
                            <input type="text" class="form-control medication-form" id="formInput0" readonly style="background:#e9ecef;">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">@lang('words.frequency_type')</label>
                            <select class="form-control medication-frequency-type" id="frequencyType0">
                                <option value="">@lang('words.select')...</option>
                                <option value="daily">@lang('words.daily')</option>
                                <option value="hourly">@lang('words.hourly')</option>
                                <option value="weekly">@lang('words.weekly')</option>
                                <option value="as_needed">@lang('words.as_needed')</option>
                                <option value="once">@lang('words.once')</option>
                            </select>
                        </div>
                        <div class="form-group frequency-container" id="frequencyContainer0"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">@lang('words.dosage_amount')</label>
                            <input type="text" class="form-control medication-dosage-amount" id="dosageAmount0" placeholder="@lang('words.dosage_placeholder')">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('words.duration_days')</label>
                            <input type="number" class="form-control medication-duration" id="durationInput0" value="7">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('words.note')</label>
                        <textarea class="form-control medication-note" rows="2" id="noteInput0" placeholder="@lang('words.note_placeholder')"></textarea>
                    </div>
                </div>
            </div>
            <button type="button" class="add-more-btn" id="addMoreBtn"><i class="fas fa-plus"></i> @lang('words.add_more_medicine')</button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" id="cancelModalBtn">@lang('words.cancel')</button>
            <button type="button" class="btn-primary" id="saveMedicationsBtn">@lang('words.save')</button>
        </div>
    </dialog>

    <!-- Retseptlar ro'yxati uchun DIALOG -->
    <dialog id="prescriptionsModal" class="notification-modal">
        <div class="modal-header">
            <h3><i class="fas fa-prescription-bottle"></i> @lang('words.prescriptions_list')</h3>
            <button type="button" class="close-modal" id="closePrescriptionsModalBtn">✕</button>
        </div>
        <div class="modal-body">
            <div id="prescriptionsList">
                <div class="text-center" id="noPrescriptionsText">
                    @lang('words.no_prescriptions')
                </div>
                <div id="prescriptionsTableContainer" style="display: none;">
                    <table class="prescriptions-table">
                        <thead>
                            <tr>
                                <th>@lang('words.medicine_name')</th>
                                <th>@lang('words.dosage')</th>
                                <th>@lang('words.form')</th>
                                <th>@lang('words.usage')</th>
                                <th>@lang('words.duration')</th>
                                <th>@lang('words.note')</th>
                            </tr>
                        </thead>
                        <tbody id="prescriptionsTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" id="closePrescriptionsBtn">@lang('words.close')</button>
        </div>
    </dialog>

    <!-- Yashirin formlar -->
    <form id="mainTreatmentForm" method="POST" action="{{ route('diagnose.store', $appointment->id) }}" style="display: none;">
        @csrf
        <input type="hidden" name="diagnosis" id="diagnosisInput">
        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
        <input type="hidden" name="slot_id" value="{{ $appointment->appointmentSlot->id }}">
        <input type="hidden" name="full_diagnosis" id="fullDiagnosisInput">
        <input type="hidden" name="treatment_type" id="treatmentTypeInput">
        <input type="hidden" name="department_id" id="departmentInput">
        <input type="hidden" name="urgency" id="urgencyInput">
        <input type="hidden" name="referral_reason" id="referralReasonInput">
        <input type="hidden" name="recommendations" id="recommendationsInput">
    </form>

    <form id="medicationsForm" method="POST" action="{{ route('doctor.prescriptions.store') }}" style="display: none;">
        @csrf
        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
        <input type="hidden" name="doctor_id" value="{{ $appointment->doctor->id }}">
        <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">
        <div id="medicationsFormFields"></div>
    </form>

    <!-- TEMPLATELAR -->
    <div id="hourlyTemplate" style="display: none;">
        <label class="form-label">@lang('words.hourly_label')</label>
        <select class="form-control">
            <option value="">@lang('words.select')...</option>
            <option value="1">@lang('words.every_1_hour')</option>
            <option value="2">@lang('words.every_2_hours')</option>
            <option value="3">@lang('words.every_3_hours')</option>
            <option value="4">@lang('words.every_4_hours')</option>
            <option value="6">@lang('words.every_6_hours')</option>
            <option value="8">@lang('words.every_8_hours')</option>
            <option value="12">@lang('words.every_12_hours')</option>
            <option value="24">@lang('words.every_24_hours')</option>
        </select>
    </div>
    <div id="dailyTemplate" style="display: none;">
        <label class="form-label">@lang('words.daily_label')</label>
        <input type="number" class="form-control" min="1" max="10" placeholder="3">
    </div>
    <div id="weeklyTemplate" style="display: none;">
        <label class="form-label">@lang('words.weekly_label')</label>
        <select class="form-control">
            <option value="1">@lang('words.once_per_week')</option>
            <option value="2">@lang('words.twice_per_week')</option>
            <option value="3">@lang('words.three_times_per_week')</option>
            <option value="4">@lang('words.four_times_per_week')</option>
            <option value="5">@lang('words.five_times_per_week')</option>
            <option value="6">@lang('words.six_times_per_week')</option>
            <option value="7">@lang('words.every_day')</option>
        </select>
    </div>
    <div id="asNeededTemplate" style="display: none;">
        <input type="text" class="form-control" value="@lang('words.as_needed')" readonly style="background:#f8f9fa;">
    </div>
    <div id="onceTemplate" style="display: none;">
        <input type="text" class="form-control" value="@lang('words.once')" readonly style="background:#f8f9fa;">
    </div>

    <script>
        const appointmentData = {
            id: {{ $appointment->id }},
            patientName: '{{ $appointment->patient->user->name }}',
            patientLastName: '{{ $appointment->patient->user->last_name }}',
            patientAge: {{ \Carbon\Carbon::parse($appointment->patient->birth_date)->age }},
            doctorName: '{{ auth()->user()->name }} {{ auth()->user()->last_name }}'
        };
    </script>
    
    <script src="{{ asset('temp2/js/consultation.js') }}"></script>
</x-layouts.main.website>