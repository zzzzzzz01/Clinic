<x-layouts.main.website>
    <x-slot:title>
        {{ $department->name }} - Xonalar
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/suppliers.css') }}" />

    <div class="main-content">
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
                        <a href="{{ route('department.index') }}" class="text-decoration-none">
                           @lang('words.department_management')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $department->name }}
                    </li>
                </ol>
            </nav>
            
            <!-- Department nomi -->
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0"> @lang('words.rooms_management') ({{ $department->name }})</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <!-- Xonalar Jadvali -->
            <div class="rooms-table-container"> 

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('words.room')</th>
                                <th>@lang('words.floor')</th>
                                <th>Xona turi</th>
                                <th>@lang('words.status')</th>
                                <th>@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody id="roomsTableBody">
                            @include('partials.table-body.department-room')
                        </tbody>
                    </table>
                </div>

                @include('partials.paginations.department-room')
            </div>

            
            <!-- Statistics Cards -->
            @include('partials.stats.department-rooms')
        </div>
    </div>

    <!-- Yotoqlar Modal Oynasi -->
    <dialog id="bedsModal" class="notification-modal">
        <div class="modal-header">
            <h3>
                <i class="fas fa-bed"></i>
                <span id="modalRoomNumber">101</span>-xona
            </h3>
            <button class="close-btn" onclick="closeBedsModal()">✕</button>
        </div>

        <div class="modal-body">
            <!-- Xona ma'lumotlari kartasi -->
            <div class="room-info-card" id="roomInfo">
                <div class="room-info-left">
                    <div class="room-info-title">
                        <i class="fas fa-door-open"></i>
                        <span id="infoRoomNumber">101</span>-xona ma'lumotlari
                    </div>
                    <div class="room-info-desc" id="infoRoomDesc">
                        Standart xona, 1-qavat
                    </div>
                </div>
                <div class="room-info-right">
                    <div class="room-info-stats" id="infoRoomStats">
                        0 <small>/ 0</small>
                    </div>
                    <div class="room-info-status" id="infoRoomStatus">
                        <i class="fas fa-bed"></i> yotoq band
                    </div>
                </div>
            </div>

            <!-- Yotoqlar Grid -->
            <div class="beds-grid" id="bedsGrid">
                <!-- JS orqali to'ldiriladi -->
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeBedsModal()">
                <i class="fas fa-times"></i> Yopish
            </button>
        </div>
    </dialog>

    <script>
        // Department xonalari ma'lumotlari (Servicedan kelgan)
        const departmentRooms = @json($roomsJson);

        // Global o'zgaruvchilar
        let currentRoomId = null;

        // Modal oynasini ochish (faqat roomId orqali)
        function openBedsModal(roomId) {
            const modal = document.getElementById('bedsModal');
            currentRoomId = roomId;
            
            // Xona ma'lumotlarini olish
            const roomData = departmentRooms[roomId];
            
            if (!roomData) {
                alert('Xona ma\'lumotlari topilmadi!');
                return;
            }
            
            // Modal sarlavhasini yangilash
            document.getElementById('modalRoomNumber').textContent = roomData.number;
            
            // Xona ma'lumotlarini yangilash
            document.getElementById('infoRoomNumber').textContent = roomData.number;
            document.getElementById('infoRoomDesc').textContent = roomData.type + ' xona, ' + roomData.floor + '-qavat';
            
            // Xona statistikasini hisoblash
            let totalBeds = roomData.capacity || 0;
            let occupiedBeds = roomData.beds ? roomData.beds.filter(bed => bed.status === 'occupied').length : 0;
            
            document.getElementById('infoRoomStats').innerHTML = occupiedBeds + ' <small>/ ' + totalBeds + '</small>';
            document.getElementById('infoRoomStatus').innerHTML = '<i class="fas fa-bed"></i> ' + occupiedBeds + ' yotoq band';
            
            // Yotoqlarni yuklash
            loadBedsForRoom(roomId);
            
            // Modalni ochish
            modal.showModal();
            document.body.classList.add('modal-open');
        }

        // Xona uchun yotoqlarni yuklash
        function loadBedsForRoom(roomId) {
            const bedsGrid = document.getElementById('bedsGrid');
            const roomData = departmentRooms[roomId];
            
            if (!roomData || !roomData.beds || roomData.beds.length === 0) {
                bedsGrid.innerHTML = `
                    <p style="text-align: center; padding: 30px; color: #64748b; grid-column: 1/-1;">
                        <i class="fas fa-bed" style="display: block; font-size: 32px; margin-bottom: 10px;"></i>
                        Bu xonada yotoqlar mavjud emas
                    </p>
                `;
                return;
            }
            
            let bedsHtml = '';
            
            roomData.beds.forEach(bed => {
                const statusClass = bed.status_class;
                const statusText = bed.status_text;
                const statusIcon = bed.status_icon || 'fa-circle';
                
                bedsHtml += `
                    <div class="bed-card ${statusClass}" data-bed-id="${bed.id}">
                        <div class="bed-header">
                            <span class="bed-number"><i class="fas fa-bed"></i> Yotoq №${bed.number}</span>
                            <span class="bed-status ${statusClass}">${statusText}</span>
                        </div>
                        <div class="bed-patient">
                `;
                
                if (bed.status === 'occupied' && bed.patient) {
                    bedsHtml += `
                            <div class="patient-name">${bed.patient.name}</div>
                            <div class="patient-details">
                                <span><i class="fas fa-calendar-alt"></i> ${bed.patient.age || '—'} yosh</span>
                                <span><i class="fas fa-procedures"></i> ${bed.patient.diagnosis || '—'}</span>
                                <span><i class="fas fa-calendar-check"></i> ${bed.patient.admitted_at || '—'}</span>
                            </div>
                    `;
                } else if (bed.status === 'maintenance') {
                    bedsHtml += `
                            <div class="no-patient">Ta'mirlash ishlari olib borilmoqda</div>
                    `;
                } else {
                    bedsHtml += `
                            <div class="no-patient">Bemor yo'q</div>
                    `;
                }
                
                bedsHtml += `
                        </div>
                    </div>
                `;
            });
            
            bedsGrid.innerHTML = bedsHtml;
        }

        // Modalni yopish
        function closeBedsModal() {
            const modal = document.getElementById('bedsModal');
            modal.close();
            document.body.classList.remove('modal-open');
            currentRoomId = null;
        }

        // Modal tashqarisiga bosilganda yopish
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('bedsModal');
            if (event.target === modal) {
                closeBedsModal();
            }
        });

        // ESC tugmasi bilan yopish
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && document.getElementById('bedsModal').open) {
                closeBedsModal();
            }
        });

        // DOM yuklanganda
        document.addEventListener('DOMContentLoaded', function() {
            // Barcha ko'rish tugmalariga event listener qo'shish
            document.querySelectorAll('.action-eye').forEach(button => {
                button.addEventListener('click', function(e) {
                    const roomId = this.getAttribute('data-room-id') || this.getAttribute('onclick').match(/'([^']+)'/)[1];
                    // Agar onclick ishlatilgan bo'lsa, bu event ishlamaydi
                });
            });
        });
    </script>
    
</x-layouts.main.website>