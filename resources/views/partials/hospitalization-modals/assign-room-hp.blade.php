<dialog id="assignRoomModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.assign_to_room')</h3>
        <button type="button" class="close-btn" onclick="closeAssignRoomModal()">✕</button>
    </div>
    <form method="POST" action="{{ route('hospitalization.rooms.store', $hospitalization) }}">
        @csrf
        <input type="hidden" name="hospitalization_id" value="{{ $hospitalization->id }}">
        <div class="form-group">
            <label class="notification-label">@lang('words.select_room'):</label> 
            <select class="form-control" name="bed_id" required>
                <option value="" selected disabled>@lang('words.select_room_and_bed')...</option>
                @foreach($rooms as $room)
                    <optgroup label="@lang('words.room') {{ $room->number }}">
                        @foreach($room->roomBeds->where('status', 'available') as $bed)
                            <option value="{{ $bed->id }}">@lang('words.room') {{ $room->number }} | {{ $bed->bed_number }}-@lang('words.bed')</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="notification-label">@lang('words.assignment_date'):</label>
            <input type="datetime-local" class="form-control" name="assigned_at" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeAssignRoomModal()">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">@lang('words.save')</button>
        </div>
    </form>
</dialog>