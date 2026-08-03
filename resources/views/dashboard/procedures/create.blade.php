<x-layouts.main.website>
    <x-slot:title>
        Procedure yaratish
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
                    <a href="{{ route('procedures.index') }}">Protseduralar</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Procedure yaratish
                </li>
            </ol>
        </nav>
        
        <!-- Search Card -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">Procedure yaratish</h4>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container">
        <div class="edit-medicine-container">
            <form method="POST" action="{{ route('procedures.store') }}" id="medicineForm">
                @csrf
                
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
                                    @lang('words.procedure_name')
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="name_uz" value="{{ old('name_uz') }}"
                                    placeholder="Protsedura nomi (UZ)">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    Protsedura nomi (RU)
                                </label>
                                <input type="text" class="form-control" name="name_ru" value="{{ old('name_ru') }}"
                                    placeholder="Protsedura nomi (RU)">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    Protsedura nomi (EN)
                                </label>
                                <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}"
                                    placeholder="Protsedura nomi (EN)">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    @lang('words.category')
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="category" value="{{ old('category') }}"
                                    placeholder="Categoriya kiriting..."> 
                            </div> 
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign"></i>
                                    @lang('words.price') ($)
                                    <span class="required">*</span>
                                </label>
                                <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price') }}" 
                                    placeholder="0.00">
                            </div>   
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock"></i>
                                    @lang('words.duration') (@lang('words.minutes'))
                                    <span class="required">*</span>
                                </label>
                                <select class="form-control" name="duration">
                                    <option value="">Tanlang...</option>
                                    <option value="15" {{ old('duration') == 15 ? 'selected' : '' }}>15 daqiqa</option>
                                    <option value="30" {{ old('duration') == 30 ? 'selected' : '' }}>30 daqiqa</option>
                                    <option value="45" {{ old('duration') == 45 ? 'selected' : '' }}>45 daqiqa</option>
                                    <option value="60" {{ old('duration') == 60 ? 'selected' : '' }}>60 daqiqa</option>
                                    <option value="90" {{ old('duration') == 90 ? 'selected' : '' }}>90 daqiqa</option>
                                    <option value="120" {{ old('duration') == 120 ? 'selected' : '' }}>120 daqiqa</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 2-FORM SECTION: Qo'shimcha ma'lumotlar -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-chart-line"></i>
                            <h3>@lang('words.additional_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-power-off"></i>
                                    @lang('words.status')
                                </label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
                                        @lang('words.active')
                                    </option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>
                                        @lang('words.inactive')
                                    </option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_uz')
                                </label>
                                <textarea class="form-control" name="description_uz" rows="3" 
                                    placeholder="Protsedura tavsifi (UZ)">{{ old('description_uz') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_ru')
                                </label>
                                <textarea class="form-control" name="description_ru" rows="3" 
                                    placeholder="Protsedura tavsifi (RU)">{{ old('description_ru') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_en')
                                </label>
                                <textarea class="form-control" name="description_en" rows="3" 
                                    placeholder="Protsedura tavsifi (EN)">{{ old('description_en') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <div class="submit-actions">
                        <a href="{{ route('procedures.index') }}" class="btn-secondary">
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