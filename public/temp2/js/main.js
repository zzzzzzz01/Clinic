(function () {
  /* ========= Preloader ======== */
  const preloader = document.querySelectorAll('#preloader')

  window.addEventListener('load', function () {
    if (preloader.length) {
      this.document.getElementById('preloader').style.display = 'none'
    }
  })

  /* ========= Add Box Shadow in Header on Scroll ======== */
  window.addEventListener('scroll', function () {
    const header = document.querySelector('.header')
    if (window.scrollY > 0) {
      header.style.boxShadow = '0px 0px 30px 0px rgba(200, 208, 216, 0.30)'
    } else {
      header.style.boxShadow = 'none'
    }
  })

  /* ========= sidebar toggle ======== */
  const sidebarNavWrapper = document.querySelector(".sidebar-nav-wrapper");
  const mainWrapper = document.querySelector(".main-wrapper");
  const menuToggleButton = document.querySelector("#menu-toggle");
  const menuToggleButtonIcon = document.querySelector("#menu-toggle i");
  const overlay = document.querySelector(".overlay");

  menuToggleButton.addEventListener("click", () => {
    sidebarNavWrapper.classList.toggle("active");
    overlay.classList.add("active");
    mainWrapper.classList.toggle("active");

    if (document.body.clientWidth > 1200) {
      if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
        menuToggleButtonIcon.classList.remove("lni-chevron-left");
        menuToggleButtonIcon.classList.add("lni-menu");
      } else {
        menuToggleButtonIcon.classList.remove("lni-menu");
        menuToggleButtonIcon.classList.add("lni-chevron-left");
      }
    } else {
      if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
        menuToggleButtonIcon.classList.remove("lni-chevron-left");
        menuToggleButtonIcon.classList.add("lni-menu");
      }
    }
  });
  overlay.addEventListener("click", () => {
    sidebarNavWrapper.classList.remove("active");
    overlay.classList.remove("active");
    mainWrapper.classList.remove("active");
  });

  /* ========= DOCTOR CREATE PAGE JS ======== */
  document.addEventListener('DOMContentLoaded', function() {
    // Password toggle
    window.togglePassword = function(passwordId) {
      const passwordInput = document.getElementById(passwordId);
      const toggleIcon = passwordInput.nextElementSibling.querySelector('i');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    };

    // Photo preview
    window.previewPhoto = function(event) {
      const input = event.target;
      const previewContainer = document.querySelector('.photo-preview');
      
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        
        reader.readAsDataURL(input.files[0]);
      }
    };

    // Phone number formatting
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
      phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // +998 XX XXX XX XX format
        if (value.length > 0) {
          if (value.length > 3) {
            value = '+998 ' + value.substring(3, 5) + ' ' + value.substring(5, 8) + ' ' + value.substring(8, 10) + ' ' + value.substring(10, 12);
          } else {
            value = '+998';
          }
        }
        
        e.target.value = value.trim();
      });
    }

    // Set default dates
    const today = new Date().toISOString().split('T')[0];
    
    const hireDateInput = document.querySelector('input[name="hire_date"]');
    const graduationDateInput = document.querySelector('input[name="graduation_date"]');
    const birthDateInput = document.querySelector('input[name="birth_date"]');
    
    if (hireDateInput && !hireDateInput.value) {
      hireDateInput.value = today;
    }
    
    if (graduationDateInput && !graduationDateInput.value) {
      const fourYearsAgo = new Date();
      fourYearsAgo.setFullYear(fourYearsAgo.getFullYear() - 4);
      graduationDateInput.value = fourYearsAgo.toISOString().split('T')[0];
    }
    
    if (birthDateInput && !birthDateInput.value) {
      const twentyFiveYearsAgo = new Date();
      twentyFiveYearsAgo.setFullYear(twentyFiveYearsAgo.getFullYear() - 25);
      birthDateInput.value = twentyFiveYearsAgo.toISOString().split('T')[0];
    }

    // Auto uppercase for password
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    [passwordInput, confirmPasswordInput].forEach(input => {
      if (input) {
        input.addEventListener('input', function() {
          this.value = this.value.toUpperCase();
        });
      }
    });

    // Smooth scroll to error (Blade syntax ishlatilmaydi, JavaScript orqali tekshiriladi)
    const firstError = document.querySelector('.is-invalid');
    if (firstError) {
      firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  });
})();



