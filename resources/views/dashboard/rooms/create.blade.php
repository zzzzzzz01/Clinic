<x-layouts.main.website>
    <x-slot:title>
        Clinic - Xonalar Boshqaruvi
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/room-create.css') }}" />

    <!-- Breadcrumb --> 

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> Asosiy sahifa
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('room.index') }}"  class="text-decoration-none">
                     Xonalar Boshqaruvi
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;"  class="text-decoration-none">
                    Yangi xona
                    </a>
                </li>
            </ol>
        </nav>
        
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">Xonalar Boshqaruvi</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form-card qismi col-lg-12 da tashkil qilindi -->
    <div class="container"> 
        <div class="form-card">
            <form action="{{ route('room.store') }}" id="roomForm" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="notification-label" for="roomNumber">
                            Xona Raqami
                        </label>
                        <input type="text" class="form-control" id="roomNumber" name="number" placeholder="Masalan: 101-A" value="{{ old('number') }}" required>
                        @error('number')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="notification-label" for="roomType">
                            Xona Turi
                        </label>
                        <div class="styled-select">
                            <select id="roomType" name="room_type_id" class="form-control" required>
                                <option value="" disabled selected>Xona turini tanlang</option>
                                @foreach($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('room_type_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="notification-label" for="floor">
                            Qavat
                        </label>
                        <div class="styled-select">
                            <select id="floor" name="floor" class="form-control" required>
                                <option value="" disabled selected>Qavatni tanlang</option>
                                @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>{{ $i }}-qavat</option>
                                @endfor
                            </select>
                        </div>
                        @error('floor')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="notification-label" for="department">Bo'lim</label>
                        <div class="styled-select">
                            <select id="department" class="form-control" name="department_id" required>
                                <option value="" disabled selected>Bo'limni tanlang</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('department_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="notification-label" for="capacity">Sig'im</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Maksimum bemor soni" value="{{ old('capacity') }}" min="1" max="10" required>
                        @error('capacity')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="notification-label" for="price">Kunlik Narx</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="0" value="{{ old('price') }}" min="0" step="0.01" required>
                        @error('price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="features-section">
                    <label class="form-label">
                        <i class="fas fa-star"></i> Xona Qulayliklari
                        <span class="feature-count" id="featureCount">0 tanlangan</span>
                    </label>
                    <div class="features-grid" id="featuresGrid">
                        @foreach($features as $feature)
                        <label class="feature-item">
                            <input type="checkbox" name="features[]" value="{{ $feature->id }}" {{ in_array($feature->id, old('features', [])) ? 'checked' : '' }}>
                            <span class="feature-checkbox"></span>
                            <span class="feature-text">{{ $feature->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('features')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label class="notification-label" for="description">Qo'shimcha Izoh</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Xona haqida qo'shimcha ma'lumot, tavsiyalar yoki maxsus shartlar...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('room.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Bekor qilish
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        Xonani Yaratish
                    </button>
                </div>
            </form>
        </div>  
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const featureCheckboxes = document.querySelectorAll('input[name="features[]"]');
            const featureCount = document.getElementById('featureCount');
            
            // Feature counter
            featureCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateFeatureCount);
            });
            
            function updateFeatureCount() {
                const checkedCount = document.querySelectorAll('input[name="features[]"]:checked').length;
                featureCount.textContent = checkedCount + ' tanlangan';
                
                // Update feature items appearance
                featureCheckboxes.forEach(checkbox => {
                    const featureItem = checkbox.closest('.feature-item');
                    if (checkbox.checked) {
                        featureItem.classList.add('selected');
                    } else {
                        featureItem.classList.remove('selected');
                    }
                });
            }
            
            // Form submission loading state
            const form = document.getElementById('roomForm');
            const submitBtn = document.getElementById('submitBtn');
            
            form.addEventListener('submit', function() {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yaratilmoqda...';
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            });
            
            // Initialize feature count
            updateFeatureCount();
            
            // Error message highlight
            @if($errors->any())
                // Scroll to first error
                const firstError = document.querySelector('.text-danger');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            @endif
        });
    </script>
</x-layouts.main.website>