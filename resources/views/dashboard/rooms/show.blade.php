<x-layouts.main.website>
    <x-slot:title>
        Clinic - Xonalar Boshqaruvi
    </x-slot:title>
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #7f8c8d;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --info: #3498db;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --border: #ecf0f1;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: var(--dark);
        }
        
        .glass-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid var(--border);
        }
        
        .glass-card:hover {
            box-shadow: var(--hover-shadow);
        }
        
        .room-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
            margin-bottom: 25px;
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .status-available { background: var(--success); }
        .status-occupied { background: var(--warning); }
        .status-maintenance { background: var(--danger); }
        
        .features-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 15px;
        }
        
        .feature-tag {
            background: var(--light);
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        
        .feature-tag:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-1px);
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }
        
        .detail-item:hover {
            background: rgba(52, 152, 219, 0.05);
            padding-left: 10px;
            padding-right: 10px;
            margin: 0 -10px;
            border-radius: 8px;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .back-btn {
            background: white;
            color: var(--dark);
            border: 1px solid var(--border);
        }
        
        .back-btn:hover {
            background: var(--light);
            color: var(--dark);
        }
        
        .patient-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: relative;
        }
        
        .patient-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .patient-name-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 2px;
        }
        
        .patient-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .doctor-info {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            color: var(--info);
            background: rgba(52, 152, 219, 0.1);
            padding: 2px 6px;
            border-radius: 12px;
            white-space: nowrap;
        }
        
        .doctor-info i {
            font-size: 0.7rem;
        }
        
        /* Bemor ma'lumotlari qatori (qabul, tashxis, kun) - faqat bitta chiziq tepasida */
        .patient-card .row.mt-2 {
            margin-top: 12px !important;
            position: relative;
            padding-top: 8px;
        }
        
        /* Gorizontal chiziq - 1.5px qalinlikda, boshidan ohirigacha bir xil */
        .patient-card .row.mt-2::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1.5px;
            background: var(--primary);
            opacity: 0.3;
            border-radius: 0;
        }
        
        .patient-card .row.mt-2 .col-4 {
            padding: 0 2px;
            position: relative;
        }
        
        .occupancy-info {
            background: var(--light);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .stats-card {
            text-align: center;
            padding: 12px 8px;
            margin: 0 50px;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .badge-modern {
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 500;
            font-size: 0.8rem;
            background: var(--light);
            border: 1px solid var(--border);
        }
        
        .room-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        
        /* Katta ekranlar uchun */
        @media (max-width: 1400px) {
            .container {
                max-width: 1320px;
                padding-left: 15px;
                padding-right: 15px;
            }
            
            h2 {
                font-size: 1.8rem;
            }
            
            h4 {
                font-size: 1.3rem;
            }
            
            h6 {
                font-size: 1rem;
            }
            
            .detail-item {
                font-size: 0.95rem;
                padding: 12px 0;
            }
            
            .action-btn {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
            
            .patient-card {
                padding: 12px;
            }
            
            .patient-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.85rem;
            }
            
            .feature-tag {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
            
            .stats-number {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 1200px) {
            .container {
                max-width: 1140px;
                padding-left: 15px;
                padding-right: 15px;
            }
            
            h2 {
                font-size: 1.7rem;
            }
            
            h4 {
                font-size: 1.2rem;
            }
            
            h6 {
                font-size: 0.95rem;
            }
            
            .detail-item {
                font-size: 0.9rem;
                padding: 10px 0;
            }
            
            .action-btn {
                padding: 7px 14px;
                font-size: 0.8rem;
            }
            
            .patient-card {
                padding: 10px;
            }
            
            .patient-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }
            
            .feature-tag {
                font-size: 0.75rem;
                padding: 4px 8px;
            }
            
            .stats-number {
                font-size: 1.6rem;
            }
            
            .breadcrumb {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 992px) {
            .container {
                max-width: 960px;
                padding-left: 12px;
                padding-right: 12px;
            }
            
            h2 {
                font-size: 1.6rem;
            }
            
            h4 {
                font-size: 1.1rem;
            }
            
            h6 {
                font-size: 0.9rem;
            }
            
            .detail-item {
                font-size: 0.85rem;
                padding: 8px 0;
            }
            
            .action-btn {
                padding: 6px 12px;
                font-size: 0.75rem;
            }
            
            .patient-card {
                padding: 8px;
            }
            
            .patient-avatar {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }
            
            .feature-tag {
                font-size: 0.7rem;
                padding: 3px 6px;
            }
            
            .stats-number {
                font-size: 1.4rem;
            }
            
            .breadcrumb {
                font-size: 0.85rem;
            }
            
            .glass-card {
                padding: 1rem !important;
            }
        }
        
        @media (max-width: 768px) {
            .room-header {
                padding: 20px;
            }
            
            .features-list {
                gap: 6px;
            }
            
            .feature-tag {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
            
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
        
        /* Eng kichik ekranlar uchun (480px va undan kichik) */
        @media (max-width: 480px) {
            .container {
                padding-left: 22px !important;
                padding-right: 22px !important;
                max-width: 100%;
            }
            
            .glass-card {
                padding: 12px !important;
                margin-bottom: 12px;
                border-radius: 8px;
            }
            
            .glass-card h4 {
                font-size: 1rem;
                margin-bottom: 12px;
            }
            
            .glass-card h4 i {
                font-size: 0.9rem;
            }
            
            .detail-item {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                font-size: 0.8rem;
            }
            
            .detail-item span {
                font-size: 0.75rem;
                white-space: nowrap;
            }
            
            .detail-item strong {
                font-size: 0.8rem;
                max-width: 60%;
                text-align: right;
                word-break: break-word;
            }
            
            .detail-item:hover {
                padding-left: 5px;
                padding-right: 5px;
                margin: 0 -5px;
            }
            
            .features-list {
                gap: 4px;
                margin-top: 8px;
            }
            
            .feature-tag {
                font-size: 0.65rem;
                padding: 3px 6px;
            }
            
            /* Joriy bemorlar qismi ixchamlashtirildi */
            .patient-card {
                padding: 8px;
                margin-bottom: 12px;
                border-left-width: 3px;
            }
            
            .patient-card .row {
                margin: 0;
            }
            
            .patient-card .col-auto {
                padding: 0 4px;
            }
            
            .patient-avatar {
                width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }
            
            .patient-name-row {
                gap: 4px;
                margin-bottom: 2px;
            }
            
            .patient-name {
                font-size: 0.8rem;
            }
            
            .doctor-info {
                font-size: 0.6rem;
                padding: 1px 4px;
                gap: 2px;
            }
            
            .doctor-info i {
                font-size: 0.55rem;
            }
            
            .patient-card p {
                font-size: 0.65rem;
                margin-bottom: 2px;
            }
            
            .patient-card .badge {
                font-size: 0.6rem;
                padding: 2px 4px;
            }
            
            /* Bemor ma'lumotlari qatori (qabul, tashxis, kun) */
            .patient-card .row.mt-2 {
                margin-top: 8px !important;
                padding-top: 6px;
            }
            
            .patient-card .row.mt-2::before {
                height: 1.5px;
                background: var(--primary);
                opacity: 0.3;
            }
            
            .patient-card .row.mt-2 .col-4 {
                padding: 0 2px;
            }
            
            .patient-card .row.mt-2 small {
                font-size: 0.5rem;
                display: block;
                margin-bottom: 2px;
            }
            
            .patient-card .row.mt-2 .fw-semibold {
                font-size: 0.65rem;
                word-break: break-word;
                line-height: 1.2;
            }
            
            /* Bo'sh joy kartasi */
            .patient-card .text-center.py-3 {
                padding: 6px 0 !important;
            }
            
            .patient-card .fa-bed {
                font-size: 1rem;
                margin-bottom: 2px;
            }
            
            .patient-card h6.text-muted {
                font-size: 0.7rem;
                margin: 0;
            }
            
            .patient-card small.text-muted {
                font-size: 0.55rem;
            }
            
            /* O'ng panel */
            .occupancy-info {
                padding: 8px;
                margin-bottom: 10px;
            }
            
            .occupancy-info .row .col-4 {
                padding: 0 2px;
            }
            
            .occupancy-info .fw-bold {
                font-size: 0.85rem;
            }
            
            .occupancy-info small {
                font-size: 0.6rem;
            }
            
            .progress {
                height: 4px !important;
                margin-bottom: 5px !important;
            }
            
            .action-btn {
                padding: 5px 6px;
                font-size: 0.65rem;
                gap: 3px;
            }
            
            .action-btn i {
                font-size: 0.65rem;
            }
            
            .row.g-2 {
                margin: -2px;
            }
            
            .row.g-2 > [class*=col-] {
                padding: 2px;
            }
            
            .stats-number {
                font-size: 1.1rem;
            }
            
            .glass-card .row.text-center .col-4 {
                padding: 0 2px;
            }
            
            .glass-card .row.text-center .fw-bold {
                font-size: 0.8rem;
            }
            
            .glass-card .row.text-center small {
                font-size: 0.5rem;
                line-height: 1.2;
                display: block;
            }
            
            .glass-card .mt-3 small {
                font-size: 0.55rem;
            }
            
            /* Breadcrumb va sarlavha */
            .title-wrapper .row {
                margin: 0;
            }
            
            .title-wrapper .col-md-6 {
                padding: 0 6px;
            }
            
            h2 {
                font-size: 1.1rem;
                margin-bottom: 5px;
            }
            
            .breadcrumb {
                font-size: 0.6rem;
                flex-wrap: wrap;
                padding: 0;
                margin: 0;
            }
            
            .breadcrumb-item + .breadcrumb-item {
                padding-left: 2px;
            }
            
            .breadcrumb-item + .breadcrumb-item::before {
                padding-right: 2px;
                font-size: 0.6rem;
            }
            
            /* Kolonnalar orasidagi masofa */
            .col-lg-8, .col-lg-4 {
                padding-left: 6px;
                padding-right: 6px;
            }
            
            /* Tavsif qismi */
            .mt-4 p {
                font-size: 0.7rem;
                line-height: 1.3;
                margin-top: 5px;
            }
            
            /* Form o'chirish tugmasi */
            .mt-3 form button {
                font-size: 0.65rem;
                padding: 5px 6px;
            }
            
            /* Statistika qatorlari */
            .glass-card .row.text-center {
                margin: 0 -2px;
            }
        }
        
        /* Juda kichik ekranlar uchun (360px va undan kichik) */
        @media (max-width: 360px) {
            .container {
                padding-left: 22px !important;
                padding-right: 22px !important;
            }
            
            .glass-card {
                padding: 8px !important;
            }
            
            .glass-card h4 {
                font-size: 0.9rem;
            }
            
            .detail-item span {
                font-size: 0.65rem;
            }
            
            .detail-item strong {
                font-size: 0.7rem;
                max-width: 55%;
            }
            
            .feature-tag {
                font-size: 0.6rem;
                padding: 2px 5px;
            }
            
            .patient-card {
                padding: 5px;
            }
            
            .patient-avatar {
                width: 24px;
                height: 24px;
                font-size: 0.6rem;
            }
            
            .patient-name {
                font-size: 0.7rem;
            }
            
            .doctor-info {
                font-size: 0.55rem;
                padding: 1px 3px;
            }
            
            .patient-card p {
                font-size: 0.6rem;
            }
            
            .patient-card .badge {
                font-size: 0.55rem;
                padding: 1px 3px;
            }
            
            .patient-card .row.mt-2 {
                margin-top: 6px !important;
                padding-top: 4px;
            }
            
            .patient-card .row.mt-2::before {
                height: 1.5px;
                background: var(--primary);
                opacity: 0.3;
            }
            
            .patient-card .row.mt-2 .fw-semibold {
                font-size: 0.6rem;
            }
            
            .action-btn {
                padding: 4px 5px;
                font-size: 0.6rem;
            }
            
            .stats-number {
                font-size: 1rem;
            }
            
            h2 {
                font-size: 1rem;
            }
            
            .breadcrumb {
                font-size: 0.5rem;
            }
            
            .occupancy-info .fw-bold {
                font-size: 0.75rem;
            }
        }

        /* room.show sahifasi uchun maxsus sozlamalar */
        .container {
            max-width: 100%;
            transition: all 0.3s ease;
        }

        /* Menyu yopilganda container kengayishi */
        .sidebar-nav-wrapper.collapsed ~ .main-wrapper .container {
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>
 

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
                    {{ $room->number }} Hona
                    </a>
                </li>
            </ol>
        </nav>
        
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $room->number }} Hona</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Asosiy ma'lumotlar -->
            <div class="col-lg-8">
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Xona Tafsilotlari
                    </h4>
                    
                    <div class="detail-item">
                        <span class="text-muted">
                            <i class="fas fa-hashtag me-2"></i> Hona raqami
                        </span>
                        <strong>{{ $room->number }}</strong>
                    </div>
                    
                    <div class="detail-item">
                        <span class="text-muted">
                            <i class="fas fa-tag me-2"></i>Xona Turi
                        </span>
                        <strong>{{ $room->roomType->name }}</strong>
                    </div>
                    
                    <div class="detail-item">
                        <span class="text-muted">
                            <i class="fas fa-layer-group me-2"></i>Qavat
                        </span>
                        <strong>{{ $room->floor }}-qavat</strong>
                    </div>
                    
                    <div class="detail-item">
                        <span class="text-muted">
                            <i class="fas fa-building me-2"></i>Bo'lim
                        </span>
                        <strong> {{ $room->department->name }} </strong>
                    </div>
                    
                    <div class="detail-item">
                        <span class="text-muted">
                            <i class="fas fa-bullseye me-2"></i>Holati
                        </span>
                        <strong class="text-warning">Band ({{ $room->roomBeds->where('status', 'occupied')->count() }}/{{ $room->capacity }})</strong>
                    </div>
                    
                    <div class="detail-item">
                        <span class="text-muted">
                            <i class="fas fa-dollar-sign me-2"></i>Narxi
                        </span>
                        <strong class="text-success">${{ $room->price }}/kun</strong>
                    </div>
                    
                    <div class="detail-item">
                        <span class="text-muted">
                            <i class="fas fa-users me-2"></i>Sig'im
                        </span>
                        <strong>{{ $room->capacity }} kishi</strong>
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="fas fa-file-alt text-primary me-2"></i>
                            Tavsif
                        </h6>
                        <p class="text-muted mb-0">
                            {{ $room->description }}
                        </p>
                    </div>
                </div>

                <!-- Qulayliklar -->
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-star text-warning me-2"></i>
                        Xona Qulayliklari
                    </h4>
                    
                    <div class="features-list">
                        @foreach($room->features as $feature)
                        <span class="feature-tag"> {{ $feature->name }} </span>
                        @endforeach
                    </div>
                </div>

                <div class="glass-card p-4">
                    <h4 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-user-injured text-info me-2"></i>
                        Joriy Bemorlar ({{ $room->roomBeds->where('status', 'occupied')->count() }} / {{ $room->roomBeds->count() }})
                    </h4>
                    
                    @foreach($room->roomBeds as $roomBed)
                        @if($roomBed->status == 'occupied')
                            @php
                                // Band to'shak - bemor ma'lumotlarini olish
                                $hospitalizationRoom = $roomBed->hospitalizationRooms->first();
                                $hospitalization = $hospitalizationRoom?->hospitalization;
                                $appointment = $hospitalization?->appointment;
                                $patient = $appointment?->patient;
                                $user = $patient?->user;
                                $doctor = $appointment?->doctor;
                            @endphp
                            
                            @if($hospitalization && $patient && $user)
                                <!-- Band to'shak - Bemor ma'lumotlari -->
                                <div class="patient-card">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="patient-avatar">
                                                {{ substr($user->name, 0, 1) }}{{ strlen($user->name) > 1 ? substr($user->name, 1, 1) : '' }}
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="patient-name-row">
                                                <span class="patient-name">{{ $user->last_name }} {{ substr($user->name, 0, 1) }}</span>
                                                @if($doctor)
                                                    <span class="doctor-info">
                                                        <i class="fas fa-user-md"></i>Dr. {{ $doctor->user->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-muted mb-1">
                                                {{ \Carbon\Carbon::parse($patient->birth_date)->age }} yosh • 
                                                {{ $appointment->reason ?? 'Kardiologiya' }}
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            @php
                                                $statusClass = $hospitalization->status == 'active' ? 'bg-success' : 'bg-warning';
                                                $statusText = $hospitalization->status == 'active' ? 'Barqaror' : 'Davolanmoqda';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2 text-center">
                                        <div class="col-4">
                                            <small class="text-muted">Qabul</small>
                                            <div class="fw-semibold">{{ $hospitalization->admission_date ? date('d.m.Y', strtotime($hospitalization->admission_date)) : '10.01.2024' }}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Tashxis</small>
                                            <div class="fw-semibold">{{ $appointment->reason ?? 'Yuraginda og\'riq' }}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Kun</small>
                                            <div class="fw-semibold">
                                                @if($hospitalization->admission_date)
                                                    {{ \Carbon\Carbon::parse($hospitalization->admission_date)->diffInDays(now()) }}
                                                @else
                                                    5
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif($roomBed->status == 'available')
                            <!-- Bo'sh to'shak -->
                            <div class="patient-card" style="border-left-color: #e74c3c;">
                                <div class="text-center py-3">
                                    <i class="fas fa-bed text-muted fa-2x mb-2"></i>
                                    <h6 class="text-muted">{{ $roomBed->bed_number }} - Bo'sh joy</h6>
                                    <small class="text-muted">Qo'shimcha bemor qabul qilish mumkin</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- O'ng panel -->
            <div class="col-lg-4">
                <!-- Bandlik ma'lumoti -->
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Bandlik Holati
                    </h4>
                    
                    <div class="occupancy-info">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="fw-bold text-primary">3</div>
                                <small class="text-muted">Jami</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-warning">2</div>
                                <small class="text-muted">Band</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-success">1</div>
                                <small class="text-muted">Bo'sh</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-warning" style="width: 66%"></div>
                        <div class="progress-bar bg-success" style="width: 34%"></div>
                    </div>
                    <small class="text-muted">66% band</small>
                </div>

                <!-- Tezkor amallar -->
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Tezkor Amallar
                    </h4>
                    
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('room.edit', $room->id) }}" class="action-btn btn btn-primary w-100">
                                <i class="fas fa-edit"></i>Tahrir
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="" class="action-btn btn btn-success w-100">
                                <i class="fas fa-user-plus"></i>Bemor
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="" class="action-btn btn btn-info w-100">
                                <i class="fas fa-history"></i>Tarix
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="" class="action-btn btn btn-warning w-100">
                                <i class="fas fa-tools"></i>Ta'mir
                            </a>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form action="" method="POST" class="d-inline w-100">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn btn-outline-danger w-100">
                                <i class="fas fa-trash"></i>O'chirish
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Xona statistika -->
                <div class="glass-card p-4">
                    <h4 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-chart-bar text-success me-2"></i>
                        Xona Statistika
                    </h4>
                    
                    <div class="row text-center">
                        <div class="col-4 mb-3">
                            <div class="fw-bold text-primary">85%</div>
                            <small class="text-muted">O'rtacha bandlik</small>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="fw-bold text-warning">4.8</div>
                            <small class="text-muted">Reyting</small>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="fw-bold text-info">12</div>
                            <small class="text-muted">Oylik bemor</small>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-muted d-block mb-1">
                            <i class="fas fa-calendar me-1"></i>Oxirgi tozalash: Bugun 08:00
                        </small>
                        <small class="text-muted d-block">
                            <i class="fas fa-clock me-1"></i>Keyingi tekshiruv: 20.01.2024
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    <script>
        // Funksiyalar
        // function addPatient() {
        //     alert('Yangi bemor qo\'shish sahifasiga o\'tish');
        // }
        
        function editRoom() {
            alert('Xona ma\'lumotlarini tahrirlash');
        }
        
        function showHistory() {
            alert('Xona to\'liq tarixi');
        }
        
        function startMaintenance() {
            if (confirm('Xonani ta\'mirlash rejimiga o\'tkazmoqchimisiz?')) {
                alert('Xona ta\'mirlash rejimiga o\'tkazildi');
            }
        }
        
        function deleteRoom() {
            if (confirm('Haqiqatan ham bu xonani oʻchirmoqchimisiz?')) {
                alert('Xona o\'chirildi');
            }
        }

        // Sahifa yuklanganda
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Xona ma\'lumotlari sahifasi yuklandi');
        });
    </script>

</x-layouts.main.website>