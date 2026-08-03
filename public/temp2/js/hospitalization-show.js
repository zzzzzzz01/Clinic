function showTab(tabId, tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
        tab.style.display = 'none';
    });
    
    document.querySelectorAll('.treatment-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
        selectedTab.classList.add('active');
        selectedTab.style.display = 'block';
    }
    
    const tabButton = document.querySelector(`.treatment-tab[data-tab="${tabName}"]`);
    if (tabButton) {
        tabButton.classList.add('active');
    }
    
    localStorage.setItem('currentTab', tabName);
}

document.addEventListener('DOMContentLoaded', function() {
    const lastActiveTab = localStorage.getItem('currentTab');
    
    if (lastActiveTab) {
        let tabId = '';
        switch(lastActiveTab) {
            case 'staff': tabId = 'staffTab'; break;
            case 'medication': tabId = 'medicationTab'; break;
            case 'test': tabId = 'testTab'; break;
            case 'procedure': tabId = 'procedureTab'; break;
            case 'rooms': tabId = 'roomsTab'; break;
            default: tabId = 'staffTab';
        }
        showTab(tabId, lastActiveTab);
    } else {
        showTab('staffTab', 'staff');
    }
});

function formatDate(dateString) {
    if (!dateString) return '{{ __("words.current") }}';
    const date = new Date(dateString);
    return date.toLocaleDateString('uz-UZ', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function exportPatientData() {
    alert('📊 {{ __("words.exporting_data") }}...');
}

function printTreatmentPlan() {
    alert('🖨️ {{ __("words.printing_plan") }}...');
}

function showAllStats() {
    alert('📈 {{ __("words.showing_stats") }}...');
}



 // Room uchun
function showAssignRoomModal() {
    document.getElementById('assignRoomModal').showModal();
}

function closeAssignRoomModal() {
    document.getElementById('assignRoomModal').close();
}


// Doctors uchun 
function showAddDoctorModal() {
    document.getElementById('addDoctorModal').showModal();
}

function closeModal(modalId) {
    document.getElementById(modalId).close();
}



// Procedures uchun 
// View dialogini ochish
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const data = btn.dataset;

        document.getElementById('completeProcedureId').value = data.id;
        
        document.getElementById('viewProcedureName').innerText = data.procedureName || '-';
        document.getElementById('viewDuration').innerText = data.duration ? data.duration + ' daqiqa' : '-';
        document.getElementById('viewRoom').innerText = data.room || '-';
        document.getElementById('viewStaff').innerText = data.staff || '-';
        document.getElementById('viewAssignedAt').innerText = data.assigned || '-';
        document.getElementById('viewPatient').innerText = data.patient || '-';
        document.getElementById('viewStatus').innerText = data.status || '-';
        
        document.getElementById('viewDialog').showModal();
    });
});

function closeDialog(id) {
    document.getElementById(id).close();
}

function openCompleteDialog(element) {
    // data-atributlardan qiymatlarni olish
    var procedureId = element.getAttribute('data-id');
    var procedureName = element.getAttribute('data-procedure-name');
    var procedureInfo = element.getAttribute('data-procedure-info');
    var mainInfo = element.getAttribute('data-main-info');
    
    var dialog = document.getElementById('completeDialog');
    
    dialog.setAttribute('data-procedure-id', procedureId);
    document.getElementById('completeProcedureId').value = procedureId;
    document.getElementById('completeProcedureInfo').innerHTML = procedureInfo || procedureName;
    document.getElementById('completeMainInfo').innerHTML = mainInfo || '';
    
    dialog.showModal();
}

function closeDialog(dialogId) {
    var dialog = document.getElementById(dialogId);
    if (dialog) {
        dialog.close();
    }
}

function submitCompleteForm() {
    const form = document.getElementById('completeForm');

    if (!form) return;

    const administeredBy = form.querySelector('[name="administered_by"]')?.value;
    const administrationAt = form.querySelector('[name="administration_at"]')?.value;

    if (!administeredBy || !administrationAt) {
        return;
    }

    form.submit();
}

