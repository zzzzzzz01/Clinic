<style>
    /* Discharge modal uchun maxsus stillar */
    #dischargePatientModal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 95%;
        max-width: 600px;
        border: none;
        border-radius: 16px;
        padding: 0;
        background: white;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        z-index: 1001;
        overflow: hidden;
    }

    #dischargePatientModal::backdrop {
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
    }

    #dischargePatientModal .modal-header {
        background: #f59e0b;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    #dischargePatientModal .modal-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 150px;
        height: 150px;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        border-radius: 50%;
        pointer-events: none;
    }

    #dischargePatientModal .modal-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    #dischargePatientModal .modal-header h3 i {
        font-size: 16px;
    }

    #dischargePatientModal .close-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 16px;
        cursor: pointer;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s ease;
        position: relative;
        z-index: 1;
    }

    #dischargePatientModal .close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    #dischargePatientModal .modal-body {
        padding: 20px;
        overflow-y: auto;
        max-height: calc(90vh - 130px);
        background: linear-gradient(to bottom, #ffffff, #fafafa);
    }

    #dischargePatientModal .form-group {
        margin-bottom: 15px;
        position: relative;
    }

    #dischargePatientModal .form-group:last-child {
        margin-bottom: 0;
    }

    #dischargePatientModal .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #2d3748;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    #dischargePatientModal .form-group label::before {
        content: '';
        display: block;
        width: 3px;
        height: 12px;
        background: #f59e0b;
        border-radius: 2px;
    }

    #dischargePatientModal .form-control {
        width: 100%;
        padding: 8px 10px;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        font-size: 13px;
        box-sizing: border-box;
        background: white;
        color: #2d3748;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    #dischargePatientModal .form-control:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.15);
        background: #fff7e6;
    }

    #dischargePatientModal .patients-list {
        max-height: 250px;
        overflow-y: auto;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        margin-bottom: 15px;
    }

    #dischargePatientModal .patient-item {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    #dischargePatientModal .patient-item:last-child {
        border-bottom: none;
    }

    #dischargePatientModal .patient-item:hover {
        background: #fff7e6;
        border-left: 4px solid #f59e0b;
    }

    #dischargePatientModal .patient-item.selected {
        background: #fff7e6;
        border-left: 4px solid #f59e0b;
    }

    #dischargePatientModal .patient-avatar {
        width: 40px;
        height: 40px;
        background: #f59e0b;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
        flex-shrink: 0;
    }

    #dischargePatientModal .patient-info {
        flex: 1;
    }

    #dischargePatientModal .patient-name {
        font-weight: 600;
        font-size: 14px;
        color: #2d3748;
        margin-bottom: 4px;
    }

    #dischargePatientModal .patient-details {
        font-size: 11px;
        color: #718096;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    #dischargePatientModal .patient-details span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    #dischargePatientModal .patient-details i {
        font-size: 9px;
        color: #f59e0b;
    }

    #dischargePatientModal .no-patients-message {
        text-align: center;
        padding: 30px;
        color: #718096;
        background: #f8fafc;
        border-radius: 8px;
        border: 2px dashed #e2e8f0;
    }

    #dischargePatientModal .no-patients-message i {
        font-size: 40px;
        color: #f59e0b80;
        margin-bottom: 10px;
    }

    #dischargePatientModal .selected-patient-info {
        background: #fff7e6;
        border: 2px solid #f59e0b;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #dischargePatientModal .selected-patient-info p {
        margin: 0;
        color: #2d3748;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #dischargePatientModal .selected-patient-info i {
        color: #f59e0b;
        width: 20px;
        text-align: center;
    }

    #dischargePatientModal .modal-footer {
        padding: 15px 20px;
        background: #f8fafc;
        border-top: 2px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    #dischargePatientModal .btn-secondary {
        background: white;
        color: #4a5568;
        border: 2px solid #cbd5e0;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    #dischargePatientModal .btn-secondary:hover {
        background: #f7fafc;
        border-color: #a0aec0;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    #dischargePatientModal .btn-danger {
        background: #f59e0b;
        color: white;
        border: 2px solid #f59e0b;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    #dischargePatientModal .btn-danger:hover:not(:disabled) {
        background: #e08e0b;
        border-color: #e08e0b;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    #dischargePatientModal .btn-danger:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Responsive stillar */
    @media (min-width: 768px) {
        #dischargePatientModal {
            max-width: 700px;
        }
    }

    @media (min-width: 1200px) {
        #dischargePatientModal {
            max-width: 800px;
        }
    }

    @media (max-width: 576px) {
        #dischargePatientModal {
            max-width: 95%;
            border-radius: 12px;
        }

        #dischargePatientModal .modal-header {
            padding: 12px 16px;
        }

        #dischargePatientModal .modal-header h3 {
            font-size: 14px;
        }

        #dischargePatientModal .modal-header h3 i {
            font-size: 14px;
        }

        #dischargePatientModal .close-btn {
            width: 28px;
            height: 28px;
            font-size: 14px;
        }

        #dischargePatientModal .modal-body {
            padding: 16px;
            max-height: calc(95vh - 120px);
        }

        #dischargePatientModal .form-group label {
            font-size: 10px;
        }

        #dischargePatientModal .form-control {
            padding: 7px 9px;
            font-size: 12px;
        }

        #dischargePatientModal .patients-list {
            max-height: 200px;
        }

        #dischargePatientModal .patient-item {
            padding: 10px;
            gap: 10px;
        }

        #dischargePatientModal .patient-avatar {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }

        #dischargePatientModal .patient-name {
            font-size: 13px;
        }

        #dischargePatientModal .patient-details {
            font-size: 10px;
            gap: 10px;
        }

        #dischargePatientModal .selected-patient-info {
            padding: 12px;
        }

        #dischargePatientModal .selected-patient-info p {
            font-size: 12px;
        }

        #dischargePatientModal .modal-footer {
            padding: 12px 16px;
        }

        #dischargePatientModal .btn-secondary,
        #dischargePatientModal .btn-danger {
            padding: 7px 14px;
            font-size: 11px;
        }
    }

    @media (max-width: 375px) {
        #dischargePatientModal .patient-details {
            flex-direction: column;
            gap: 5px;
        }

        #dischargePatientModal .modal-footer {
            flex-direction: column;
        }

        #dischargePatientModal .modal-footer button {
            width: 100%;
        }
    }
