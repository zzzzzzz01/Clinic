<x-layouts.main.website>
    <x-slot:title>
        @lang('words.rooms_management')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/rooms.css') }}" />
    
    <div class="container-fluid px-0">

        <!-- Title -->
        <div class="container pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main.page')
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" style="color: #808080;" class="text-decoration-none">
                            @lang('words.rooms_management')
                        </a>
                    </li>
                </ol>
            </nav>
            
            <!-- Search -->
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.rooms_management')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container">
            <div class="admin-content">
                <!-- Stats Cards - $stats array dan olinadi -->

                <!-- Action Bar -->
                <div class="action-bar">
                    <div class="left-actions">
                        <button class="filter-toggle-btn" id="filterToggleBtn">
                            <i class="fas fa-sliders-h"></i>
                            <span>@lang('words.filters')</span>
                            <span class="filter-count" id="filterCount">0</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </button>
                        
                        <a href="{{ route('room.create') }}" class="add-room-btn">
                            <i class="fas fa-plus"></i> @lang('words.add_new_room')
                        </a>
                        
                    </div>
                    <button class="waiting-patients-btn" onclick="openWaitingPatientsModal({{ count($hospitalizations) }})">
                        <i class="fas fa-clock"></i> 
                        @lang('words.waiting_list')
                        <span class="waiting-badge">{{ count($hospitalizations) }}</span>
                    </button>
                </div>
  
                @include('partials.filters.complete-maintenance')

                <!-- Rooms Grid -->
                <div class="rooms-grid" id="roomsContainer">
                    @forelse($rooms as $room)
                    <x-room-card :room="$room" />
                    @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 2rem; background: white; border-radius: 0.5rem;">
                        @lang('words.no_rooms_found')
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @include('partials.paginations.room')

                
                @include('partials.stats.room')
            </div>
        </div>
    </div>
 
    <!-- Asosiy qismda discharge modalni chaqirish -->
    @include('partials.modals.rooms.discharge')
 
    <!-- Complete Maintenance Modal (Ta'mirni tamomlash) -->
    @include('partials.modals.rooms.complete-maintenance')

    <!-- Assign Patient Modal (Bemor joylashtirish) -->
    @include('partials.modals.rooms.assign-maintenance')

    <!-- Waiting Patients Modal (Navbatdagi bemorlar) -->
    @include('partials.modals.rooms.waiting-patient')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Alert Notification (Dinamik) -->
    <div id="alertNotification" class="alert-notification" style="display: none;">
        <i id="alertIcon" class="fas fa-check-circle"></i>
        <span id="alertMessage" class="message"></span>
        <button class="close-alert" onclick="hideAlert()">✕</button>
    </div> 
    <!-- JavaScript: Ma'lumotlarni global qilish -->
    <script>
        // Ma'lumotlarni JSON ga aylantirib yuborish
        window.hospitalizationsData = @json($hospitalizations);
        window.roomsData = @json($rooms->items());
        
        console.log('✅ Hospitalizations count:', window.hospitalizationsData.length);
        console.log('✅ Rooms count:', window.roomsData.length);
        
        // Agar ma'lumotlar bo'sh bo'lsa, xabar chiqarish
        if (window.hospitalizationsData.length === 0) {
            console.warn('⚠️ Hech qanday navbatdagi bemor mavjud emas!');
        }
    </script>

    <script src="{{ asset('temp2/js/rooms.js') }}"></script> 
    
</x-layouts.main.website>