function openCancelDialog(element) {
    var id = element.getAttribute('data-id');
    var procedureName = element.getAttribute('data-procedure-name');
    var dialog = document.getElementById('cancelDialog');
    
    if (dialog) {
        document.getElementById('cancelProcedureId').value = id;
        document.getElementById('cancelProcedureName').innerHTML = procedureName;
        dialog.showModal();
    } else {
        alert('Dialog topilmadi');
    }
}

// Tahrirlash dialogini ochish
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        
        document.getElementById('editProcedureId').value = btn.dataset.id;
        
        // Protsedura nomi selectda tanlash
        const procedureSelect = document.getElementById('editProcedureIdSelect');
        for(let i = 0; i < procedureSelect.options.length; i++) {
            if(procedureSelect.options[i].text === btn.dataset.procedureName) {
                procedureSelect.selectedIndex = i;
                break;
            }
        }
        
        // Davomiyligi
        document.getElementById('editNotes').value = btn.dataset.note;
        
        // Xona selectda tanlash
        const roomSelect = document.getElementById('editRoomId');
        for(let i = 0; i < roomSelect.options.length; i++) {
            if(roomSelect.options[i].text.includes(btn.dataset.room)) {
                roomSelect.selectedIndex = i;
                break;
            }
        }
        
        // Hodim selectda tanlash
        const staffSelect = document.getElementById('editStaffId');
        for(let i = 0; i < staffSelect.options.length; i++) {
            if(staffSelect.options[i].text.includes(btn.dataset.staff)) {
                staffSelect.selectedIndex = i;
                break;
            }
        }
        
        document.getElementById('editForm').action = "{{ route('hospitalization.procedure.update') }}";
        document.getElementById('editModal').showModal();
    });
});

 // O'chirish dialogini ochish
 document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();

        const id = btn.dataset.id;
        const name = btn.dataset.procedureName;

        document.getElementById('deleteProcedureName').innerText = name;
        document.getElementById('procedureDeleteName').innerText = name;

        const form = document.getElementById('procedureDeleteForm');
        form.action = `{{ url('hospitalization/procedures') }}/${id}/destroy`;

        const checkbox = document.getElementById('procedureDeleteCheckbox');
        const submitBtn = document.getElementById('procedureDeleteSubmitBtn');

        checkbox.checked = false;
        submitBtn.disabled = true;

        checkbox.onchange = function () {
            submitBtn.disabled = !this.checked;
        };

        document.getElementById('procedureDeleteModal').showModal();
    });
});

function closeProcedureDeleteModal() {
    document.getElementById('procedureDeleteModal').close();
}










// Test uchun  
let selectedTests = [];
let currentTestType = 'test';
let showAllItems = true;

function showAssignTestModal() {
    const modal = document.getElementById('assignTestModal');
    modal.showModal();
    document.body.style.overflow = 'hidden';
    selectedTests = [];
    showTestType('test');
    updateSelectedList();
    resetTestList();
}

function closeAssignTestModal() {
    const modal = document.getElementById('assignTestModal');
    modal.close();
    document.body.style.overflow = '';
    document.getElementById('testSearch').value = '';
    document.getElementById('testNotes').value = '';
    document.getElementById('testOrderDate').value = '{{ now()->format("Y-m-d\TH:i") }}';
    selectedTests = [];
    resetTestList();
}

function showTestType(type) {
    currentTestType = type;
    if (type === 'test') {
        document.getElementById('testTypeBtn').className = 'btn-primary type-btn';
        document.getElementById('testPanelTypeBtn').className = 'btn-secondary type-btn';
        showAllItems = false;
        filterTestItems();
    } else {
        document.getElementById('testTypeBtn').className = 'btn-secondary type-btn';
        document.getElementById('testPanelTypeBtn').className = 'btn-primary type-btn';
        showAllItems = false;
        filterTestItems();
    }
}

