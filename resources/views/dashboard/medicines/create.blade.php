<x-layouts.main.website>
    <x-slot:title>
        @lang('words.medicine_create')
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
                    @lang('words.medicine_create')
                </li>
            </ol>
        </nav>
        
        <!-- Search Card -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.medicine_create')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="medicine-create-container">
            <form method="POST" action="{{ route('medicines.store') }}" id="medicineForm">
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
                                    @lang('words.medicine_name')
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('words.name_placeholder')">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    @lang('words.category')
                                    <span class="required">*</span>
                                </label>
                                <select class="form-control" name="medicine_category_id">
                                    <option value="" selected disabled>@lang('words.select_category')</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                    <input type="number" class="form-control" name="strength_value" placeholder="500">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-weight-hanging"></i>
                                        @lang('words.unit')
                                        <span class="required">*</span>
                                    </label>
                                    <select class="form-control" name="strength_unit">
                                        <option value="" selected disabled>@lang('words.select')</option>
                                        <option value="mg">mg</option>
                                        <option value="g">g</option>
                                        <option value="ml">ml</option>
                                        <option value="%">%</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-tablets"></i>
                                        @lang('words.medicine_form')
                                    </label>
                                    <select class="form-control" name="form">
                                        <option value="" selected disabled>@lang('words.select_form')</option>
                                        <option value="tabletka">@lang('words.tablets')</option>
                                        <option value="kapsula">@lang('words.capsules')</option>
                                        <option value="sirop">@lang('words.syrups')</option>
                                        <option value="maz">@lang('words.ointments')</option>
                                        <option value="in'ektsiya">@lang('words.injections')</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-box"></i>
                                        @lang('words.package_type')
                                    </label>
                                    <select class="form-control" name="package_type">
                                        <option value="" selected disabled>@lang('words.select_package')</option>
                                        <option value="Quti">@lang('words.box')</option>
                                        <option value="Flakon">@lang('words.vial')</option>
                                        <option value="Blister">@lang('words.blister')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2-FORM SECTION: Qo'shimcha ma'lumotlar -->
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
                                <input type="number" class="form-control" name="units_per_box" placeholder="20" value="10">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-warehouse"></i>
                                    @lang('words.current_stock')
                                </label>
                                <input type="number" class="form-control" name="stock_boxes" placeholder="0" value="0">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    @lang('words.min_stock')
                                </label>
                                <input type="number" class="form-control" name="min_stock" placeholder="50" value="50">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-truck"></i>
                                    @lang('words.supplier')
                                </label>
                                <select class="form-control" name="supplier_id">
                                    <option value="" selected disabled>@lang('words.select_supplier')</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign"></i>
                                    @lang('words.price')
                                    <span class="required">*</span>
                                </label>
                                <input type="number" class="form-control" name="price" placeholder="@lang('words.price_placeholder')">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_uz')
                                </label>
                                <textarea class="form-control" name="description_uz" placeholder="@lang('words.description_uz_placeholder')"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_ru')
                                </label>
                                <textarea class="form-control" name="description_ru" placeholder="@lang('words.description_ru_placeholder')"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    @lang('words.description_en')
                                </label>
                                <textarea class="form-control" name="description_en" placeholder="@lang('words.description_en_placeholder')"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <div class="submit-actions">
                        <a href="{{ route('medicines.index') }}" class="btn-secondary">
                            <i class="fas fa-times"></i>
                            @lang('words.cancel')
                        </a>
                        <button type="submit" class="btn-primary">
                            @lang('words.create')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.main.website>