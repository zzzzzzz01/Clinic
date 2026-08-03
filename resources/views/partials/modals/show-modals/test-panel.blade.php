<dialog id="testPanelViewModal">
    <div class="modal-header">
        <h3><span id="testPanelViewModalTitle">@lang('words.test_panel_details')</span></h3>
        <button class="close-btn" id="testPanelCloseViewModalBtn">✕</button>
    </div>
    <div class="modal-body">
        <!-- Modal info grid -->
        <div class="modal-info-grid" id="testPanelViewInfoGrid">
            <div class="modal-info-item">
                <div class="modal-info-label"><i class="fas fa-barcode"></i> @lang('words.code')</div>
                <div class="modal-info-value" id="testPanelViewCode">-</div>
            </div>
            <div class="modal-info-item">
                <div class="modal-info-label"><i class="fas fa-dollar-sign"></i> @lang('words.price_label')</div>
                <div class="modal-info-value" id="testPanelViewPrice">-</div>
            </div>
            <div class="modal-info-item">
                <div class="modal-info-label"><i class="fas fa-clock"></i> @lang('words.time_label')</div>
                <div class="modal-info-value" id="testPanelViewTime">-</div>
            </div>
            <div class="modal-info-item">
                <div class="modal-info-label"><i class="fas fa-map-marker-alt"></i> @lang('words.department_label_modal')</div>
                <div class="modal-info-value" id="testPanelViewDepartment">-</div>
            </div>
            <div class="modal-info-item">
                <div class="modal-info-label"><i class="fas fa-vial"></i> @lang('words.tests_count_label')</div>
                <div class="modal-info-value" id="testPanelViewTestsCount">-</div>
            </div>
            <div class="modal-info-item">
                <div class="modal-info-label"><i class="fas fa-chart-line"></i> @lang('words.status')</div>
                <div class="modal-info-value" id="testPanelViewStatus">-</div>
            </div>
        </div>
        
        <!-- Testlar ro'yxati -->
        <div class="modal-tests-header">
            <i class="fas fa-list-check"></i>
            <h5>@lang('words.tests_list')</h5>
            <span id="testPanelViewTestsCountBadge">0 @lang('words.tests_count_badge')</span>
        </div>
        <div class="modal-tests-list" style="" id="testPanelViewTestsList">
            <div class="text-center py-4">@lang('words.no_tests_found')</div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn-cancel" id="testPanelCloseViewFooterBtn">@lang('words.close')</button>
    </div>
</dialog>