<dialog id="waitingPatientsModal" onclose="closeWaitingPatientsModal()">
    <div class="modal-header">
        <h3>
            <i class="fas fa-clock"></i>
            @lang('words.waiting_patients')
            <span class="waiting-count-badge" id="waitingCount">{{ count($hospitalizations) }}</span>
        </h3>
        <button class="close-btn" onclick="closeWaitingPatientsModal()">✕</button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label>@lang('words.patients_waiting_for_room')</label>
            
            <!-- Qidiruv maydoni -->
            <div class="waiting-search-container">
                <div class="waiting-search-wrapper">
                    <i class="fas fa-search waiting-search-icon"></i>
                    <input type="text" 
                            id="waitingSearch" 
                            class="waiting-search-input" 
                            placeholder="@lang('words.search_patient_by_name_phone_doctor_department')"
                            autocomplete="off">
                    <button type="button" class="waiting-clear-search" id="waitingClearSearch" onclick="clearWaitingSearch()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Natijalar jadvali -->
            <div class="waiting-table-container">
                <table class="waiting-table" id="waitingResults">
                    <thead>
                        <tr>
                            <th>@lang('words.patient')</th>
                            <th class="desktop-only">@lang('words.doctor')</th>
                            <th>@lang('words.department')</th>
                            <th>@lang('words.status')</th>
                            <th class="desktop-only">@lang('words.waiting_time')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dinamik yuklanadi -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn-secondary" onclick="closeWaitingPatientsModal()">
            <i class="fas fa-times"></i> @lang('words.close')
        </button>
        <button type="button" class="btn-primary" onclick="refreshWaitingPatients()">
            <i class="fas fa-sync-alt"></i> @lang('words.refresh')
        </button>
    </div>
</dialog>