<!-- resources/views/partials/notification-modal.blade.php -->
<dialog id="doctorNotificationModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.send_notification_to'): <span id="doctorNotifName"></span></h3>
        <button class="close-btn" onclick="closeDoctorNotificationModal()">✕</button>
    </div>

    <form id="doctorNotifForm" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label class="notification-label">@lang('words.doctor_info')</label>
                <div class="language-inputs">
                    <div class="language-input-wrapper">
                        <input type="text" class="form-control" id="doctorNotifFullName" readonly>
                    </div>
                    <div class="language-input-wrapper">
                        <input type="text" class="form-control" id="doctorNotifRole" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="notification-label">@lang('words.title')</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <div class="form-group">
                <label class="notification-label">@lang('words.description')</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label class="notification-label">@lang('words.send_time')</label>
                <input type="datetime-local" class="form-control" name="send_time" value="{{ now()->format('Y-m-d\TH:i') }}" required>
            </div>
        </div>

        <div class="modal-footer">
            <a href="#" id="doctorNotifLink">
                <button type="button" class="btn-success" style="width: 100%;">
                    @lang('words.view_all_notifications') (<span id="doctorNotifCount">0</span>)
                </button>
            </a>
            <button type="button" class="btn-secondary" onclick="closeDoctorNotificationModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">@lang('words.send')</button>
        </div>
    </form>
</dialog>

<!-- NURSE NOTIFICATION MODAL -->
<dialog id="nurseNotificationModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.send_notification_to'): <span id="nurseNotifName"></span></h3>
        <button class="close-btn" onclick="closeNurseNotificationModal()">✕</button>
    </div>

    <form id="nurseNotificationForm" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label class="notification-label">@lang('words.nurse_info')</label>
                <div class="language-inputs">
                    <div class="language-input-wrapper">
                        <input type="text" class="form-control" id="nurseNotifFullName" readonly>
                    </div>
                    <div class="language-input-wrapper">
                        <input type="text" class="form-control" id="nurseNotifRole" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="notification-label">@lang('words.title')</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <div class="form-group">
                <label class="notification-label">@lang('words.description')</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label class="notification-label">@lang('words.send_time')</label>
                <input type="datetime-local" class="form-control" name="send_time" value="{{ now()->format('Y-m-d\TH:i') }}" required>
            </div>
        </div>

        <div class="modal-footer">
            <a href="">
                <button type="button" class="btn-success" style="width: 100%;">
                    @lang('words.view_all_notifications') (<span id="nurseNotifCount">0</span>)
                </button>
            </a>
            <button type="button" class="btn-secondary" onclick="closeNurseNotificationModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">@lang('words.send')</button>
        </div>
    </form>
</dialog>

<style>
    .form-group {
        margin-bottom: 10px;
    }
</style>