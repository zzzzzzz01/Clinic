<dialog class="notification-modal" id="checkoutModal">
    <form id="checkoutForm" method="POST" action="{{ route('pharmacist.sale.store') }}">
        @csrf 
        <div class="modal-header">
            <h3>@lang('words.pharmacist.sales.confirm_sale')</h3> 
            <button type="button" class="close-btn" id="checkoutCloseBtn">✕</button>
        </div>
        <div class="modal-body" id="checkoutBody">
            <div class="checkout-list">
                <div id="checkoutItems">
                    <!-- Dinamik -->
                </div>
            </div>
            <div class="checkout-summary" id="checkoutSummary">
                <!-- Dinamik -->
            </div>
            <div id="hiddenInputs"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" id="checkoutCancelBtn">@lang('words.pharmacist.sales.cancel')</button>
            <button type="submit" class="btn-primary" id="checkoutConfirmBtn">
                <i class="fas fa-check me-1"></i> @lang('words.pharmacist.sales.confirm')
            </button>
        </div> 
    </form>
</dialog>