document.addEventListener('DOMContentLoaded', function() {
    // Input o'zgarishini kuzatish
    const formControls = document.querySelectorAll('.form-control:not([type="file"])');
    
    formControls.forEach(element => {
        element.addEventListener('input', function() {
            const originalValue = this.getAttribute('data-original');
            const currentValue = this.value;
            
            if (String(originalValue) !== String(currentValue)) {
                this.classList.add('changed');
            } else {
                this.classList.remove('changed');
            }
        });

        if (element.tagName === 'SELECT') {
            element.addEventListener('change', function() {
                const originalValue = this.getAttribute('data-original');
                const currentValue = this.value;
                
                if (String(originalValue) !== String(currentValue)) {
                    this.classList.add('changed');
                } else {
                    this.classList.remove('changed');
                }
            });
        }
    });

    // Modal boshqaruvi
    const modal = document.getElementById('passwordCancelModal');
    const showModalBtn = document.getElementById('showPasswordModalBtn');
    const passportNumber = document.getElementById('passportNumber');
    const modalPasswordPreview = document.getElementById('modalPasswordPreview');
    const passwordSuccess = document.getElementById('passwordSuccess');
    const successPasswordDisplay = document.getElementById('successPasswordDisplay');

    if (passportNumber && modalPasswordPreview) {
        passportNumber.addEventListener('input', function() {
            modalPasswordPreview.textContent = this.value || 'N/A';
        });
    }

    window.showPasswordModal = function() {
        modal.showModal();
        document.body.style.overflow = 'hidden';
        modal.style.top = '50%';
        modal.style.left = '50%';
        modal.style.transform = 'translate(-50%, -50%)';
    };

    window.closePasswordModal = function() {
        modal.close();
        document.body.style.overflow = '';
    };

    if (showModalBtn) {
        showModalBtn.addEventListener('click', showPasswordModal);
    }

    modal.addEventListener('click', function(e) {
        const rect = modal.getBoundingClientRect();
        const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                            rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
        
        if (!isInDialog) {
            closePasswordModal();
        }
    });

    modal.addEventListener('cancel', function(e) {
        e.preventDefault();
        closePasswordModal();
    });

    // Phone number formatting
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                value = '+998 ' + value;
                if (value.length > 7) value = value.substring(0, 7) + ' ' + value.substring(7);
                if (value.length > 11) value = value.substring(0, 11) + ' ' + value.substring(11);
                if (value.length > 14) value = value.substring(0, 14);
            }
            
            e.target.value = value;
        });
    }

    // Form submit
    const mainForm = document.getElementById('updateNurseForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (mainForm) {
        mainForm.addEventListener('submit', function() {
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    }
});


// Schedule uchun

function copyToNextDay(dayId) {
    dayId = parseInt(dayId);
    
    const currentStart = document.querySelector(`[name="days[${dayId}][start_time]"]`);
    const currentEnd = document.querySelector(`[name="days[${dayId}][end_time]"]`);
    const currentLunchStart = document.querySelector(`[name="days[${dayId}][lunch_start]"]`);
    const currentLunchEnd = document.querySelector(`[name="days[${dayId}][lunch_end]"]`);
    const currentDuration = document.querySelector(`[name="days[${dayId}][appointment_duration]"]`);
    
    const currentIsWorkingInputs = document.querySelectorAll(`[name="days[${dayId}][is_working]"]`);
    const currentIsWorkingCheckbox = currentIsWorkingInputs.length >= 2 ? currentIsWorkingInputs[1] : null;
    
    if (!currentStart) {
        console.error(`Day ${dayId} not found`);
        return false;
    }
    
    let nextDayId = dayId + 1;
    if (nextDayId > 7) {
        nextDayId = 1;
    }
    
    const nextStart = document.querySelector(`[name="days[${nextDayId}][start_time]"]`);
    const nextEnd = document.querySelector(`[name="days[${nextDayId}][end_time]"]`);
    const nextLunchStart = document.querySelector(`[name="days[${nextDayId}][lunch_start]"]`);
    const nextLunchEnd = document.querySelector(`[name="days[${nextDayId}][lunch_end]"]`);
    const nextDuration = document.querySelector(`[name="days[${nextDayId}][appointment_duration]"]`);
    
    const nextIsWorkingInputs = document.querySelectorAll(`[name="days[${nextDayId}][is_working]"]`);
    const nextIsWorkingCheckbox = nextIsWorkingInputs.length >= 2 ? nextIsWorkingInputs[1] : null;
    
    if (!nextStart) {
        console.error(`Next day ${nextDayId} not found`);
        return false;
    }
    
    nextStart.value = currentStart.value || '';
    nextEnd.value = currentEnd.value || '';
    nextLunchStart.value = currentLunchStart.value || '';
    nextLunchEnd.value = currentLunchEnd.value || '';
    
    if (currentDuration && nextDuration) {
        nextDuration.value = currentDuration.value || '30';
    }
    
    if (currentIsWorkingCheckbox && nextIsWorkingCheckbox) {
        nextIsWorkingCheckbox.checked = currentIsWorkingCheckbox.checked;
        
        [nextStart, nextEnd, nextLunchStart, nextLunchEnd].forEach(input => {
            if (input) input.disabled = !currentIsWorkingCheckbox.checked;
        });
        
        if (nextDuration) {
            nextDuration.disabled = !currentIsWorkingCheckbox.checked;
        }
    }
    
    const dayNames = {
        1: 'dushanba',
        2: 'seshanba',
        3: 'chorshanba',
        4: 'payshanba',
        5: 'juma',
        6: 'shanba',
        7: 'yakshanba'
    };
    
    alert(`Jadval ${dayNames[dayId]}dan ${dayNames[nextDayId]}ga nusxalandi!`);
}

