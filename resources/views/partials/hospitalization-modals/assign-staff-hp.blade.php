<dialog id="addDoctorModal" class="notification-modal">
    <div class="modal-header">
        <h3>@lang('words.assign_staff')</h3>
        <button class="close-btn" onclick="closeModal('addDoctorModal')">✕</button>
    </div>
    
    <form action="{{ route('hospitalization.doctor.store', $hospitalization) }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $hospitalization->id }}" name="hospitalization_id">
        <div class="form-group">
            <label class="notification-label">@lang('words.specialist'):</label>
            <select class="form-control" name="staff" required>
                <option value="" disabled selected>@lang('words.select')...</option>
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
            <label class="notification-label">@lang('words.role'):</label>
            <select class="form-control" name="role" required>
                <option value="Asosiy shifokor">@lang('words.main_doctor')</option>
                <option value="Konsultant">@lang('words.consultant')</option>
                <option value="Yordamchi shifokor">@lang('words.assistant_doctor')</option>
                <option value="Kunduzgi smena">@lang('words.day_shift')</option>
                <option value="Kechki smena">@lang('words.night_shift')</option>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('addDoctorModal')">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">@lang('words.save')</button>
        </div>
    </form>
</dialog>