</style>

<!-- Discharge Patient Modal -->
<dialog id="dischargePatientModal" class="discharge-modal">
    <div class="modal-header">
        <h3>
            <i class="fas fa-sign-out-alt"></i>
            @lang('words.discharge_patient'): @lang('words.room') <span id="dischargeRoomNumber"></span>
        </h3>
        <button class="close-btn" onclick="closeDischargePatientModal()">✕</button>
    </div>

    <form id="dischargePatientForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <!-- Bo'shatiladigan bemorni tanlash -->
            <div class="form-group">
                <label>@lang('words.select_patient_to_discharge')</label>
                <div id="patientsList" class="patients-list"></div>
                <div id="noPatientsMessage" class="no-patients-message" style="display: none;">
                    <i class="fas fa-info-circle"></i>
                    <p>@lang('words.no_patients_in_this_room')</p>
                </div>
            </div>

            <!-- Tanlangan bemor ma'lumotlari -->
            <div id="selectedPatientInfo" class="selected-patient-info" style="display: none;">
                <!-- Dinamik to'ldiriladi -->
            </div>

            <!-- Bo'shatish vaqti -->
            <div class="form-group">
                <label>@lang('words.discharge_date')</label>
                <input type="datetime-local" 
                    id="dischargeDate" 
                    name="discharge_date" 
                    class="form-control" 
                    value="{{ now()->format('Y-m-d\TH:i') }}"
                    required>
            </div>

            <!-- Izoh -->
            <div class="form-group">
                <label>@lang('words.notes')</label>
                <textarea id="dischargeNotes" name="discharge_notes" class="form-control" rows="3" placeholder="@lang('words.additional_notes_placeholder')"></textarea>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" id="dischargeRoomId" name="room_id">
            <input type="hidden" id="dischargeBedId" name="bed_id">
            <input type="hidden" id="dischargeHospitalizationId" name="hospitalization_id">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDischargePatientModal()">
                <i class="fas fa-times"></i> @lang('words.cancel')
            </button>
            <button type="submit" class="btn-danger" id="confirmDischargePatient" disabled>
                <i class="fas fa-sign-out-alt"></i> @lang('words.discharge')
            </button>
        </div>
    </form>
