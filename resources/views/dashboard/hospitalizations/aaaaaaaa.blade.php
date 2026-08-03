<!-- Laboratoriya testlari tabi -->
<div class="tab-header">
    <h3> Laboratoriya Testlari</h3>
    @if(auth()->user()->hasRole('Admin'))
    <button class="btn-primary" onclick="showAssignTestModal()">
        <i class="fas fa-plus"></i> 
    </button>
    @endif
</div>

<div class="content-list" id="testContent">
    @foreach($orderItems as $item)
        <div class="test-card">
            <div class="test-header">
                <div>
                    <div class="test-name">
                        @if($item->item_type === 'test')
                            {{ $item->results->first()?->test->name ?? 'Test nomi' }}
                        @else
                            {{ $item->panel->name ?? 'Test panel' }}
                        @endif
                    </div>
                    <div class="test-type">
                        {{ $item->item_type === 'test' ? 'Test' : 'Test panel' }}
                    </div>
                </div>
                @php
                    $statusLabels = [
                        'pending' => 'Kutilmoqda',
                        'ready' => 'Bajarildi',
                        'completed' => 'Bajarildi',
                        'cancelled' => 'Bekor qilingan',
                    ];

                    $statusClass = [
                        'pending' => 'status-pending',
                        'ready' => 'status-completed',
                        'completed' => 'status-completed',
                        'cancelled' => 'status-cancelled',
                    ];

                    $statusText = $statusLabels[$item->result_status] ?? ucfirst($item->status);
                    $statusCss  = $statusClass[$item->result_status] ?? 'status-unknown';
                @endphp

                <span class="test-status {{ $statusCss }}">
                    {{ $statusText }}
                </span>
            </div>
            
            <div class="test-info">
                <div class="test-detail-row">
                    <div class="test-detail-col">
                        <div class="test-detail">
                            <span class="test-detail-label">Buyurtma sanasi:</span>
                            <span class="test-detail-value"> 
                                {{ Carbon\Carbon::parse($item->order->ordered_at)->format('Y.m.d') ?? '-' }}
                            </span>
                        </div>
                        <div class="test-detail">
                            <span class="test-detail-label">Buyurtma qilgan:</span> 
                            <span class="test-detail-value full">
                                {{ $item->order->doctor->user->last_name ?? 'Nomaʼlum' }}
                                {{ $item->order->doctor->user->name ?? 'Nomaʼlum' }}
                                <small>({{ $item->order->doctor->user->roles->pluck('name')->first() ?? '—' }})</small>
                            </span>

                            <span class="test-detail-value short">
                                {{ $item->order->doctor->user->last_name ?? 'Nomaʼlum' }}
                                {{ isset($item->order->doctor->user->name) ? mb_substr($item->order->doctor->user->name, 0, 1) . '.' : '' }}
                                <small>({{ $item->order->doctor->user->roles->pluck('name')->first() ?? '—' }})</small>
                            </span>
                        </div>
                    </div>
                    <div class="test-detail-col">
                        <div class="test-detail">
                            <span class="test-detail-label">Uchrashtirish sanasi:</span>
                            <span class="test-detail-value">2024.01.10</span>
                        </div>
                        <div class="test-detail">
                            <span class="test-detail-label">Test kodi:</span>
                            <span class="test-detail-value">
                                @if($item->item_type === 'test')
                                    {{ $item->results->first()?->test->code ?? 'N/A' }}
                                @else
                                    {{ $item->panel->code ?? 'N/A' }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>                            
            <div class="test-result">
                @if($item->item_type === 'test')
                    @php
                        $result = $item->results->first();
                        $value = $result->value ?? null;
                        $unit = $result->unit ?? null;
                        $min = $result->normal_min ?? null;
                        $max = $result->normal_max ?? null;
                        $status = $result->status ?? 'pending';
                        
                        $hasValue = !is_null($value);
                        $isNormal = true;
                        $showNormalBadge = false;
                        $rangeClass = '';
                        
                        if ($hasValue && is_numeric($value) && !is_null($min) && !is_null($max)) {
                            $numericValue = floatval($value);
                            
                            if ($numericValue < $min) {
                                $isNormal = false;
                                $rangeClass = 'below-range';
                            } elseif ($numericValue > $max) {
                                $isNormal = false;
                                $rangeClass = 'above-range';
                            } else {
                                $showNormalBadge = true;
                            }
                        }
                    @endphp
                    
                    <div class="result-label">Natija:</div>
                    <div class="result-value {{ $rangeClass }}">
                        {{ $hasValue ? $value : 'Kutilmoqda' }}
                        
                        @if($hasValue && $unit)
                            <span class="result-unit">{{ $unit }}</span>
                        @endif
                        
                        @if(!$isNormal)
                            <span class="range-indicator">
                                @if($rangeClass == 'below-range')
                                    <i class="fas fa-arrow-down"></i>
                                    <span class="indicator-text">Past</span>
                                @else
                                    <i class="fas fa-arrow-up"></i>
                                    <span class="indicator-text">Yuqori</span>
                                @endif
                            </span>
                        @endif
                        
                        @if($showNormalBadge)
                            <span class="normal-badge">
                                <i class="fas fa-check"></i>
                                <span>Normal</span>
                            </span>
                        @endif
                    </div>
                    
                    @if($hasValue && !is_null($min) && !is_null($max))
                        <div class="normal-range-info">
                            <span class="range-label">Normal oralig'i:</span>
                            <span class="range-value">
                                {{ $min }} - {{ $max }}
                                @if($unit)
                                    <span class="range-unit">{{ $unit }}</span>
                                @endif
                            </span>
                        </div>
                    @endif
                @else
                    @php
                        $allCompleted = $item->results->every(fn($r) => $r->status !== 'pending');
                    @endphp

                    @if($allCompleted)
                        <div class="result-label">Natija:</div>
                        <div class="test-actions" style="margin-top:5px;">
                            <a href="">
                                <button class="btn btn-primary btn-sm">
                                    Natijalarni ko‘rish
                                </button>
                            </a>
                        </div>
                    @endif
                @endif
            </div>
            
            {{-- ESLATMA --}}
            @if($item->item_type === 'test' && $item->order->note)
                <div class="test-order-note">
                    {{ $item->order->note }}
                </div>
            @endif
        </div>
    @endforeach  
</div>

<!-- Test biriktirish modal oynasi -->
<dialog class="notification-modal" id="assignTestModal">
    <div class="modal-header">
        <h3>Test buyurtma qilish</h3>
        <button class="close-btn" onclick="closeAssignTestModal()">✕</button>
    </div>
    
    <div class="modal-body" style="max-height: 72vh;">
        <!-- Test turini tanlash tugmalari -->
        <div class="modal-type-selector">
            <div class="type-buttons-wrapper">
                <button type="button" id="testTypeBtn" class="btn-primary type-btn" onclick="showTestType('test')">
                    <i class="fas fa-vial"></i> Test
                </button>
                <button type="button" id="testPanelTypeBtn" class="btn-secondary type-btn" onclick="showTestType('testPanel')">
                    <i class="fas fa-list"></i> Test Paneli
                </button>
            </div> 
        </div>
        
        <!-- Qidiruv qismi -->
        <div class="form-group" style="padding: 0;">
            <label class="notification-label">Qidirish</label>
            <input type="text" id="testSearch" class="form-control" placeholder="Test nomi bo'yicha qidiring..." onkeyup="searchTests()">
        </div>
        
        <!-- Testlar ro'yxati -->
        <div class="modal-tests-list" id="testsList">
            <div class="tests-items-wrapper" id="testItemsContainer">
                @foreach($tests as $test)
                <div class="test-select-item test-item" 
                    onclick="toggleTestSelection({{ $test->id }}, 'test')" 
                    data-test-id="{{ $test->id }}"
                    data-type="test"
                    data-price="{{ $test->price }}"
                    data-duration="{{ $test->time ?? '1 soat' }}"
                    data-code="{{ $test->code }}">
                    <div class="test-select-content">
                        <div class="test-select-info">
                            <div class="test-select-name">
                                {{ $test->name }}
                            </div>
                            <div class="test-select-meta">
                                <!-- <span class="test-category-badge">{{ $test->category ?? 'Umumiy' }}</span> -->
                                <div class="test-select-code">Kod: {{ $test->code ?? 'TEST-' . $test->id }}</div>
                            </div>
                        </div>
                        <div class="test-select-price">
                            <div class="test-price-amount">
                                {{ number_format($test->price ?? 0, 0, ',', ' ') }} $
                            </div>
                            <div class="test-duration-text">
                                {{ $test->duration ?? '1' }} soat
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                @foreach($testPanels as $panel)
                <div class="test-panel-select-item test-panel-item" 
                    onclick="toggleTestSelection({{ $panel->id }}, 'testPanel')" 
                    data-panel-id="{{ $panel->id }}"
                    data-type="testPanel"
                    data-price="{{ $panel->price }}"
                    data-duration="{{ $panel->time ?? '2 soat' }}"
                    data-code="{{ $panel->code }}"
                    data-tests-count="{{ count($panel->tests ?? []) }}">
                    <div class="test-select-content">
                        <div class="test-select-info">
                            <div class="test-select-name">
                                {{ $panel->name }}
                            </div>
                            <div class="test-select-description">
                                <!-- {{ $panel->description ?? '' }} -->
                                {{ Str::limit($panel->description ?? '-', 25) }}
                            </div>
                            <div class="panel-tests-list">
                                <div class="panel-tests-title">O'z ichiga oladi: <span>{{ count($panel->tests ?? []) }} ta test</span></div> 
                            </div>
                        </div>
                        <div class="test-select-price">
                            <div class="test-price-amount">
                                {{ number_format($panel->price ?? 0, 0, ',', ' ') }} $
                            </div>
                            <div class="test-duration-text">
                                {{ $panel->time ?? '2' }} soat
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Tanlanganlar ro'yxati -->
        <div class="selected-tests" id="selectedTests" style="display: none;">
            <h4 class="selected-tests-title">
                <i class="fas fa-check-circle"></i> Tanlangan testlar
            </h4>
            <form id="testOrderForm" method="POST" action="{{ route('hospitalization.tests.store', $hospitalization) }}">
                @csrf
                <input type="hidden" name="hospitalization_id" value="{{ $hospitalization->id }}">
                <input type="hidden" name="patient_id" value="{{ $hospitalization->appointment->patient->id }}">
                <input type="hidden" name="selected_tests" id="selectedTestsInput">
                
                <div id="selectedList" class="selected-tests-list">
                    <!-- Tanlangan testlar bu yerda ko'rsatiladi -->
                </div>
                
                <div class="form-group">
                    <label class="notification-label"></i> Izoh:</label>
                    <textarea name="notes" id="testNotes" class="form-control" rows="3" placeholder="Qo'shimcha izohlar..."></textarea>
                </div>

                <div class="form-group">
                    <label class="notification-label"></i> Buyurtmachi:</label>
                    <select name="ordered_by" class="form-control">
                        <option value="" selected disabled>Tanlang</option>
                        @foreach ($staffs as $staff)
                            <option value="{{ $staff->staff_id }}">
                                {{ $staff->staff->user->last_name }} {{ $staff->staff->user->name }} ({{ $staff->role }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="notification-label">Status:</label>
                    <select name="order_type" class="form-control">
                        <option value="" selected disabled>Tanlang</option>
                        <option value="normal"> Oddiy </option> 
                        <option value="urgent"> Shoshilinch </option>
                        <option value="emergency"> Favqulodda </option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="notification-label">Buyurtma sanasi:</label>
                    <input type="datetime-local" name="order_date" id="testOrderDate" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn-secondary" onclick="closeAssignTestModal()">
            <i class="fas fa-times"></i> Bekor qilish
        </button>
        <button class="btn-primary" onclick="submitTestOrder()">
            Saqlash
        </button>
    </div>
</dialog>

<style>
    /* Test Card styles */
    .test-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .test-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .test-name {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 4px;
    }

    .test-type {
        font-size: 13px;
        color: var(--gray-color);
    }

    .test-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-completed {
        background: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .test-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }

    .test-detail-row {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .test-detail-col {
        flex: 1;
        /* min-width: 200px; */
    }

    .test-detail {
        margin-bottom: 8px;
        font-size: 13px;
    }

    .test-detail-label {
        color: var(--gray-color);
        margin-right: 8px;
    } 

    

    .result-label {
        color: var(--gray-color);
        font-size: 12px;
        margin-bottom: 0;
        font-weight: 600;
    }

    /* .result-value {
        color: var(--dark-color);
        font-size: 14px;
        line-height: 1.4;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    } */

    .result-value.below-range {
        color: #e74c3c;
        border-left: 4px solid #e74c3c;
        padding-left: 8px;
    }

    .result-value.above-range {
        color: #f39c12;
        border-left: 4px solid #f39c12;
        padding-left: 8px;
    }

    .result-unit {
        color: var(--gray-color);
        font-size: 12px;
        font-weight: normal;
    }

    .range-indicator {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-left: auto;
    }

    .result-value.below-range .range-indicator {
        background-color: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.2);
    }

    .result-value.above-range .range-indicator {
        background-color: rgba(243, 156, 18, 0.1);
        color: #f39c12;
        border: 1px solid rgba(243, 156, 18, 0.2);
    }

    .range-indicator i {
        font-size: 10px;
    }

    .indicator-text {
        margin-left: 2px;
    }

    .normal-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 4px;
        background-color: rgba(46, 204, 113, 0.1);
        color: var(--secondary-color);
        font-size: 11px;
        font-weight: 600;
        border: 1px solid rgba(46, 204, 113, 0.2);
        margin-left: auto;
    }

    .normal-badge i {
        font-size: 10px;
    }

    .normal-range-info {
        font-size: 11px;
        color: var(--gray-color);
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .range-label {
        color: var(--gray-color);
    }

    .range-value {
        color: var(--dark-color);
        font-weight: 500;
    }

    .range-unit {
        color: var(--gray-color);
        margin-left: 2px;
    }

    .test-actions {
        text-align: center;
    }

    .test-order-note {
        margin-top: 8px;
        font-size: 13px;
        color: var(--gray-color);
    }

    /* Modal Styles - notification-modal */
    .modal-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        margin: 20px auto;
    }

    .modal-large {
        max-width: 1200px;
        max-height: 90vh;
        overflow-y: auto;
    }  

    /* .modal-footer {
        padding: 20px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    } */

    .modal-type-selector {
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
    }

    .type-buttons-wrapper {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .type-btn {
        flex: 1;
        padding: 10px;
    } 

    .modal-form-group {
        margin-bottom: 20px;
    }

    .modal-form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark-color);
    }

    .modal-form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .modal-tests-list {
        max-height: 500px;
        overflow-y: auto;
        /* border: 1px solid #eee; */
        border-radius: 8px;
        padding: 10px 0;
    }

    /* Tests grid - 2 columns on large, 1 column on small */
    .tests-items-wrapper {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .test-select-item {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        border-left: 4px solid #ddd;
    }

    .test-panel-select-item {
        padding: 7px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        border-left: 4px solid #ddd;
        /* grid-column: 1 / -1; */
    }

    .test-select-item:hover,
    .test-panel-select-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .test-select-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .test-select-info {
        flex: 1;
    }

    .test-select-name {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 14px;
        margin-bottom: 8px;
    }

    .test-select-meta {
        font-size: 11px;
        color: var(--gray-color);
    }

    .test-category-badge {
        display: inline-block;
        padding: 2px 8px;
        background: #ecf0f1;
        border-radius: 4px;
        font-size: 10px;
        margin-bottom: 4px;
    }

    .test-select-code {
        margin-top: 4px;
    }

    .test-select-description {
        font-size: 12px;
        color: var(--gray-color);
        margin-bottom: 8px;
    }

    .panel-tests-list {
        margin-top: 8px;
        padding: 6px 0;
        width: 100%;
    }

    .panel-tests-title {
        font-weight: 600;
        font-size: 11px;
        margin-bottom: 4px;
        color: var(--dark-color);
    }

    .panel-tests-count {
        font-size: 11px;
        color: var(--gray-color);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #e8f4fd;
        padding: 4px 10px;
        border-radius: 15px;
    }

    .panel-tests-count i {
        color: var(--primary-color);
        font-size: 10px;
        margin-right: 4px;
    }

    .test-select-price {
        text-align: right;
        min-width: 80px;
    }

    .test-price-amount {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 14px;
        margin-bottom: 4px;
    }

    .test-duration-text {
        font-size: 11px;
        color: var(--gray-color);
    }

    .modal-selected-tests {
        margin-top: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .selected-tests-title {
        margin: 13px 0;
        font-size: 16px;
        color: var(--dark-color);
    }

    .selected-tests-list {
        font-size: 14px;
        margin-bottom: 15px;
        max-height: 300px;
        overflow-y: auto;
    }

    .selected-test-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .selected-test-info {
        flex: 1;
    }

    .selected-test-name {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 13px;
    }

    .selected-test-badge {
        font-size: 9px;
        padding: 1px 5px;
        margin-left: 6px;
        color: #fff;
        border-radius: 4px;
    }

    .badge-test {
        background: var(--primary-color);
    }

    .badge-panel {
        background: #0099CC;
    }

    .selected-test-meta {
        font-size: 11px;
        color: var(--gray-color);
        margin-top: 2px;
    }

    .selected-test-count {
        font-size: 11px;
        color: var(--gray-color);
        margin-top: 4px;
    }

    .selected-test-actions {
        text-align: right;
    }

    .selected-test-price {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 13px;
    }

    .selected-test-remove {
        color: #e74c3c;
        background-color: #fdedec;
        border-radius: 20px;
        border: none;
        cursor: pointer;
        font-size: 11px;
        margin-top: 2px;
        padding: 2px 5px;
    }

    .selected-test-remove:hover {
        opacity: 0.8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tests-items-wrapper {
            grid-template-columns: 1fr;
        }
        
        .test-detail-row {
            /* flex-direction: column; */
            gap: 12px;
        } 
    }

    @media (max-width: 576px) {
        .test-select-name {
            font-size: 12px;
            margin-bottom: 3px;
        }

        .test-select-description {
            font-size: 9px;
            margin-bottom: 0;
        }

        .test-price-amount {
            margin-bottom: 0;
        }

        .selected-test-name {
            font-size: 11px;
        }

        .selected-test-badge {
            font-size: 8px;
            padding: 1px 4px;
            margin-left: 3px;
        }

        .selected-test-meta {
            font-size: 10px;
            margin-top: 1px;
        }

        .selected-test-count {
            font-size: 10px;
            margin-top: 3px;
        }
        .selected-test-remove {
            font-size: 9px;
            padding: 2px 5px;
        }
    }
</style>

<script>
    let selectedTests = [];
    let currentTestType = 'test';
    let showAllItems = true;

    function showAssignTestModal() {
        const modal = document.getElementById('assignTestModal');
        modal.showModal();
        document.body.style.overflow = 'hidden';
        
        selectedTests = [];
        showTestType('test');
        updateSelectedList();
        resetTestList();
    }

    function closeAssignTestModal() {
        const modal = document.getElementById('assignTestModal');
        modal.close();
        document.body.style.overflow = '';
        
        document.getElementById('testSearch').value = '';
        document.getElementById('testNotes').value = '';
        document.getElementById('testOrderDate').value = '{{ now()->format("Y-m-d\TH:i") }}';
        selectedTests = [];
        resetTestList();
    }

    function showTestType(type) {
        currentTestType = type;
        
        if (type === 'test') {
            document.getElementById('testTypeBtn').className = 'btn-primary type-btn';
            document.getElementById('testPanelTypeBtn').className = 'btn-secondary type-btn';
            showAllItems = false;
            filterTestItems();
        } else {
            document.getElementById('testTypeBtn').className = 'btn-secondary type-btn';
            document.getElementById('testPanelTypeBtn').className = 'btn-primary type-btn';
            showAllItems = false;
            filterTestItems();
        }
    }

    function filterTestItems() {
        const testItems = document.querySelectorAll('#testItemsContainer > div');
        const searchTerm = document.getElementById('testSearch').value.toLowerCase();
        
        testItems.forEach(item => {
            const itemType = item.getAttribute('data-type');
            const itemName = item.querySelector('.test-select-name').textContent.toLowerCase();
            
            const typeMatch = showAllItems ? true : (currentTestType === itemType);
            const searchMatch = searchTerm === '' || itemName.includes(searchTerm);
            
            if (typeMatch && searchMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
            
            const itemId = item.getAttribute('data-test-id') || item.getAttribute('data-panel-id');
            const isSelected = selectedTests.some(t => t.id == itemId && t.type === itemType);
            
            item.style.background = isSelected ? 'rgba(0, 191, 255, 0.1)' : 'white';
            item.style.borderLeftColor = isSelected ? 'var(--primary-color)' : '#ddd';
        });
    }

    function resetTestList() {
        showAllItems = false;
        document.getElementById('testSearch').value = '';
        filterTestItems();
    }

    function toggleTestSelection(id, type) {
        const index = selectedTests.findIndex(item => item.id == id && item.type === type);

        if (index !== -1) {
            selectedTests.splice(index, 1);
            filterTestItems();
            updateSelectedList();
            return;
        }

        let element;
        if (type === 'test') {
            element = document.querySelector(`[data-test-id="${id}"][data-type="test"]`);
        } else {
            element = document.querySelector(`[data-panel-id="${id}"][data-type="testPanel"]`);
        }

        if (!element) return;

        const item = {
            id: id,
            type: type,
            name: element.querySelector('.test-select-name').textContent.trim(),
            price: parseInt(element.dataset.price),
            duration: element.dataset.duration || '',
        };

        if (type === 'test') {
            item.code = element.dataset.code || '';
        }

        if (type === 'testPanel') {
            const testsCount = element.dataset.testsCount || 0;
            item.testsCount = testsCount;
        }

        selectedTests.push(item);
        filterTestItems();
        updateSelectedList();
    }

    function removeSelectedTest(index) {
        selectedTests.splice(index, 1);
        filterTestItems();
        updateSelectedList();
    }

    function updateSelectedList() {
        const selectedList = document.getElementById('selectedList');
        const selectedContainer = document.getElementById('selectedTests');
        
        if (selectedTests.length === 0) {
            selectedContainer.style.display = 'none';
            return;
        }
        
        selectedContainer.style.display = 'block';
        
        let html = '';
        let totalPrice = 0;
        
        selectedTests.forEach((item, index) => {
            const priceNum = parseInt(item.price) || 0;
            totalPrice += priceNum;
            
            html += `
            <div class="selected-test-item">
                <div class="selected-test-info">
                    <div class="selected-test-name">
                        ${item.name}

                        <span class="selected-test-badge ${item.type === 'test' ? 'badge-test' : 'badge-panel'}">
                            ${item.type === 'test' ? 'Test' : 'Panel'}
                        </span>
                    </div>

                    <div class="selected-test-meta">
                        ${item.duration} soat • Kod: ${item.code}
                    </div>

                    ${item.testsCount ? `
                        <div class="selected-test-count">
                            <strong>O'z ichiga oladi:</strong>
                            ${item.testsCount} ta test
                        </div>
                    ` : ''}
                </div>

                <div class="selected-test-actions">
                    <div class="selected-test-price">
                        ${formatPrice(item.price)} $
                    </div>

                    <button type="button"
                            class="selected-test-remove"
                            onclick="removeSelectedTest(${index})">
                        <i class="fas fa-circle-xmark"></i>
                        Olib tashlash
                    </button>
                </div>
            </div>
            `;
        });
        
        html += `
            <div style="margin-top: 10px; padding-top: 10px; border-top: 2px solid var(--primary-color);">
                <div style="display: flex; justify-content: space-between; font-weight: 700; color: var(--dark-color);">
                    <span>Jami:</span>
                    <span>${formatPrice(totalPrice)} $</span>
                </div>
                <div style="font-size: 12px; color: var(--gray-color); margin-top: 5px;">
                    ${selectedTests.length} ta test tanlandi
                </div>
            </div>
        `;
        
        selectedList.innerHTML = html;
        document.getElementById('selectedTestsInput').value = JSON.stringify(selectedTests);
    }

    function searchTests() {
        filterTestItems();
    }

    function formatPrice(price) {
        if (!price) return '0';
        const num = parseInt(price);
        if (isNaN(num)) return price;
        return num.toLocaleString('uz-UZ');
    }

    function submitTestOrder() {
        if (selectedTests.length === 0) {
            alert('Iltimos, kamida bitta test tanlang!');
            return;
        }
        
        document.getElementById('testOrderForm').submit();
    }
</script>