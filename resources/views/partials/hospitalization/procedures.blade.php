<div class="tab-header">
    <h3>@lang('words.procedures')</h3>
    @if(auth()->user()->hasRole('Admin')) 
        <button class="btn-primary" onclick="document.getElementById('addProcedureModal').showModal()">
            <i class="fas fa-plus"></i> 
        </button> 
    @endif
</div>

<div class="procedure-hos-table-container">
    <table class="procedure-table">
        <thead>
            <tr>
                <th>#</th>
                <th>@lang('words.name')</th>
                <th>@lang('words.status')</th>
                <th>@lang('words.time')</th>
                <th>@lang('words.staff')</th>
                <th>@lang('words.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($procedureItems as $item)
                <tr class="supplier-row">
                    <td class="row-number">{{ $item['iteration'] }}</td>
                    <td class="procedure-name"> 
                        <div>
                            <strong class="procedure-name">{{ mb_strimwidth($item['procedure_name'], 0, 20, '...') }}</strong><br>
                            <span class="description">{{ $item['procedure_description'] }}</span>
                        </div> 
                    </td>
                    <td>
                        <span class="status-badge" style="background-color: {{ $item['statusBgColor'] }}; color: {{ $item['statusColor'] }};">
                            <i class="{{ $item['statusIcon'] }}"></i> {{ $item['statusText'] }}
                        </span>
                    </td>
                    <td class="quantity-display">
                        <span class="duration" style="font-weight: 600;">{{ $item['duration'] }} @lang('words.minutes')</span><br>
                        <span style="font-size: 0.8rem; color: #6c757d;">{{ $item['room'] }} @lang('words.room')</span>
                    </td>
                    <td class="quantity-display">
                        <span class="full-name">{{ $item['staff_name'] }}</span>
                        <span class="medicine-dose">{{ $item['staff_type_text'] }}</span>
                    </td>
                    <td>
                        <div class="action-dropdown" data-dropdown-id="dropdown-{{ $item['id'] }}">
                            <span class="action-dots">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </span>
                            <div class="dropdown-content" id="dropdown-{{ $item['id'] }}">
                                <a href="javascript:void(0)" class="text-primary view-btn"
                                    data-id="{{ $item['id'] }}"
                                    data-procedure-name="{{ $item['procedure_name'] }}"
                                    data-duration="{{ $item['duration'] }}"
                                    data-room="{{ $item['room'] }}"
                                    data-staff="{{ $item['staff_name'] }}"
                                    data-assigned="{{ $item['assignedAt'] }}"
                                    data-patient="{{ $item['procedurePatient'] }}"
                                    data-status="{{ $item['statusText'] }}">
                                    <i class="fas fa-eye"></i> @lang('words.view')
                                </a>

                                @if($item['status'] === 'pending')
                                <a href="javascript:void(0)" class="text-primary"
                                    onclick="openCompleteDialog(this)"
                                    data-id="{{ $item['id'] }}"
                                    data-procedure-name="{{ $item['procedure_name'] }}"
                                    data-procedure-info="{{ addslashes($item['procedureInfo']) }}"
                                    data-main-info="{{ addslashes($item['mainInfo']) }}">
                                    <i class="fa-solid fa-check"></i> @lang('words.complete')
                                </a>

                                <a href="javascript:void(0)" class="text-primary"
                                    onclick="openCancelDialog(this)"
                                    data-id="{{ $item['id'] }}"
                                    data-procedure-name="{{ $item['procedure_name'] }}">
                                    <i class="fa-solid fa-ban"></i> @lang('words.cancel')
                                </a>

                                <a href="javascript:void(0)" class="text-primary edit-btn"
                                    data-id="{{ $item['id'] }}"
                                    data-procedure-name="{{ $item['procedure_name'] }}"
                                    data-note="{{ $item['notes'] }}"
                                    data-room="{{ $item['room'] }}"
                                    data-staff="{{ $item['staff_name'] }}">
                                    <i class="fas fa-edit"></i> @lang('words.edit')
                                </a>
                                @endif
                                <a href="javascript:void(0)" class="text-danger delete-btn"
                                    data-id="{{ $item['id'] }}"
                                    data-procedure-name="{{ $item['procedure_name'] }}">
                                    <i class="fas fa-trash"></i> @lang('words.delete')
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('partials.hospitalization-modals.show-procedure-hp')

@include('partials.hospitalization-modals.complete-procedure-hp')

@include('partials.hospitalization-modals.cancel-procedure-hp')

@include('partials.hospitalization-modals.assign-procedure-hp')

@include('partials.hospitalization-modals.edit-procedure-hp')

@include('partials.hospitalization-modals.delete-procedure-hp')

