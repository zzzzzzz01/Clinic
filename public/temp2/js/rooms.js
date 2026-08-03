console.log(window.hospitalizationsData);
console.log(window.roomsData);


// ==================== ASSIGN PATIENT MODAL ====================
const assignPatientModal = document.getElementById('assignPatientModal');
const modalRoomNumber = document.getElementById('modalRoomNumber');
const selectedRoomId = document.getElementById('selectedRoomId');
const selectedHospitalizationId = document.getElementById('selectedHospitalizationId');
const selectedBedId = document.getElementById('selectedBedId');
const patientSearch = document.getElementById('patientSearch');
const searchResults = document.getElementById('searchResults');
const clearSearchBtn = document.getElementById('clearSearch');
const selectedPatientContainer = document.getElementById('selectedPatientContainer');
const selectedPatientAvatar = document.getElementById('selectedPatientAvatar');
const selectedPatientName = document.getElementById('selectedPatientName');
const selectedPatientMeta = document.getElementById('selectedPatientMeta');
const admissionDate = document.getElementById('admissionDate');
const bedsContainer = document.getElementById('bedsContainer');
const confirmBtn = document.getElementById('confirmAssignPatient');

let searchTimeout;
let selectedPatient = null;

// Assign patient buttons
document.querySelectorAll('.assign-patient-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const roomId = this.dataset.roomId;
        const roomNumber = this.dataset.roomNumber;
        openAssignPatientModal(roomId, roomNumber);
    });
});

function openAssignPatientModal(roomId, roomNumber) {
    selectedRoomId.value = roomId;
    modalRoomNumber.textContent = roomNumber;
    
    assignPatientModal.showModal();
    document.body.classList.add('modal-open');
    
    // Reset form
    resetAssignForm();
    
    // Load available beds
    loadAvailableBeds(roomId);
    
    // Focus search input
    setTimeout(() => {
        patientSearch.focus();
    }, 100);
}

function resetAssignForm() {
    patientSearch.value = '';
    clearSearchBtn.classList.remove('show');
    searchResults.innerHTML = `
        <div class="no-results">
            <i class="fas fa-search"></i>
            <p style="font-size: 14px;">Bemor qidirish uchun ism yoki familiya kiriting</p>
        </div>
    `;
    selectedPatientContainer.style.display = 'none';
    selectedHospitalizationId.value = '';
    selectedBedId.value = '';
    selectedPatient = null;
    confirmBtn.disabled = true;
    
    // Reset beds selection
    document.querySelectorAll('.bed-item').forEach(bed => {
        bed.classList.remove('selected');
    });
}

window.closeAssignPatientModal = function() {
    assignPatientModal.close();
    document.body.classList.remove('modal-open');
}

window.clearPatientSearch = function() {
    patientSearch.value = '';
    clearSearchBtn.classList.remove('show');
    searchResults.innerHTML = `
        <div class="no-results">
            <i class="fas fa-search"></i>
            <p>Bemor qidirish uchun ism yoki familiya kiriting</p>
        </div>
    `;
    patientSearch.focus();
}

// ==================== MUHIM: Search functionality ====================
patientSearch.addEventListener('input', function() {
    const query = this.value.trim();
    
    // Clear button ni ko'rsatish/yashirish
    if (query.length > 0) {
        clearSearchBtn.classList.add('show');
    } else {
        clearSearchBtn.classList.remove('show');
        // Agar input bo'sh bo'lsa, default holatga qaytish
        searchResults.innerHTML = `
            <div class="no-results">
                <i class="fas fa-search"></i>
                <p>Bemor qidirish uchun ism yoki familiya kiriting</p>
            </div>
        `;
        return;
    }
    
    // Agar 2 harfdan kam bo'lsa
    if (query.length < 2) {
        searchResults.innerHTML = `
            <div class="no-results">
                <i class="fas fa-info-circle"></i>
                <p>Kamida 2 ta harf kiriting</p>
            </div>
        `;
        return;
    }
    
    // Debounce - 300ms kuting
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        searchHospitalizations(query);
    }, 300);
});

