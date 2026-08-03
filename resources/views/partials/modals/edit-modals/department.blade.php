<dialog id="editDepartmentModal" class="notification-modal">
    <div class="modal-header">
        <h3><i class="fas fa-edit"></i> @lang('words.edit_department')</h3>
        <button class="close-btn" onclick="closeEditModal()">✕</button>
    </div>

    <form id="editDepartmentForm" method="POST">
        @csrf
        @method('PUT')
        
        <div class="modal-body">
            <!-- Bo'lim nomi - 3 til -->
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.department_name') (UZ)</label>
                        <input type="text" class="form-control" id="edit_name_uz" name="name_uz" required placeholder="@lang('words.enter_department_name')">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.department_name') (RU)</label>
                        <input type="text" class="form-control" id="edit_name_ru" name="name_ru" required placeholder="@lang('words.enter_department_name')">
                    </div>
                </div> 
                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.department_name') (EN)</label>
                        <input type="text" class="form-control" id="edit_name_en" name="name_en" required placeholder="@lang('words.enter_department_name')">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.floor')</label>
                        <select class="form-control" id="edit_floor" name="floor" required>
                            <option value="" disabled selected>@lang('words.select_floor')</option>
                            <option value="1">@lang('words.floor_1')</option>
                            <option value="2">@lang('words.floor_2')</option>
                            <option value="3">@lang('words.floor_3')</option>
                            <option value="4">@lang('words.floor_4')</option>
                        </select>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.head_doctor')</label>
                        <select class="form-control" id="edit_head_doctor" name="head_doctor_id">
                            <option value="">@lang('words.unassigned')</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">
                                    {{ $doctor->user->last_name }} {{ $doctor->user->name }} - {{ $doctor->specialization }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.status')</label>
                        <select class="form-control" id="edit_status" name="status">
                            <option value="1">@lang('words.active')</option>
                            <option value="0">@lang('words.inactive')</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tavsif - 3 til --> 
                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.description') (UZ)</label>
                        <textarea class="form-control" id="edit_description_uz" name="description_uz" rows="3" placeholder="@lang('words.enter_description')"></textarea>
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.description') (RU)</label>
                        <textarea class="form-control" id="edit_description_ru" name="description_ru" rows="3" placeholder="@lang('words.enter_description')"></textarea>
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label class="notification-label">@lang('words.description') (EN)</label>
                        <textarea class="form-control" id="edit_description_en" name="description_en" rows="3" placeholder="@lang('words.enter_description')"></textarea>
                    </div>
                </div> 
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeEditModal()">
                <i class="fas fa-times"></i> @lang('words.cancel')
            </button>
            <button type="submit" class="btn-primary">
                @lang('words.save_changes')
            </button>
        </div>
    </form>
</dialog>