function filterTestItems() {
    const testItems = document.querySelectorAll('#testItemsContainer > div');
    const searchTerm = document.getElementById('testSearch').value.toLowerCase();
    
    testItems.forEach(item => {
        const itemType = item.getAttribute('data-type');
        const itemName = item.querySelector('.test-select-name').textContent.toLowerCase();
        const typeMatch = showAllItems ? true : (currentTestType === itemType);
        const searchMatch = searchTerm === '' || itemName.includes(searchTerm);
        
        if (typeMatch && searchMatch) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
        
        const itemId = item.getAttribute('data-test-id') || item.getAttribute('data-panel-id');
        const isSelected = selectedTests.some(t => t.id == itemId && t.type === itemType);
        item.style.background = isSelected ? 'rgba(0, 191, 255, 0.1)' : 'white';
        item.style.borderLeftColor = isSelected ? 'var(--primary-color)' : '#ddd';
    });
}

function resetTestList() {
    showAllItems = false;
    document.getElementById('testSearch').value = '';
    filterTestItems();
}

function toggleTestSelection(id, type) {
    const index = selectedTests.findIndex(item => item.id == id && item.type === type);

    if (index !== -1) {
        selectedTests.splice(index, 1);
        filterTestItems();
        updateSelectedList();
        return;
    }

    let element;
    if (type === 'test') {
        element = document.querySelector(`[data-test-id="${id}"][data-type="test"]`);
    } else {
        element = document.querySelector(`[data-panel-id="${id}"][data-type="testPanel"]`);
    }

    if (!element) return;

    const item = {
        id: id,
        type: type,
        name: element.querySelector('.test-select-name').textContent.trim(),
        price: parseInt(element.dataset.price),
        duration: element.dataset.duration || '',
    };

    if (type === 'test') {
        item.code = element.dataset.code || '';
    }

    if (type === 'testPanel') {
        const testsCount = element.dataset.testsCount || 0;
        item.testsCount = testsCount;
    }

    selectedTests.push(item);
    filterTestItems();
    updateSelectedList();
}

function removeSelectedTest(index) {
    selectedTests.splice(index, 1);
    filterTestItems();
    updateSelectedList();
}

function updateSelectedList() {
    const selectedList = document.getElementById('selectedList');
    const selectedContainer = document.getElementById('selectedTests');
    
    if (selectedTests.length === 0) {
        selectedContainer.style.display = 'none';
        return;
    }
    
    selectedContainer.style.display = 'block';
    
    let html = '';
    let totalPrice = 0;
    
    selectedTests.forEach((item, index) => {
        const priceNum = parseInt(item.price) || 0;
        totalPrice += priceNum;
    
        html += `
        <div class="selected-test-item">
            <div class="selected-test-info">
                <div class="selected-test-name">
                    ${item.name}
                    <span class="selected-test-badge ${item.type === 'test' ? 'badge-test' : 'badge-panel'}">
                        ${item.type === 'test' ? window.Lang.words.test : window.Lang.words.panel}
                    </span>
                </div>
    
                <div class="selected-test-meta">
                    ${item.duration} ${window.Lang.words.hour} • ${window.Lang.words.code}: ${item.code}
                </div>
    
                ${item.testsCount ? `
                    <div class="selected-test-count">
                        <strong>${window.Lang.words.includes}:</strong>
                        ${item.testsCount} ${window.Lang.words.tests}
                    </div>
                ` : ''}
            </div>
    
            <div class="selected-test-actions">
                <div class="selected-test-price">
                    ${formatPrice(item.price)} $
                </div>
    
                <button type="button"
                        class="selected-test-remove"
                        onclick="removeSelectedTest(${index})">
                    <i class="fas fa-circle-xmark"></i>
                    ${window.Lang.words.remove}
                </button>
            </div>
        </div>
        `;
    });
    
    html += `
        <div style="margin-top: 10px; padding-top: 10px; border-top: 2px solid var(--primary-color);">
            <div style="display: flex; justify-content: space-between; font-weight: 700; color: var(--dark-color);">
                <span>${window.Lang.words.total}:</span>
                <span>${formatPrice(totalPrice)} $</span>
            </div>
    
            <div style="font-size: 12px; color: var(--gray-color); margin-top: 5px;">
                ${selectedTests.length} ${window.Lang.words.tests_selected}
            </div>
        </div>
    `;
    
    selectedList.innerHTML = html;
    document.getElementById('selectedTestsInput').value = JSON.stringify(selectedTests);
}

