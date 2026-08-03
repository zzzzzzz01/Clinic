<dialog class="notification-modal" id="notificationModal"> 
    <div class="modal-header"> 
        <h3 id="modalTitle">@lang('words.pharmacist.sales.add_medicine')</h3>
        <button class="close-btn" id="modalCloseBtn">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group">
                <label class="notification-label" for="modalType">@lang('words.pharmacist.sales.quantity_type')</label>
                <select class="form-control" id="modalType">
                    <option value="dona">@lang('words.pharmacist.sales.piece')</option>
                    <option value="quti">@lang('words.pharmacist.sales.box')</option>
                </select>
            </div>
            <div class="form-group">
                <label class="notification-label" for="modalQuantity">@lang('words.pharmacist.sales.quantity')</label>
                <input type="number" class="form-control" id="modalQuantity" value="1" min="1">
            </div>
        </div>
        <div class="info-banner">
            <strong id="modalPriceInfo"></strong>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn-secondary" id="modalCancelBtn">@lang('words.pharmacist.sales.cancel')</button>
        <button class="btn-primary" id="modalAddBtn">@lang('words.pharmacist.sales.add')</button>
    </div> 
</dialog>