// ==================== MUHIM: searchHospitalizations funksiyasi ====================
function searchHospitalizations(query) {
    console.log('Searching for:', query);
    console.log('Hospitalizations data:', window.hospitalizationsData);
    
    // Tekshirish: ma'lumotlar mavjudmi?
    if (!window.hospitalizationsData || window.hospitalizationsData.length === 0) {
        console.warn('No hospitalizations data found!');
        searchResults.innerHTML = `
            <div class="no-results">
                <i class="fas fa-exclamation-circle"></i>
                <p>Navbatdagi bemorlar mavjud emas</p>
            </div>
        `;
        return;
    }
    
    searchResults.innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Qidirilmoqda...</p>
        </div>
    `;
    
    const queryLower = query.toLowerCase();
    
    // Filter hospitalizations data
    const filtered = window.hospitalizationsData.filter(h => {
        const patientName = (h.patient_name || '').toLowerCase();
        const phone = (h.patient_phone || '').toLowerCase();
        const doctorName = (h.doctor_name || '').toLowerCase();
        const departmentName = (h.department_name || '').toLowerCase();
        
        return patientName.includes(queryLower) || 
            phone.includes(queryLower) ||
            doctorName.includes(queryLower) ||
            departmentName.includes(queryLower);
    });
    
    console.log('Filtered results:', filtered.length);
    
    displaySearchResults(filtered);
}

// ==================== MUHIM: displaySearchResults funksiyasi ====================
function displaySearchResults(results) {
    if (!results || results.length === 0) {
        searchResults.innerHTML = `
            <div class="no-results">
                <i class="fas fa-user-slash"></i>
                <p>Bemor topilmadi</p>
                <p style="font-size: 12px; color: #999; margin-top: 5px;">
                    <i class="fas fa-info-circle"></i> 
                    Bemor ismi, familiyasi, telefon raqami, shifokor yoki bo'lim bo'yicha qidiring
                </p>
            </div>
        `;
        return;
    }
    
    let html = '';
    results.forEach(h => {
        const fullName = h.patient_name || 'Noma\'lum';
        // Initials - ismning birinchi harflari
        const nameParts = fullName.split(' ');
        let initials = '';
        if (nameParts.length >= 2) {
            initials = nameParts[0].charAt(0) + nameParts[1].charAt(0);
        } else if (nameParts.length === 1) {
            initials = nameParts[0].charAt(0);
        } else {
            initials = 'B';
        }
        initials = initials.toUpperCase().substring(0, 2);
        
        html += `
            <div class="search-result-item" onclick="selectHospitalization(
                '${h.id}', 
                '${fullName.replace(/'/g, "\\'")}', 
                '${(h.patient_phone || '').replace(/'/g, "\\'")}', 
                '${(h.doctor_name || '').replace(/'/g, "\\'")}', 
                '${(h.department_name || '').replace(/'/g, "\\'")}'
            )">
                <div class="result-avatar">
                    ${initials}
                </div>
                <div class="result-info">
                    <div class="result-name">${fullName}</div>
                    <div class="result-details">
                        <span><i class="fas fa-phone"></i> ${h.patient_phone || 'Tel mavjud emas'}</span>
                        <span><i class="fas fa-user-md"></i> ${h.doctor_name || 'Shifokor belgilanmagan'}</span>
                        <span><i class="fas fa-building"></i> ${h.department_name || 'Bo\'lim belgilanmagan'}</span>
                    </div>
                </div>
            </div>
        `;
    });
    
    searchResults.innerHTML = html;
}

// ==================== selectHospitalization funksiyasi ====================
window.selectHospitalization = function(id, name, phone, doctorName, departmentName) {
    console.log('Selected patient:', { id, name, phone, doctorName, departmentName });
    
    selectedHospitalizationId.value = id;
    selectedPatient = { id, name, phone, doctorName, departmentName };
    
    // Update selected patient display
    selectedPatientName.textContent = name;
    selectedPatientMeta.innerHTML = `
        <span><i class="fas fa-phone"></i> ${phone || 'Tel mavjud emas'}</span>
        <span><i class="fas fa-user-md"></i> ${doctorName || 'Shifokor belgilanmagan'}</span>
        <span><i class="fas fa-building"></i> ${departmentName || 'Bo\'lim belgilanmagan'}</span>
    `;
    
    const initials = name.split(' ').map(n => n.charAt(0)).join('').substring(0, 2).toUpperCase();
    selectedPatientAvatar.textContent = initials || 'B';
    
    selectedPatientContainer.style.display = 'block';
    
    // Clear search results
    searchResults.innerHTML = `
        <div class="no-results" style="background: #e8f5e9; border-color: #4caf50;">
            <i class="fas fa-check-circle" style="color: #4caf50;"></i>
            <p style="color: #2e7d32;">Bemor tanlandi: ${name}</p>
        </div>
    `;
    
    // Enable confirm button if bed is selected
    if (selectedBedId.value) {
        confirmBtn.disabled = false;
    }
}

function loadAvailableBeds(roomId) {
    // Find room by ID in rooms collection
    const room = roomsData.find(r => r.id == roomId);
    
    if (!room || !room.room_beds) {
        bedsContainer.innerHTML = '<p class="no-results">O\'rinlar mavjud emas</p>';
        return;
    }
    
    const availableBeds = room.room_beds.filter(bed => bed.status !== 'occupied');
    
    if (availableBeds.length === 0) {
        bedsContainer.innerHTML = '<p class="no-results">Bu xonada bo\'sh o\'rin mavjud emas</p>';
        return;
    }
    
    let html = '';
    availableBeds.forEach(bed => {
        html += `
            <div class="bed-item" onclick="selectBed(${bed.id})">
                <div class="bed-number">${bed.number || 'O\'rin'}</div>
                <div class="bed-status available">Bo'sh</div>
            </div>
        `;
    });
    
    bedsContainer.innerHTML = html;
}

window.selectBed = function(bedId) {
    selectedBedId.value = bedId;
    
    // Remove selected class from all beds
    document.querySelectorAll('.bed-item').forEach(bed => {
        bed.classList.remove('selected');
    });
    
    // Add selected class to clicked bed
    event.currentTarget.classList.add('selected');
    
    // Enable confirm button if patient is selected
    if (selectedHospitalizationId.value) {
        confirmBtn.disabled = false;
    }
}

// ==================== ALERT NOTIFICATION (AUTO-HOPE YO'Q) ====================
function showAlert(message, type = 'success') {
    const alert = document.getElementById('alertNotification');
    const icon = document.getElementById('alertIcon');
    const messageEl = document.getElementById('alertMessage');
    
    // Eski session alertlarni o'chirish
    const existingAlerts = document.querySelectorAll('#sessionAlert');
    existingAlerts.forEach(el => el.remove());
    
    // Remove previous classes
    alert.classList.remove('alert-success', 'alert-error', 'alert-warning', 'alert-info', 'show');
    
    // Add new class
    alert.classList.add(`alert-${type}`);
    
    // Set icon based on type
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
    
    // Set message
    messageEl.textContent = message;
    
    // Show alert
    alert.style.display = 'flex';
    
    // Trigger animation
    setTimeout(() => {
        alert.classList.add('show');
    }, 10);
    
    // 🚫 AUTO HOPE BUTUNLAY O'CHIRILDI - alert faqat yopish tugmasi yoki ESC bilan yopiladi
}

function hideAlert() {
    const alert = document.getElementById('alertNotification');
    
    if (alert) {
        alert.classList.remove('show');
        
        // Hide after animation
        setTimeout(() => {
            alert.style.display = 'none';
        }, 300);
    }
}

// 🚫 SESSION ALERTNI AVTOMATIK YOPISH O'CHIRILDI
document.addEventListener('DOMContentLoaded', function() {
    const sessionAlert = document.getElementById('sessionAlert');
    if (sessionAlert) {
        // Hech narsa qilmaymiz - alert ochiq qoladi
        console.log('Session alert ko\'rsatilmoqda');
    }
});

// Click outside to close (agar kerak bo'lsa)
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

// ==================== ASSIGN PATIENT FORM SUBMIT ====================
document.getElementById('assignPatientForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!selectedHospitalizationId.value || !selectedBedId.value || !admissionDate.value) {
        showAlert('Iltimos, barcha maydonlarni to\'ldiring', 'warning');
        return;
    }
    
    const roomId = selectedRoomId.value;
    
    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Joylashtirilmoqda...';
    
    const formData = {
        hospitalization_id: selectedHospitalizationId.value,
        admission_date: admissionDate.value,
        bed_id: selectedBedId.value
    };
    
    fetch(`/rooms/${roomId}/assign-patient`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Muvaffaqiyatli bo'lsa
            showAlert(data.message, 'success');
            
            // Xona statusini yangilash
            updateRoomStatusAfterAssign(roomId, data);
            
            closeAssignPatientModal();
            
            // 🚫 RELOAD O'CHIRILDI - alert ochiq qoladi
            // location.reload();
        } else {
            // Xatolik bo'lganda
            const errorMessage = data.message || 'Xatolik yuz berdi';
            closeAssignPatientModal();
            showAlert(errorMessage, 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        closeAssignPatientModal();
        showAlert('Xatolik: ' + error.message, 'error');
    })
    .finally(() => {
        confirmBtn.innerHTML = '<i class="fas fa-check"></i> Joylashtirish';
        confirmBtn.disabled = false;
    });
});

// ==================== DISCHARGE PATIENT FUNCTIONS ====================
window.dischargePatient = function(roomId, bedId, hospitalizationId) {
    if (!confirm('Bemorni bo\'shatishni tasdiqlaysizmi?')) {
        return;
    }
    
    const dischargeBtn = event?.currentTarget;
    if (dischargeBtn) {
        dischargeBtn.disabled = true;
        dischargeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    }
    
    fetch(`/rooms/${roomId}/discharge-patient`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            bed_id: bedId,
            hospitalization_id: hospitalizationId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            
            // Discharge modalni yopish (agar ochiq bo'lsa)
            const dischargeModal = document.getElementById('dischargePatientModal');
            if (dischargeModal && dischargeModal.open) {
                dischargeModal.close();
            }
            
            // Xona statusini yangilash
            updateRoomStatusAfterDischarge(roomId, data);
            
            // 🚫 RELOAD O'CHIRILDI - alert ochiq qoladi
            // location.reload();
        } else {
            showAlert(data.message || 'Xatolik yuz berdi', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Xatolik: ' + error.message, 'error');
    })
    .finally(() => {
        if (dischargeBtn) {
            dischargeBtn.disabled = false;
            dischargeBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Bo\'shatish';
        }
    });
};

// Xona statusini yangilash funksiyasi (assign uchun)
function updateRoomStatusAfterAssign(roomId, data) {
    // Xona cardini topish
    const roomCard = document.querySelector(`.room-card[data-room-id="${roomId}"]`);
    if (!roomCard) return;
    
    // Xona statusini yangilash
    const roomStatus = roomCard.querySelector('.room-status .badge');
    const roomCardLeftBadge = roomCard.querySelector('.room-card-left .badge');
    const actionButtons = roomCard.querySelector('.action-buttons');
    const bedOccupancy = roomCard.querySelector('.detail-item:last-child .detail-value');
    
    // Statusni yangilash (full yoki available bo'lishi mumkin)
    const newStatus = data.room_status || 'available';
    
    // Badgelarni yangilash
    if (roomStatus) {
        roomStatus.className = 'badge';
        if (newStatus === 'full') {
            roomStatus.classList.add('bg-warning');
            roomStatus.textContent = 'To\'liq';
        } else {
            roomStatus.classList.add('bg-success');
            roomStatus.textContent = 'Mavjud';
        }
    }
    
    // Chap badge ni yangilash (mobil versiya uchun)
    if (roomCardLeftBadge) {
        roomCardLeftBadge.className = 'badge';
        if (newStatus === 'full') {
            roomCardLeftBadge.classList.add('bg-warning');
            roomCardLeftBadge.textContent = 'To\'liq';
        } else {
            roomCardLeftBadge.classList.add('bg-success');
            roomCardLeftBadge.textContent = 'Bo\'sh';
        }
    }
    
    // Bed occupancy ni yangilash
    if (bedOccupancy) {
        const current = bedOccupancy.textContent.split('/');
        if (current.length === 2) {
            const newOccupied = parseInt(current[0]) + 1;
            bedOccupancy.textContent = `${newOccupied}/${current[1]}`;
        }
    }
    
    // Action tugmalarini yangilash
    updateActionButtons(roomCard, roomId, newStatus, data);
}

// Bo'shatishdan keyin xona statusini yangilash
function updateRoomStatusAfterDischarge(roomId, data) {
    const roomCard = document.querySelector(`.room-card[data-room-id="${roomId}"]`);
    if (!roomCard) return;
    
    const newStatus = data.room_status || 'available';
    
    // data-status atributini yangilash
    roomCard.dataset.status = newStatus;
    
    // Badgelarni yangilash
    const roomStatus = roomCard.querySelector('.room-status .badge');
    const roomCardLeftBadge = roomCard.querySelector('.room-card-left .badge');
    
    if (roomStatus) {
        roomStatus.className = 'badge';
        if (newStatus === 'empty') {
            roomStatus.classList.add('bg-secondary');
            roomStatus.textContent = 'Hona bo\'sh';
        } else if (newStatus === 'available') {
            roomStatus.classList.add('bg-success');
            roomStatus.textContent = 'Mavjud';
        } else if (newStatus === 'full') {
            roomStatus.classList.add('bg-warning');
            roomStatus.textContent = 'To\'liq';
        }
    }
    
    if (roomCardLeftBadge) {
        roomCardLeftBadge.className = 'badge';
        if (newStatus === 'empty') {
            roomCardLeftBadge.classList.add('bg-secondary');
            roomCardLeftBadge.textContent = 'Empty';
        } else if (newStatus === 'available') {
            roomCardLeftBadge.classList.add('bg-success');
            roomCardLeftBadge.textContent = 'Bo\'sh';
        } else if (newStatus === 'full') {
            roomCardLeftBadge.classList.add('bg-warning');
            roomCardLeftBadge.textContent = 'To\'liq';
        }
    }
    
    // Action tugmalarini yangilash
    const roomNumber = roomCard.querySelector('.room-number')?.textContent.trim() || '';
    updateActionButtons(roomCard, roomId, newStatus, { bed_id: null, hospitalization_id: null });
}

// ==================== MUHIM: Action tugmalarini yangilash ====================
function updateActionButtons(roomCard, roomId, status, data = {}) {
    const actionButtons = roomCard.querySelector('.action-buttons');
    if (!actionButtons) return;
    
    const roomNumber = roomCard.querySelector('.room-number')?.textContent.trim() || '';
    
    // Eski tugmalarni olib tashlash
    actionButtons.innerHTML = '';
    
    // View va Edit tugmalari (hamma holatda bo'ladi)
    let buttons = `
        <a href="/rooms/${roomId}"><button class="btn-icon"><i class="fas fa-eye"></i></button></a>
        <a href="/rooms/${roomId}/edit"><button class="btn-icon"><i class="fas fa-edit"></i></button></a>
    `;
    
    // Statusga mos qo'shimcha tugmalar
    if (status === 'empty') {
        buttons += `
            <button class="action-btn success assign-patient-btn" data-room-id="${roomId}" data-room-number="${roomNumber}">
                <i class="fas fa-user-plus"></i> <span>Bemor</span>
            </button>
        `;
    } else if (status === 'available') {
        buttons += `
            <button class="action-btn success assign-patient-btn" data-room-id="${roomId}" data-room-number="${roomNumber}">
                <i class="fas fa-user-plus"></i> <span>Bemor</span>
            </button>
        `;
    } else if (status === 'full') {
        buttons += `
            <button class="action-btn warning discharge-room-btn" data-room-id="${roomId}" data-room-number="${roomNumber}">
                <i class="fas fa-sign-out-alt"></i> <span>Bo'shatish</span>
            </button>
        `;
    } else if (status === 'maintenance') {
        buttons += `
            <button class="action-btn danger complete-maintenance-btn" 
                    data-room-id="${roomId}" 
                    data-room-number="${roomNumber}"
                    onclick="openCompleteMaintenanceModal('${roomId}', '${roomNumber}')">
                <i class="fas fa-check"></i> <span>Tamomlash</span>
            </button>
        `;
    }
    
    actionButtons.innerHTML = buttons;
    
    // Yangi tugmalarni bog'lash
    bindAllButtons();
}

// ==================== MUHIM: Barcha tugmalarni bog'lash ====================
function bindAllButtons() {
    // Assign tugmalarini bog'lash
    bindAssignButtons();
    
    // Discharge tugmalarini bog'lash
    bindDischargeButtons();
    
    // Complete maintenance tugmalarini bog'lash
    bindCompleteMaintenanceButtons();
}

// Yangi qo'shilgan assign tugmalarini bog'lash
function bindAssignButtons() {
    document.querySelectorAll('.assign-patient-btn').forEach(btn => {
        // Eski event listenerlarni olib tashlash
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        
        newBtn.addEventListener('click', function() {
            const roomId = this.dataset.roomId;
            const roomNumber = this.dataset.roomNumber;
            openAssignPatientModal(roomId, roomNumber);
        });
    });
}

// Discharge tugmalarini bog'lash
function bindDischargeButtons() {
    document.querySelectorAll('.discharge-room-btn').forEach(btn => {
        // Eski event listenerlarni olib tashlash
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        
        newBtn.addEventListener('click', function() {
            const card = this.closest('.room-card');
            if (!card) return;
            
            const roomId = card.dataset.roomId;
            const roomNumber = card.querySelector('.room-number')?.textContent.trim() || '';
            
            // patients ma'lumotlarini olish
            const patients = [];
            const patientElements = card.querySelectorAll('.patient-info');
            patientElements.forEach(el => {
                // Bu yerda patients ma'lumotlarini yig'ish logikasi
                // Sizning mavjud kodingizga qarab
            });
            
            if (window.openDischargePatientModal) {
                openDischargePatientModal(roomId, roomNumber, patients);
            }
        });
    });
}

// ==================== MUHIM: Complete maintenance tugmalarini bog'lash ====================
function bindCompleteMaintenanceButtons() {
    // .complete-maintenance-btn classiga ega tugmalarni topish
    document.querySelectorAll('.complete-maintenance-btn').forEach(btn => {
        // Eski event listenerlarni olib tashlash
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        
        newBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const roomId = this.dataset.roomId;
            const roomNumber = this.dataset.roomNumber;
            
            console.log('Maintenance button clicked:', roomId, roomNumber);
            
            if (typeof window.openCompleteMaintenanceModal === 'function') {
                window.openCompleteMaintenanceModal(roomId, roomNumber);
            } else {
                console.error('openCompleteMaintenanceModal funksiyasi topilmadi');
                alert('Xatolik: openCompleteMaintenanceModal funksiyasi topilmadi');
            }
        });
    });
}

// ==================== WAITING PATIENTS MODAL ====================
const waitingPatientsModal = document.getElementById('waitingPatientsModal');
const waitingResults = document.getElementById('waitingResults').getElementsByTagName('tbody')[0];
const waitingCount = document.getElementById('waitingCount');
const waitingSearch = document.getElementById('waitingSearch');
const waitingClearSearch = document.getElementById('waitingClearSearch');

let formattedHospitalizations = window.hospitalizationsData || [];
let scrollPosition = 0;

function disableScroll() {
    scrollPosition = window.scrollY;
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.top = `-${scrollPosition}px`;
    document.body.style.width = '100%';
}

function enableScroll() {
    document.body.style.overflow = '';
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width = '';
    window.scrollTo(0, scrollPosition);
}

window.openWaitingPatientsModal = function(count) {
    waitingCount.textContent = count;
    
    // Scrollni o'chirish
    disableScroll();
    
    // Modalni ochish
    waitingPatientsModal.showModal();
    document.body.classList.add('modal-open');
    
    // Ma'lumotlarni ko'rsatish
    formattedHospitalizations = window.hospitalizationsData || [];
    displayWaitingPatients(formattedHospitalizations);
    
    // Inputga fokuslanmaslik - MUHIM!
    // waitingSearch.focus(); -- BU QATORNI O'CHIRING
}

window.closeWaitingPatientsModal = function() {
    waitingPatientsModal.close();
    document.body.classList.remove('modal-open');
    
    // Scrollni qayta yoqish
    enableScroll();
    
    waitingSearch.value = '';
    waitingClearSearch.classList.remove('show');
}

window.refreshWaitingPatients = function() {
    formattedHospitalizations = window.hospitalizationsData || [];
    displayWaitingPatients(formattedHospitalizations);
    waitingSearch.value = '';
    waitingClearSearch.classList.remove('show');
}

window.clearWaitingSearch = function() {
    waitingSearch.value = '';
    waitingClearSearch.classList.remove('show');
    displayWaitingPatients(formattedHospitalizations);
    // waitingSearch.focus(); -- BU QATORNI HAM O'CHIRING
}

// Qidiruv inputiga faqat foydalanuvchi bosganda ishlaydi
waitingSearch.addEventListener('input', function() {
    const query = this.value.trim().toLowerCase();
    
    if (query.length > 0) {
        waitingClearSearch.classList.add('show');
    } else {
        waitingClearSearch.classList.remove('show');
    }
    
    if (query.length === 0) {
        displayWaitingPatients(formattedHospitalizations);
        return;
    }
    
    const filtered = formattedHospitalizations.filter(h => {
        const fullName = (h.patient_name || '').toLowerCase();
        const phone = (h.patient_phone || '').toLowerCase();
        const doctorName = (h.doctor_name || '').toLowerCase();
        const departmentName = (h.department_name || '').toLowerCase();
        
        return fullName.includes(query) || 
            phone.includes(query) || 
            doctorName.includes(query) || 
            departmentName.includes(query);
    });
    
    displayWaitingPatients(filtered);
});

function displayWaitingPatients(patients) {
    if (!patients || patients.length === 0) {
        waitingResults.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    <p style="color: #718096; font-size: 12px; margin: 0;">Bemor topilmadi</p>
                </td>
            </tr>
        `;
        return;
    }
    
    let html = '';
    patients.forEach(patient => {
        let priorityClass = 'priority-medium';
        const priority = String(patient.priority || '').toLowerCase();
        
        if (priority === 'high' || priority === 'yuqori') {
            priorityClass = 'priority-high';
        } else if (priority === 'low' || priority === 'past') {
            priorityClass = 'priority-low';
        }
        
        const nameParts = (patient.patient_name || 'Noma\'lum').split(' ');
        const lastName = nameParts[0] || '';
        const firstName = nameParts[1] || '';
        const middleName = nameParts[2] || '';
        
        const fullName = patient.patient_name || 'Noma\'lum';
        const shortName = lastName + ' ' + (firstName ? firstName.charAt(0) + '.' : '') + (middleName ? ' ' + middleName.charAt(0) + '.' : '');
        
        html += `
            <tr>
                <td>
                    <div class="patient-name-large">${fullName}</div>
                    <div class="patient-name-small">${shortName}</div>
                    <div class="phone-cell"><i class="fas fa-phone" style="font-size: 8px; margin-right: 2px;"></i> ${patient.patient_phone || 'Tel mavjud emas'}</div>
                </td>
                <td class="desktop-only">${patient.doctor_name || ''}</td>
                <td>${patient.department_name || ''}</td>
                <td>
                    <span class="priority-badge ${priorityClass}">
                        ${patient.priority || 'Normal'}
                    </span>
                </td>
                <td class="desktop-only">
                    ${patient.waiting_since || ''}
                    <div class="waiting-time"><i class="far fa-clock" style="margin-right: 2px;"></i> ${patient.created_at || ''}</div>
                </td>
            </tr>
        `;
    });
    
    waitingResults.innerHTML = html;
}

