// ================================= MEDICATION LOGIC =================================

let medications = [];
let medicationCounter = 1;
let currentAppointmentId = appointmentData.id;
let savedPrescriptions = [];

// DOM elementlari
const medicationModal = document.getElementById('medicationModal');
const openMedicationBtn = document.getElementById('openMedicationBtn');
const closeModalBtn = document.getElementById('closeModalBtn');
const cancelModalBtn = document.getElementById('cancelModalBtn');
const saveMedicationsBtn = document.getElementById('saveMedicationsBtn');
const addMoreBtn = document.getElementById('addMoreBtn');
const medicationsContainer = document.getElementById('medicationFormsContainer');
const printPrescriptionBtn = document.getElementById('printPrescriptionBtn');
const viewPrescriptionsBtn = document.getElementById('viewPrescriptionsBtn');
const prescriptionsCountSpan = document.getElementById('prescriptionsCount');
const prescriptionsModal = document.getElementById('prescriptionsModal');
const closePrescriptionsModalBtn = document.getElementById('closePrescriptionsModalBtn');
const closePrescriptionsBtn = document.getElementById('closePrescriptionsBtn');
const buttonGroup = document.getElementById('buttonGroup');

// Tugmalar guruhini yangilash
function updateButtonGroup() {
    if (!buttonGroup) return;
    
    if (medications.length > 0) {
        buttonGroup.classList.remove('single-button');
        if (printPrescriptionBtn) {
            printPrescriptionBtn.style.display = 'flex';
        }
    } else {
        buttonGroup.classList.add('single-button');
        if (printPrescriptionBtn) {
            printPrescriptionBtn.style.display = 'none';
        }
    }
}

function getStorageKey() {
    return 'medications_' + currentAppointmentId;
}

function saveToLocalStorage() {
    if (medications.length > 0) {
        localStorage.setItem(getStorageKey(), JSON.stringify(medications));
    } else {
        localStorage.removeItem(getStorageKey());
    }
    updateButtonGroup();
}

function loadFromLocalStorage() {
    const saved = localStorage.getItem(getStorageKey());
    if (saved) {
        try {
            medications = JSON.parse(saved);
            updateMedicationsTable();
            updateButtonGroup();
            return true;
        } catch(e) {
            console.error('Error loading medications:', e);
            return false;
        }
    }
    updateButtonGroup();
    return false;
}

function clearMedications() {
    medications = [];
    updateMedicationsTable();
    saveToLocalStorage();
    updateButtonGroup();
}

function updatePrescriptionsButton(count) {
    if (viewPrescriptionsBtn) {
        if (count > 0) {
            viewPrescriptionsBtn.style.display = 'inline-flex';
            if (prescriptionsCountSpan) {
                prescriptionsCountSpan.textContent = count;
            }
        } else {
            viewPrescriptionsBtn.style.display = 'none';
        }
    }
}

function loadSavedPrescriptions() {
    fetch('/prescriptions/' + currentAppointmentId, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.prescriptions) {
            savedPrescriptions = data.prescriptions;
            updatePrescriptionsButton(savedPrescriptions.length);
        } else {
            savedPrescriptions = [];
            updatePrescriptionsButton(0);
        }
    })
    .catch(error => {
        console.error('Error loading prescriptions:', error);
        savedPrescriptions = [];
        updatePrescriptionsButton(0);
    });
}

function openPrescriptionsModal() {
    if (prescriptionsModal) {
        displayPrescriptions();
        prescriptionsModal.showModal();
        document.body.classList.add('modal-open');
    }
}

function displayPrescriptions() {
    const tbody = document.getElementById('prescriptionsTableBody');
    const tableContainer = document.getElementById('prescriptionsTableContainer');
    const noText = document.getElementById('noPrescriptionsText');
    
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (!savedPrescriptions || savedPrescriptions.length === 0) {
        if (tableContainer) tableContainer.style.display = 'none';
        if (noText) noText.style.display = 'block';
        return;
    }
    
    if (tableContainer) tableContainer.style.display = 'block';
    if (noText) noText.style.display = 'none';
    
    for (let i = 0; i < savedPrescriptions.length; i++) {
        const p = savedPrescriptions[i];
        const row = tbody.insertRow();
        
        const medicineName = p.medicine_name || p.name || '';
        const dosage = p.dosage || '-';
        const form = p.form || '-';
        const usageText = p.usage_text || p.usage || '-';
        const durationDays = p.duration_days || p.duration || '-';
        const note = p.note || '-';
        
        row.innerHTML = `
            <td><strong>${escapeHtml(String(medicineName))}</strong></td>
            <td>${escapeHtml(String(dosage))}</td>
            <td>${escapeHtml(String(form))}</td>
            <td>${escapeHtml(String(usageText))}</td>
            <td>${escapeHtml(String(durationDays))} kun</td>
            <td>${escapeHtml(String(note))}</td>
        `;
    }
}

