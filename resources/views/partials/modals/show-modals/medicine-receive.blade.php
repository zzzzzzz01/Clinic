<!-- View Details Dialog -->
<dialog id="viewDialog" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.view_medicine_details')</h3>
        <button type="button" class="close-btn" onclick="closeDialog('viewDialog')" aria-label="Close">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group">
                <label class="notification-label">@lang('words.medicine')</label>
                <div class="form-control" style="background-color: #f8f9fa;" id="viewMedicineName">-</div>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.receive_date')</label>
                <div class="form-control" style="background-color: #f8f9fa;" id="viewReceiveDate">-</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="notification-label">@lang('words.stock_boxes')</label>
                <div class="form-control" style="background-color: #f8f9fa;" id="viewQuantityBoxes">-</div>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.pieces_per_box')</label>
                <div class="form-control" style="background-color: #f8f9fa;" id="viewPiecesPerBox">-</div>
            </div>
        </div>
        <div class="form-group">
            <label class="notification-label">@lang('words.total_pieces')</label>
            <div class="form-control" style="background-color: #f8f9fa; font-weight: bold;" id="viewTotalPieces">-</div>
        </div>
        <div class="form-group">
            <label class="notification-label">@lang('words.manufacturer')</label>
            <div class="form-control" style="background-color: #f8f9fa;" id="viewManufacturer">-</div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-secondary" onclick="closeDialog('viewDialog')">@lang('words.close')</button>
    </div>
</dialog>