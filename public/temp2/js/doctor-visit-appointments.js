// ==================== DOCTOR APPOINTMENT MODALS ====================
let currentSlotId = null;
let currentSlotData = null;

// ==================== UMUMIY MODAL FUNKSIYALARI ====================
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    
    document.body.style.overflow = 'hidden';
    
    try {
        if (modal.tagName === 'DIALOG') {
            modal.showModal();
        } else {
            modal.style.display = 'flex';
        }
    } catch(e) {
        modal.style.display = 'flex';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    
    try {
        if (modal.tagName === 'DIALOG') {
            modal.close();
        } else {
            modal.style.display = 'none';
        }
    } catch(e) {
        modal.style.display = 'none';
    }
    
    document.body.style.overflow = '';
}

// ==================== BOOKED MODAL ====================
function openBookedModal(slotId, slotData) {
    currentSlotId = slotId;
    currentSlotData = slotData;
    
    if (slotData.patient) {
        const nameEl = document.getElementById('bookedPatientName');
        const passportEl = document.getElementById('bookedPatientPassport');
        const birthEl = document.getElementById('bookedPatientBirthDate');
        const ageEl = document.getElementById('bookedPatientAge');
        const phoneEl = document.getElementById('bookedPatientPhone');
        const reasonEl = document.getElementById('bookedReason');
        const createdAtEl = document.getElementById('bookedCreatedAt');
        
        if (nameEl) nameEl.textContent = slotData.patient.name || 'Bemor';
        if (passportEl) passportEl.textContent = slotData.patient.passport || '---';
        if (birthEl) birthEl.textContent = slotData.patient.birth_date || '---';
        if (ageEl) ageEl.textContent = slotData.patient.age ? slotData.patient.age + ' yosh' : '---';
        if (phoneEl) phoneEl.textContent = slotData.patient.phone || '---';
        if (reasonEl) reasonEl.textContent = slotData.patient.reason || 'Ko\'rsatilmagan';
        if (createdAtEl) createdAtEl.textContent = slotData.patient.created_at || '---';
    }
    
    // Date format: YYYY-MM-DD dan DD.MM.YYYY ga o'zgartirish
    const timeEl = document.getElementById('bookedSlotTime');
    const dateEl = document.getElementById('bookedSlotDate');
    
    if (timeEl && slotData.start_time && slotData.end_time) {
        // Vaqtni faqat soat va daqiqa qilib olish
        const startTime = slotData.start_time.substring(0, 5);
        const endTime = slotData.end_time.substring(0, 5);
        timeEl.textContent = startTime + ' - ' + endTime;
    } else if (timeEl) {
        timeEl.textContent = '--:-- - --:--';
    }
    
    if (dateEl && slotData.date) {
        // Sanani YYYY-MM-DD dan DD.MM.YYYY ga o'zgartirish
        const dateParts = slotData.date.split('-');
        if (dateParts.length === 3) {
            const formattedDate = dateParts[2] + '.' + dateParts[1] + '.' + dateParts[0];
            dateEl.textContent = formattedDate;
        } else {
            dateEl.textContent = slotData.date || '--.--.----';
        }
    } else if (dateEl) {
        dateEl.textContent = '--.--.----';
    }
    
    // Boshlash tugmasi linki
    const startLink = document.getElementById('startConsultationLink');
    if (startLink) {
        startLink.onclick = function(e) {
            e.preventDefault();
            window.location.href = '/doctor/consultation/' + slotId + '?date=' + (slotData.date || '');
        };
    }
    
    openModal('bookedModal');
}

function closeBookedModal() {
    closeModal('bookedModal');
}