function closePrescriptionsModal() {
    if (prescriptionsModal) {
        prescriptionsModal.close();
        document.body.classList.remove('modal-open');
    }
}

function openMedicationModal() {
    if (medicationModal) {
        medicationModal.showModal();
        document.body.classList.add('modal-open');
    }
}

function closeMedicationModal() {
    if (medicationModal) {
        medicationModal.close();
        document.body.classList.remove('modal-open');
    }
}

function addMedicationForm() {
    const template = document.querySelector('.medication-form-group');
    if (!template) return;
    
    const newForm = template.cloneNode(true);
    const newIndex = medicationCounter++;
    
    newForm.setAttribute('data-index', newIndex);
    
    const header = newForm.querySelector('h4');
    if (header) header.innerHTML = '<i class="fas fa-pills"></i> Dori ' + medicationCounter;
    
    const select = newForm.querySelector('.medication-name');
    if (select) {
        select.id = 'medNameSelect_' + newIndex;
        select.value = '';
        select.setAttribute('data-index', newIndex);
        select.addEventListener('change', function() {
            updateMedicationDetails(newIndex);
        });
    }
    
    const dosage = newForm.querySelector('.medication-dosage');
    if (dosage) {
        dosage.id = 'dosageInput' + newIndex;
        dosage.value = '';
        dosage.readOnly = true;
        dosage.disabled = true;
        dosage.style.backgroundColor = '#e9ecef';
    }
    
    const formEl = newForm.querySelector('.medication-form');
    if (formEl) {
        formEl.id = 'formInput' + newIndex;
        formEl.value = '';
        formEl.readOnly = true;
        formEl.disabled = true;
        formEl.style.backgroundColor = '#e9ecef';
    }
    
    const freqType = newForm.querySelector('.medication-frequency-type');
    if (freqType) {
        freqType.id = 'frequencyType' + newIndex;
        freqType.value = '';
        freqType.setAttribute('data-index', newIndex);
        freqType.addEventListener('change', function() {
            updateFrequencyFields(newIndex);
        });
    }
    
    const amount = newForm.querySelector('.medication-dosage-amount');
    if (amount) amount.id = 'dosageAmount' + newIndex;
    
    const duration = newForm.querySelector('.medication-duration');
    if (duration) duration.id = 'durationInput' + newIndex;
    
    const note = newForm.querySelector('.medication-note');
    if (note) note.id = 'noteInput' + newIndex;
    
    const freqContainer = newForm.querySelector('.frequency-container');
    if (freqContainer) freqContainer.id = 'frequencyContainer' + newIndex;
    
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'remove-btn';
    removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
    removeBtn.onclick = function() { removeMedicationForm(newIndex); };
    newForm.appendChild(removeBtn);
    
    medicationsContainer.appendChild(newForm);
}

function updateMedicationDetails(idx) {
    const select = document.getElementById('medNameSelect_' + idx);
    const dosage = document.getElementById('dosageInput' + idx);
    const form = document.getElementById('formInput' + idx);
    
    if (select && select.selectedIndex > 0) {
        const option = select.options[select.selectedIndex];
        const dosageVal = option.getAttribute('data-dosage') || '';
        const formVal = option.getAttribute('data-form') || '';
        
        if (dosage) dosage.value = dosageVal;
        if (form) form.value = formVal;
    } else {
        if (dosage) dosage.value = '';
        if (form) form.value = '';
    }
}

