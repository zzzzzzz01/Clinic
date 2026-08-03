<dialog id="testModal" class="notification-modal">
    <div class="modal-header" style="background: linear-gradient(135deg, #00BFFF 0%, #1E90FF 100%)">
        <div class="modal-title">@lang('words.select_available_tests')
        <div class="selected-count">
            <span id="modalSelectedCount">{{ $panelTests->count() }}</span>
        </div>
        </div>
        <button class="modal-close" id="modalClose">✕</button>
    </div>
    <div class="modal-body">
        <div class="modal-search">
            <input type="text" class="modal-search-input" id="testSearch" placeholder="@lang('words.search_test_placeholder')">
        </div>
        
        <div class="available-tests-grid" id="availableTestsContainer">
            @foreach($allTests as $test)
                <div class="test-card {{ $panelTests->contains('id', $test->id) ? 'selected' : '' }}" 
                        data-test-id="{{ $test->id }}"
                        data-test-name="{{ $test->name }}"
                        data-test-code="{{ $test->code }}"
                        data-test-price="{{ $test->price }}"
                        data-test-duration="{{ $test->duration }}"
                        data-test-description="{{ $test->description ?? '' }}">
                    <div class="test-card-header">
                        <div class="test-card-name">{{ $test->name }}</div>
                        <div class="test-card-code">{{ $test->code }}</div>
                    </div>
                    <div class="test-card-body">{{ $test->description ?? __('words.no_description') }}</div>
                    <div class="test-card-footer">
                        <div class="test-card-price">${{ number_format($test->price, 2) }}</div>
                        <div class="test-card-duration"><i class="fas fa-clock"></i> {{ $test->duration }} @lang('words.hours')</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn-secondary" id="modalCancel">@lang('words.cancel')</button>
        <button class="btn-primary" id="modalSave">@lang('words.save')</button>
    </div>
</dialog>