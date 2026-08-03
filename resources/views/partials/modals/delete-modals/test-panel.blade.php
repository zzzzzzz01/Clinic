<dialog id="testPanelDeleteModal" class="delete-modal">
    <div class="delete-modal-header">
        <h3>@lang('words.delete_panel')</h3>
        <button class="close-btn" id="testPanelCloseDeleteModalBtn">✕</button>
    </div>

    <form id="testPanelDeleteForm" method="POST">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning_irreversible')</h4>
                <p>@lang('words.delete_panel_warning')</p>
            </div>

            <div class="form-group">
                <label>@lang('words.panel_information')</label>
                <div class="info-box-delete">
                    <div class="info-row">
                        <span class="info-label">@lang('words.name'):</span>
                        <span class="info-value" id="testPanelDeleteName"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">@lang('words.code'):</span>
                        <span class="info-value" id="testPanelDeleteCode"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="testPanelConfirmDeleteCheckbox" required>
                    <span class="confirm-text">@lang('words.confirm_delete')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" id="testPanelCancelDeleteBtn">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="testPanelDeleteSubmitBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>