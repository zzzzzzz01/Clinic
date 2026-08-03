// public/js/notification-modal.js
// ========== MAVJUD NOTIFICATION (DOCTOR) ==========
let doctorNotifScrollPosition = 0;

function openDoctorNotificationModal(doctorId, firstName, lastName, role, notifCount) {
    const modal = document.getElementById('doctorNotificationModal');
    if (!modal) return;

    document.getElementById('doctorNotifName').textContent = firstName;
    document.getElementById('doctorNotifFullName').value = lastName + ' ' + firstName;
    document.getElementById('doctorNotifRole').value = role;
    document.getElementById('doctorNotifCount').textContent = notifCount;
    document.getElementById('doctorNotifForm').action = '/admin/doctors/' + doctorId + '/notify';

    doctorNotifScrollPosition = window.pageYOffset;

    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeDoctorNotificationModal() {
    const modal = document.getElementById('doctorNotificationModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// Doctor Notification modal events
// document.addEventListener('DOMContentLoaded', function() {
//     const doctorNotificationModal = document.getElementById('doctorNotificationModal');
//     if (doctorNotificationModal) {
//         doctorNotificationModal.addEventListener('cancel', function(e) {
//             e.preventDefault();
//             closeDoctorNotificationModal();
//         });

//         doctorNotificationModal.addEventListener('click', function(e) {
//             const rect = this.getBoundingClientRect();
//             const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
//                             rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
            
//             if (!isInDialog) {
//                 closeDoctorNotificationModal();
//             }
//         });
//     }
// });

// ========== NURSE NOTIFICATION QO'SHIMCHA ==========
let nurseNotifScrollPosition = 0;

function openNurseNotificationModal(nurseId, firstName, lastName, role, notifCount) {
    const modal = document.getElementById('nurseNotificationModal');
    if (!modal) return;

    document.getElementById('nurseNotifName').textContent = firstName;
    document.getElementById('nurseNotifFullName').value = lastName + ' ' + firstName;
    document.getElementById('nurseNotifRole').value = role;
    document.getElementById('nurseNotifCount').textContent = notifCount;
    document.getElementById('nurseNotificationForm').action = '/admin/nurses/' + nurseId + '/notify'; 

    nurseNotifScrollPosition = window.pageYOffset;

    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeNurseNotificationModal() {
    const modal = document.getElementById('nurseNotificationModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// Nurse Notification modal events
document.addEventListener('DOMContentLoaded', function() {
    const nurseNotificationModal = document.getElementById('nurseNotificationModal');
    if (nurseNotificationModal) {
        nurseNotificationModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            closeNurseNotificationModal();
        });

        nurseNotificationModal.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                            rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
            
            if (!isInDialog) {
                closeNurseNotificationModal();
            }
        });
    }
});

// ESC tugmasi (doctor + nurse)
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const doctorModal = document.getElementById('doctorNotificationModal');
        if (doctorModal && doctorModal.open) closeDoctorNotificationModal();
        
        const nurseModal = document.getElementById('nurseNotificationModal');
        if (nurseModal && nurseModal.open) closeNurseNotificationModal();
    }
});