function resetDay(dayId) {
    dayId = parseInt(dayId);
    
    const startTime = document.querySelector(`[name="days[${dayId}][start_time]"]`);
    const endTime = document.querySelector(`[name="days[${dayId}][end_time]"]`);
    const lunchStart = document.querySelector(`[name="days[${dayId}][lunch_start]"]`);
    const lunchEnd = document.querySelector(`[name="days[${dayId}][lunch_end]"]`);
    const duration = document.querySelector(`[name="days[${dayId}][appointment_duration]"]`);
    
    const isWorkingInputs = document.querySelectorAll(`[name="days[${dayId}][is_working]"]`);
    const isWorkingCheckbox = isWorkingInputs.length >= 2 ? isWorkingInputs[1] : null;
    
    if (!startTime) {
        console.error(`Day ${dayId} not found`);
        return false;
    }
    
    const isWeekday = dayId >= 1 && dayId <= 5;
    
    if (isWeekday) {
        startTime.value = '08:00';
        endTime.value = '17:00';
        lunchStart.value = '12:00';
        lunchEnd.value = '13:00';
        if (duration) {
            duration.value = '30';
            duration.disabled = false;
        }
        if (isWorkingCheckbox) {
            isWorkingCheckbox.checked = true;
        }
        
        [startTime, endTime, lunchStart, lunchEnd].forEach(input => {
            if (input) input.disabled = false;
        });
    } else {
        startTime.value = '';
        endTime.value = '';
        lunchStart.value = '';
        lunchEnd.value = '';
        if (duration) {
            duration.value = '30';
            duration.disabled = true;
        }
        if (isWorkingCheckbox) {
            isWorkingCheckbox.checked = false;
        }
        
        [startTime, endTime, lunchStart, lunchEnd].forEach(input => {
            if (input) input.disabled = true;
        });
    }
    
    const dayNames = {
        1: 'dushanba',
        2: 'seshanba',
        3: 'chorshanba',
        4: 'payshanba',
        5: 'juma',
        6: 'shanba',
        7: 'yakshanba'
    };
    
    alert(`${dayNames[dayId]} kuni standart qiymatlarga qaytarildi!`);
}

