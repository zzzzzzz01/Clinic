<!-- DORI-DARMONLAR JADVALI -->
<div class="tab-header">
    <h3>@lang('words.medicines')</h3>
    @if(auth()->user()->hasRole('Admin'))
    <button class="btn-primary" id="openMedicationModalBtn">
        <i class="fas fa-plus"></i>
    </button>
    @endif
</div>

<div id="medicationsList" class="medications-list">
    <!-- Desktop table -->
    <table class="medications-table">
        <thead>
            <tr>
                <th>#</th>
                <th>@lang('words.medicine_name')</th>
                <th>@lang('words.duration_status')</th>
                <th>@lang('words.period')</th>
                <th>@lang('words.prescribed')</th>
                <th>@lang('words.actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicationItems as $item)
                <tr data-medication-id="{{ $item['id'] }}" class="medication-row {{ $item['rowClass'] }}">
                    <td class="row-number">
                        {{ $item['iteration'] }}
                    </td>
                    <td class="medication-cell medication-name">
                        <div class="medication-name-container">
                            <div>
                                <strong class="medicine-name">{{ $item['medicine_name'] }}</strong><br>
                                <span class="medicine-dosage">
                                    {{ $item['dosage'] }} • {{ $item['form'] }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="medication-cell">
                        <span class="status-medicine-badge"
                            style="color: {{ $item['statusColor'] }};
                                    background-color: {{ $item['bgColor'] }};">
                            <i class="{{ $item['statusIcon'] }}"></i>
                            {{ $item['statusText'] }}
                        </span>
                        <span class="date-range">
                            {{ $item['start_at_format'] }} - {{ $item['end_at_format'] }}
                        </span>
                    </td>

                    <td class="medication-cell medication-duration">
                        <div class="duration-days">{{ $item['duration_days'] }}</div>
                        <span class="usage-text">
                            {{ $item['usageText'] }}
                        </span>
                    </td>

                    <td class="medication-cell medication-prescribed">
                        <span class="hire-date">{{ $item['prescribedBy'] }}</span><br>
                        <span class="hire-day">
                            {{ $item['start_date_format'] }}
                        </span>
                    </td>
                    <td class="medication-actions">
                        <button type="button" class="btn-primary" data-id="{{ $item['id'] }}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="6" class="empty-cell" style="padding: 25px;">
                        @lang('words.no_prescription')
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Mobile cards -->
    <div class="mobile-cards">
        @if(count($medicationItems) > 0)
            @foreach($medicationItems as $item)
                <div class="medication-card {{ $item['rowClass'] ? 'medication-card-non-scheduled' : 'medication-card-default' }}" data-medication-id="{{ $item['id'] }}">
                    <div class="card-medicine-compact">
                        <div class="medicine-icon">
                            <i class="fas fa-capsules"></i>
                        </div>
                        <div class="medicine-info">
                            <div class="medicine-name-line">
                                <strong class="medicine-name">{{ $item['medicine_name'] }}</strong>
                                <span class="medicine-form-badge" style="color: {{ $item['statusColor'] }};
                                    background-color: {{ $item['bgColor'] }};">{{ $item['statusText'] }}</span>
                            </div>
                            <p class="medicine-details">{{ $item['dosage'] }} | {{ $item['form'] }}</p>
                        </div>
                    </div>
                    
                    <div class="card-details-inline">
                        <div class="detail-item">
                            <div class="detail-content">
                                <span class="detail-label">@lang('words.schedule')</span>
                                <span class="detail-value status-value">{{ $item['usageText'] }}</span>
                            </div>
                        </div>
                        
                        <div class="separator"></div>
                        
                        <div class="detail-item">
                            <div class="detail-content">
                                <span class="detail-label">@lang('words.period')</span> 
                                <span class="detail-value">{{ $item['duration_days'] }}</span> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="medication-actions ">
                        <button type="button" class="btn-primary" data-id="{{ $item['id'] }}">
                            <i class="fas fa-eye"></i>
                            <span>@lang('words.view')</span>
                        </button>
                    </div>
                    
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-icon-wrapper">
                    <div class="empty-icon">
                        <i class="fas fa-pills"></i>
                    </div>
                </div>
                <div class="empty-content">
                    <h4>@lang('words.no_prescription_title')</h4>
                    <p>@lang('words.no_prescription_desc')</p>
                </div>
                <button class="btn-add" id="emptyStateAddBtn">
                    <i class="fas fa-plus"></i> @lang('words.add_medicine')
                </button>
            </div>
        @endif
    </div>
</div>

@foreach($medicationModalData as $modalItem)
    @if($modalItem['isAsNeeded'])
        @include('partials.hospitalization-modals.as-needed')
    @else
        @include('partials.hospitalization-modals.regular')   
    @endif
@endforeach



@include('partials.hospitalization-modals.assign-medicine-hp')   