function updateFrequencyFields(idx) {
    const typeSelect = document.getElementById('frequencyType' + idx);
    if (!typeSelect) return;
    
    const type = typeSelect.value;
    const container = document.getElementById('frequencyContainer' + idx);
    if (!container) return;
    
    const hourlyDiv = document.getElementById('hourlyTemplate');
    const dailyDiv = document.getElementById('dailyTemplate');
    const weeklyDiv = document.getElementById('weeklyTemplate');
    const asNeededDiv = document.getElementById('asNeededTemplate');
    const onceDiv = document.getElementById('onceTemplate');
    
    container.innerHTML = '';
    
    if (type === 'hourly' && hourlyDiv) {
        const clone = hourlyDiv.cloneNode(true);
        clone.id = 'hourlyDiv_' + idx;
        clone.style.display = 'block';
        const select = clone.querySelector('select');
        if (select) select.id = 'hourlyInterval_' + idx;
        container.appendChild(clone);
    } 
    else if (type === 'daily' && dailyDiv) {
        const clone = dailyDiv.cloneNode(true);
        clone.id = 'dailyDiv_' + idx;
        clone.style.display = 'block';
        const input = clone.querySelector('input');
        if (input) input.id = 'dailyFrequency_' + idx;
        container.appendChild(clone);
    } 
    else if (type === 'weekly' && weeklyDiv) {
        const clone = weeklyDiv.cloneNode(true);
        clone.id = 'weeklyDiv_' + idx;
        clone.style.display = 'block';
        const select = clone.querySelector('select');
        if (select) select.id = 'weeklyFrequency_' + idx;
        container.appendChild(clone);
    } 
    else if (type === 'as_needed' && asNeededDiv) {
        const clone = asNeededDiv.cloneNode(true);
        clone.id = 'asNeededDiv_' + idx;
        clone.style.display = 'block';
        container.appendChild(clone);
    } 
    else if (type === 'once' && onceDiv) {
        const clone = onceDiv.cloneNode(true);
        clone.id = 'onceDiv_' + idx;
        clone.style.display = 'block';
        container.appendChild(clone);
    }
}

function removeMedicationForm(idx) {
    const forms = document.querySelectorAll('.medication-form-group');
    if (forms.length <= 1) {
        alert("Kamida bitta dori qolishi kerak!");
        return;
    }
    const formToRemove = document.querySelector('.medication-form-group[data-index="' + idx + '"]');
    if (formToRemove) formToRemove.remove();
}

function saveMedications() {
    const forms = document.querySelectorAll('.medication-form-group');
    const temp = [];
    
    for (let i = 0; i < forms.length; i++) {
        const f = forms[i];
        const idx = f.getAttribute('data-index');
        
        const select = document.getElementById('medNameSelect_' + idx);
        const mid = select?.value;
        if (!mid) { 
            alert('Dori nomi tanlanmagan'); 
            return; 
        }
        
        const freqType = document.getElementById('frequencyType' + idx)?.value;
        if (!freqType) { 
            alert('Istemol turi tanlanmagan'); 
            return; 
        }
        
        const dosageAmount = document.getElementById('dosageAmount' + idx)?.value;
        if (!dosageAmount) { 
            alert('Doza miqdori kiriting'); 
            return; 
        }
        
        const duration = document.getElementById('durationInput' + idx)?.value;
        if (!duration) { 
            alert('Davomiylik kiriting'); 
            return; 
        }
        
        let freqVal = '';
        if (freqType === 'hourly') freqVal = document.getElementById('hourlyInterval_' + idx)?.value || '';
        else if (freqType === 'daily') freqVal = document.getElementById('dailyFrequency_' + idx)?.value || '';
        else if (freqType === 'weekly') freqVal = document.getElementById('weeklyFrequency_' + idx)?.value || '';
        
        let usage = '';
        if (freqType === 'hourly') usage = 'Har ' + freqVal + ' soatda, ' + dosageAmount;
        else if (freqType === 'daily') usage = 'Kuniga ' + freqVal + ' marta, ' + dosageAmount;
        else if (freqType === 'weekly') usage = 'Haftasiga ' + freqVal + ' marta, ' + dosageAmount;
        else if (freqType === 'as_needed') usage = 'Ehtiyoj bo\'lganda, ' + dosageAmount;
        else if (freqType === 'once') usage = 'Bir marta, ' + dosageAmount;
        
        const note = document.getElementById('noteInput' + idx)?.value || '';
        const dosage = document.getElementById('dosageInput' + idx)?.value || '';
        const formEl = document.getElementById('formInput' + idx)?.value || '';
        const name = select.options[select.selectedIndex]?.text || 'Noma\'lum';
        
        temp.push({
            id: mid, name: name, dosage: dosage, form: formEl,
            frequencyType: freqType, frequencyValue: freqVal,
            dosageAmount: dosageAmount, usage: usage, duration: duration, note: note
        });
    }
    
    if (temp.length === 0) { 
        alert('Kamida bitta dori qo\'shing'); 
        return; 
    }
    
    medications = temp;
    updateMedicationsTable();
    saveToLocalStorage();
    closeMedicationModal();
    updateButtonGroup();
    alert(medications.length + ' ta dori vaqtinchalik saqlandi!');
}

