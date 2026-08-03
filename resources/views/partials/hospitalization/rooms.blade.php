<div class="tab-header">
    <h3>@lang('words.patient_rooms')</h3>
    @if(auth()->user()->hasRole('Admin'))
        <button type="button" class="btn-primary" onclick="showAssignRoomModal()">
            <i class="fas fa-plus"></i>
        </button>
    @endif
</div>

<div class="content-grid" id="roomsContent"> 
    @foreach($roomAssignments as $room)
        <div class="room-card">
            <div class="room-header">
                <div>
                    <div class="room-number">
                        <i class="fas fa-door-closed"></i>
                        @lang('words.room') {{ $room['number'] }}
                    </div>
                    <div class="room-type">
                        {{ $room['room_type'] }}
                        • {{ $room['floor'] }}-@lang('words.floor')
                    </div>
                </div>
                @if($room['is_current'])
                    <span class="room-status status-active">@lang('words.current')</span>
                @else
                    <span class="room-status status-inactive">@lang('words.previous')</span>
                @endif
            </div>
            <div class="room-details">
                <div class="room-detail">
                    <div class="room-detail-label">@lang('words.bed_number'):</div>
                    <div class="room-detail-value">{{ $room['bed_number'] }}-@lang('words.bed')</div>
                </div>
                <div class="room-detail">
                    <div class="room-detail-label">@lang('words.department'):</div>
                    <div class="room-detail-value">{{ $room['department_name'] }}</div>
                </div>
                <div class="room-detail">
                    <div class="room-detail-label">@lang('words.admitted_date'):</div>
                    <div class="room-detail-value">{{ $room['assigned_at_format'] }}</div>
                </div>
                <div class="room-detail">
                    <div class="room-detail-label">@lang('words.discharged_date'):</div>
                    <div class="room-detail-value">{{ $room['unassigned_at_format'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@include('partials.hospitalization-modals.assign-room-hp')