<dialog id="assignPatientModal" onclose="closeAssignPatientModal()">
    <div class="modal-header">
        <h3>
            <i class="fas fa-user-plus"></i>
            @lang('words.assign_patient'): @lang('words.room') <span id="modalRoomNumber"></span>
        </h3>
        <button class="close-btn" onclick="closeAssignPatientModal()">✕</button>
    </div>

    <form id="assignPatientForm" method="POST">
        @csrf
        <div class="modal-body">
            <!-- Qidiruv qismi -->
            <div class="form-group">
                <label>@lang('words.search_waiting_patient')</label>
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" 
                                id="patientSearch" 
                                class="search-input" 
                                placeholder="@lang('words.search_patient_by_name_phone')"
                                autocomplete="off">
                        <button type="button" class="clear-search" id="clearSearch" onclick="clearPatientSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div id="searchResults" class="search-results">
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <p>@lang('words.enter_name_to_search')</p>
                    </div>
                </div>
            </div>

            <!-- Tanlangan bemor ma'lumotlari -->
            <div id="selectedPatientContainer" style="display: none;">
                <div class="selected-patient-info">
                    <div class="selected-patient-avatar" id="selectedPatientAvatar">B</div>
                    <div class="selected-patient-details">
                        <div class="selected-patient-name" id="selectedPatientName"></div>
                        <div class="selected-patient-meta" id="selectedPatientMeta"></div>
                    </div>
                </div>
            </div>

            <!-- Yotqizish vaqti -->
            <div class="form-group">
                <label>@lang('words.admission_date')</label>
                <input type="datetime-local" 
                        id="admissionDate" 
                        name="admission_date" 
                        class="form-control" 
                        value="{{ now()->format('Y-m-d\TH:i') }}"
                        required>
            </div>

            <!-- Bo'sh o'rinlarni tanlash -->
            <div class="form-group">
                <label>@lang('words.select_empty_bed')</label>
                <div id="bedsContainer" class="beds-container">
                    <!-- Dinamik yuklanadi -->
                </div>
            </div>

            <input type="hidden" id="selectedRoomId" name="room_id">
            <input type="hidden" id="selectedHospitalizationId" name="hospitalization_id">
            <input type="hidden" id="selectedBedId" name="bed_id">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeAssignPatientModal()">
                <i class="fas fa-times"></i> @lang('words.cancel')
            </button>
            <button type="submit" class="btn-primary" id="confirmAssignPatient" disabled>
                <i class="fas fa-check"></i> @lang('words.assign')
            </button>
        </div>
    </form>
</dialog>