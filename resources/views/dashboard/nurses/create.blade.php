<x-layouts.main.website>
    <x-slot:title>
        @lang('words.create_new_nurse')
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
                    <a href="{{ route('nurses.index') }}" class="text-decoration-none">
                        @lang('words.nurses_list')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.create_new_nurse')
                    </a>
                </li>
            </ol>
        </nav>
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.create_new_nurse')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('nurses.store') }}" method="POST" enctype="multipart/form-data" id="createNurseForm">
            @csrf
            
            <!-- Main Content -->
            <div class="nurse-main-content">
                <!-- Shaxsiy va kasbiy ma'lumotlar -->
                <div class="form-sections">
                    <!-- Shaxsiy ma'lumotlar -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-id-card"></i>
                            <h3>@lang('words.personal_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        @lang('words.name')
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  
                                           placeholder="@lang('words.enter_name')" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        @lang('words.last_name')
                                    </label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"  
                                           placeholder="@lang('words.enter_last_name')" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>
                                    @lang('words.middle_name')
                                </label>
                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" 
                                       placeholder="@lang('words.enter_middle_name')" value="{{ old('middle_name') }}">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        @lang('words.passport_series')
                                    </label>
                                    <input type="text" class="form-control @error('passport_series') is-invalid @enderror" name="passport_series" 
                                           maxlength="9" placeholder="AA1234567" value="{{ old('passport_series') }}">
                                    @error('passport_series')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        @lang('words.passport_number')
                                    </label>
                                    <input type="text" class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" 
                                           maxlength="14" placeholder="12345678901012" value="{{ old('passport_number') }}">
                                    @error('passport_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars"></i>
                                    @lang('words.gender')
                                </label>
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" >
                                    <option value="" disabled selected>@lang('words.select_gender')</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>@lang('words.female')</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>@lang('words.male')</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kasbiy ma'lumotlar -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-briefcase-medical"></i>
                            <h3>@lang('words.professional_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user-md"></i>
                                    @lang('words.position')
                                </label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" name="position"  
                                       placeholder="@lang('words.enter_position')" value="{{ old('position') }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-graduation-cap"></i>
                                    @lang('words.enter_qualification')
                                </label>
                                <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification"  
                                       placeholder="@lang('words.enter_qualification')" value="{{ old('qualification') }}">
                                @error('qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    @lang('words.hired_date')
                                </label>
                                <input type="date" class="form-control @error('hire_date') is-invalid @enderror" name="hire_date"  
                                       value="{{ old('hire_date') }}">
                                @error('hire_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-stethoscope"></i>
                                    @lang('words.specialization')
                                </label>
                                <input type="text" class="form-control @error('specialization') is-invalid @enderror" name="specialization"  
                                       placeholder="@lang('words.enter_specialization')" value="{{ old('specialization') }}">
                                @error('specialization')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Aloqa ma'lumotlari -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-location-dot"></i>
                            <h3>@lang('words.contact_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i>
                                    @lang('words.phone')
                                </label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone"  
                                       placeholder="+998 XX XXX XX XX" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    @lang('words.email')
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"  
                                       placeholder="email@example.com" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    @lang('words.address')
                                </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" 
                                       placeholder="@lang('words.enter_address')" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    @lang('words.birth_date')
                                </label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date"  
                                       value="{{ old('birth_date') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sistema ma'lumotlari -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-key"></i>
                            <h3>@lang('words.system_info')</h3>
                        </div>
                        <div class="form-grid">
                            
                            <div class="form-group password-group">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i>
                                    @lang('words.password')
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"  
                                       placeholder="@lang('words.enter_password')" maxlength="8" style="text-transform: uppercase;">
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group password-group">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i>
                                    @lang('words.confirm_password')
                                </label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" 
                                       name="password_confirmation"  placeholder="@lang('words.repeat_password')" 
                                       maxlength="8" style="text-transform: uppercase;">
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-chart-line"></i>
                                    @lang('words.experience_years')
                                </label>
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" name="experience_years"  
                                       placeholder="@lang('words.enter_experience_years')" min="0" max="50" value="{{ old('experience_years') }}">
                                @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Ta'lim ma'lumotlari -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-graduation-cap"></i>
                            <h3>@lang('words.education_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-university"></i>
                                    @lang('words.university')
                                </label>
                                <input type="text" class="form-control @error('education_university') is-invalid @enderror" name="education_university"  
                                       placeholder="@lang('words.enter_university')" value="{{ old('education_university') }}">
                                @error('education_university')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-book"></i>
                                    @lang('words.education_specialization')
                                </label>
                                <input type="text" class="form-control @error('education_specialization') is-invalid @enderror" name="education_specialization"  
                                       placeholder="@lang('words.enter_education_specialization')" value="{{ old('education_specialization') }}">
                                @error('education_specialization')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-layer-group"></i>
                                    @lang('words.education_level')
                                </label>
                                <input type="text" class="form-control @error('education_level') is-invalid @enderror" name="education_level"  
                                       placeholder="@lang('words.enter_education_level')" value="{{ old('education_level') }}">
                                @error('education_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    @lang('words.graduation_date')
                                </label>
                                <input type="date" class="form-control @error('graduation_date') is-invalid @enderror" name="graduation_date"  
                                       value="{{ old('graduation_date') }}">
                                @error('graduation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bo'lim va rasm -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-hospital"></i>
                            <h3>@lang('words.workplace_info')</h3>
                        </div>
                        <div class="form-grid">

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-building"></i>
                                    @lang('words.department')
                                </label>
                                <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" >
                                    <option value="" disabled selected>@lang('words.select_department')</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            @php
                                                $locale = app()->getLocale();
                                                $deptName = match($locale) {
                                                    'ru' => $department->name_ru ?? $department->name_uz,
                                                    'en' => $department->name_en ?? $department->name_uz,
                                                    default => $department->name_uz,
                                                };
                                            @endphp
                                            {{ $deptName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-door-closed"></i>
                                    @lang('words.room_number')
                                </label>
                                <input type="text" class="form-control @error('room_number') is-invalid @enderror" name="room_number"  
                                       placeholder="@lang('words.enter_room_number')" value="{{ old('room_number') }}">
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-sticky-note"></i>
                                    @lang('words.additional_info')
                                </label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" name="bio" 
                                          placeholder="@lang('words.enter_additional_info')">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-camera"></i>
                                    @lang('words.upload_photo')
                                </label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" accept="image/*" 
                                       id="photoInput" onchange="previewPhoto(event)">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="photo-preview-container">
                                    <div class="photo-preview">
                                        <div class="photo-placeholder">
                                            <i class="fas fa-user-plus"></i>
                                            <span>@lang('words.no_photo_uploaded')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="submit-section">
                <div class="submit-actions">
                    <button type="button" onclick="window.history.back()" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        @lang('words.cancel')
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        @lang('words.create_nurse')
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-layouts.main.website>