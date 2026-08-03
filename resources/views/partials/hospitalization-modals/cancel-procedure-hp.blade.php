<!-- Bekor qilish Dialogi -->
<dialog id="cancelDialog" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.cancel_procedure')(<strong id="cancelProcedureName"></strong>)</h3>
        <button class="close-btn" onclick="document.getElementById('cancelDialog').close()">✕</button>
    </div>
    <form id="cancelForm" method="POST" action="{{ route('hospitalization.procedure.administation.cancel') }}">
        @csrf 
        <input type="hidden" name="hospitalization_procedure_id" id="cancelProcedureId">
        <div class="modal-body"> 
            <div class="form-group" style="padding: 0;">
                <label class="notification-label">@lang('words.cancel_reason')</label>
                <textarea class="form-control" name="cancel_reason" rows="3" placeholder="@lang('words.enter_cancel_reason')..." required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="document.getElementById('cancelDialog').close()">@lang('words.no')</button>
            <button type="submit" class="btn-danger">@lang('words.yes_cancel')</button>
        </div>
    </form>
</dialog>