// ==================== TOGGLE FEATURES ====================
window.toggleFeatures = function(button) {
    const featuresList = button.nextElementSibling;
    if (featuresList && featuresList.classList.contains('features-list')) {
        const isOpen = featuresList.classList.contains('show');
        document.querySelectorAll('.features-list.show').forEach(list => {
            list.classList.remove('show');
        });
        if (!isOpen) {
            featuresList.classList.add('show');
        }
    }
};

document.addEventListener('click', function(e) {
    if (!e.target.closest('.feature-btn')) {
        document.querySelectorAll('.features-list.show').forEach(list => {
            list.classList.remove('show');
        });
    }
});

// ==================== FILTER ====================
document.getElementById('applyFilters')?.addEventListener('click', function() {
    const floor = document.getElementById('floorFilter').value;
    const status = document.getElementById('statusFilter').value;
    const department = document.getElementById('departmentFilter').value;

    document.querySelectorAll('.room-card').forEach(room => {
        const matchFloor = !floor || room.dataset.floor == floor;
        const matchStatus = !status || room.dataset.status == status;
        const matchDepartment = !department || room.dataset.department == department;
        room.style.display = (matchFloor && matchStatus && matchDepartment) ? 'flex' : 'none';
    });
});

// ==================== MODAL CLOSE ON BACKDROP CLICK ====================
assignPatientModal.addEventListener('click', function(e) {
    const rect = this.getBoundingClientRect();
    const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                    rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
    if (!isInDialog) {
        closeAssignPatientModal();
    }
});

