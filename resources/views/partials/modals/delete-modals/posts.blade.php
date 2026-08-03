<dialog id="deleteDialog" class="delete-modal">
    <form method="POST" action="" id="deletePostForm">
        @csrf
        @method('DELETE')
        <div class="delete-modal-header">
            <h3>@lang('words.delete_post')</h3>
            <button type="button" class="close-btn" onclick="closeDialog('deleteDialog')">✕</button>
        </div>
        
        <div class="modal-body">
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h4>@lang('words.warning_irreversible')</h4>
                <p>@lang('words.delete_post_warning')</p>
            </div>

            <div class="form-group">
                <label>@lang('words.post_info')</label>
                <div class="info-box-delete">
                    <div class="info-row">
                        <span class="info-label">@lang('words.post'):</span>
                        <span class="info-value" id="deletePostTitle"></span>
                    </div>
                </div>
            </div>

            <div class="confirm-box">
                <label class="confirm-label">
                    <input type="checkbox" id="deleteCheckbox" onchange="toggleDeleteButton()">
                    <span class="confirm-text">@lang('words.confirm_delete_post')</span>
                </label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDialog('deleteDialog')">@lang('words.cancel')</button>
            <button type="submit" class="btn-delete" id="confirmDeleteBtn" disabled>@lang('words.delete')</button>
        </div>
    </form>
</dialog>