function updateMedicationsTable() {
    const tbody = document.getElementById('medicationsTableBody');
    const table = document.getElementById('medicationsTable');
    const noText = document.getElementById('noMedicationsText');
    
    if (!tbody) return;
    
    tbody.innerHTML = '';
    if (medications.length === 0) {
        if (table) table.style.display = 'none';
        if (noText) noText.style.display = 'block';
        updateButtonGroup();
        return;
    }
    
    if (table) table.style.display = 'table';
    if (noText) noText.style.display = 'none';
    
    for (let i = 0; i < medications.length; i++) {
        const m = medications[i];
        const row = tbody.insertRow();
        row.innerHTML = `
            <td><strong>${escapeHtml(String(m.name))}</strong></td>
            <td><strong>${escapeHtml(String(m.form || '-'))}</strong></td>
            <td>${escapeHtml(String(m.usage))}</td>
            <td>${escapeHtml(String(m.duration))} kun</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeMedFromTable(${i})"><i class="fas fa-trash"></i></button></td>
        `;
    }
    
    updateButtonGroup();
}

function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    if (typeof str !== 'string') str = String(str);
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

window.removeMedFromTable = function(i) {
    if (confirm('O\'chirilsinmi?')) {
        medications.splice(i, 1);
        updateMedicationsTable();
        saveToLocalStorage();
        updateButtonGroup();
    }
}

function printAndStorePrescription() {
    if (medications.length === 0) {
        alert('Chop etish uchun retsept mavjud emas!');
        return;
    }
    openPrintWindow();
}