function searchTests() {
    filterTestItems();
}

function formatPrice(price) {
    if (!price) return '0';
    const num = parseInt(price);
    if (isNaN(num)) return price;
    return num.toLocaleString('uz-UZ');
}

function submitTestOrder() {
    document.getElementById('testOrderForm').submit();
} 








// Dori medicine uchun 
function openMedicationModal() {
    var modal = document.getElementById('medicationModal');
    if (modal) {
        modal.showModal();
        document.getElementById('medicationsForm').reset();
        document.querySelectorAll('.error-message').forEach(function(el) { 
            el.classList.remove('show'); 
        });
        document.querySelectorAll('.form-control.error').forEach(function(el) { 
            el.classList.remove('error'); 
        });
        var freqContainer = document.getElementById('frequencyContainer');
        if (freqContainer) {
            freqContainer.innerHTML = '<label class="notification-label required">&nbsp;</label><div class="placeholder-box"> ' +
            window.Lang.words.select_type_first +
            ' </div>';
        }
        document.getElementById('dosageInput').value = '';
        document.getElementById('formInput').value = '';
    }
    return false;
}

function closeMedicationModal() {
    var modal = document.getElementById('medicationModal');
    if (modal) {
        modal.close();
    }
    return false;
}

function validateMedicationForm() {
    var isValid = true;
    document.querySelectorAll('.error-message').forEach(function(el) { 
        el.classList.remove('show'); 
    });
    document.querySelectorAll('.form-control.error').forEach(function(el) { 
        el.classList.remove('error'); 
    });
    
    var medicineSelect = document.querySelector('select[name="medicine_id"]');
    var frequencyType = document.querySelector('.frequency-type');
    var dosageAmount = document.querySelector('input[name="dosage_amount"]');
    var durationDays = document.querySelector('input[name="duration_days"]');
    var prescribedBy = document.querySelector('.prescribed-by-select');
    var startDate = document.querySelector('input[name="start_at"]');
    
    if (!medicineSelect || !medicineSelect.value) {
        showError('medicineError', 'Dorini tanlang');
        if (medicineSelect) medicineSelect.classList.add('error');
        isValid = false;
    }
    
    if (!frequencyType || !frequencyType.value) {
        showError('frequencyTypeError', 'Qabul qilish turini tanlang');
        if (frequencyType) frequencyType.classList.add('error');
        isValid = false;
    } else {
        var frequencyValue = document.querySelector('input[name="frequency_value"]');
        if (frequencyValue && !frequencyValue.value && !['once', 'as_needed'].includes(frequencyType.value)) {
            var container = document.getElementById('frequencyContainer');
            if (container) {
                var existingError = container.querySelector('.dynamic-error');
                if (!existingError) {
                    var errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message show dynamic-error';
                    errorDiv.style.marginTop = '6px';
                    errorDiv.innerHTML = 'Qiymatni kiriting';
                    container.appendChild(errorDiv);
                }
            }
            if (frequencyValue) frequencyValue.classList.add('error');
            isValid = false;
        }
    }
    
    if (!dosageAmount || !dosageAmount.value.trim()) {
        showError('dosageAmountError', 'Doza miqdorini kiriting');
        if (dosageAmount) dosageAmount.classList.add('error');
        isValid = false;
    }
    
    if (!durationDays || !durationDays.value || durationDays.value < 1) {
        showError('durationError', 'Davomiylik 1 kundan kam bo\'lmasligi kerak');
        if (durationDays) durationDays.classList.add('error');
        isValid = false;
    }
    
    if (!prescribedBy || !prescribedBy.value) {
        showError('prescribedByError', 'Shifokorni tanlang');
        if (prescribedBy) prescribedBy.classList.add('error');
        isValid = false;
    }
    
    if (!startDate || !startDate.value) {
        showError('startDateError', 'Boshlash sanasini kiriting');
        if (startDate) startDate.classList.add('error');
        isValid = false;
    }
    
    if (isValid) {
        var saveBtn = document.querySelector('.btn-save');
        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("words.saving") }}';
        }
    }
    return isValid;
}

