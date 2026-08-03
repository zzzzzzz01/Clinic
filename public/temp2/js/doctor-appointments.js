// ==================== DOCTOR APPOINTMENT MODALS ====================
let doctorAppointmentScrollPosition = 0;

// Global o'zgaruvchilar
let currentSlotData = null;
let currentSlotId = null;
let createStep = 1;
let selectedPatient = null;
let currentCreateSlotId = null;
let currentCreateData = null;
let currentSearchType = 'passport';

// ==================== AVAILABLE MODAL (Yangi qabul) ====================
function openAvailableModal(slotId, slotData) {
    const modal = document.getElementById('availableModal');
    if (!modal) return;
    
    currentSlotId = slotId;
    currentSlotData = slotData;
    currentCreateSlotId = slotId;
    currentCreateData = slotData;
    createStep = 1;
    selectedPatient = null;
    
    // Modal ma'lumotlarini to'ldirish
    const formattedDate = slotData.date.split('-').reverse().join('.');

    document.getElementById('availableModalDate').textContent = formattedDate;
    document.getElementById('availableModalTime').textContent =
    slotData.start_time.substring(0, 5) + ' - ' + slotData.end_time.substring(0, 5);
    
    // Formani tozalash
    resetAvailableForm();
    updateStepDisplay();
    
    // Scroll pozitsiyasini saqlash
    doctorAppointmentScrollPosition = window.pageYOffset;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeAvailableModal() {
    const modal = document.getElementById('availableModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
        resetAvailableForm();
    }
}

function updateStepDisplay() {
    // Steplarni yangilash
    for (let i = 1; i <= 3; i++) {
        const stepEl = document.getElementById('step' + i);
        if (stepEl) {
            stepEl.classList.remove('active', 'completed');
            if (i < createStep) stepEl.classList.add('completed');
            if (i === createStep) stepEl.classList.add('active');
        }
    }
    
    // Contentlarni ko'rsatish/yashirish
    document.getElementById('step1Content').style.display = createStep === 1 ? 'block' : 'none';
    document.getElementById('step2Content').style.display = createStep === 2 ? 'block' : 'none';
    document.getElementById('step3Content').style.display = createStep === 3 ? 'block' : 'none';
    
    // Tugmalarni boshqarish
    const backBtn = document.getElementById('backBtn');
    const nextBtn = document.getElementById('nextBtn');
    const saveBtn = document.getElementById('saveBtn');
    
    if (createStep === 1) {
        if (backBtn) backBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'inline-flex';
        if (saveBtn) saveBtn.style.display = 'none';
    } else if (createStep === 2) {
        if (backBtn) backBtn.style.display = 'inline-flex';
        if (nextBtn) nextBtn.style.display = 'inline-flex';
        if (saveBtn) saveBtn.style.display = 'none';
    } else {
        if (backBtn) backBtn.style.display = 'inline-flex';
        if (nextBtn) nextBtn.style.display = 'none';
        if (saveBtn) saveBtn.style.display = 'inline-flex';
    }
}

function nextStep() {
    if (createStep === 1) {
        createStep = 2;
        updateStepDisplay();
        setTimeout(() => {
            if (currentSearchType === 'passport') {
                document.getElementById('passportSeries').focus();
            } else {
                document.getElementById('patientName').focus();
            }
        }, 100);
    } else if (createStep === 2) {
        if (!selectedPatient) {
            showToastMessage('⚠️ Iltimos, avval bemorni tanlang!', 'warning');
            return;
        }
        createStep = 3;
        updateStepDisplay();
        renderSelectedPatientCard();
        setTimeout(() => {
            document.getElementById('reasonText').focus();
        }, 100);
    }
}

function prevStep() {
    if (createStep > 1) {
        createStep--;
        updateStepDisplay();
    }
}

// ==================== BOOKED MODAL (Band qilingan) ====================
function openBookedModal(appoinmentId, appointmentData) {
    const modal = document.getElementById('bookedModal');
    if (!modal) return;
    
    currentAppoinmentId = appoinmentId;
    currentAppointmentData = appointmentData;
    
    // Modal ma'lumotlarini to'ldirish
    document.getElementById('bookedPatientName').textContent = appointmentData.patient?.name || 'Bemor'; 
    document.getElementById('bookedPatientPassport').textContent = appointmentData.patient?.passport || '---';
    document.getElementById('bookedPatientBirthDate').textContent = appointmentData.patient?.birth_date || '---';
    document.getElementById('bookedPatientAge').textContent = appointmentData.patient?.age ? appointmentData.patient.age + ' yosh' : '---';
    document.getElementById('bookedPatientPhone').textContent = appointmentData.patient?.phone || '---';
    document.getElementById('bookedReason').textContent = appointmentData.patient?.reason || 'Ko\'rsatilmagan'; 
    document.getElementById('bookedDuration').textContent = appointmentData.duration ? appointmentData.duration + ' min' : 'Ko\'rsatilmagan'; 
    document.getElementById('bookedSlotTime').textContent = appointmentData.start_time + ' - ' + appointmentData.end_time;
    document.getElementById('bookedSlotDate').textContent = appointmentData.date;
    document.getElementById('bookedCreatedAt').textContent = appointmentData.patient?.created_at || '---';
    
    // Boshlash tugmasi linki
    const startLink = document.getElementById('startConsultationLink');
    if (startLink) {
        startLink.href = '/ajax/doctor/consultation/' + appoinmentId + '?date=' + appointmentData.date;
    }
    
    // Bekor qilish tugmasi eventi
    const cancelBtn = document.getElementById('cancelBookedBtn');
    if (cancelBtn) {
        cancelBtn.onclick = function() {
            cancelBookedAppointment(appoinmentId);
        };
    }
    
    doctorAppointmentScrollPosition = window.pageYOffset;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeBookedModal() {
    const modal = document.getElementById('bookedModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// ==================== COMPLETED MODAL (Tugagan) ====================
function openCompletedModal(slotId, slotData) {
    const modal = document.getElementById('completedModal');
    if (!modal) return;
    
    currentSlotId = slotId;
    currentSlotData = slotData;
    
    // Modal ma'lumotlarini to'ldirish
    document.getElementById('completedPatientName').textContent = slotData.patient?.name || '--';
    document.getElementById('completedPatientPassport').textContent = slotData.patient?.passport || '---';
    document.getElementById('completedPatientBirthDate').textContent = slotData.patient?.birth_date || '---';
    document.getElementById('completedPatientAge').textContent = slotData.patient?.age ? slotData.patient.age + ' yosh' : '---';
    document.getElementById('completedPatientPhone').textContent = slotData.patient?.phone || '---';
    document.getElementById('completedReason').textContent = slotData.patient?.reason || 'Ko\'rsatilmagan';
    document.getElementById('completedSlotTime').textContent = slotData.start_time + ' - ' + slotData.end_time;
    document.getElementById('completedSlotDate').textContent = slotData.date;
    document.getElementById('completedCreatedAt').textContent = slotData.patient?.created_at || '---';
    
    doctorAppointmentScrollPosition = window.pageYOffset;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeCompletedModal() {
    const modal = document.getElementById('completedModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// UPDATE - openAppointmentModal funksiyasini o'zgartiring
function openAppointmentModal(appoinmentId, appointmentData) {
    console.log('Opening modal:', appoinmentId, appointmentData);
    
    if (!appointmentData) {
        showToastMessage('Xatolik: Ma\'lumot topilmadi', 'danger');
        return;
    }
    
    // 🔥 MUHIM: Slotni kartadan yangi ma'lumotlar bilan olish
    const slotCard = document.querySelector('.time-slot-card[data-slot-id="' + appoinmentId + '"]');
    const currentStatus = slotCard ? slotCard.getAttribute('data-status') : appointmentData.status;
    
    // Agar karta statusi parametrdan farq qilsa, yangilangan ma'lumotlardan foydalan
    if (currentStatus && currentStatus !== appointmentData.status) {
        appointmentData.status = currentStatus;
        
        // Agar status 'available' bo'lsa, patient ni null qilish
        if (currentStatus === 'available') {
            appointmentData.patient = null;
        }
        
        // Agar status 'booked' bo'lsa, kartadagi patient ma'lumotlarini olish
        if (currentStatus === 'booked') {
            const patientName = slotCard.querySelector('.patient-info-small strong');
            const patientPhone = slotCard.querySelector('.patient-phone');
            const patientReason = slotCard.querySelector('.patient-reason');
            
            if (patientName) {
                appointmentData.patient = {
                    name: patientName.textContent,
                    phone: patientPhone ? patientPhone.textContent.replace(/[^0-9+]/g, '') : '',
                    reason: patientReason ? patientReason.textContent.replace(/[^a-zA-Zа-яА-Я0-9\s]/g, '') : ''
                };
            }
        }
    }
    
    if (appointmentData.status === 'available') {
        openAvailableModal(appoinmentId, appointmentData);
    } else if (appointmentData.status === 'booked') {
        openBookedModal(appoinmentId, appointmentData);
    } else if (appointmentData.status === 'completed') {
        openCompletedModal(appoinmentId, appointmentData);
    }
}

// ==================== BEMOR QIDIRISH ====================
function switchSearchTab(type) {
    currentSearchType = type;
    
    document.querySelectorAll('.search-tab').forEach(tab => {
        if (tab.getAttribute('data-type') === type) {
            tab.classList.add('active');
        } else {
            tab.classList.remove('active');
        }
    });
    
    document.getElementById('passportSearch').style.display = type === 'passport' ? 'block' : 'none';
    document.getElementById('nameSearch').style.display = type === 'name' ? 'block' : 'none';
    document.getElementById('patientResults').innerHTML = '';
}

function searchPatientsBackend() {
    // Avvalgi xatoliklarni tozalash
    const passportSeriesError = document.getElementById('passportSeriesError');
    const passportNumberError = document.getElementById('passportNumberError');
    const patientNameError = document.getElementById('patientNameError');
    
    if (passportSeriesError) passportSeriesError.innerText = '';
    if (passportNumberError) passportNumberError.innerText = '';
    if (patientNameError) patientNameError.innerText = '';
    
    let searchTerm = '';
    
    if (currentSearchType === 'passport') {
        const series = document.getElementById('passportSeries')?.value || '';
        const number = document.getElementById('passportNumber')?.value || '';
        
        if (!series && !number) {
            if (passportSeriesError) passportSeriesError.innerText = 'Iltimos, pasport seriya yoki raqamni kiriting!';
            if (passportNumberError) passportNumberError.innerText = 'Iltimos, pasport seriya yoki raqamni kiriting!';
            return;
        }
        searchTerm = series + number;
    } else {
        const name = document.getElementById('patientName')?.value.trim() || '';
        
        if (name.length < 2) {
            if (patientNameError) patientNameError.innerText = 'Qidirish uchun kamida 2 ta belgi kiriting';
            return;
        }
        searchTerm = name;
    }
    
    // Qolgan qidiruv kodi o'zgarishsiz
    document.getElementById('searchLoader').style.display = 'block';
    document.getElementById('patientResults').innerHTML = '';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    fetch('/ajax/search-patients?q=' + encodeURIComponent(searchTerm) + '&type=' + currentSearchType, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('searchLoader').style.display = 'none';
        
        if (!data || data.length === 0) {
            document.getElementById('patientResults').innerHTML = `
                <div style="text-align:center; padding:30px;">
                    <i class="fas fa-user-slash fa-2x"></i>
                    <p>❌ ${document.documentElement.lang === 'ru'
                        ? 'Пациент не найден'
                        : document.documentElement.lang === 'en'
                        ? 'No patient found'
                        : 'Hech qanday bemor topilmadi'}
                    </p>
                </div>
            `;
            return;
        }
        
        renderPatientList(data);
    })
    .catch(error => {
        console.error('Search error:', error);
        document.getElementById('searchLoader').style.display = 'none';
        document.getElementById('patientResults').innerHTML = `
            <div style="text-align:center; padding:30px;">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
                <p>❌ ${document.documentElement.lang === 'ru'
                    ? 'Произошла ошибка'
                    : document.documentElement.lang === 'en'
                    ? 'An error occurred'
                    : 'Xatolik yuz berdi'}
                </p>
            </div>
        `;
    });
}

function renderPatientList(patients) {
    const container = document.getElementById('patientResults');
    container.innerHTML = '';
    
    // Locale bo'yicha tilni aniqlash
    const getSelectText = () => {
        const lang = navigator.language || navigator.userLanguage || 'uz';
        
        if (lang.startsWith('ru')) {
            return 'Выбрать';
        } else if (lang.startsWith('en')) {
            return 'Select';
        } else {
            return 'Tanlash'; // default: o'zbek
        }
    };
    
    const selectText = getSelectText();
    
    patients.forEach(patient => {
        const card = document.createElement('div');
        card.className = 'patient-card';
        card.onclick = () => selectPatient(patient);
        card.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <strong>${escapeHtml(patient.name)}</strong>
                <span style="color: #2ecc71;">${selectText} →</span>
            </div>
            <div style="display: flex; gap: 15px; font-size: 12px; margin-top: 8px;">
                <span>${escapeHtml(patient.passport_full || '---')}</span>
                <span>${escapeHtml(patient.birth_date_formatted || '---')} (${patient.age || '?'} yosh)</span>
                <span>${escapeHtml(patient.phone || '---')}</span>
            </div>
        `;
        container.appendChild(card);
    });
}

// SELECT PATIENT - faqat qiymatlarni yangilaydi
function selectPatient(patient) {
    selectedPatient = patient;
    
    // HTML elementlariga qiymatlarni joylaymiz
    document.getElementById('displayPatientName').textContent = patient.name;
    document.getElementById('displayPatientPassport').textContent = patient.passport_full || '---';
    document.getElementById('displayPatientPhone').textContent = patient.phone || '---';
    document.getElementById('displayPatientBirth').textContent = patient.birth_date_formatted || '---';
    document.getElementById('displayPatientAge').textContent = patient.age || '?';
    
    document.getElementById('patientResults').innerHTML = '';
    document.getElementById('passportSeries').value = '';
    document.getElementById('passportNumber').value = '';
    document.getElementById('patientName').value = '';
    
    if (createStep === 2) {
        createStep = 3;
        updateStepDisplay();
        // Hech qanday render funksiyasi chaqirilmaydi!
        setTimeout(() => {
            document.getElementById('reasonText').focus();
        }, 100);
    }
}

// CHANGE PATIENT - kartani tozalash
function changeSelectedPatient() {
    if (confirm('Haqiqatan ham bemorni o\'zgartirmoqchimisiz?')) {
        selectedPatient = null;
        createStep = 2;
        updateStepDisplay();
        document.getElementById('patientResults').innerHTML = '';
        
        // Kartadagi qiymatlarni tozalaymiz
        document.getElementById('displayPatientName').textContent = '---';
        document.getElementById('displayPatientPassport').textContent = '---';
        document.getElementById('displayPatientPhone').textContent = '---';
        document.getElementById('displayPatientBirth').textContent = '---';
        document.getElementById('displayPatientAge').textContent = '?';
    }
}

// RESET FORM - kartani tozalash
function resetAvailableForm() {
    createStep = 1;
    selectedPatient = null;
    
    document.getElementById('passportSeries').value = '';
    document.getElementById('passportNumber').value = '';
    document.getElementById('patientName').value = '';
    document.getElementById('reasonText').value = '';
    document.getElementById('additionalInfo').value = '';
    document.getElementById('patientResults').innerHTML = '';
    
    // Kartadagi qiymatlarni tozalaymiz
    document.getElementById('displayPatientName').textContent = '---';
    document.getElementById('displayPatientPassport').textContent = '---';
    document.getElementById('displayPatientPhone').textContent = '---';
    document.getElementById('displayPatientBirth').textContent = '---';
    document.getElementById('displayPatientAge').textContent = '?';
    
    updateStepDisplay();
}

// ==================== QABULNI SAQLASH ====================
function saveAppointment() {
    const reason = document.getElementById('reasonText').value.trim() || '';
    const additionalInfo = document.getElementById('additionalInfo').value.trim() || '';
    
    let fullReason = reason;
    if (additionalInfo) fullReason += '\n\nQo\'shimcha: ' + additionalInfo;
    
    if (!reason) {
        showToastMessage('⚠️ Iltimos, qabul sababini kiriting!', 'warning');
        document.getElementById('reasonText').focus();
        return;
    }
    
    if (!selectedPatient) {
        showToastMessage('⚠️ Bemor tanlanmagan!', 'warning');
        return;
    }
    
    const saveBtn = document.getElementById('saveBtn');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saqlanmoqda...';
    saveBtn.disabled = true;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    fetch('/ajax/store-appointment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            slot_id: currentCreateSlotId,
            patient_id: selectedPatient.id,
            reason: fullReason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToastMessage(data.message, 'success');
    
            updateSlotCard(currentCreateSlotId, 'booked', {
                patient: {
                    name: selectedPatient.name,
                    phone: selectedPatient.phone,
                    reason: fullReason
                }
            });
    
            closeAvailableModal();
        } else {
            showToastMessage('❌ ' + (data.message || 'Xatolik yuz berdi'), 'danger');
    
            // ❗ xatolik bo‘lsa modalni yopish
            closeAvailableModal();
        }
    
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    })
    .catch(error => {
        console.error('Save error:', error);
    
        showToastMessage('❌ Xatolik yuz berdi', 'danger');
    
        // ❗ server/network error bo‘lsa ham modalni yopish
        closeAvailableModal();
    
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// ==================== BAND SLOTNI BEKOR QILISH ====================
function cancelBookedAppointment(slotId) {
    
    const cancelBtn = document.getElementById('cancelBookedBtn');
    const originalText = cancelBtn.innerHTML;
    cancelBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Bekor qilinmoqda...';
    cancelBtn.disabled = true;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    fetch('/ajax/cancel-booked-appointment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ slot_id: slotId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToastMessage(data.message, 'success');
            updateSlotCard(slotId, 'available', null);
            closeBookedModal();
        } else {
            showToastMessage('❌ ' + (data.message || 'Xatolik yuz berdi'), 'danger');
        }
        cancelBtn.innerHTML = originalText;
        cancelBtn.disabled = false;
    })
    .catch(error => {
        console.error('Cancel error:', error);
        showToastMessage('❌ Xatolik yuz berdi', 'danger');
        cancelBtn.innerHTML = originalText;
        cancelBtn.disabled = false;
    });
}


// ==================== SLOT KARTASINI YANGILASH ====================
function updateSlotCard(slotId, newStatus, newData) {
    const slotCard = document.querySelector('.time-slot-card[data-slot-id="' + slotId + '"]');
    if (!slotCard) return;
    
    slotCard.classList.remove('available', 'booked', 'pending', 'completed');
    slotCard.classList.add(newStatus);
    slotCard.setAttribute('data-status', newStatus);
    
    const statusSpan = slotCard.querySelector('.slot-status');
    const patientInfoDiv = slotCard.querySelector('.patient-info-small');
    
    if (newStatus === 'available') {
        statusSpan.textContent = 'Bo\'sh';
        statusSpan.className = 'slot-status status-available-slot';
        patientInfoDiv.innerHTML = '<i class="fas fa-plus-circle"></i> Bo\'sh';
        patientInfoDiv.classList.add('text-muted');
    } else if (newStatus === 'booked' && newData && newData.patient) {
        statusSpan.textContent = 'Band';
        statusSpan.className = 'slot-status status-booked-slot';
        patientInfoDiv.innerHTML = `
            <strong>${escapeHtml(newData.patient.name)}</strong>
            <div class="patient-phone"><i class="fas fa-phone"></i> ${escapeHtml(newData.patient.phone || '')}</div>
            <div class="patient-reason"><i class="fas fa-notes-medical"></i> ${escapeHtml((newData.patient.reason || '').substring(0, 20))}</div>
        `;
        patientInfoDiv.classList.remove('text-muted');
    }
}

// ==================== TOAST MESSAGE ====================
function showToastMessage(message, type = 'success') {

    const alertBox = document.getElementById('global-alert');

    if (!alertBox) return;

    let alertClass = 'alert-success';
    let icon = 'fa-check-circle';

    if (type === 'danger') {
        alertClass = 'alert-danger';
        icon = 'fa-times-circle';
    }

    if (type === 'warning') {
        alertClass = 'alert-warning';
        icon = 'fa-exclamation-triangle';
    }

    alertBox.innerHTML = `
        <div class="${alertClass}">
            <i class="fas ${icon} me-2"></i>
            ${message}
        </div>
    `;
}

// ==================== DATE PICKER ====================
function openDatePicker() {
    const modal = document.getElementById('datePickerModal');
    if (modal) modal.showModal();
}

function closeDatePicker() {
    const modal = document.getElementById('datePickerModal');
    if (modal) modal.close();
}

function goToSelectedDate() {
    const selectedDate = document.getElementById('selectedDateInput').value;
    if (selectedDate) {
        window.location.href = doctorRoute + '?date=' + selectedDate;
    }
    closeDatePicker();
}

// ==================== YORDAMCHI FUNKSIYALAR ====================
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== ENTER VA ESC EVENTLARI ====================
document.addEventListener('DOMContentLoaded', function() {
    // Enter bilan qidirish
    const searchInputs = ['passportSeries', 'passportNumber', 'patientName'];
    searchInputs.forEach(function(id) {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchPatientsBackend();
                }
            });
        }
    });
    
    // ESC bilan modalni yopish
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = ['availableModal', 'bookedModal', 'completedModal', 'datePickerModal'];
            modals.forEach(function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal && modal.open) {
                    if (modalId === 'availableModal') closeAvailableModal();
                    if (modalId === 'bookedModal') closeBookedModal();
                    if (modalId === 'completedModal') closeCompletedModal();
                    if (modalId === 'datePickerModal') closeDatePicker();
                }
            });
        }
    });
    
    // Filter tabs
    const filterTabs = document.querySelectorAll('.filter-tab');
    filterTabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;
            filterTabs.forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
            
            const cards = document.querySelectorAll('.time-slot-card');
            cards.forEach(function(card) {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else {
                    card.style.display = card.dataset.status === filter ? 'block' : 'none';
                }
            });
        });
    });

    // Input yozganda xatolikni tozalash
    const passportSeries = document.getElementById('passportSeries');
    const passportNumber = document.getElementById('passportNumber');
    const patientName = document.getElementById('patientName');

    if (passportSeries) {
        passportSeries.addEventListener('input', function() {
            const err1 = document.getElementById('passportSeriesError');
            const err2 = document.getElementById('passportNumberError');
            if (err1) err1.innerText = '';
            if (err2) err2.innerText = '';
        });
    }

    if (passportNumber) {
        passportNumber.addEventListener('input', function() {
            const err1 = document.getElementById('passportSeriesError');
            const err2 = document.getElementById('passportNumberError');
            if (err1) err1.innerText = '';
            if (err2) err2.innerText = '';
        });
    }

    if (patientName) {
        patientName.addEventListener('input', function() {
            const err = document.getElementById('patientNameError');
            if (err) err.innerText = '';
        });
    }
});