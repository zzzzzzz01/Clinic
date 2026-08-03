
<dialog id="deleteDialog" class="delete-modal">
    <form method="POST" action="" id="deleteMedicineForm">
        @csrf
        @method('DELETE')
        <div class="delete-modal-header">
            <h3>@lang('words.delete_medicine_dialog_title')</h3>
            <button type="button" class="close-btn" onclick="closeDialog('deleteDialog')">✕</button>
        </div>
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning')! @lang('words.irreversible_action')</h4>
                <p>@lang('words.delete_warning_message')</p>
            </div>

            <div class="form-group">
                <label>@lang('words.medicine_info')</label>
                <div class="info-box-delete">
                    <div class="info-row">
                        <span class="info-label">@lang('words.medicine'):</span>
                        <span class="info-value" id="deleteMedicineName"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="deleteCheckbox">
                    <span class="confirm-text">@lang('words.confirm_delete_label')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDialog('deleteDialog')">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="confirmDeleteBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>