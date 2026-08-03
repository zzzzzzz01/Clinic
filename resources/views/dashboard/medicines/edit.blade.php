<x-layouts.main.website>
    <x-slot:title>
        {{ $medicine->name }} - @lang('words.edit')
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
                    <a href="{{ route('medicines.index') }}">@lang('words.medicines_list')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $medicine->name }} - @lang('words.edit')
                </li>
            </ol>
        </nav>
        
        <!-- Search Card -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $medicine->name }} - @lang('words.edit')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

    <div class="container">
        <div class="edit-medicine-container">
            <form method="POST" action="{{ route('medicine.update', $medicine) }}" id="medicineForm">
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
                                    @lang('words.medicine_name')
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $medicine->name) }}"
                                    data-original="{{ $medicine->name }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    @lang('words.category')
                                    <span class="required">*</span>
                                </label>
                                <select class="form-control" name="medicine_category_id" data-original="{{ $medicine->medicine_category_id }}">
                                    <option value="" disabled>@lang('words.select_category')</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('medicine_category_id', $medicine->medicine_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-chart-line"></i>
                                        @lang('words.dose_amount')
                                        <span class="required">*</span>
                                    </label>
                                    <input type="number" class="form-control" name="strength_value" value="{{ old('strength_value', $medicine->strength_value) }}" data-original="{{ $medicine->strength_value }}">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-weight-hanging"></i>
                                        @lang('words.unit')
                                        <span class="required">*</span>
                                    </label>
                                    <select class="form-control" name="strength_unit" data-original="{{ $medicine->strength_unit }}">
                                        <option value="" disabled>@lang('words.select')</option>
                                        <option value="mg" {{ old('strength_unit', $medicine->strength_unit) == 'mg' ? 'selected' : '' }}>mg</option>
                                        <option value="g" {{ old('strength_unit', $medicine->strength_unit) == 'g' ? 'selected' : '' }}>g</option>
                                        <option value="ml" {{ old('strength_unit', $medicine->strength_unit) == 'ml' ? 'selected' : '' }}>ml</option>
                                        <option value="%" {{ old('strength_unit', $medicine->strength_unit) == '%' ? 'selected' : '' }}>%</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-tablets"></i>
                                        @lang('words.medicine_form')
                                    </label>
                                    <select class="form-control" name="form" data-original="{{ $medicine->form }}">
                                        <option value="" disabled>@lang('words.select_form')</option>
                                        <option value="tabletka" {{ old('form', $medicine->form) == 'tabletka' ? 'selected' : '' }}>@lang('words.tablets')</option>
                                        <option value="kapsula" {{ old('form', $medicine->form) == 'kapsula' ? 'selected' : '' }}>@lang('words.capsules')</option>
                                        <option value="sirop" {{ old('form', $medicine->form) == 'sirop' ? 'selected' : '' }}>@lang('words.syrups')</option>
                                        <option value="maz" {{ old('form', $medicine->form) == 'maz' ? 'selected' : '' }}>  @lang('words.ointments')</option>
                                        <option value="in'ektsiya" {{ old('form', $medicine->form) == 'in\'ektsiya' ? 'selected' : '' }}>💉 @lang('words.injections')</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-box"></i>
                                        @lang('words.package_type')
                                    </label>
                                    <select class="form-control" name="package_type" data-original="{{ $medicine->package_type }}">
                                        <option value="" disabled>@lang('words.select_package')</option>
                                        <option value="Quti" {{ old('package_type', $medicine->package_type) == 'Quti' ? 'selected' : '' }}> @lang('words.box')</option>
                                        <option value="Flakon" {{ old('package_type', $medicine->package_type) == 'Flakon' ? 'selected' : '' }}> @lang('words.vial')</option>
                                        <option value="Blister" {{ old('package_type', $medicine->package_type) == 'Blister' ? 'selected' : '' }}>@lang('words.blister')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2-FORM SECTION: Miqdor va narx ma'lumotlari -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-chart-line"></i>
                            <h3>@lang('words.quantity_price_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-cube"></i>
                                    @lang('words.units_per_box')
                                </label>
                                <input type="number" class="form-control" name="units_per_box" value="{{ old('units_per_box', $medicine->units_per_box) }}" data-original="{{ $medicine->units_per_box }}" placeholder="20">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-truck"></i>
                                    @lang('words.supplier')
                                </label>
                                <select class="form-control" name="supplier_id" data-original="{{ $medicine->supplier_id }}">
                                    <option value="" disabled>@lang('words.select_supplier')</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $medicine->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign"></i>
                                    @lang('words.price')
                                    <span class="required">*</span>
                                </label>
                                <input type="number" class="form-control" name="price" value="{{ old('price', $medicine->price) }}" data-original="{{ $medicine->price }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_uz')
                                </label>
                                <textarea class="form-control" name="description_uz" data-original="{{ $medicine->description_uz }}" placeholder="@lang('words.description_uz_placeholder')">{{ old('description_uz', $medicine->description_uz) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_ru')
                                </label>
                                <textarea class="form-control" name="description_ru" data-original="{{ $medicine->description_ru }}" placeholder="@lang('words.description_ru_placeholder')">{{ old('description_ru', $medicine->description_ru) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_en')
                                </label>
                                <textarea class="form-control" name="description_en" data-original="{{ $medicine->description_en }}" placeholder="@lang('words.description_en_placeholder')">{{ old('description_en', $medicine->description_en) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <div class="submit-actions">
                        <a href="{{ route('medicines.show', $medicine) }}" class="btn-secondary">
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