waitingPatientsModal.addEventListener('click', function(e) {
    const rect = this.getBoundingClientRect();
    const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                    rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
    if (!isInDialog) {
        closeWaitingPatientsModal();
    }
});

// ==================== CLOSE ON ESCAPE KEY ====================
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (assignPatientModal.open) {
            closeAssignPatientModal();
        }
        if (waitingPatientsModal.open) {
            closeWaitingPatientsModal();  // Bu funksiya scrollni qayta yoqadi
        }
        if (document.getElementById('completeMaintenanceModal')?.open) {
            closeCompleteMaintenanceModal();
        }
        if (document.getElementById('dischargePatientModal')?.open) {
            closeDischargePatientModal();
        }
        // Alertni ham ESC bilan yopish
        hideAlert();
    }
});

// ==================== PREVENT BODY SCROLL ====================
window.addEventListener('scroll', function() {
    if (assignPatientModal.open || waitingPatientsModal.open) {
        window.scrollTo(0, 0);
    }
});

// ==================== DISCHARGE MODAL FUNCTIONS ====================
window.openDischargePatientModal = function(roomId, roomNumber, patients) {
    const modal = document.getElementById('dischargePatientModal');
    if (!modal) return;
    
    document.getElementById('dischargeRoomId').value = roomId;
    document.getElementById('dischargeRoomNumber').textContent = roomNumber;
    
    const patientsList = document.getElementById('dischargePatientsList');
    
    if (!patients || patients.length === 0) {
        patientsList.innerHTML = '<p class="no-results">Bu xonada bemorlar mavjud emas</p>';
        return;
    }
    
    let html = '';
    patients.forEach(patient => {
        const patientName = patient.patient ? 
            (patient.patient.last_name + ' ' + patient.patient.name + ' ' + (patient.patient.middle_name || '')) : 
            'Noma\'lum';
        
        const doctorName = patient.doctor ? 
            (patient.doctor.last_name + ' ' + patient.doctor.name.charAt(0) + '.') : 
            'Shifokor yo\'q';
        
        html += `
            <div class="patient-item" onclick="selectDischargePatient(${patient.bed_id}, ${patient.hospitalization_id}, '${patientName.replace(/'/g, "\\'")}')">
                <div class="patient-item-info">
                    <div class="patient-item-name">${patientName}</div>
                    <div class="patient-item-details">
                        <span><i class="fas fa-user-md"></i> ${doctorName}</span>
                        <span><i class="fas fa-bed"></i> O'rin ${patient.bed_number}</span>
                    </div>
                </div>
            </div>
        `;
    });
    
    patientsList.innerHTML = html;
    
    // Scrollni o'chirish
    disableScroll();
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

window.closeDischargePatientModal = function() {
    const modal = document.getElementById('dischargePatientModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
        
        // Scrollni qayta yoqish
        enableScroll();
    }
}

window.selectDischargePatient = function(bedId, hospitalizationId, patientName) {
    document.getElementById('dischargeBedId').value = bedId;
    document.getElementById('dischargeHospitalizationId').value = hospitalizationId;
    document.getElementById('selectedDischargePatient').textContent = patientName;
    document.getElementById('selectedDischargeInfo').style.display = 'block';
}

window.confirmDischarge = function() {
    const roomId = document.getElementById('dischargeRoomId').value;
    const bedId = document.getElementById('dischargeBedId').value;
    const hospitalizationId = document.getElementById('dischargeHospitalizationId').value;
    
    if (!bedId || !hospitalizationId) {
        showAlert('Iltimos, bemorni tanlang', 'warning');
        return;
    }
    
    dischargePatient(roomId, bedId, hospitalizationId);
}

// ==================== COMPLETE MAINTENANCE MODAL ====================
// Complete maintenance modalni ochish uchun global funksiya
window.openCompleteMaintenanceModal = function(roomId, roomNumber) {
    console.log('🔵 Opening complete maintenance modal:', roomId, roomNumber);
    
    const modal = document.getElementById('completeMaintenanceModal');
    const roomIdInput = document.getElementById('maintenanceRoomId');
    const modalRoomSpan = document.getElementById('modalMaintenanceRoomNumber');
    
    if (modal && roomIdInput && modalRoomSpan) {
        roomIdInput.value = roomId;
        modalRoomSpan.textContent = roomNumber;
        
        // Scrollni o'chirish
        disableScroll();
        
        modal.showModal();
        document.body.classList.add('modal-open');
    } else {
        console.error('Modal elementlari topilmadi:', {
            modal: !!modal,
            roomIdInput: !!roomIdInput,
            modalRoomSpan: !!modalRoomSpan
        });
    }
};

// ==================== COMPLETE MAINTENANCE MODAL EVENTLARI ====================
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('completeMaintenanceModal');
    if (!modal) {
        console.error('completeMaintenanceModal topilmadi');
        return;
    }

    // Close funksiyasini global qilish
    window.closeCompleteMaintenanceModal = function() {
        if (modal) {
            modal.close();
            document.body.classList.remove('modal-open');
            // Scrollni qayta yoqish
            enableScroll();
        }
    };

    // Backdrop bosilganda yopish
    modal.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const isInDialog = (
            rect.top <= e.clientY && 
            e.clientY <= rect.top + rect.height &&
            rect.left <= e.clientX && 
            e.clientX <= rect.left + rect.width
        );
        
        if (!isInDialog) {
            closeCompleteMaintenanceModal();
        }
    });

    // Form submit
    const form = document.getElementById('completeMaintenanceForm');
    const submitBtn = document.getElementById('confirmCompleteMaintenance');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const roomId = document.getElementById('maintenanceRoomId').value;
            
            if (!roomId) {
                alert('Xona ID topilmadi');
                return;
            }
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yuklanmoqda...';
            }

            // Bugungi sana
            const today = new Date().toISOString().split('T')[0];
            
            const formData = {
                completion_date: today,
                notes: 'Ta\'mir tamomlandi'
            };
            
            console.log('📤 Sending complete maintenance data:', formData);
            
            // API ga so'rov yuborish
            fetch(`/rooms/${roomId}/complete-maintenance`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Server xatolik (${response.status}): ${text.substring(0, 200)}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Server response:', data);
                
                // MODALNI YOPISH
                closeCompleteMaintenanceModal();
                
                if (data.success) {
                    // ALERT CHIQARISH
                    if (window.showAlert) {
                        showAlert(data.message, 'success');
                    }
                    
                    // Xona statusini yangilash
                    setTimeout(() => {
                        updateRoomStatusAfterMaintenance(roomId, data.room_status);
                    }, 100);
                } else {
                    if (window.showAlert) {
                        showAlert(data.message || 'Xatolik yuz berdi', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                
                closeCompleteMaintenanceModal();
                
                if (window.showAlert) {
                    showAlert('Xatolik yuz berdi: ' + error.message, 'error');
                }
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-check"></i> Tamomlash';
                }
            });
        });
    }
});