function showError(elementId, message) {
    var errorEl = document.getElementById(elementId);
    if (errorEl) {
        errorEl.innerHTML = message;
        errorEl.classList.add('show');
    }
}

function updatePrescribedByFields() {
    var select = document.querySelector('.prescribed-by-select');
    var selectedOption = select.selectedOptions[0];
    if (selectedOption && selectedOption.dataset) {
        document.getElementById('prescribedByType').value = selectedOption.dataset.type || '';
        document.getElementById('prescribedById').value = selectedOption.dataset.id || '';
    }
}

function updateMedicationDetails() {
    var select = document.querySelector('.medicine-select');
    var dosageInput = document.getElementById('dosageInput');
    var formInput = document.getElementById('formInput');
    if (select && select.value) {
        var opt = select.selectedOptions[0];
        if (dosageInput) dosageInput.value = opt.dataset.strength || '';
        if (formInput) formInput.value = opt.dataset.form || '';
        var errorEl = document.getElementById('medicineError');
        if (errorEl) errorEl.classList.remove('show');
        select.classList.remove('error');
    }
}

function updateFrequencyFields() {
    var select = document.querySelector('.frequency-type');
    var frequencyType = select ? select.value : '';
    var container = document.getElementById('frequencyContainer');
    if (!container) return;
    
    var html = '';
    switch (frequencyType) {
        case 'hourly':
            html = `
                <label class="notification-label required">${window.Lang.words.every_hours}</label>
                <input type="number" class="form-control" name="frequency_value" min="1" max="24" placeholder="--" required>
            `;
            break;
    
        case 'daily':
            html = `
                <label class="notification-label required">${window.Lang.words.times_per_day}</label>
                <input type="number" class="form-control" name="frequency_value" min="1" max="10" placeholder="--" required>
            `;
            break;
    
        case 'weekly':
            html = `
                <label class="notification-label required">${window.Lang.words.times_per_week}</label>
                <input type="number" class="form-control" name="frequency_value" min="1" max="7" placeholder="--" required>
            `;
            break;
    
        case 'interval':
            html = `
                <label class="notification-label required">${window.Lang.words.every_days}</label>
                <input type="number" class="form-control" name="frequency_value" min="1" placeholder="--" required>
            `;
            break;
    
        case 'as_needed':
            html = `
                <input type="hidden" name="frequency_value" value="1">
                <label class="notification-label">${window.Lang.words.meaning}</label>
                <input type="text" class="form-control" value="${window.Lang.words.as_needed}" readonly>
            `;
            break;
    
        case 'once':
            html = `
                <input type="hidden" name="frequency_value" value="1">
                <label class="notification-label">${window.Lang.words.meaning}</label>
                <input type="text" class="form-control" value="${window.Lang.words.once}" readonly>
            `;
            break;
    
        default:
            html = `
                <label class="notification-label required">&nbsp;</label>
                <div class="placeholder-box">
                    ${window.Lang.words.select_type_first}
                </div>
            `;
    }
    container.innerHTML = html;
    
    var errorEl = document.getElementById('frequencyTypeError');
    if (errorEl) errorEl.classList.remove('show');
    if (select) select.classList.remove('error');
    
    var dynamicError = container.querySelector('.dynamic-error');
    if (dynamicError) dynamicError.remove();
}

