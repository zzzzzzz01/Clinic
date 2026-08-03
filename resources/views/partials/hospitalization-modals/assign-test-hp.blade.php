<dialog class="notification-modal" id="assignTestModal">
    <div class="modal-header">
        <h3>@lang('words.order_test')</h3>
        <button class="close-btn" onclick="closeAssignTestModal()">✕</button>
    </div>
    
    <div class="modal-body" style="max-height: 72vh;">
        <div class="modal-type-selector">
            <div class="type-buttons-wrapper">
                <button type="button" id="testTypeBtn" class="btn-primary type-btn" onclick="showTestType('test')">
                    <i class="fas fa-vial"></i> @lang('words.test')
                </button>
                <button type="button" id="testPanelTypeBtn" class="btn-secondary type-btn" onclick="showTestType('testPanel')">
                    <i class="fas fa-list"></i> @lang('words.test_panel')
                </button>
            </div> 
        </div>
        
        <div class="form-group" style="padding: 0;">
            <label class="notification-label">@lang('words.search')</label>
            <input type="text" id="testSearch" class="form-control" placeholder="@lang('words.search_by_test_name')..." onkeyup="searchTests()">
        </div>
        
        <div class="modal-tests-list" id="testsList">
            <div class="tests-items-wrapper" id="testItemsContainer">
                @foreach($tests as $test)
                <div class="test-select-item test-item" onclick="toggleTestSelection({{ $test->id }}, 'test')" data-test-id="{{ $test->id }}" data-type="test" data-price="{{ $test->price }}" data-duration="{{ $test->time ?? '1' }}" data-code="{{ $test->code }}">
                    <div class="test-select-content">
                        <div class="test-select-info">
                            <div class="test-select-name">{{ $test->name }}</div>
                            <div class="test-select-meta">
                                <div class="test-select-code">@lang('words.code'): {{ $test->code ?? 'TEST-' . $test->id }}</div>
                            </div>
                        </div>
                        <div class="test-select-price">
                            <div class="test-price-amount">{{ number_format($test->price ?? 0, 0, ',', ' ') }} $</div>
                            <div class="test-duration-text">{{ $test->duration ?? '1' }} @lang('words.hour')</div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                @foreach($testPanels as $panel)
                <div class="test-panel-select-item test-panel-item" onclick="toggleTestSelection({{ $panel->id }}, 'testPanel')" data-panel-id="{{ $panel->id }}" data-type="testPanel" data-price="{{ $panel->price }}" data-duration="{{ $panel->time ?? '2' }}" data-code="{{ $panel->code }}" data-tests-count="{{ count($panel->tests ?? []) }}">
                    <div class="test-select-content">
                        <div class="test-select-info">
                            <div class="test-select-name">{{ $panel->name }}</div>
                            <div class="test-select-description">{{ Str::limit($panel->description ?? '-', 25) }}</div>
                            <div class="panel-tests-list">
                                <div class="panel-tests-title">@lang('words.includes'): <span>{{ count($panel->tests ?? []) }} @lang('words.tests')</span></div> 
                            </div>
                        </div>
                        <div class="test-select-price">
                            <div class="test-price-amount">{{ number_format($panel->price ?? 0, 0, ',', ' ') }} $</div>
                            <div class="test-duration-text">{{ $panel->time ?? '2' }} @lang('words.hour')</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="selected-tests" id="selectedTests" style="display: none;">
            <h4 class="selected-tests-title"><i class="fas fa-check-circle"></i> @lang('words.selected_tests')</h4>
            <form id="testOrderForm" method="POST" action="{{ route('hospitalization.tests.store', $hospitalization) }}">
                @csrf
                <input type="hidden" name="hospitalization_id" value="{{ $hospitalization->id }}">
                <input type="hidden" name="patient_id" value="{{ $hospitalization->appointment->patient->id }}">
                <input type="hidden" name="selected_tests" id="selectedTestsInput">
                <div id="selectedList" class="selected-tests-list"></div>
                <div class="form-group">
                    <label class="notification-label">@lang('words.note'):</label>
                    <textarea name="notes" id="testNotes" class="form-control" rows="3" placeholder="@lang('words.additional_notes')..."></textarea>
                </div>
                <div class="form-group">
                    <label class="notification-label">@lang('words.ordered_by'):</label>
                    <select name="ordered_by" class="form-control">
                        <option value="" selected disabled>@lang('words.select')</option>
                        @foreach ($hospitalizationStaff as $staff)
                            <option value="{{ $staff->staff_id }}">{{ $staff->staff->user->last_name }} {{ $staff->staff->user->name }} ({{ $staff->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="notification-label">@lang('words.status'):</label>
                    <select name="order_type" class="form-control">
                        <option value="" selected disabled>@lang('words.select')</option>
                        <option value="normal">@lang('words.normal')</option> 
                        <option value="urgent">@lang('words.urgent')</option>
                        <option value="emergency">@lang('words.emergency')</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="notification-label">@lang('words.order_date'):</label>
                    <input type="datetime-local" name="order_date" id="testOrderDate" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn-secondary" onclick="closeAssignTestModal()"><i class="fas fa-times"></i> @lang('words.cancel')</button>
        <button class="btn-primary" onclick="submitTestOrder()">@lang('words.save')</button>
    </div>
</dialog>