</dialog>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM elementlar
            const dischargePatientModal = document.getElementById('dischargePatientModal');
            const dischargeRoomNumber = document.getElementById('dischargeRoomNumber');
            const dischargeRoomId = document.getElementById('dischargeRoomId');
            const dischargeBedId = document.getElementById('dischargeBedId');
            const dischargeHospitalizationId = document.getElementById('dischargeHospitalizationId');
            const dischargeDate = document.getElementById('dischargeDate');
            const dischargeNotes = document.getElementById('dischargeNotes');
            const patientsList = document.getElementById('patientsList');
            const noPatientsMessage = document.getElementById('noPatientsMessage');
            const selectedPatientInfo = document.getElementById('selectedPatientInfo');
            const confirmDischargeBtn = document.getElementById('confirmDischargePatient');

            // Sana formatlash funksiyasi
            function formatDate(dateString) {
                if (!dateString) return 'Noma\'lum';
                
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return 'Noma\'lum';
                
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                
                return `${day}.${month}.${year} | ${hours}:${minutes}`;
            }

            // Bemorlar ro'yxatini ko'rsatish
            function displayPatientsList(patients) {
                if (!patientsList) return;
                
                if (!patients || patients.length === 0) {
                    patientsList.style.display = 'none';
                    if (noPatientsMessage) noPatientsMessage.style.display = 'block';
                    return;
                }
                
                patientsList.style.display = 'block';
                if (noPatientsMessage) noPatientsMessage.style.display = 'none';
                
                let html = '';
                patients.forEach((patient, index) => {
                    // Bed ma'lumotlarini olish
                    let bedId = patient.bed_id || '';
                    let bedNumber = patient.bed_number || '';
                    
                    // hospitalization_room orqali
                    if (patient.hospitalization_room && patient.hospitalization_room.bed) {
                        bedId = patient.hospitalization_room.bed.id || bedId;
                        bedNumber = patient.hospitalization_room.bed.number || bedNumber;
                    }
                    
                    // hospitalizationRooms orqali
                    if ((!bedId || !bedNumber) && patient.hospitalizationRooms) {
                        const firstKey = Object.keys(patient.hospitalizationRooms)[0];
                        if (firstKey && patient.hospitalizationRooms[firstKey].bed) {
                            bedId = patient.hospitalizationRooms[firstKey].bed.id || bedId;
                            bedNumber = patient.hospitalizationRooms[firstKey].bed.number || bedNumber;
                        }
                    }
                    
                    // Bemor ismi
                    const patientName = patient.patient_name || 
                                    (patient.patient ? 
                                        (patient.patient.last_name + ' ' + patient.patient.name) : 
                                        'Noma\'lum');
                    
                    // Initiallar
                    const nameParts = patientName.split(' ');
                    const initials = nameParts.map(n => n.charAt(0)).join('').substring(0, 2).toUpperCase();
                    
                    // Doktor ismi
                    const doctorName = patient.doctor_name || 
                                    (patient.doctor ? 
                                        (patient.doctor.last_name + ' ' + patient.doctor.name) : 
                                        '--');
                    
                    // Yotqizilgan vaqt
                    const admissionDate = patient.admission_date || patient.created_at;
                    const formattedAdmissionDate = formatDate(admissionDate);
                    
                    // Hospitalization ID
                    const hospitalizationId = patient.hospitalization_id || patient.id || '';
                    
                    html += `
                        <div class="patient-item" 
                            data-hospitalization-id="${hospitalizationId}"
                            data-bed-id="${bedId}"
                            data-patient-name="${patientName.replace(/"/g, '&quot;')}"
                            data-doctor-name="${doctorName.replace(/"/g, '&quot;')}"
                            data-admission-date="${admissionDate || ''}"
                            data-bed-number="${bedNumber}">
                            <div class="patient-avatar">${initials || 'B'}</div>
                            <div class="patient-info">
                                <div class="patient-name">${patientName}</div>
                                <div class="patient-details">
                                    <span><i class="fas fa-user-md"></i> ${doctorName}</span>
                                    <span><i class="fas fa-bed"></i> O'rin: ${bedNumber || '--'}</span>
                                    <span><i class="fas fa-calendar-alt"></i> ${formattedAdmissionDate}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                patientsList.innerHTML = html;
                
                // Patient item larga click event qo'shish
                document.querySelectorAll('.patient-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const hospitalizationId = this.dataset.hospitalizationId;
                        const bedId = this.dataset.bedId;
                        const patientName = this.dataset.patientName;
                        const doctorName = this.dataset.doctorName;
                        const admissionDate = this.dataset.admissionDate;
                        const bedNumber = this.dataset.bedNumber;
                        
                        selectPatientForDischarge(hospitalizationId, bedId, patientName, doctorName, admissionDate, bedNumber, this);
                    });
                });
            }

            // Bemorni tanlash
            function selectPatientForDischarge(hospitalizationId, bedId, patientName, doctorName, admissionDate, bedNumber, element) {
                if (!dischargeHospitalizationId || !dischargeBedId || !selectedPatientInfo || !confirmDischargeBtn) {
                    console.error('Required elements not found');
                    return;
                }
                
                // Ma'lumotlarni o'rnatish
                dischargeHospitalizationId.value = hospitalizationId;
                dischargeBedId.value = bedId;
                
                // Oldingi tanlanganlarni tozalash
                document.querySelectorAll('.patient-item').forEach(item => {
                    item.classList.remove('selected');
                });
                
                // Yangi tanlanganni highlight qilish
                if (element) {
                    element.classList.add('selected');
                }
                
                // Tanlangan bemor ma'lumotlarini ko'rsatish
                const admissionDateFormatted = formatDate(admissionDate);
                
                selectedPatientInfo.innerHTML = `
                    <p><i class="fas fa-user"></i> <strong>Tanlangan bemor:</strong> ${patientName}</p>
                    <p><i class="fas fa-user-md"></i> <strong>Shifokor:</strong> ${doctorName}</p>
                    <p><i class="fas fa-bed"></i> <strong>O'rin:</strong> ${bedNumber}</p>
                    <p><i class="fas fa-calendar-alt"></i> <strong>Yotqizilgan vaqt:</strong> ${admissionDateFormatted}</p>
                `;
                
                selectedPatientInfo.style.display = 'flex';
                selectedPatientInfo.style.flexDirection = 'column';
                
                // Tugmani aktivlashtirish
                confirmDischargeBtn.disabled = false;
            }

            // Discharge modalni ochish
            window.openDischargePatientModal = function(roomId, roomNumber, patients) {
                console.log('📋 Opening modal with patients:', patients);
                console.log('📋 Patients count:', patients ? patients.length : 0);
                
                // Debug - patients ma'lumotlarini tekshirish
                if (patients && patients.length > 0) {
                    patients.forEach((p, i) => {
                        console.log(`Patient ${i+1}:`, {
                            id: p.id || p.hospitalization_id,
                            name: p.patient_name,
                            bed_id: p.bed_id,
                            bed_number: p.bed_number,
                            has_hospitalization_room: !!p.hospitalization_room,
                            has_hospitalizationRooms: !!p.hospitalizationRooms
                        });
                    });
                }
                
                // Ma'lumotlarni o'rnatish
                if (dischargeRoomId) dischargeRoomId.value = roomId;
                if (dischargeRoomNumber) dischargeRoomNumber.textContent = roomNumber;
                
                // Ro'yxatlarni tozalash
                if (patientsList) patientsList.innerHTML = '';
                if (selectedPatientInfo) {
                    selectedPatientInfo.style.display = 'none';
                    selectedPatientInfo.innerHTML = '';
                }
                
                // Bemorlar ro'yxatini ko'rsatish
                displayPatientsList(patients);
                
                // Modalni ochish
                if (dischargePatientModal) {
                    dischargePatientModal.showModal();
                    document.body.classList.add('modal-open');
                    document.body.style.overflow = 'hidden';
                }
                
                // Formani reset qilish
                if (dischargeNotes) dischargeNotes.value = '';
                if (dischargeBedId) dischargeBedId.value = '';
                if (dischargeHospitalizationId) dischargeHospitalizationId.value = '';
                if (confirmDischargeBtn) confirmDischargeBtn.disabled = true;
            };

            // Discharge modalni yopish
            window.closeDischargePatientModal = function() {
                if (!dischargePatientModal) return;
                
                dischargePatientModal.close();
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                
                // Tozalash
                if (patientsList) {
                    patientsList.innerHTML = '';
                    patientsList.style.display = 'block';
                }
                if (selectedPatientInfo) {
                    selectedPatientInfo.style.display = 'none';
                    selectedPatientInfo.innerHTML = '';
                }
                if (noPatientsMessage) noPatientsMessage.style.display = 'none';
                if (dischargeNotes) dischargeNotes.value = '';
                if (dischargeBedId) dischargeBedId.value = '';
                if (dischargeHospitalizationId) dischargeHospitalizationId.value = '';
                if (confirmDischargeBtn) confirmDischargeBtn.disabled = true;
            };

            // Form submit
            document.getElementById('dischargePatientForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validatsiya
                if (!dischargeHospitalizationId || !dischargeBedId || !dischargeDate) {
                    alert('Form elementlari topilmadi');
                    return;
                }
                
                if (!dischargeHospitalizationId.value || !dischargeBedId.value || !dischargeDate.value) {
                    alert('Iltimos, barcha maydonlarni to\'ldiring');
                    return;
                }
                
                const roomId = dischargeRoomId.value;
                
                // Tugmani disable qilish
                if (confirmDischargeBtn) {
                    confirmDischargeBtn.disabled = true;
                    confirmDischargeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Bo\'shatilmoqda...';
                }
                
                // Form data
                const formData = {
                    hospitalization_id: dischargeHospitalizationId.value,
                    bed_id: dischargeBedId.value,
                    discharge_date: dischargeDate.value,
                    discharge_notes: dischargeNotes ? dischargeNotes.value : ''
                };
                
                console.log('Sending discharge data:', formData);
                
                // AJAX so'rov
                fetch(`/rooms/${roomId}/discharge-patient`, {
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
                            throw new Error(text);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Muvaffaqiyatli bo'lsa
                        localStorage.setItem('alertMessage', data.message);
                        localStorage.setItem('alertType', 'success');
                        
                        // Modalni yopish
                        closeDischargePatientModal();
                        
                        // Sahifani yangilash
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        // Xatolik bo'lganda
                        const errorMessage = data.message || 'Xatolik yuz berdi';
                        
                        closeDischargePatientModal();
                        
                        setTimeout(() => {
                            if (typeof window.showAlert === 'function') {
                                window.showAlert(errorMessage, 'error');
                            } else {
                                alert(errorMessage);
                            }
                        }, 300);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    
                    const errorMessage = 'Xatolik: ' + error.message;
                    
                    closeDischargePatientModal();
                    
                    setTimeout(() => {
                        if (typeof window.showAlert === 'function') {
                            window.showAlert(errorMessage, 'error');
                        } else {
                            alert(errorMessage);
                        }
                    }, 300);
                });
            });

            // Backdrop bosilganda yopish
            if (dischargePatientModal) {
                dischargePatientModal.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const isInDialog = (
                        rect.top <= e.clientY && 
                        e.clientY <= rect.top + rect.height &&
                        rect.left <= e.clientX && 
                        e.clientX <= rect.left + rect.width
                    );
                    
                    if (!isInDialog) {
                        closeDischargePatientModal();
                    }
                });
            }

            // Escape tugmasi bosilganda
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && dischargePatientModal && dischargePatientModal.open) {
                    closeDischargePatientModal();
                }
            });
        });
</script>