<div class="tab-header">
    <h3>@lang('words.laboratory_tests')</h3>
    @if(auth()->user()->hasRole('Admin'))
    <button class="btn-primary" onclick="showAssignTestModal()">
        <i class="fas fa-plus"></i> 
    </button>
    @endif
</div>

<div class="content-list" id="testContent">

@foreach($testItems as $item)

    <div class="test-card">

        {{-- HEADER --}}
        <div class="test-header">
            <div>
                <div class="test-name">
                    {{ $item['testName'] }}
                </div>

                <div class="test-type">
                    {{ $item['testType'] ?? '-' }}
                </div>
            </div>

            <span class="status-badge" 
                    style="color: {{ $item['statusColor'] }};
                        background-color: {{ $item['statusBgColor'] }};">
                {{ $item['statusText'] }}
            </span>
        </div>

        {{-- INFO --}}
        <div class="test-info">

            <div class="test-detail-row">

                <div class="test-detail-col">

                    <div class="test-detail">
                        <span class="test-detail-label">@lang('words.order_date'):</span>
                        <span class="test-detail-value">
                            {{ $item['ordered_at'] }}
                        </span>
                    </div>

                    <div class="test-detail">
                        <span class="test-detail-label">@lang('words.ordered_by'):</span>

                        <span class="test-detail-value full">
                            {{ $item['doctor_name'] }}
                            <small>({{ $item['doctor_role'] }})</small>
                        </span>

                        <span class="test-detail-value short">
                            {{ $item['short_name'] }}
                            <small>({{ $item['doctor_role'] }})</small>
                        </span>
                    </div>

                </div>

                <div class="test-detail-col">

                    <div class="test-detail" style="margin-left: 50px;">
                        <span class="test-detail-label">@lang('words.duration'):</span>
                        <span class="test-detail-value">
                            {{ $item['testDuration'] ?? '—' }} @lang('words.hour')
                        </span>
                    </div>

                    <div class="test-detail" style="margin-left: 50px;">
                        <span class="test-detail-label">@lang('words.test_code'):</span>
                        <span class="test-detail-value">
                            {{ $item['testCode'] }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

        {{-- RESULT (ZERO IF VERSION) --}}
        <div class="test-result">

            <div class="result-label">@lang('words.result'):</div>
            
            {{-- faqat service decide qiladi --}}
            @if($item['resultData'])

                <div class="result-value {{ $item['resultData']['rangeClass'] }}">

                    {{ $item['resultData']['value'] ?? __('words.waiting') }}

                    @if($item['resultData']['indicator'] === 'down')
                        <span class="range-indicator">
                            <i class="fas fa-arrow-down"></i>
                            <span class="indicator-text">@lang('words.low')</span>
                        </span>
                    @endif

                    @if($item['resultData']['indicator'] === 'up')
                        <span class="range-indicator">
                            <i class="fas fa-arrow-up"></i>
                            <span class="indicator-text">@lang('words.high')</span>
                        </span>
                    @endif

                    @if($item['resultData']['showNormalBadge'])
                        <span class="normal-badge">
                            <i class="fas fa-check"></i>
                            <span>@lang('words.normal')</span>
                        </span>
                    @endif

                </div>

            @endif
            

            {{-- PANEL RESULT --}}
            @if($item['isPanel'] && $item['allCompleted'])
                <div class="test-actions">
                    <a href="{{ route('test.panel.show', ['hospitalization' => $hospitalization->id, 'item' => $item['id']]) }}">
                        <p class="test-result-p">@lang('words.view_results') <i class="fa-solid fa-caret-right"></i></p>
                    </a>
                </div>
            @endif

        </div>

        {{-- NOTE --}}
        @if($item['note'])
            <div class="test-order-note">
                {{ $item['note'] }}
            </div>
        @endif

    </div>

@endforeach

</div>

@include('partials.hospitalization-modals.assign-test-hp')

