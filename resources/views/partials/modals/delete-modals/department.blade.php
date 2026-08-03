<dialog id="deleteDepartmentModal" class="delete-modal">
    <div class="delete-modal-header">
        <h3>@lang('words.delete_department')</h3>
        <button class="close-btn" onclick="closeDeleteDepartmentModal()">✕</button>
    </div>

    <form id="deleteDepartmentForm" method="POST">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning_delete')</h4>
                <p>@lang('words.delete_warning_text')</p>
            </div>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">@lang('words.delete_department_name')</span>
                    <span class="info-value" id="deleteDepartmentName"></span>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="confirmDeleteCheckbox" required>
                    <span class="confirm-text">@lang('words.confirm_delete')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDeleteDepartmentModal()">
                <i class="fas fa-times"></i> @lang('words.cancel')
            </button>
            <button type="submit" class="btn-delete" id="deleteSubmitBtn" disabled>
                <i class="fas fa-trash"></i> @lang('words.delete')
            </button>
        </div>
    </form>
</dialog>