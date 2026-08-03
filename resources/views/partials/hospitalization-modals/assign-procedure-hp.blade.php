<!-- Procedure qoshish Dialogi -->
<dialog id="addProcedureModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.add_new_procedure')</h3>
        <button class="close-btn" onclick="this.closest('dialog').close()">✕</button>
    </div>
    <form action="{{ route('hospitalization.procedure.store', $hospitalization) }}" method="POST">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $hospitalization->appointment->patient->id }}">
        <input type="hidden" name="hospitalization_id" value="{{ $hospitalization->id }}">
        <div class="modal-body" style="padding: 0;">
            <div class="form-group">
                <label class="notification-label">@lang('words.staff')</label>
                <select class="form-control" name="staff_id" required>
                    <option value="" disabled selected>@lang('words.select_doctor_or_nurse')</option>
                    <optgroup label="@lang('words.doctors')">
                        @foreach($doctors as $doctor)
                            <option value="doctor_{{ $doctor->id }}">{{ $doctor->user->name }} {{ $doctor->user->last_name }} — @lang('words.doctor')</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="@lang('words.nurses')">
                        @foreach($nurses as $nurse)
                            <option value="nurse_{{ $nurse->id }}">{{ $nurse->user->name }} {{ $nurse->user->last_name }} — @lang('words.nurse')</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.procedure_name')</label>
                <select class="form-control" name="procedure_id" required>
                    <option value="">@lang('words.select_procedure')</option>
                    @foreach($procedures as $pro)
                        <option value="{{ $pro->id }}">{{ $pro->name_uz }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.room')</label>
                <select class="form-control" name="room_id" required>
                    <option value="">@lang('words.select_room')</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->number }} | {{ $room->department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.description')</label>
                <textarea class="form-control" placeholder="@lang('words.enter_procedure_details')..." name="notes" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="this.closest('dialog').close()">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">@lang('words.save')</button>
        </div>
    </form>
</dialog>