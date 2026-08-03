<!-- Edit Dialog -->
<dialog id="editDialog" class="notification-modal">
    <form method="POST" action="" id="editMedicineForm">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h3>@lang('words.edit_medicine_dialog_title')</h3>
            <button type="button" class="close-btn" onclick="closeDialog('editDialog')" aria-label="Close">✕</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="editRowIndex" value="">
            <div class="form-row">
                <div class="form-group">
                    <label for="editMedicineName" class="notification-label">@lang('words.medicine')</label>
                    <input type="text" id="editMedicineName" class="form-control" readonly style="background-color: #f8f9fa;">
                </div>
                <div class="form-group">
                    <label for="editReceiveDate" class="notification-label">@lang('words.receive_date')</label>
                    <input type="date" id="editReceiveDate" name="receive_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="editQuantityBoxes" class="notification-label">@lang('words.stock_boxes')</label>
                    <input type="number" id="editQuantityBoxes" name="quantity_boxes" class="form-control" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label for="editPiecesPerBox" class="notification-label">@lang('words.pieces_per_box')</label>
                    <input type="number" id="editPiecesPerBox" name="pieces_per_box" class="form-control" min="1" value="1" required>
                </div>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.total_pieces')</label>
                <div class="form-control" style="background-color: #f8f9fa; font-weight: bold;" id="editTotalPieces">1</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDialog('editDialog')">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">
                @lang('words.update')
            </button>
        </div>
    </form>
</dialog>