function updateSkipReasonField(selectElement, slotId) {
    var skipReasonContainer = document.getElementById('skipReasonContainer' + slotId);
    var selectedValue = selectElement.value;
    
    if (['skipped', 'stopped', 'resumed'].includes(selectedValue)) {
        if (skipReasonContainer) {
            skipReasonContainer.style.display = 'block';
        }
    } else {
        if (skipReasonContainer) {
            skipReasonContainer.style.display = 'none';
        }
    }
    updateSelectStyle(selectElement);
}

function updateSelectStyle(selectElement) {
    var value = selectElement.value;
    var borderColor = '#ddd';
    var bgColor = 'white';
    var textColor = '#000';
    
    switch(value) {
        case 'pending':
            borderColor = '#ddd';
            bgColor = 'white';
            textColor = '#000';
            break;
        case 'given':
            borderColor = '#28a745';
            bgColor = '#d4edda';
            textColor = '#155724';
            break;
        case 'skipped':
            borderColor = '#dc3545';
            bgColor = '#f8d7da';
            textColor = '#721c24';
            break;
        case 'stopped':
            borderColor = '#6c757d';
            bgColor = '#e2e3e5';
            textColor = '#383d41';
            break;
        case 'resumed':
            borderColor = '#17a2b8';
            bgColor = '#d1ecf1';
            textColor = '#0c5460';
            break;
    }
    selectElement.style.borderColor = borderColor;
    selectElement.style.backgroundColor = bgColor;
    selectElement.style.color = textColor;
}

function showMedicationModal(medicationId) {
    var modal = document.getElementById('medicationModal' + medicationId);
    if (modal) {
        modal.showModal();
    }
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.close();
    }
}

// AS NEEDED FORM FUNKSIYALARI - TUZATILGAN
function showAdministerForm(medicationId) {
    console.log('showAdministerForm called for ID:', medicationId);
    var form = document.getElementById('asNeededAdministerForm' + medicationId);
    
    if (form) {
        console.log('Form found, current display:', form.style.display);
        // Formni ko'rsatish
        form.style.display = 'block';
        form.style.transition = 'all 0.3s ease';
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        console.log('Form display set to:', form.style.display);
    } else {
        console.error('Form not found for ID: asNeededAdministerForm' + medicationId);
        // Debug uchun barcha formlarni konsolga chiqarish
        var allForms = document.querySelectorAll('.administer-form');
        console.log('Available forms:', allForms.length);
        allForms.forEach(function(f) {
            console.log('Form ID:', f.id);
        });
    }
}

function hideAdministerForm(medicationId) {
    console.log('hideAdministerForm called for ID:', medicationId);
    var form = document.getElementById('asNeededAdministerForm' + medicationId);
    
    if (form) {
        form.style.display = 'none';
        console.log('Form hidden');
    } else {
        console.error('Form not found for ID: asNeededAdministerForm' + medicationId);
    }
}

function toggleAdministerForm(medicationId) {
    var form = document.getElementById('asNeededAdministerForm' + medicationId);
    if (form) {
        if (form.style.display === 'none' || form.style.display === '') {
            showAdministerForm(medicationId);
        } else {
            hideAdministerForm(medicationId);
        }
    }
}

