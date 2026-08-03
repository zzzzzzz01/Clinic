// ========== MAVJUD DELETE (DOCTOR) ==========
let doctorDeleteScrollPosition = 0;

function openDoctorDeleteModal(id, firstName, lastName, middleName, role) {
    const modal = document.getElementById('doctorDeleteModal');
    const form = document.getElementById('doctorDeleteForm');
    
    if (!modal || !form) return;

    form.action = '/doctors/' + id + '/delete';
    
    const fullName = lastName + ' ' + firstName + (middleName ? ' ' + middleName : '');
    
    document.getElementById('doctorDeleteFullName').textContent = fullName;
    document.getElementById('doctorDeleteRole').textContent = role || 'Shifokor';
    
    const checkbox = document.getElementById('doctorDeleteCheckbox');
    const submitBtn = document.getElementById('doctorDeleteSubmitBtn');
    
    if (checkbox) checkbox.checked = false;
    if (submitBtn) submitBtn.disabled = true;
    
    doctorDeleteScrollPosition = window.pageYOffset;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeDoctorDeleteModal() {
    const modal = document.getElementById('doctorDeleteModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// Doctor Delete Checkbox event
document.addEventListener('DOMContentLoaded', function() {
    const doctorDeleteCheckbox = document.getElementById('doctorDeleteCheckbox');
    const doctorDeleteSubmitBtn = document.getElementById('doctorDeleteSubmitBtn');
    if (doctorDeleteCheckbox && doctorDeleteSubmitBtn) {
        doctorDeleteCheckbox.addEventListener('change', function() {
            doctorDeleteSubmitBtn.disabled = !this.checked;
        });
    }
    
    const doctorDeleteModal = document.getElementById('doctorDeleteModal');
    if (doctorDeleteModal) {
        doctorDeleteModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            closeDoctorDeleteModal();
        });

        doctorDeleteModal.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                            rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
            
            if (!isInDialog) {
                closeDoctorDeleteModal();
            }
        });
    }
});

// ========== NURSE DELETE QO'SHIMCHA ==========
let nurseDeleteScrollPosition = 0;

function openNurseDeleteModal(id, firstName, lastName, middleName, role) {
    const modal = document.getElementById('deleteNurseModal');
    const form = document.getElementById('deleteNurseForm');
    
    if (!modal || !form) return;

    form.action = '/nurses/' + id;
    
    const fullName = lastName + ' ' + firstName + (middleName ? ' ' + middleName : '');
    
    document.getElementById('deleteNurseFullName').textContent = fullName;
    document.getElementById('deleteNurseRole').textContent = role || 'Hamshira';
    
    const checkbox = document.getElementById('confirmDeleteCheckbox');
    const submitBtn = document.getElementById('deleteSubmitBtn');
    
    if (checkbox) checkbox.checked = false;
    if (submitBtn) submitBtn.disabled = true;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeNurseDeleteModal() {
    const modal = document.getElementById('deleteNurseModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// Nurse Delete Checkbox event
document.addEventListener('DOMContentLoaded', function() {
    const nurseDeleteCheckbox = document.getElementById('confirmDeleteCheckbox');
    const nurseDeleteSubmitBtn = document.getElementById('deleteSubmitBtn');
    if (nurseDeleteCheckbox && nurseDeleteSubmitBtn) {
        nurseDeleteCheckbox.addEventListener('change', function() {
            nurseDeleteSubmitBtn.disabled = !this.checked;
        });
    }
    
    const nurseDeleteModal = document.getElementById('deleteNurseModal');
    if (nurseDeleteModal) {
        nurseDeleteModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            closeDeleteModal();
        });

        nurseDeleteModal.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                            rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
            
            if (!isInDialog) {
                closeDeleteModal();
            }
        });
    }
});

// ESC tugmasi (doctor + nurse)
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const doctorModal = document.getElementById('doctorDeleteModal');
        if (doctorModal && doctorModal.open) closeDoctorDeleteModal();
        
        const nurseModal = document.getElementById('nurseDeleteModal');
        if (nurseModal && nurseModal.open) closeNurseDeleteModal();
    }
});


// ========== FEATURE DELETE ==========
let featureDeleteScrollPosition = 0;

function openFeatureDeleteModal(id, name, status) {
    const modal = document.getElementById('featureDeleteModal');
    const form = document.getElementById('featureDeleteForm');
    
    if (!modal || !form) return;

    form.action = '/features/' + id;
    
    document.getElementById('featureDeleteName').textContent = name || 'Noma\'lum';
    
    const statusText = status == 1 ? '@lang("words.active")' : '@lang("words.inactive")';
    document.getElementById('featureDeleteStatus').textContent = statusText;
    
    const checkbox = document.getElementById('featureDeleteCheckbox');
    const submitBtn = document.getElementById('featureDeleteSubmitBtn');
    
    if (checkbox) checkbox.checked = false;
    if (submitBtn) submitBtn.disabled = true;
    
    featureDeleteScrollPosition = window.pageYOffset;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeFeatureDeleteModal() {
    const modal = document.getElementById('featureDeleteModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// Checkbox event listener
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('featureDeleteCheckbox');
    const submitBtn = document.getElementById('featureDeleteSubmitBtn');
    
    if (checkbox && submitBtn) {
        checkbox.addEventListener('change', function() {
            submitBtn.disabled = !this.checked;
        });
    }
});




// ==================== SUPPLIER DELETE MODAL ====================
const supplierConfirmCheckbox = document.getElementById('supplierConfirmDeleteCheckbox');
const supplierDeleteSubmitBtn = document.getElementById('supplierDeleteSubmitBtn');

if (supplierConfirmCheckbox && supplierDeleteSubmitBtn) {
    supplierConfirmCheckbox.addEventListener('change', function() {
        supplierDeleteSubmitBtn.disabled = !this.checked;
    });
}

function openSupplierDeleteModal(id, name) {
    const modal = document.getElementById('supplierDeleteModal');
    const form = document.getElementById('supplierDeleteForm');
    
    if (!modal || !form) return;

    form.action = '/suppliers/' + id + '/destroy';
    document.getElementById('supplierDeleteName').textContent = name;
    
    const checkbox = document.getElementById('supplierConfirmDeleteCheckbox');
    const submitBtn = document.getElementById('supplierDeleteSubmitBtn');
    
    if (checkbox) checkbox.checked = false;
    if (submitBtn) submitBtn.disabled = true;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeSupplierDeleteModal() {
    const modal = document.getElementById('supplierDeleteModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}




// ==================== Medicine DELETE MODAL ====================
let medicineScrollPosition = 0;

function openMedicineDeleteModal(id, name) {
    const modal = document.getElementById('deleteMedicineModal');
    const form = document.getElementById('deleteMedicineForm');
    
    if (!modal || !form) return;

    form.action = '/medicine/' + id + '/destroy';
    document.getElementById('medicineDeleteName').textContent = name;
    
    const checkbox = document.getElementById('medicineConfirmDeleteCheckbox');
    const submitBtn = document.getElementById('medicineDeleteSubmitBtn');
    
    if (checkbox) {
        checkbox.checked = false;
        // CHANGE EVENT LISTENER QO'SHISH
        checkbox.onchange = function() {
            submitBtn.disabled = !this.checked;
        };
    }
    if (submitBtn) submitBtn.disabled = true;
    
    medicineScrollPosition = window.pageYOffset;
    
    modal.showModal();
    document.body.classList.add('modal-open');
}

function closeMedicineDeleteModal() {
    const modal = document.getElementById('deleteMedicineModal');
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}