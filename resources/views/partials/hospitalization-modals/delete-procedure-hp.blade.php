<!-- Protsedura O'chirish Dialogi -->
<dialog id="procedureDeleteModal" class="delete-modal">
    <div class="delete-modal-header">
        <h3>@lang('words.delete_procedure')</h3>
        <button class="close-btn" onclick="closeProcedureDeleteModal()">✕</button>
    </div>

    <form id="procedureDeleteForm" method="POST" action="">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning')!</h4>
                <p>@lang('words.delete_confirmation') <strong id="deleteProcedureName"></strong> @lang('words.procedure')? @lang('words.delete_warning')</p>
            </div>

            <div class="form-group"style="padding: 0;">
                <label>@lang('words.procedure_info')</label>
                <div class="info-box-delete">
                    <div class="info-row">
                        <span class="info-label">@lang('words.procedure_name'):</span>
                        <span class="info-value" id="procedureDeleteName"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="procedureDeleteCheckbox">
                    <span class="confirm-text">@lang('words.confirm_delete')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeProcedureDeleteModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="procedureDeleteSubmitBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>