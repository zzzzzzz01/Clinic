// Scroll boshqaruvi
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.showModal();
        document.body.classList.add('modal-open');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// Xodimlar modal
function loadDepartmentStaff(departmentId, departmentName) {
    const modal = document.getElementById('staffModal');
    const modalTitle = document.getElementById('modalDepartmentName');
    const staffTableBody = document.getElementById('staffTableBody');
    
    modalTitle.textContent = departmentName;
    staffTableBody.innerHTML = `<tr><td colspan="4" class="text-center">${lang.loading}</td></tr>`;
    openModal('staffModal');
    
    fetch(`/departments/${departmentId}/staff`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                staffTableBody.innerHTML = `<tr><td colspan="4" class="text-center">${lang.no_staff}</td></tr>`;
                return;
            }
            
            let html = '';
            data.forEach((staff, index) => {
                const status = staff.status;
                html += `
                    <tr>
                        <td class="row-number">${index + 1}</td>
                        <td class="table-text">${staff.name}</td>
                        <td class="table-text">${staff.position}</td>
                        <td>
                            <span class="status-badge ${status.class}"
                                style="color: ${status.color}; background-color: ${status.bg_color};">
                                <i class="fas ${status.icon}"></i>
                                ${status.text}
                            </span>
                        </td>
                    </tr>
                `;
            });
            staffTableBody.innerHTML = html;
        })
        .catch(error => {
            staffTableBody.innerHTML = `<tr><td colspan="4" class="text-center">${lang.error_occurred}</td></tr>`;
        });
}

function closeStaffModal() {
    closeModal('staffModal');
}

// O'chirish modal
function closeDeleteDepartmentModal() {
    closeModal('deleteDepartmentModal');
    
    const checkbox = document.getElementById('confirmDeleteCheckbox');
    const submitBtn = document.getElementById('deleteSubmitBtn');
    if (checkbox) checkbox.checked = false;
    if (submitBtn) submitBtn.disabled = true;
}

// Edit modal
function closeEditModal() {
    closeModal('editDepartmentModal');
}

// Document ready
document.addEventListener('DOMContentLoaded', function() {
    
    // View staff btn event
    document.querySelectorAll('.view-staff-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.departmentId;
            const name = this.dataset.departmentName;
            loadDepartmentStaff(id, name);
        });
    });

// Edit button event
document.querySelectorAll('.edit-department-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const id = this.dataset.id;
        const nameUz = this.dataset.nameUz;
        const nameRu = this.dataset.nameRu;
        const nameEn = this.dataset.nameEn;
        const headDoctor = this.dataset.headDoctor;
        const floor = this.dataset.floor;
        const descriptionUz = this.dataset.descriptionUz;
        const descriptionRu = this.dataset.descriptionRu;
        const descriptionEn = this.dataset.descriptionEn;
        const status = this.dataset.status;
        
        const form = document.getElementById('editDepartmentForm');
        const editNameUz = document.getElementById('edit_name_uz');
        const editNameRu = document.getElementById('edit_name_ru');
        const editNameEn = document.getElementById('edit_name_en');
        const editFloor = document.getElementById('edit_floor');
        const editHeadDoctor = document.getElementById('edit_head_doctor');
        const editStatus = document.getElementById('edit_status');
        const editDescriptionUz = document.getElementById('edit_description_uz');
        const editDescriptionRu = document.getElementById('edit_description_ru');
        const editDescriptionEn = document.getElementById('edit_description_en');
        
        // Form action ni sozlash
        if (form) form.action = `/departments/${id}`;
        
        // Ma'lumotlarni to'ldirish
        if (editNameUz) editNameUz.value = nameUz || '';
        if (editNameRu) editNameRu.value = nameRu || '';
        if (editNameEn) editNameEn.value = nameEn || '';
        if (editFloor) editFloor.value = floor || '';
        if (editHeadDoctor) editHeadDoctor.value = headDoctor || '';
        if (editStatus) editStatus.value = status !== undefined ? status : '1';
        if (editDescriptionUz) editDescriptionUz.value = descriptionUz || '';
        if (editDescriptionRu) editDescriptionRu.value = descriptionRu || '';
        if (editDescriptionEn) editDescriptionEn.value = descriptionEn || '';
        
        openModal('editDepartmentModal');
    });
});

    // Delete button event
    document.querySelectorAll('.delete-department-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            const modal = document.getElementById('deleteDepartmentModal');
            const form = document.getElementById('deleteDepartmentForm');
            const deleteName = document.getElementById('deleteDepartmentName');
            const checkbox = document.getElementById('confirmDeleteCheckbox');
            const submitBtn = document.getElementById('deleteSubmitBtn');
            
            if (deleteName) deleteName.textContent = name;
            if (form) form.action = `/departments/${id}`;
            if (checkbox) checkbox.checked = false;
            if (submitBtn) submitBtn.disabled = true;
            
            openModal('deleteDepartmentModal');
        });
    });

    // Confirm checkbox event
    const confirmCheckbox = document.getElementById('confirmDeleteCheckbox');
    if (confirmCheckbox) {
        confirmCheckbox.addEventListener('change', function() {
            const submitBtn = document.getElementById('deleteSubmitBtn');
            if (submitBtn) submitBtn.disabled = !this.checked;
        });
    }

    // Form submit event
    const deleteForm = document.getElementById('deleteDepartmentForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('deleteSubmitBtn');
            if (submitBtn) {
                submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${lang.deleting}`;
                submitBtn.disabled = true;
            }
        });
    }

    // Edit form submit event
    const editForm = document.getElementById('editDepartmentForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-save');
            if (submitBtn) {
                submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${lang.saving}`;
                submitBtn.disabled = true;
            }
        });
    }    

    // Dropdown toggle
    document.querySelectorAll('.action-dots').forEach(dots => {
        dots.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.closest('.action-dropdown');
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            
            // Boshqa dropdownlarni yopish
            document.querySelectorAll('.dropdown-content.show').forEach(content => {
                if (content !== dropdownContent) {
                    content.classList.remove('show');
                }
            });
            
            dropdownContent.classList.toggle('show');
        });
    });

    // Sahifaning boshqa joyiga bosganda dropdownlarni yopish
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-dropdown')) {
            document.querySelectorAll('.dropdown-content.show').forEach(content => {
                content.classList.remove('show');
            });
        }
    });

    // Filter toggle
    const filterToggleBtn = document.getElementById('departmentFilterToggleBtn');
    if (filterToggleBtn) {
        filterToggleBtn.addEventListener('click', function() {
            const filterSection = document.querySelector('.filter-section');
            if (filterSection) {
                filterSection.classList.toggle('show');
                this.querySelector('.toggle-icon').classList.toggle('fa-chevron-down');
                this.querySelector('.toggle-icon').classList.toggle('fa-chevron-up');
            }
        });
    }

    // Search input
    const searchInput = document.getElementById('departmentTableSearchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('.department-row');
            
            rows.forEach(row => {
                const departmentName = row.querySelector('.department-name')?.textContent?.toLowerCase() || '';
                if (departmentName.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

});