// ==================== COMPLETED MODAL ====================
function openCompletedModal(slotId, slotData) {
    currentSlotId = slotId;
    currentSlotData = slotData;
    
    if (slotData.patient) {
        const nameEl = document.getElementById('completedPatientName');
        const passportEl = document.getElementById('completedPatientPassport');
        const birthEl = document.getElementById('completedPatientBirthDate');
        const ageEl = document.getElementById('completedPatientAge');
        const phoneEl = document.getElementById('completedPatientPhone');
        const reasonEl = document.getElementById('completedReason');
        const createdAtEl = document.getElementById('completedCreatedAt');
        
        if (nameEl) nameEl.textContent = slotData.patient.name || '--';
        if (passportEl) passportEl.textContent = slotData.patient.passport || '---';
        if (birthEl) birthEl.textContent = slotData.patient.birth_date || '---';
        if (ageEl) ageEl.textContent = slotData.patient.age ? slotData.patient.age + ' yosh' : '---';
        if (phoneEl) phoneEl.textContent = slotData.patient.phone || '---';
        if (reasonEl) reasonEl.textContent = slotData.patient.reason || 'Ko\'rsatilmagan';
        if (createdAtEl) createdAtEl.textContent = slotData.patient.created_at || '---';
    }
    
    // Date format: YYYY-MM-DD dan DD.MM.YYYY ga o'zgartirish
    const timeEl = document.getElementById('completedSlotTime');
    const dateEl = document.getElementById('completedSlotDate');
    
    if (timeEl && slotData.start_time && slotData.end_time) {
        // Vaqtni faqat soat va daqiqa qilib olish
        const startTime = slotData.start_time.substring(0, 5);
        const endTime = slotData.end_time.substring(0, 5);
        timeEl.textContent = startTime + ' - ' + endTime;
    } else if (timeEl) {
        timeEl.textContent = '--:-- - --:--';
    }
    
    if (dateEl && slotData.date) {
        // Sanani YYYY-MM-DD dan DD.MM.YYYY ga o'zgartirish
        const dateParts = slotData.date.split('-');
        if (dateParts.length === 3) {
            const formattedDate = dateParts[2] + '.' + dateParts[1] + '.' + dateParts[0];
            dateEl.textContent = formattedDate;
        } else {
            dateEl.textContent = slotData.date || '--.--.----';
        }
    } else if (dateEl) {
        dateEl.textContent = '--.--.----';
    }
    
    openModal('completedModal');
}

function closeCompletedModal() {
    closeModal('completedModal');
}

// ==================== ASOSIY MODAL OCHISH ====================
function openAppointmentModal(slotId, slotData) {
    if (!slotData) {
        console.error('Xatolik: Ma\'lumot topilmadi');
        return;
    }
    
    const status = slotData.status;
    
    if (status === 'booked') {
        openBookedModal(slotId, slotData);
    } else if (status === 'completed') {
        openCompletedModal(slotId, slotData);
    } else {
        console.log('Modal ochilmadi: ' + status);
    }
}

// ==================== DATE PICKER ====================
function openDatePicker() {
    openModal('datePickerModal');
}

function closeDatePicker() {
    closeModal('datePickerModal');
}

function goToSelectedDate() {
    const selectedDateInput = document.getElementById('selectedDateInput');
    if (selectedDateInput && selectedDateInput.value) {
        window.location.href = doctorRoute + '?date=' + selectedDateInput.value;
    }
    closeDatePicker();
}

// ==================== EVENT LISTENERS ====================
document.addEventListener('DOMContentLoaded', function() {
    // ESC bilan modalni yopish
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modalIds = ['bookedModal', 'completedModal', 'datePickerModal'];
            modalIds.forEach(function(id) {
                const modal = document.getElementById(id);
                if (modal && modal.open === true) {
                    closeModal(id);
                }
            });
        }
    });
    
    // Session alertni avtomatik yopish
    const sessionAlert = document.getElementById('sessionAlert');
    if (sessionAlert) {
        setTimeout(function() {
            sessionAlert.style.opacity = '0';
            setTimeout(function() {
                if (sessionAlert) sessionAlert.remove();
            }, 500);
        }, 3000);
    }
});