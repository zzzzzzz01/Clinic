<!-- ========== DOCTOR DELETE MODAL ========== -->
<dialog id="doctorDeleteModal" class="delete-modal">
    <div class="delete-modal-header">
        <h3>@lang('words.delete_doctor')</h3>
        <button class="close-btn" onclick="closeDoctorDeleteModal()">✕</button>
    </div>

    <form id="doctorDeleteForm" method="POST" action="">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning_irreversible')</h4>
                <p>@lang('words.delete_doctor_warning')</p>
            </div>

            <div class="form-group">
                <label>@lang('words.doctor_info')</label>
                <div class="info-box-delete">
                    <div class="info-row">
                        <span class="info-label">@lang('words.full_name'):</span>
                        <span class="info-value" id="doctorDeleteFullName"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">@lang('words.position'):</span>
                        <span class="info-value" id="doctorDeleteRole"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="doctorDeleteCheckbox">
                    <span class="confirm-text">@lang('words.confirm_delete_doctor')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDoctorDeleteModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="doctorDeleteSubmitBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>

<!-- ========== NURSE DELETE MODAL ========== -->
<dialog id="deleteNurseModal" class="delete-modal">
    <div class="modal-header delete-header">
        <h3>@lang('words.delete_nurse')</h3>
        <button class="close-btn" onclick="closeNurseDeleteModal()">✕</button>
    </div>

    <form id="deleteNurseForm" method="POST">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning_irreversible')</h4>
                <p>@lang('words.delete_nurse_warning')</p>
            </div>

            <div class="form-group">
                <label class="delete-label">@lang('words.nurse_info')</label>
                <div class="info-box-delete">
                    <div class="info-row">
                        <span class="info-label">@lang('words.full_name'):</span>
                        <span class="info-value" id="deleteNurseFullName"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">@lang('words.position'):</span>
                        <span class="info-value" id="deleteNurseRole"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="confirmDeleteCheckbox" required>
                    <span class="confirm-text">@lang('words.confirm_delete_nurse')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="deleteSubmitBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>

<!-- ========== FEATURE DELETE MODAL ========== -->
<dialog id="featureDeleteModal" class="delete-modal">
    <div class="delete-modal-header">
        <h3> @lang('words.delete_feature')</h3>
        <button class="close-btn" onclick="closeFeatureDeleteModal()">✕</button>
    </div>

    <form id="featureDeleteForm" method="POST" action="">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning')</h4>
                <p>@lang('words.delete_warning_message')</p>
            </div>

            <div class="form-group">
                <label>@lang('words.feature_info')</label>
                <div class="info-box-delete">
                    <div class="info-row">
                        <span class="info-label">@lang('words.feature_name'):</span>
                        <span class="info-value" id="featureDeleteName"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">@lang('words.status'):</span>
                        <span class="info-value" id="featureDeleteStatus"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="featureDeleteCheckbox">
                    <span class="confirm-text">@lang('words.confirm_delete_feature')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeFeatureDeleteModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="featureDeleteSubmitBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>

<!-- ========== SUPPLIER DELETE MODAL ========== -->
<dialog id="supplierDeleteModal" class="delete-modal">
    <div class="modal-header delete-header">
        <h3>@lang('words.supplier_delete_title')</h3>
        <button class="close-btn" onclick="closeSupplierDeleteModal()">✕</button>
    </div>

    <form id="supplierDeleteForm" method="POST">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.supplier_delete_warning_title')</h4>
                <p>@lang('words.supplier_delete_warning_text')</p>
            </div>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">@lang('words.supplier_delete_name_label')</span>
                    <span class="info-value" id="supplierDeleteName"></span>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="supplierConfirmDeleteCheckbox" required>
                    <span class="confirm-text">@lang('words.supplier_delete_confirm_text')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeSupplierDeleteModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="supplierDeleteSubmitBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>


<!-- ========== MEDICINE DELETE MODAL ========== -->
<dialog id="deleteMedicineModal" class="delete-modal">
    <div class="modal-header delete-header">
        <h3>@lang('words.delete_medicine')</h3>
        <button class="close-btn" onclick="closeMedicineDeleteModal()">✕</button>
    </div>

    <form id="deleteMedicineForm" method="POST">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning_irreversible')</h4>
                <p>@lang('words.delete_medicine_warning')</p>
            </div>

            <div class="form-group">
                <div class="info-box">
                    <div class="info-row">
                        <span class="medicine-info-label">@lang('words.medicine_name'):</span>
                        <span class="info-value" id="medicineDeleteName"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="medicineConfirmDeleteCheckbox" required>
                    <span class="confirm-text">@lang('words.confirm_delete_medicine')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeMedicineDeleteModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="medicineDeleteSubmitBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>

<!-- ========== TEST DELETE MODAL ========== -->
<dialog id="testDeleteModal" class="delete-modal">
    <div class="delete-modal-header">
        <h3>@lang('words.delete_test')</h3>
        <button class="close-btn" id="testCloseDeleteModalBtn">✕</button>
    </div>

    <form id="testDeleteForm" method="POST">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning_irreversible')</h4>
                <p>@lang('words.delete_test_warning')</p>
            </div>

            <div class="form-group">
                <label>@lang('words.test_information')</label>
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">@lang('words.test_name'):</span>
                        <span class="info-value" id="testDeleteName"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">@lang('words.test_code'):</span>
                        <span class="info-value" id="testDeleteCode"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">@lang('words.price'):</span>
                        <span class="info-value" id="testDeletePrice"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="testConfirmDeleteCheckbox">
                    <span class="confirm-text">@lang('words.confirm_delete_test')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" id="testCancelDeleteBtn">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="testConfirmDeleteBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>