function applyTemplate(templateType) {
    const days = [1, 2, 3, 4, 5, 6, 7];
    
    days.forEach(dayId => {
        const isWeekday = dayId >= 1 && dayId <= 5;
        const isWeekend = dayId === 6 || dayId === 7;
        
        const startTime = document.querySelector(`[name="days[${dayId}][start_time]"]`);
        const endTime = document.querySelector(`[name="days[${dayId}][end_time]"]`);
        const lunchStart = document.querySelector(`[name="days[${dayId}][lunch_start]"]`);
        const lunchEnd = document.querySelector(`[name="days[${dayId}][lunch_end]"]`);
        const duration = document.querySelector(`[name="days[${dayId}][appointment_duration]"]`);
        
        const isWorkingInputs = document.querySelectorAll(`[name="days[${dayId}][is_working]"]`);
        const isWorkingCheckbox = isWorkingInputs.length >= 2 ? isWorkingInputs[1] : null;
        
        if (!startTime) return;
        
        if (templateType === 'clear') {
            startTime.value = '';
            endTime.value = '';
            lunchStart.value = '';
            lunchEnd.value = '';
            if (duration) {
                duration.value = '30';
                duration.disabled = true;
            }
            if (isWorkingCheckbox) isWorkingCheckbox.checked = false;
            
            [startTime, endTime, lunchStart, lunchEnd].forEach(input => {
                if (input) input.disabled = true;
            });
        } 
        else if (templateType === 'weekday' && isWeekday) {
            startTime.value = '08:00';
            endTime.value = '17:00';
            lunchStart.value = '12:00';
            lunchEnd.value = '13:00';
            if (duration) {
                duration.value = '30';
                duration.disabled = false;
            }
            if (isWorkingCheckbox) isWorkingCheckbox.checked = true;
            
            [startTime, endTime, lunchStart, lunchEnd].forEach(input => {
                if (input) input.disabled = false;
            });
        }
        else if (templateType === 'weekend' && isWeekend) {
            startTime.value = '09:00';
            endTime.value = '13:00';
            lunchStart.value = '';
            lunchEnd.value = '';
            if (duration) {
                duration.value = '30';
                duration.disabled = false;
            }
            if (isWorkingCheckbox) isWorkingCheckbox.checked = true;
            
            [startTime, endTime].forEach(input => {
                if (input) input.disabled = false;
            });
            [lunchStart, lunchEnd].forEach(input => {
                if (input) input.disabled = true;
            });
        }
    });
    
    let message = '';
    switch(templateType) {
        case 'weekday':
            message = 'Ish kuni shabloni (dushanba-juma) qo\'llandi!';
            break;
        case 'weekend':
            message = 'Dam olish kuni shabloni (shanba-yakshanba) qo\'llandi!';
            break;
        case 'clear':
            message = 'Barcha kunlar tozalandi!';
            break;
    }
    alert(message);
}

document.addEventListener('DOMContentLoaded', function() {
    for (let dayId = 1; dayId <= 7; dayId++) {
        const isWorkingInputs = document.querySelectorAll(`[name="days[${dayId}][is_working]"]`);
        const durationSelector = document.querySelector(`[name="days[${dayId}][appointment_duration]"]`);
        const startTime = document.querySelector(`[name="days[${dayId}][start_time]"]`);
        const endTime = document.querySelector(`[name="days[${dayId}][end_time]"]`);
        const lunchStart = document.querySelector(`[name="days[${dayId}][lunch_start]"]`);
        const lunchEnd = document.querySelector(`[name="days[${dayId}][lunch_end]"]`);
        
        if (isWorkingInputs.length >= 2) {
            const checkbox = isWorkingInputs[1];
            
            checkbox.addEventListener('change', function() {
                const inputs = [startTime, endTime, lunchStart, lunchEnd, durationSelector];
                inputs.forEach(input => {
                    if (input) input.disabled = !this.checked;
                });
                
                if (!this.checked) {
                    if (startTime) startTime.value = '';
                    if (endTime) endTime.value = '';
                    if (lunchStart) lunchStart.value = '';
                    if (lunchEnd) lunchEnd.value = '';
                }
            });
            
            // Initial state
            const inputs = [startTime, endTime, lunchStart, lunchEnd, durationSelector];
            inputs.forEach(input => {
                if (input) input.disabled = !checkbox.checked;
            });
        }
    }
});


// ========== FEATURE UCHUN ==========

// RESET - CREATE formaga qaytish
function resetToCreateForm() {
    document.querySelectorAll('#featuresTableBody tr').forEach(row => {
        row.classList.remove('feature-selected');
    });
    
    document.getElementById('featureCreateFormContainer').style.display = 'block';
    document.getElementById('featureEditFormContainer').style.display = 'none';
    document.getElementById('featureCreateForm').reset();
}

// Desktop EDIT formani ko'rsatish
function showEditForm(id, nameUz, nameRu, nameEn, descriptionUz, descriptionRu, descriptionEn, status) {
    const form = document.getElementById('featureEditForm');
    form.action = '/features/' + id;
    document.getElementById('featureId').value = id;
    document.getElementById('featureNameUz').value = nameUz || '';
    document.getElementById('featureNameRu').value = nameRu || '';
    document.getElementById('featureNameEn').value = nameEn || '';
    document.getElementById('featureDescriptionUz').value = descriptionUz || '';
    document.getElementById('featureDescriptionRu').value = descriptionRu || '';
    document.getElementById('featureDescriptionEn').value = descriptionEn || '';
    document.getElementById('featureStatus').value = status;
    
    document.getElementById('featureCreateFormContainer').style.display = 'none';
    document.getElementById('featureEditFormContainer').style.display = 'block';
}