// Xona statusini yangilash funksiyasi (maintenance uchun)
window.updateRoomStatusAfterMaintenance = function(roomId, newStatus) {
    console.log('🔄 Updating room:', roomId, 'to status:', newStatus);
    
    const card = document.querySelector(`.room-card[data-room-id="${roomId}"]`);
    if (!card) {
        console.error('Room card not found:', roomId);
        return;
    }
    
    // data-status atributini yangilash
    card.dataset.status = newStatus;
    
    // Statusga mos class va matnlarni belgilash
    let badgeClass = '';
    let badgeText = '';
    let leftBadgeText = '';
    
    if (newStatus === 'empty') {
        badgeClass = 'bg-secondary';
        badgeText = 'Hona bo\'sh';
        leftBadgeText = 'Empty';
    } else if (newStatus === 'available') {
        badgeClass = 'bg-success';
        badgeText = 'Mavjud';
        leftBadgeText = 'Bo\'sh';
    } else if (newStatus === 'full') {
        badgeClass = 'bg-warning';
        badgeText = 'To\'liq';
        leftBadgeText = 'To\'liq';
    }
    
    // 1. Chap tarafdagi badgeni yangilash
    const leftBadge = card.querySelector('.room-card-left .badge');
    if (leftBadge) {
        leftBadge.className = 'badge';
        leftBadge.classList.remove('bg-secondary', 'bg-success', 'bg-warning', 'bg-danger');
        leftBadge.classList.add(...badgeClass.split(' '));
        leftBadge.textContent = leftBadgeText;
    }
    
    // 2. O'ng tarafdagi status badgeni yangilash
    const rightBadge = card.querySelector('.room-status .badge');
    if (rightBadge) {
        rightBadge.className = 'badge';
        rightBadge.classList.remove('bg-secondary', 'bg-success', 'bg-warning', 'bg-danger');
        rightBadge.classList.add(...badgeClass.split(' '));
        rightBadge.textContent = badgeText;
    }
    
    // 3. Maintenance info ni o'chirish (agar bor bo'lsa)
    const maintenanceInfo = card.querySelector('.maintenance-info');
    if (maintenanceInfo) {
        maintenanceInfo.remove();
    }
    
    // 4. Action tugmalarni yangilash
    updateActionButtons(card, roomId, newStatus);
    
    console.log('✅ Room updated successfully');
};

