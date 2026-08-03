<x-layouts.main.website>
    <x-slot:title>
        {{ $nurse->user->last_name }} {{ $nurse->user->name }} - @lang('words.edit')
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
                    <a href="{{ route('nurses.index') }}">@lang('words.nurses_list')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.edit')
                    </a>
                </li>
            </ol>
        </nav>
        
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $nurse->user->last_name }} {{ $nurse->user->name }} - @lang('words.edit')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('nurses.update', $nurse) }}" method="POST" enctype="multipart/form-data" id="updateNurseForm">
            @csrf
            @method('PUT')
            
            <!-- Main Content -->
            <div class="nurse-main-content">
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
                                    <input type="text" class="form-control" name="name" 
                                           value="{{ old('name', $nurse->user->name) }}" data-original="{{ $nurse->user->name }}">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        @lang('words.last_name')
                                    </label>
                                    <input type="text" class="form-control" name="last_name" 
                                           value="{{ old('last_name', $nurse->user->last_name) }}" 
                                           data-original="{{ $nurse->user->last_name }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>
                                    @lang('words.middle_name')
                                </label>
                                <input type="text" class="form-control" name="middle_name" 
                                       value="{{ old('middle_name', $nurse->user->middle_name) }}"
                                       data-original="{{ $nurse->user->middle_name }}">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        @lang('words.passport_series')
                                    </label>
                                    <input type="text" class="form-control" name="passport_series" 
                                           maxlength="9" value="{{ old('passport_series', $nurse->passport_series) }}"
                                           data-original="{{ $nurse->passport_series }}">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        @lang('words.passport_number')
                                    </label>
                                    <input type="text" class="form-control" name="passport_number" 
                                           maxlength="14" value="{{ old('passport_number', $nurse->passport_number) }}"
                                           data-original="{{ $nurse->passport_number }}" id="nursePassportNumber">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars"></i>
                                    @lang('words.gender')
                                </label>
                                <select class="form-control" name="gender" data-original="{{ $nurse->gender ?? '' }}">
                                    <option value="" disabled {{ old('gender', $nurse->gender ?? '') == '' ? 'selected' : '' }}>
                                        @lang('words.select_gender')
                                    </option>
                                    <option value="female" 
                                        {{ old('gender', $nurse->gender ?? '') == 'female' ? 'selected' : '' }}>
                                        @lang('words.female')
                                    </option>
                                    <option value="male" 
                                        {{ old('gender', $nurse->gender ?? '') == 'male' ? 'selected' : '' }}>
                                        @lang('words.male')
                                    </option>
                                </select>
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
                                <input type="text" class="form-control" name="position" 
                                       value="{{ old('position', $nurse->position) }}"
                                       data-original="{{ $nurse->position }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-graduation-cap"></i>
                                    @lang('words.qualification')
                                </label>
                                <input type="text" class="form-control" name="qualification" 
                                       value="{{ old('qualification', $nurse->qualification) }}"
                                       data-original="{{ $nurse->qualification }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    @lang('words.hired_date')
                                </label>
                                <input type="date" class="form-control" name="hire_date" 
                                       value="{{ old('hire_date', $nurse->hire_date) }}" data-original="{{ $nurse->hire_date }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-stethoscope"></i>
                                    @lang('words.specialization')
                                </label>
                                <input type="text" class="form-control" name="specialization" 
                                       value="{{ old('specialization', $nurse->specialization) }}"
                                       data-original="{{ $nurse->specialization }}">
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
                                <input type="tel" class="form-control" name="phone" 
                                       value="{{ old('phone', $nurse->user->phone) }}"
                                       data-original="{{ $nurse->user->phone }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    @lang('words.email')
                                </label>
                                <input type="email" class="form-control" name="email" 
                                       value="{{ old('email', $nurse->user->email) }}"
                                       data-original="{{ $nurse->user->email }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    @lang('words.address')
                                </label>
                                <input type="text" class="form-control" name="address" 
                                       value="{{ old('address', $nurse->address) }}"
                                       data-original="{{ $nurse->address }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    @lang('words.birth_date')
                                </label>
                                <input type="date" class="form-control" name="birth_date" 
                                       value="{{ old('birth_date', $nurse->birth_date) }}" data-original="{{ $nurse->birth_date }}">
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
                            <div class="form-group">
                                <button type="button" class="cancel-password-btn" id="nurseShowPasswordModalBtn">
                                    <i class="fas fa-ban"></i>
                                    @lang('words.cancel_password')
                                </button>
                            </div>
                            
                            <div class="password-success" id="nursePasswordSuccess">
                                <i class="fas fa-check-circle"></i>
                                <div class="password-success-content">
                                    <div class="password-success-title">@lang('words.password_cancelled_successfully')</div>
                                    <div class="password-success-text" id="nurseSuccessPasswordDisplay"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-chart-line"></i>
                                    @lang('words.experience_years')
                                </label>
                                <input type="number" class="form-control" name="experience_years" 
                                       min="0" max="50" value="{{ old('experience_years', $nurse->experience_years) }}"
                                       data-original="{{ $nurse->experience_years }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-check-circle"></i>
                                    @lang('words.status')
                                </label>
                                <select class="form-control" name="status" data-original="{{ $nurse->status ?? '' }}">
                                    <option value="" disabled {{ $nurse->status == '' ? 'selected' : '' }}>
                                        @lang('words.select_status')
                                    </option>
                                    <option value="active" {{ $nurse->status == 'active' ? 'selected' : '' }}>
                                        @lang('words.active')
                                    </option>
                                    <option value="inactive" {{ $nurse->status == 'inactive' ? 'selected' : '' }}>
                                        @lang('words.inactive')
                                    </option>
                                    <option value="on_leave" {{ $nurse->status == 'on_leave' ? 'selected' : '' }}>
                                        @lang('words.on_leave')
                                    </option>
                                </select>
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
                                <input type="text" class="form-control" name="education_university" 
                                       value="{{ old('education_university', $nurse->education_university ?? '--') }}"
                                       data-original="{{ $nurse->education_university }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-book"></i>
                                    @lang('words.education_specialization')
                                </label>
                                <input type="text" class="form-control" name="education_specialization" 
                                       value="{{ old('education_specialization', $nurse->education_specialization ?? '--') }}"
                                       data-original="{{ $nurse->education_specialization }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-layer-group"></i>
                                    @lang('words.education_level')
                                </label>
                                <input type="text" class="form-control" name="education_level" 
                                       value="{{ old('education_level', $nurse->education_level ?? '--') }}"
                                       data-original="{{ $nurse->education_level }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    @lang('words.graduation_date')
                                </label>
                                <input type="date" class="form-control" name="graduation_date" 
                                       value="{{ old('graduation_date', $nurse->graduation_date) }}" data-original="{{ $nurse->graduation_date }}">
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
                                <select class="form-control" name="department_id">
                                    <option value="" disabled>@lang('words.select_department')</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id', $nurse->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-sticky-note"></i>
                                    @lang('words.additional_info')
                                </label>
                                <textarea class="form-control" name="bio" 
                                          data-original="{{ $nurse->bio }}">{{ old('bio', $nurse->bio) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-camera"></i>
                                    @lang('words.upload_photo')
                                </label>
                                <input type="file" class="form-control" name="photo" accept="image/*" 
                                       id="photoInput" onchange="previewPhoto(event)">
                                <div class="photo-preview-container">
                                    <div class="photo-preview">
                                        @if($nurse->photo)
                                            <img src="{{ asset('storage/' . $nurse->photo) }}" alt="@lang('words.photo')">
                                        @else
                                            <div class="photo-placeholder">
                                                <i class="fas fa-user-plus"></i>
                                                <span>@lang('words.no_photo_uploaded')</span>
                                            </div>
                                        @endif
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
                    <a href="{{ route('nurses.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        @lang('words.cancel')
                    </a>
                    <button type="submit" class="btn-primary" id="nurseSubmitBtn">
                        @lang('words.update')
                    </button>
                </div>
            </div>
        </form>
    </div>

    @include('partials.password-cancel', [
        'nurse' => $nurse
    ])

</x-layouts.main.website>