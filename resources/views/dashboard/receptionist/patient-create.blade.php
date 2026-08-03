<x-layouts.main.website>
    <x-slot:title>
    @lang('words.add_patient')
    </x-slot:title>

    <div class="container pt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main_page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('receptionist.index') }}">@lang('words.patients')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.add_patient')
                    </a>
                </li>
            </ol>
        </nav>

        <!-- Search Card -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">Bemor @lang('words.add_patient')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('patient.store') }}" method="POST">
            @csrf 
            
            <!-- Main Content -->
            <div class="main-content">
                <!-- Shaxsiy ma'lumotlar -->
                <div class="form-sections">
                    <!-- Shaxsiy ma'lumotlar -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-user-circle"></i>
                            <h3>@lang('words.personal_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        @lang('words.name_human') <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" placeholder="Ism" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i>
                                        @lang('words.last_name') <span class="text-danger">*</span>
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
                                    @lang('words.middle_name')
                                </label>
                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                       name="middle_name" placeholder="Otasining ismi" value="{{ old('middle_name') }}">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        @lang('words.passport_series') <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('passport_series') is-invalid @enderror" 
                                           name="passport_series" maxlength="2" placeholder="AA" value="{{ old('passport_series') }}" style="text-transform: uppercase;">
                                    @error('passport_series')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport"></i>
                                        @lang('words.passport_number') <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('passport_number') is-invalid @enderror" 
                                           name="passport_number" maxlength="7" placeholder="1234567" value="{{ old('passport_number') }}">
                                    @error('passport_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        @lang('words.birth_date') <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                           name="birth_date" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars"></i>
                                        @lang('words.gender') <span class="text-danger">*</span>
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
                    </div>

                    <!-- Aloqa ma'lumotlari -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-address-card"></i>
                            <h3>@lang('words.main_info')</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-phone"></i>
                                        @lang('words.phone') <span class="text-danger">*</span>
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
                                        @lang('words.email')
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" placeholder="email@example.com" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    @lang('words.address') 
                                </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                       name="address" placeholder="@lang('words.enter_address')" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="submit-section"> 
                <div class="submit-actions">
                    <a href="{{ route('receptionist.index') }}" class="btn-secondary">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Telefon inputiga mask qo'shish
            const phoneInput = document.querySelector('input[name="phone"]');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        if (value.length <= 2) {
                            this.value = value;
                        } else if (value.length <= 5) {
                            this.value = value.substring(0, 2) + ' ' + value.substring(2);
                        } else if (value.length <= 8) {
                            this.value = value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5);
                        } else {
                            this.value = value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5, 8) + ' ' + value.substring(8, 10);
                        }
                    }
                });
            }

            // Pasport seriyasini katta harflarga o'tkazish
            const passportSeries = document.querySelector('input[name="passport_series"]');
            if (passportSeries) {
                passportSeries.addEventListener('input', function() {
                    this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '').slice(0, 2);
                });
            }

            // Pasport raqamiga faqat raqamlar
            const passportNumber = document.querySelector('input[name="passport_number"]');
            if (passportNumber) {
                passportNumber.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 7);
                });
            }

            // Tug'ilgan sanani tekshirish (18 yosh)
            const birthDateInput = document.querySelector('input[name="birth_date"]');
            if (birthDateInput) {
                birthDateInput.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - selectedDate.getFullYear();
                    const monthDiff = today.getMonth() - selectedDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
                        age--;
                    }
                    if (age < 18 && age > 0) {
                        alert('⚠️ Bemor 18 yoshdan katta bo\'lishi kerak!');
                        this.value = '';
                    }
                });
            }

            // Formani yuborishdan oldin validatsiya
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const birthDate = document.querySelector('input[name="birth_date"]').value;
                    if (birthDate) {
                        const selectedDate = new Date(birthDate);
                        const today = new Date();
                        let age = today.getFullYear() - selectedDate.getFullYear();
                        const monthDiff = today.getMonth() - selectedDate.getMonth();
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
                            age--;
                        }
                        if (age < 18) {
                            e.preventDefault();
                            alert('⚠️ Bemor 18 yoshdan katta bo\'lishi kerak!');
                            document.querySelector('input[name="birth_date"]').focus();
                            return false;
                        }
                    }

                    const phone = document.querySelector('input[name="phone"]').value.replace(/\s/g, '');
                    if (phone.length < 9) {
                        e.preventDefault();
                        alert('⚠️ Iltimos, to\'liq telefon raqamini kiriting!');
                        document.querySelector('input[name="phone"]').focus();
                        return false;
                    }

                    const passportSeriesVal = document.querySelector('input[name="passport_series"]').value;
                    if (passportSeriesVal.length !== 2) {
                        e.preventDefault();
                        alert('⚠️ Pasport seriyasi 2 ta harfdan iborat bo\'lishi kerak!');
                        document.querySelector('input[name="passport_series"]').focus();
                        return false;
                    }

                    const passportNumberVal = document.querySelector('input[name="passport_number"]').value;
                    if (passportNumberVal.length !== 7) {
                        e.preventDefault();
                        alert('⚠️ Pasport raqami 7 ta raqamdan iborat bo\'lishi kerak!');
                        document.querySelector('input[name="passport_number"]').focus();
                        return false;
                    }

                    return true;
                });
            }
        });
    </script>
</x-layouts.main.website>