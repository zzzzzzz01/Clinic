<!-- Tahrirlash Dialogi -->
<dialog id="editModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.edit_procedure')</h3>
        <button class="close-btn" onclick="closeDialog('editModal')">✕</button>
    </div>
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="hospitalization_procedure_id" id="editProcedureId">
        <div class="modal-body" style="padding: 0;">
            <div class="form-row" style="margin-bottom: 0; gap: 0">
                <div class="form-group">
                    <label class="notification-label">@lang('words.staff')</label>
                    <select class="form-control" name="staff_id" id="editStaffId" required>
                        <option value="" disabled>@lang('words.select_doctor_or_nurse')</option>
                        <optgroup label="@lang('words.doctors')">
                            @foreach($doctors as $doctor)
                                <option value="doctor_{{ $doctor->id }}">
                                    {{ $doctor->user->name }} {{ $doctor->user->last_name }} — @lang('words.doctor')
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="@lang('words.nurses')">
                            @foreach($nurses as $nurse)
                                <option value="nurse_{{ $nurse->id }}">
                                    {{ $nurse->user->name }} {{ $nurse->user->last_name }} — @lang('words.nurse')
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                    <label class="notification-label">@lang('words.procedure_name')</label>
                    <select class="form-control" name="procedure_id" id="editProcedureIdSelect" required>
                        <option value="">@lang('words.select_procedure')</option>
                        @foreach($procedures as $pro)
                            <option value="{{ $pro->id }}">
                                {{ $pro->name_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.room')</label>
                <select class="form-control" name="room_id" id="editRoomId" required>
                    <option value="">@lang('words.select_room')</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->number }} | {{ $room->department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.description')</label>
                <textarea class="form-control" name="notes" id="editNotes" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDialog('editModal')">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">@lang('words.save')</button>
        </div>
    </form>
</dialog>