// DOM yuklanganda barcha tugmalarni bog'lash
document.addEventListener('DOMContentLoaded', function() {
    // Barcha tugmalarni bog'lash
    bindAllButtons();
});

// Discharge modal backdrop click
document.addEventListener('DOMContentLoaded', function() {
    const dischargeModal = document.getElementById('dischargePatientModal');
    if (dischargeModal) {
        dischargeModal.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                            rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
            if (!isInDialog) {
                closeDischargePatientModal();
            }
        });
    }
});

// Filter panel boshqaruvi
const filterToggleBtn = document.getElementById('filterToggleBtn');
const filterPanel = document.getElementById('filterPanel');
const filterOverlay = document.getElementById('filterOverlay');
const filterCloseBtn = document.getElementById('filterCloseBtn');
const filterCount = document.getElementById('filterCount');
const searchInput = document.getElementById('searchInput');
const clearSearch = document.getElementById('clearSearch');
const statusRadios = document.querySelectorAll('input[name="status"]');
const departmentSelect = document.getElementById('departmentSelect');
const floorSelect = document.getElementById('floorSelect');

function countActiveFilters() {
    let count = 0;
    if (searchInput && searchInput.value) count++;
    const selectedStatus = document.querySelector('input[name="status"]:checked');
    if (selectedStatus && selectedStatus.value !== 'all') count++;
    if (departmentSelect && departmentSelect.value !== 'all') count++;
    if (floorSelect && floorSelect.value !== 'all') count++;
    return count;
}