// Qatorni bosish
function handleRowClick(event, id, nameUz, nameRu, nameEn, descriptionUz, descriptionRu, descriptionEn, status) {
    if (event.target.closest('.action-dropdown') || 
        event.target.closest('.dropdown-content')) {
        return;
    }
    
    event.preventDefault();
    event.stopPropagation();
    
    document.querySelectorAll('#featuresTableBody tr').forEach(row => {
        row.classList.remove('feature-selected');
    });
    
    const currentRow = event.currentTarget;
    currentRow.classList.add('feature-selected');
    
    if (window.innerWidth <= 768) {
        document.getElementById('modalFeatureId').value = id;
        document.getElementById('modalNameUz').value = nameUz || '';
        document.getElementById('modalNameRu').value = nameRu || '';
        document.getElementById('modalNameEn').value = nameEn || '';
        document.getElementById('modalDescriptionUz').value = descriptionUz || '';
        document.getElementById('modalDescriptionRu').value = descriptionRu || '';
        document.getElementById('modalDescriptionEn').value = descriptionEn || '';
        document.getElementById('modalStatus').value = status;
        document.getElementById('editFeatureForm').action = '/features/' + id;
        document.getElementById('editFeatureModal')
        .showModal();
        document.body.classList.add('modal-open');
    } else {
        showEditForm(id, nameUz, nameRu, nameEn, descriptionUz, descriptionRu, descriptionEn, status);
    }
    
    return false;
}

// Tahrirlash tugmasi - TO'G'RILANGAN VERSION
function openEditFeatureModal(event, id, nameUz, nameRu, nameEn, descriptionUz, descriptionRu, descriptionEn, status) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Dropdownni yopish
    document.querySelectorAll('.dropdown-content.show').forEach(menu => {
        menu.classList.remove('show');
    });
    
    // Selected classni yangilash
    document.querySelectorAll('#featuresTableBody tr').forEach(row => {
        row.classList.remove('feature-selected');
        if (row.getAttribute('data-id') == id) {
            row.classList.add('feature-selected');
        }
    });
    
    if (window.innerWidth <= 768) {
        // Mobile - modal ochish
        document.getElementById('modalFeatureId').value = id;
        document.getElementById('modalNameUz').value = nameUz || '';
        document.getElementById('modalNameRu').value = nameRu || '';
        document.getElementById('modalNameEn').value = nameEn || '';
        document.getElementById('modalDescriptionUz').value = descriptionUz || '';
        document.getElementById('modalDescriptionRu').value = descriptionRu || '';
        document.getElementById('modalDescriptionEn').value = descriptionEn || '';
        document.getElementById('modalStatus').value = status;
        document.getElementById('editFeatureForm').action = '/features/' + id;
        
        const modal = document.getElementById('editFeatureModal');
        modal.showModal();  // ❌ XATO: modal.showModal() emas, modal.showModal()
        document.body.classList.add('modal-open');
    } else {
        // Desktop - formani ko'rsatish
        showEditForm(id, nameUz, nameRu, nameEn, descriptionUz, descriptionRu, descriptionEn, status);
    }
    
    return false;
}

// Yangi qulaylik yaratish
function openCreateFeatureModal() {
    if (window.innerWidth <= 768) {
        const modal = document.getElementById('createFeatureModal');
        modal.showModal();
        document.body.classList.add('modal-open');
        const form = document.getElementById('createFeatureForm');
        if (form) form.reset();
    } else {
        resetToCreateForm();
    }
}

// Dialog yopish
function closeDialog(dialogId) {
    const modal = document.getElementById(dialogId);
    if (modal) {
        modal.close();
        document.body.classList.remove('modal-open');
    }
}

// Ekran o'lchami o'zgarganda
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        const editDialog = document.getElementById('editFeatureModal');
        const createDialog = document.getElementById('createFeatureModal');
        if (editDialog && editDialog.open) editDialog.close();
        if (createDialog && createDialog.open) createDialog.close();
    }
});

// Click outside dropdown to close
document.addEventListener('click', function() {
    document.querySelectorAll('.dropdown-content.show').forEach(menu => {
        menu.classList.remove('show');
    });
});



// ==================== SUPPLIER SEARCH ====================
const supplierTableSearchInput = document.getElementById('supplierMainSearchInput');

if (supplierTableSearchInput) {
    supplierTableSearchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.supplier-row');
        
        rows.forEach(row => {
            const supplierName = row.querySelector('.full-name')?.textContent.toLowerCase() || '';
            if (supplierName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}
