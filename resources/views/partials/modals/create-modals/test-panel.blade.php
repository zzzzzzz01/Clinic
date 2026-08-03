<dialog id="testPanelCreateModal">
    <div class="modal-header">
        <h3>@lang('words.create_test_panel')</h3>
        <button class="close-btn" id="testPanelCloseCreateModalBtn">✕</button>
    </div>
    <div class="modal-body">
        <form id="testPanelCreateForm" method="POST" action="{{ route('test-panels.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('words.panel_name') (UZ) <span class="text-danger">*</span></label>
                        <input type="text" name="name_uz" class="form-control" id="testPanelNameUz" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('words.panel_name')  (RU) <span class="text-danger">*</span></label>
                        <input type="text" name="name_ru" class="form-control" id="testPanelNameRu" required>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('words.panel_name')  (EN) <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control" id="testPanelNameEn" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('words.panel_code') <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" id="testPanelCode" required>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('words.time_hours_input') <span class="text-danger">*</span></label>
                        <input type="number" name="time" class="form-control" id="testPanelTime" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('words.department_select') <span class="text-danger">*</span></label>
                        <select name="department_id" class="form-control" id="testPanelDepartment" required>
                            <option value="">@lang('words.select_department')</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name_uz }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label>@lang('words.description_uz')</label>
                <textarea name="description_uz" class="form-control" rows="2" id="testPanelDescriptionUz"></textarea>
            </div>
            <div class="form-group mb-3">
                <label>@lang('words.description_ru')</label>
                <textarea name="description_ru" class="form-control" rows="2" id="testPanelDescriptionRu"></textarea>
            </div>
            <div class="form-group mb-3">
                <label>@lang('words.description_en')</label>
                <textarea name="description_en" class="form-control" rows="2" id="testPanelDescriptionEn"></textarea>
            </div>
            <div class="form-group mb-3">
                <label>@lang('words.status_select')</label>
                <select name="status" class="form-control" id="testPanelStatus">
                    <option value="1">@lang('words.active')</option>
                    <option value="0">@lang('words.inactive')</option>
                </select>
            </div> 
            <div class="form-group mb-3">
                <label>@lang('words.price_input') <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" id="testPanelPrice" step="0.01" required>
            </div> 
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-secondary" id="testPanelCancelCreateBtn">@lang('words.cancel')</button>
        <button type="submit" class="btn-primary" form="testPanelCreateForm" id="testPanelCreateSubmit">@lang('words.save')</button>
    </div>
</dialog>