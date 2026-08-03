<x-layouts.main.website>
    <x-slot:title>
        Yangi Shifokor yaratish
    </x-slot:title>


    <div class="container pt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> Asosiy sahifa
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctors.index') }}">Shifokorlar</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;"  class="text-decoration-none">
                        Yaratish
                    </a>
                </li>
            </ol>
        </nav>
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">Shifokorlar raratish</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Main Content -->
            <div class="main-content">
                <!-- Shaxsiy va kasbiy ma'lumotlar -->
                <div class="form-sections">
                    <!-- Shaxsiy ma'lumotlar -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-id-card"></i>
                            <h3>Shaxsiy ma'lumotlar</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        Ism
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" autocomplete="name"  placeholder="Ism" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        Familiya
                                    </label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           name="last_name" placeholder="Familiya" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>
                                    Sharfi
                                </label>
                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                       name="middle_name" placeholder="Sharfi" value="{{ old('middle_name') }}">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        Pasport seriya
                                    </label>
                                    <input type="text" class="form-control @error('passport_series') is-invalid @enderror" 
                                           name="passport_series" maxlength="9" placeholder="AA1234567" value="{{ old('passport_series') }}">
                                    @error('passport_series')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        Pasport raqami
                                    </label>
                                    <input type="text" class="form-control @error('passport_number') is-invalid @enderror" 
                                           name="passport_number" maxlength="14" placeholder="12345678901012" value="{{ old('passport_number') }}">
                                    @error('passport_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars"></i>
                                    Jins
                                </label>
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                    <option value="" disabled selected>Jinsni tanlang</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Ayol</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Erkak</option>
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
                            <h3>Kasbiy ma'lumotlar</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user-md"></i>
                                    Lavozim
                                </label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                       name="position" placeholder="Lavozim" value="{{ old('position') }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-graduation-cap"></i>
                                    Malaka darajasi
                                </label>
                                <input type="text" class="form-control @error('qualification') is-invalid @enderror" 
                                       name="qualification" placeholder="Malaka darajasi" value="{{ old('qualification') }}">
                                @error('qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    Ishga kirgan sana
                                </label>
                                <input type="date" class="form-control @error('hire_date') is-invalid @enderror" 
                                       name="hire_date" value="{{ old('hire_date') }}">
                                @error('hire_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-stethoscope"></i>
                                    Mutaxassisligi
                                </label>
                                <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                                       name="specialization" placeholder="Mutaxassislik" value="{{ old('specialization') }}">
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
                            <h3>Aloqa ma'lumotlari</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i>
                                    Telefon
                                </label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" placeholder="+998 XX XXX XX XX" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" placeholder="email@example.com" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Manzil
                                </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                       name="address" placeholder="Manzil" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Tug'ilgan sana
                                </label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       name="birth_date" value="{{ old('birth_date') }}">
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
                            <h3>Sistema ma'lumotlari</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group password-group">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i>
                                    Parol
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password"  placeholder="Parol" maxlength="8">
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
                                    Parolni tasdiqlash
                                </label> 
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" 
                                       name="password_confirmation"  placeholder="Parolni takrorlang" maxlength="8">
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
                                    Tajriba (yil)
                                </label>
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                       name="experience_years" placeholder="Tajriba" min="0" max="50" value="{{ old('experience_years') }}">
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
                            <h3>Ta'lim ma'lumotlari</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-university"></i>
                                    Universitet
                                </label>
                                <input type="text" class="form-control @error('education_university') is-invalid @enderror" 
                                       name="education_university" placeholder="Universitet nomi" value="{{ old('education_university') }}">
                                @error('education_university')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-book"></i>
                                    Mutaxassislik
                                </label>
                                <input type="text" class="form-control @error('education_specialization') is-invalid @enderror" 
                                       name="education_specialization" placeholder="Mutaxassislik" value="{{ old('education_specialization') }}">
                                @error('education_specialization')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-layer-group"></i>
                                    O'qish bosqichi
                                </label>
                                <input type="text" class="form-control @error('education_level') is-invalid @enderror" 
                                       name="education_level" placeholder="Bakalavr, Magistr" value="{{ old('education_level') }}">
                                @error('education_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    Bitirgan sana
                                </label>
                                <input type="date" class="form-control @error('graduation_date') is-invalid @enderror" 
                                       name="graduation_date" value="{{ old('graduation_date') }}">
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
                            <h3>Ish joyi ma'lumotlari</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-building"></i>
                                    Bo'lim
                                </label>
                                <select class="form-control @error('department_id') is-invalid @enderror" 
                                        name="department_id">
                                    <option value="" disabled selected>Bo'limni tanlang</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Qo'shimcha ma'lumotlar
                                </label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" 
                                          name="bio" placeholder="Qo'shimcha ma'lumotlar">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-camera"></i>
                                    Rasm yuklash
                                </label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                       name="photo" accept="image/*" id="photoInput" onchange="previewPhoto(event)">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="photo-preview-container">
                                    <div class="photo-preview">
                                        <div class="photo-placeholder">
                                            <i class="fas fa-user-plus"></i>
                                            <span>Rasm yuklanmagan</span>
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
                <div class="section-header" style="border: none; justify-content: center;">
                    <i class="fas fa-check-circle"></i>
                    <h3>Shifokor yaratishni yakunlash</h3>
                </div>
                <p>Barcha maydonlarni to'ldirganingizni tekshiring. Ma'lumotlar to'g'ri ekanligiga ishonch hosil qiling.</p>
                <div class="submit-actions">
                    <a href="{{ route('doctors.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Bekor qilish
                    </a>
                    <button type="submit" class="btn-primary">
                        Saqlash
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- @if(session('error'))
        <div class="alert-notification show alert-success" id="sessionAlert" style="display: flex;">
            <i class="fas fa-check-circle"></i>
            <span class="message">{{ session('error') }}</span>
            <button class="close-alert" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif -->

    @include('partials.alert')



</x-layouts.main.website>