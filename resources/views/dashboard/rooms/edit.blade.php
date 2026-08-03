<x-layouts.main.website>
    <x-slot:title>
        Clinic - Xonalar Boshqaruvi
    </x-slot:title> 
    <link rel="stylesheet" href="{{ asset('temp2/css/room-create.css') }}" />
 
    <div class="container">
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
                    {{ $room->number }} Hona tahriri
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $room->number }} Hona tahriri</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container"> 
        <div class="form-card">
            <form action="{{ route('room.update', $room->id) }}" id="roomForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <!-- 1 - Xona Raqami -->
                    <div class="form-group">
                        <label class="notification-label" for="roomNumber"> Xona Raqami</label>
                        <input type="text" class="form-control" id="roomNumber" name="number" 
                                value="{{ old('number', $room->number) }}" placeholder="Masalan: 101-A" 
                                data-original="{{ $room->number }}" required>
                        @error('number')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- 2 - Xona Turi -->
                    <div class="form-group">
                        <label class="notification-label" for="roomType">Xona Turi</label> 
                        <select class="form-control" id="roomType" name="room_type_id" data-original="{{ $room->room_type_id }}" required>
                            <option value="" disabled>Xona turini tanlang</option>
                            @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" 
                                {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                                {{ $roomType->name }}
                            </option>
                            @endforeach
                        </select> 
                        @error('room_type_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- 3 - QAVAT -->
                    <div class="form-group">
                        <label class="notification-label" for="floor"> Qavat</label> 
                            <select id="floor" class="form-control" name="floor" data-original="{{ $room->floor }}" required>
                                <option value="" disabled>Qavatni tanlang</option>
                                @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" 
                                    {{ old('floor', $room->floor) == $i ? 'selected' : '' }}>
                                    {{ $i }}-qavat
                                </option>
                                @endfor
                            </select> 
                        @error('floor')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- 4 - BO'LIM (Qavat bilan yonma-yon) -->
                    <div class="form-group">
                        <label class="notification-label" for="department">Bo'lim</label> 
                            <select id="department"  class="form-control" name="department_id" data-original="{{ $room->department_id }}" required>
                                <option value="" disabled>Bo'limni tanlang</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" 
                                    {{ old('department_id', $room->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                                @endforeach
                            </select> 
                        @error('department_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- 5 - SIG'IM -->
                    <div class="form-group">
                        <label class="notification-label" for="capacity"> Sig'im</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" 
                                value="{{ old('capacity', $room->capacity) }}" placeholder="Maxsimum" 
                                data-original="{{ $room->capacity }}" min="1" max="10" required>
                        @error('capacity')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- 6 - KUNLIK NARX -->
                    <div class="form-group">
                        <label class="notification-label" for="price">Kunlik Narx</label>
                        <input type="number" class="form-control" id="price" name="price" 
                                value="{{ old('price', $room->price) }}" placeholder="0" 
                                data-original="{{ $room->price }}" min="0" step="0.01" required>
                        @error('price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 7 - HOLAT -->
                    <div class="form-group">
                        <label class="notification-label" for="status">Holati</label> 
                            <select class="form-control" id="status" name="status" data-original="{{ $room->status }}" required>
                                <option value="empty" {{ old('status', $room->status) == 'empty' ? 'selected' : '' }}>Bo'sh</option>
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Mavjud</option>
                                <option value="full" {{ old('status', $room->status) == 'full' ? 'selected' : '' }}>To'liq</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Ta'mirda</option>
                            </select> 
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="features-section">
                    <label class="form-label">
                        <i class="fas fa-star"></i> Xona Qulayliklari
                        <span class="feature-count" id="featureCount">
                            {{ count($room->features) }} tanlangan
                        </span>
                    </label>
                    <div class="features-grid" id="featuresGrid">
                        @foreach($features as $feature)
                        @php
                            $isChecked = in_array($feature->id, old('features', $room->features->pluck('id')->toArray()));
                        @endphp
                        <label class="feature-item {{ $isChecked ? 'selected' : '' }}" data-feature-id="{{ $feature->id }}">
                            <input type="checkbox" name="features[]" value="{{ $feature->id }}" 
                                {{ $isChecked ? 'checked' : '' }}
                                data-original="{{ $isChecked ? 'checked' : '' }}">
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
                    <label class="notification-label" for="description">
                        <i class="fas fa-file-alt"></i> Qo'shimcha Izoh
                    </label>
                    <textarea class="form-control" id="description" name="description" rows="3" 
                                placeholder="Xona haqida qo'shimcha ma'lumot, tavsiyalar yoki maxsus shartlar..."
                                data-original="{{ $room->description }}">{{ old('description', $room->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('room.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Bekor qilish
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-check"></i> Saqlash
                    </button>
                </div>
            </form>
        </div> 
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==================== ALERT NOTIFICATION ====================
            
            // Alert funksiyalarini global qilish
            window.showAlert = function(message, type = 'success') {
                console.log('Showing alert:', message, type); // Debug uchun
                const alert = document.getElementById('alertNotification');
                const icon = document.getElementById('alertIcon');
                const messageEl = document.getElementById('alertMessage');
                
                if (!alert) {
                    console.error('Alert elementi topilmadi');
                    return;
                }
                
                // Remove previous classes
                alert.classList.remove('alert-success', 'alert-error', 'alert-warning', 'alert-info', 'show');
                
                // Add new class
                alert.classList.add(`alert-${type}`);
                
                // Set icon based on type
                if (icon) {
                    switch(type) {
                        case 'success':
                            icon.className = 'fas fa-check-circle';
                            break;
                        case 'error':
                            icon.className = 'fas fa-exclamation-circle';
                            break;
                        case 'warning':
                            icon.className = 'fas fa-exclamation-triangle';
                            break;
                        case 'info':
                            icon.className = 'fas fa-info-circle';
                            break;
                    }
                }
                
                // Set message
                if (messageEl) messageEl.textContent = message;
                
                // Show alert
                alert.style.display = 'flex';
                
                // Trigger animation
                setTimeout(() => {
                    alert.classList.add('show');
                }, 10);
                
                // Auto hide after 5 seconds
                setTimeout(() => {
                    hideAlert();
                }, 5000);
            }

            window.hideAlert = function() {
                const alert = document.getElementById('alertNotification');
                
                if (alert) {
                    alert.classList.remove('show');
                    
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }
            }

            // Click outside to close
            document.addEventListener('click', function(e) {
                const alert = document.getElementById('alertNotification');
                if (alert && alert.classList.contains('show') && !alert.contains(e.target)) {
                    hideAlert();
                }
            });

            // Escape key to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideAlert();
                }
            });

            // Sahifa yuklanganda session dan alertni chiqarish
            @if(session('success'))
                console.log('Session success found: {{ session('success') }}');
                setTimeout(function() {
                    showAlert('{{ session('success') }}', 'success');
                }, 100);
            @endif

            @if(session('error'))
                console.log('Session error found: {{ session('error') }}');
                setTimeout(function() {
                    showAlert('{{ session('error') }}', 'error');
                }, 100);
            @endif

            @if(session('warning'))
                console.log('Session warning found: {{ session('warning') }}');
                setTimeout(function() {
                    showAlert('{{ session('warning') }}', 'warning');
                }, 100);
            @endif

            @if(session('info'))
                console.log('Session info found: {{ session('info') }}');
                setTimeout(function() {
                    showAlert('{{ session('info') }}', 'info');
                }, 100);
            @endif

            // Barcha input, select va textarea elementlarini olish
            const formElements = document.querySelectorAll('input, select, textarea');
            const featureCheckboxes = document.querySelectorAll('input[name="features[]"]');
            const featureItems = document.querySelectorAll('.feature-item');
            const featureCount = document.getElementById('featureCount');
            
            // Har bir elementga o'zgarishlarni kuzatish funksiyasini qo'shish
            formElements.forEach(element => {
                // Elementning original qiymatini saqlash
                const originalValue = element.getAttribute('data-original');
                
                // O'zgarishlarni kuzatish
                element.addEventListener('input', function() {
                    checkChanges(this);
                });
                
                element.addEventListener('change', function() {
                    checkChanges(this);
                });
                
                // Select elementlar uchun alohida
                if (element.tagName === 'SELECT') {
                    element.addEventListener('change', function() {
                        checkChanges(this);
                    });
                }
            });
            
            // Feature checkboxlar uchun alohida kuzatish
            featureCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const featureItem = this.closest('.feature-item');
                    const originalChecked = this.getAttribute('data-original') === 'checked';
                    
                    if (this.checked !== originalChecked) {
                        featureItem.classList.add('changed');
                    } else {
                        featureItem.classList.remove('changed');
                    }
                    
                    // Feature count ni yangilash
                    updateFeatureCount();
                });
            });
            
            // Element o'zgarganligini tekshirish funksiyasi
            function checkChanges(element) {
                const originalValue = element.getAttribute('data-original');
                let currentValue = element.value;
                
                // Select elementlar uchun
                if (element.tagName === 'SELECT') {
                    currentValue = element.value;
                }
                
                // Agar qiymat o'zgargan bo'lsa
                if (currentValue != originalValue) {
                    element.classList.add('changed');
                } else {
                    element.classList.remove('changed');
                }
            }
            
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
                // Show loading state
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saqlanmoqda...';
                submitBtn.disabled = true;
                
                // Re-enable after 3 seconds in case of error
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            });
            
            // Initialize feature count
            updateFeatureCount();
        });
    </script>
</x-layouts.main.website>