function openPrintWindow() {
    let medicationsHtml = '';
    for (let i = 0; i < medications.length; i++) {
        const m = medications[i];
        medicationsHtml += `
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">${escapeHtml(String(m.name))}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${escapeHtml(String(m.form || '-'))}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${escapeHtml(String(m.dosage || '-'))}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${escapeHtml(String(m.usage))}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${escapeHtml(String(m.duration))} kun</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${escapeHtml(String(m.note || '-'))}</td>
            </tr>
        `;
    }
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head><title>Retsept</title><meta charset="UTF-8">
        <style>
            body { font-family: Arial; margin: 40px; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background: #3498db; color: white; }
            @media print { body { margin: 0; padding: 20px; } }
        </style>
        </head>
        <body>
            <h2>RETSEPT</h2>
            <p><strong>Bemor:</strong> ${escapeHtml(String(appointmentData.patientLastName))} ${escapeHtml(String(appointmentData.patientName))}</p>
            <p><strong>Yoshi:</strong> ${appointmentData.patientAge}</p>
            <p><strong>Sana:</strong> ${new Date().toLocaleDateString()}</p>
            <table class="medications-table" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr><th style="border:1px solid #ddd; padding:8px;">Dori</th><th style="border:1px solid #ddd; padding:8px;">Forma</th><th style="border:1px solid #ddd; padding:8px;">Doza</th><th style="border:1px solid #ddd; padding:8px;">Qabul qilish</th><th style="border:1px solid #ddd; padding:8px;">Davomiylik</th><th style="border:1px solid #ddd; padding:8px;">Izoh</th></tr>
                </thead>
                <tbody>${medicationsHtml}</tbody>
            </table>
            <p><strong>Shifokor:</strong> ${escapeHtml(String(appointmentData.doctorName))}</p>
            <script>window.onload = function() { window.print(); window.close(); }</script>
        </body>
        </html>
    `);
    printWindow.document.close();
    
    setTimeout(function() {
        storePrescriptionToDatabase();
    }, 1000);
}

function storePrescriptionToDatabase() {
    const fields = document.getElementById('medicationsFormFields');
    if (fields) {
        fields.innerHTML = '';
        for (let i = 0; i < medications.length; i++) {
            const m = medications[i];
            fields.innerHTML += `
                <input type="hidden" name="medications[${i}][medicine_id]" value="${escapeHtml(String(m.id))}">
                <input type="hidden" name="medications[${i}][dosage]" value="${escapeHtml(String(m.dosage))}">
                <input type="hidden" name="medications[${i}][form]" value="${escapeHtml(String(m.form))}">
                <input type="hidden" name="medications[${i}][frequency_type]" value="${escapeHtml(String(m.frequencyType))}">
                <input type="hidden" name="medications[${i}][frequency_value]" value="${escapeHtml(String(m.frequencyValue))}">
                <input type="hidden" name="medications[${i}][dosage_amount]" value="${escapeHtml(String(m.dosageAmount))}">
                <input type="hidden" name="medications[${i}][usage]" value="${escapeHtml(String(m.usage))}">
                <input type="hidden" name="medications[${i}][duration]" value="${escapeHtml(String(m.duration))}">
                <input type="hidden" name="medications[${i}][note]" value="${escapeHtml(String(m.note))}">
            `;
        }
    }
    
    const medForm = document.getElementById('medicationsForm');
    const formData = new FormData(medForm);
    
    fetch(medForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            clearMedications();
            loadSavedPrescriptions();
            alert('Retsept muvaffaqiyatli saqlandi!');
        } else {
            alert('Xatolik: ' + (data.message || 'Noma\'lum xatolik'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Xatolik yuz berdi');
    });
}

function submitAllForms() {
    document.getElementById('diagnosisInput').value = document.getElementById('diagnosisField')?.value || '';
    document.getElementById('fullDiagnosisInput').value = document.getElementById('fullDiagnosisField')?.value || '';
    document.getElementById('treatmentTypeInput').value = selectedTreatmentType;
    document.getElementById('departmentInput').value = document.getElementById('departmentField')?.value || '';
    document.getElementById('urgencyInput').value = document.getElementById('urgencyField')?.value || '';
    document.getElementById('referralReasonInput').value = document.getElementById('referralReasonField')?.value || '';
    document.getElementById('recommendationsInput').value = document.getElementById('recommendationsField')?.value || '';
    document.getElementById('mainTreatmentForm').submit();
}

let selectedTreatmentType = 'outpatient';

function selectHospitalization(type) {
    selectedTreatmentType = type;
    const outpatient = document.getElementById('outpatientOption');
    const inpatient = document.getElementById('inpatientOption');
    const referral = document.getElementById('referralForm');
    const recommendations = document.getElementById('recommendationsSection');
    
    if (outpatient) outpatient.classList.toggle('selected', type === 'outpatient');
    if (inpatient) inpatient.classList.toggle('selected', type === 'inpatient');
    if (referral) referral.classList.toggle('show', type === 'inpatient');
    if (recommendations) recommendations.style.display = type === 'inpatient' ? 'none' : 'block';
}

document.addEventListener('DOMContentLoaded', function() {
    if (openMedicationBtn) openMedicationBtn.addEventListener('click', openMedicationModal);
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeMedicationModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeMedicationModal);
    if (saveMedicationsBtn) saveMedicationsBtn.addEventListener('click', saveMedications);
    if (addMoreBtn) addMoreBtn.addEventListener('click', addMedicationForm);
    if (printPrescriptionBtn) printPrescriptionBtn.addEventListener('click', printAndStorePrescription);
    if (viewPrescriptionsBtn) viewPrescriptionsBtn.addEventListener('click', openPrescriptionsModal);
    if (closePrescriptionsModalBtn) closePrescriptionsModalBtn.addEventListener('click', closePrescriptionsModal);
    if (closePrescriptionsBtn) closePrescriptionsBtn.addEventListener('click', closePrescriptionsModal);
    
    const submitBtn = document.getElementById('submitAllBtn');
    if (submitBtn) submitBtn.addEventListener('click', submitAllForms);
    
    const outpatientOption = document.getElementById('outpatientOption');
    const inpatientOption = document.getElementById('inpatientOption');
    if (outpatientOption) outpatientOption.addEventListener('click', function() { selectHospitalization('outpatient'); });
    if (inpatientOption) inpatientOption.addEventListener('click', function() { selectHospitalization('inpatient'); });
    
    loadFromLocalStorage();
    loadSavedPrescriptions();
    selectHospitalization('outpatient');
    updateButtonGroup();
    
    const firstSelect = document.getElementById('medNameSelect_0');
    const firstFreqType = document.getElementById('frequencyType0');
    if (firstSelect) firstSelect.addEventListener('change', function() { updateMedicationDetails(0); });
    if (firstFreqType) firstFreqType.addEventListener('change', function() { updateFrequencyFields(0); });
});