<!-- TAG ADD DIALOG -->
<dialog id="tagDialog" class="notification-modal">
    <form method="POST" action="{{ route('tags.store') }}" id="tagForm">
        @csrf
        <div class="modal-header">
            <h3>@lang('words.add_new_tag')</h3>
            <button type="button" class="close-btn" onclick="closeTagDialog('tagDialog')">✕</button>
        </div>
        
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                    <label>@lang('words.name_uz') <span class="text-danger">*</span></label>
                    <input type="text" 
                        class="form-control" 
                        name="name_uz" 
                        placeholder="@lang('words.name_uz_placeholder')" 
                        required>
                </div>

                <div class="form-group">
                    <label>@lang('words.name_ru') <span class="text-danger">*</span></label>
                    <input type="text" 
                        class="form-control" 
                        name="name_ru" 
                        placeholder="@lang('words.name_ru_placeholder')" 
                        required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>@lang('words.name_en') <span class="text-danger">*</span></label>
                    <input type="text" 
                        class="form-control" 
                        name="name_en" 
                        placeholder="@lang('words.name_en_placeholder')" 
                        required>
                </div>

                <div class="form-group">
                    <label>@lang('words.slug')</label>
                    <input type="text" 
                        class="form-control" 
                        name="slug" 
                        placeholder="@lang('words.slug_placeholder')">
                    <small class="form-text text-muted">@lang('words.slug_help')</small>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeTagDialog('tagDialog')">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> @lang('words.save')
            </button>
        </div>
    </form>
</dialog>
