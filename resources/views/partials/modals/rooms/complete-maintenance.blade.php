<dialog id="completeMaintenanceModal" onclose="closeCompleteMaintenanceModal()">
    <div class="modal-header" style="background: var(--success);">
        <h3>
            <i class="fas fa-tools"></i>
            @lang('words.complete_maintenance'): @lang('words.room') <span id="modalMaintenanceRoomNumber"></span>
        </h3>
        <button class="close-btn" onclick="closeCompleteMaintenanceModal()">✕</button>
    </div>

    <form id="completeMaintenanceForm" method="POST">
        @csrf
        <input type="hidden" id="maintenanceRoomId" name="room_id">
        
        <div class="modal-body" style="padding: 30px 24px; text-align: center;">
            <!-- Tasdiqlash - markazlashtirilgan -->
            <div class="confirmation-box" style="justify-content: center; padding: 20px; background: var(--success-light); border: none; border-radius: 12px;">
                <i class="fas fa-circle-check" style="font-size: 2.5rem; color: var(--success); margin-bottom: 15px;"></i>
                <span style="font-size: 1.2rem; font-weight: 500; color: #7b341e; display: block;">@lang('words.confirm_complete_maintenance')</span>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeCompleteMaintenanceModal()">
                @lang('words.cancel')
            </button>
            <button type="submit" class="btn-primary" id="confirmCompleteMaintenance" style="background: var(--success);">
                <i class="fas fa-check"></i> @lang('words.complete')
            </button>
        </div>
    </form>
</dialog>