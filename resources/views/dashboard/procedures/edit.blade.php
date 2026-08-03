<x-layouts.main.website>
    <x-slot:title>
        {{ $procedure->name }} - @lang('words.edit')
    </x-slot:title>

    <div class="container pt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('procedures.index') }}">@lang('words.procedures_list')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $procedure->name }} - @lang('words.edit')
                </li>
            </ol>
        </nav>
        
        <!-- Search Card -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $procedure->name }} - @lang('words.edit')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container">
        <div class="edit-medicine-container">
            <form method="POST" action="{{ route('procedures.update', $procedure) }}" id="medicineForm">
                @csrf
                @method('PUT')
                
                <!-- 2 ta form-section -->
                <div class="form-sections">
                    
                    <!-- 1-FORM SECTION: Asosiy ma'lumotlar -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-info-circle"></i>
                            <h3>@lang('words.basic_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-capsules"></i>
                                    @lang('words.procedure_name') (UZ) 
                                </label>
                                <input type="text" class="form-control" name="name_uz" value="{{ old('name_uz', $procedure->name_uz) }}"
                                    data-original="{{ $procedure->name_uz }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-capsules"></i>
                                    @lang('words.procedure_name') (RU) 
                                </label>
                                <input type="text" class="form-control" name="name_ru" value="{{ old('name_ru', $procedure->name_ru) }}"
                                    data-original="{{ $procedure->name_ru }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-capsules"></i>
                                    @lang('words.procedure_name') (EN)
                                </label>
                                <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $procedure->name_en) }}"
                                    data-original="{{ $procedure->name_en }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    @lang('words.category')
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="category" value="{{ old('name', $procedure->category) }}"
                                    data-original="{{ $procedure->category }}">
                            </div> 
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-dollar"></i>
                                    @lang('words.price') ($)
                                </label>
                                <input type="number" class="form-control" name="price" value="{{ old('price', $procedure->price) }}" data-original="{{ $procedure->strength_value }}">
                            </div>   
                        </div>
                    </div>

                    <!-- 2-FORM SECTION: Miqdor va narx ma'lumotlari -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-chart-line"></i>
                            <h3>@lang('words.additional_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock"></i>
                                    @lang('words.duration') (@lang('words.minutes'))
                                </label>
                                <input type="number" class="form-control" name="duration" value="{{ old('duration', $procedure->duration) }}" data-original="{{ $procedure->units_per_box }}" placeholder="20">
                            </div> 
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-box"></i>
                                    @lang('words.status')
                                </label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $procedure->is_active == 1 ? 'selected' : '' }}>
                                        @lang('words.active')
                                    </option>
                                    <option value="0" {{ $procedure->is_active == 0 ? 'selected' : '' }}>
                                        @lang('words.inactive')
                                    </option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_uz')
                                </label>
                                <textarea class="form-control" name="description_uz" data-original="{{ $procedure->description_uz }}" placeholder="@lang('words.description_uz_placeholder')">{{ old('description_uz', $procedure->description_uz) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_ru')
                                </label>
                                <textarea class="form-control" name="description_ru" data-original="{{ $procedure->description_ru }}" placeholder="@lang('words.description_ru_placeholder')">{{ old('description_ru', $procedure->description_ru) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_en')
                                </label>
                                <textarea class="form-control" name="description_en" data-original="{{ $procedure->description_en }}" placeholder="@lang('words.description_en_placeholder')">{{ old('description_en', $procedure->description_en) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <div class="submit-actions">
                        <a href="{{ route('medicines.show', $procedure) }}" class="btn-secondary">
                            <i class="fas fa-times"></i>
                            @lang('words.cancel')
                        </a>
                        <button type="submit" class="btn-primary">
                            @lang('words.save')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layouts.main.website>