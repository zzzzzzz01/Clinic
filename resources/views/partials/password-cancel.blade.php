 <!-- NURSE MODAL -->
<dialog id="nursePasswordCancelModal" class="passwordCancelModal" onclose="closeNursePasswordModal()">
    <div class="modal-header">
        <h3>@lang('words.cancel_password')</h3>
        <button class="close-btn" onclick="closeNursePasswordModal()">✕</button>
    </div>

    <form id="nurseCancelPasswordForm" method="POST" action="{{ route('nurses.cancel-password', $nurse) }}">
        @csrf
        @method('PUT')
        
        <div class="modal-body">
            <div class="password-preview">
                <span>@lang('words.new_password')</span>
                <strong id="nurseModalPasswordPreview"></strong>
            </div>

            <div class="form-group">
                <label>@lang('words.send_time')</label>
                <input type="datetime-local" class="form-control" name="cancel_time" 
                       value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeNursePasswordModal()">✕ @lang('words.cancel')</button>
            <button type="submit" class="btn-primary">@lang('words.cancel_password')</button>
        </div>
    </form>
</dialog>