<x-layouts.main.website>
    <x-slot:title>
        @lang('words.new_supplier')
    </x-slot:title>

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('suppliers.index') }}">@lang('words.suppliers')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @lang('words.new_supplier')
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.add_new_supplier')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form method="POST" action="{{ route('suppliers.store') }}" id="supplierForm">
            @csrf
            
            <div class="form-sections">
                
                <!-- 1-FORM SECTION: Asosiy ma'lumotlar -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-info-circle"></i>
                        <h3>@lang('words.supplier_basic_info')</h3>
                    </div>
                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    @lang('words.supplier_name_uz')
                                </label>
                                <input type="text" class="form-control" name="name_uz" value="{{ old('name_uz') }}"
                                    placeholder="@lang('words.supplier_name_uz_placeholder')">
                                @error('name_uz')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    @lang('words.supplier_name_ru')
                                </label>
                                <input type="text" class="form-control" name="name_ru" value="{{ old('name_ru') }}"
                                    placeholder="@lang('words.supplier_name_ru_placeholder')">
                                @error('name_ru')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-language"></i>
                                    @lang('words.supplier_name_en')
                                </label>
                                <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}"
                                    placeholder="@lang('words.supplier_name_en_placeholder')">
                                @error('name_en')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    @lang('words.type_uz')
                                </label>
                                <input type="text" class="form-control" name="type_uz" value="{{ old('type_uz') }}"
                                    placeholder="@lang('words.type_uz_placeholder')">
                                @error('type_uz')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    @lang('words.type_ru')
                                </label>
                                <input type="text" class="form-control" name="type_ru" value="{{ old('type_ru') }}"
                                    placeholder="@lang('words.type_ru_placeholder')">
                                @error('type_ru')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    @lang('words.type_en')
                                </label>
                                <input type="text" class="form-control" name="type_en" value="{{ old('type_en') }}"
                                    placeholder="@lang('words.type_en_placeholder')">
                                @error('type_en')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-align-left"></i>
                                @lang('words.description_uz')
                            </label>
                            <textarea class="form-control" name="description_uz" rows="3"
                                placeholder="@lang('words.supplier_description_uz_placeholder')">{{ old('description_uz') }}</textarea>
                            @error('description_uz')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-align-left"></i>
                                @lang('words.description_ru')
                            </label>
                            <textarea class="form-control" name="description_ru" rows="3"
                                placeholder="@lang('words.supplier_description_ru_placeholder')">{{ old('description_ru') }}</textarea>
                            @error('description_ru')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-align-left"></i>
                                @lang('words.description_en')
                            </label>
                            <textarea class="form-control" name="description_en" rows="3"
                                placeholder="@lang('words.supplier_description_en_placeholder')">{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 2-FORM SECTION: Aloqa ma'lumotlari -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-address-card"></i>
                        <h3>@lang('words.contact_info')</h3>
                    </div>
                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    @lang('words.email')
                                </label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="example@mail.com">
                                @error('email')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i>
                                    @lang('words.phone')
                                </label>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}"
                                    placeholder="+998 XX XXX XX XX">
                                @error('phone')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    @lang('words.address')
                                </label>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                                    placeholder="@lang('words.enter_address')">
                                @error('address')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on"></i>
                                    @lang('words.status')
                                </label>
                                <select class="form-control" name="is_active">
                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>@lang('words.active')</option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>@lang('words.inactive')</option>
                                </select>
                                @error('is_active')
                                    <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                @lang('words.contact_person')
                            </label>
                            <input type="text" class="form-control" name="contact_person" value="{{ old('contact_person') }}"
                                placeholder="@lang('words.contact_person_placeholder')">
                            @error('contact_person')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="submit-section">
                <div class="submit-actions">
                    <a href="{{ route('suppliers.index') }}" class="btn-secondary">
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
</x-layouts.main.website>