// MAIN DOM CONTENT LOADED - TO'G'RILANGAN
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - initializing event listeners');
    
    // 1. Dori qo'shish modal tugmalari
    var openBtn = document.getElementById('openMedicationModalBtn');
    if (openBtn) {
        openBtn.addEventListener('click', openMedicationModal);
    }
    
    var emptyStateBtn = document.getElementById('emptyStateAddBtn');
    if (emptyStateBtn) {
        emptyStateBtn.addEventListener('click', openMedicationModal);
    }
    
    var closeModalBtn = document.getElementById('closeMedicationModalBtn');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeMedicationModal);
    }
    
    var cancelBtn = document.getElementById('cancelMedicationBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeMedicationModal);
    }
    
    // 2. Ko'rish tugmalari (modal ochish uchun)
    var viewBtns = document.querySelectorAll('.medication-actions .btn-primary, .medication-actions .btn-primary');
    viewBtns.forEach(function(btn) {
        // Faqat modal ochish uchun - "Berish" tugmasi emas
        var isViewBtn = btn.closest('.medication-actions') && !btn.querySelector('.fa-syringe');
        if (isViewBtn || !btn.querySelector('.fa-syringe')) {
            btn.addEventListener('click', function(e) {
                var id = this.getAttribute('data-id');
                if (id) {
                    showMedicationModal(id);
                }
            });
        }
    });
    
    // 3. Modal yopish tugmalari
    var closeBtns = document.querySelectorAll('.close-btn, .btn-cancel-modal');
    closeBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            if (id) {
                closeModal('medicationModal' + id);
            }
        });
    });
    
    // 4. AS NEEDED - "Berish" tugmalari (MUHIM - TUZATILGAN)
    var administerBtns = document.querySelectorAll('.info-card .btn-primary, .add-action-cell .btn-primary');
    administerBtns.forEach(function(btn) {
        // Eski event listenerlarni olib tashlash
        btn.removeEventListener('click', administerClickHandler);
        btn.addEventListener('click', administerClickHandler);
        console.log('Administer button attached:', btn);
    });
    
    // 5. AS NEEDED - "Bekor qilish" tugmalari
    var cancelAdministerBtns = document.querySelectorAll('.btn-outline-sm');
    cancelAdministerBtns.forEach(function(btn) {
        btn.removeEventListener('click', cancelAdministerClickHandler);
        btn.addEventListener('click', cancelAdministerClickHandler);
        console.log('Cancel button attached:', btn);
    });
    
    // 6. Status selectlar uchun
    var selects = document.querySelectorAll('.status-select');
    selects.forEach(function(select) {
        var slotId = select.getAttribute('data-slot-id');
        if (slotId) {
            updateSkipReasonField(select, slotId);
            if (select.value !== 'pending') {
                updateSelectStyle(select);
            }
            select.addEventListener('change', function() {
                updateSkipReasonField(this, slotId);
                updateSelectStyle(this);
            });
        }
    });
    
    // 7. Modal scroll body fix
    document.querySelectorAll('dialog').forEach(function(dialog) {
        dialog.addEventListener('close', function() {
            var hasOpenDialog = document.querySelector('dialog[open]');
            if (!hasOpenDialog) {
                document.body.style.overflow = '';
            }
        });
    });
});

// Handler funksiyalar
function administerClickHandler(event) {
    event.stopPropagation();
    event.preventDefault();
    var id = this.getAttribute('data-id');
    console.log('Administer button clicked, ID:', id);
    if (id) {
        showAdministerForm(id);
    }
}

function cancelAdministerClickHandler(event) {
    event.stopPropagation();
    event.preventDefault();
    var id = this.getAttribute('data-id');
    console.log('Cancel button clicked, ID:', id);
    if (id) {
        hideAdministerForm(id);
    }
}

// Modal ochiq holda scrollni oldini olish
document.addEventListener('click', function() {
    setTimeout(function() {
        var hasOpenDialog = document.querySelector('dialog[open]');
        if (hasOpenDialog) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }, 10);
});

// Form submit validation
function submitSlotForm(formId) {
    var form = document.getElementById(formId);
    if (form) {
        form.submit();
    }
    return false;
} 