function updateFilterCount() {
    const count = countActiveFilters();
    if (filterCount) {
        filterCount.textContent = count;
        filterCount.style.display = count > 0 ? 'inline-block' : 'none';
    }
}

function openFilterPanel() {
    if (filterPanel) filterPanel.classList.add('open');
    if (filterOverlay) filterOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    if (filterToggleBtn) filterToggleBtn.classList.add('active');
}

function closeFilterPanel() {
    if (filterPanel) filterPanel.classList.remove('open');
    if (filterOverlay) filterOverlay.classList.remove('active');
    document.body.style.overflow = '';
    if (filterToggleBtn) filterToggleBtn.classList.remove('active');
}

if (filterToggleBtn) filterToggleBtn.addEventListener('click', openFilterPanel);
if (filterCloseBtn) filterCloseBtn.addEventListener('click', closeFilterPanel);
if (filterOverlay) filterOverlay.addEventListener('click', closeFilterPanel);

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && filterPanel && filterPanel.classList.contains('open')) {
        closeFilterPanel();
    }
});

if (clearSearch) {
    clearSearch.addEventListener('click', function() {
        if (searchInput) {
            searchInput.value = '';
            this.style.display = 'none';
            updateFilterCount();
        }
    });
}

if (searchInput) {
    searchInput.addEventListener('input', function() {
        if (clearSearch) {
            clearSearch.style.display = this.value ? 'block' : 'none';
        }
        updateFilterCount();
    });
}

statusRadios.forEach(radio => radio.addEventListener('change', updateFilterCount));
if (departmentSelect) departmentSelect.addEventListener('change', updateFilterCount);
if (floorSelect) floorSelect.addEventListener('change', updateFilterCount);

const resetBtn = document.getElementById('resetFilters');
if (resetBtn) {
    resetBtn.addEventListener('click', function() {
        window.location.href = window.location.pathname;
    });
}

updateFilterCount();