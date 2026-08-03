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

    // Nurse Modal boshqaruvi (faqat yopish tugmasi bilan yopiladi)
    const nurseModal = document.getElementById('nursePasswordCancelModal');
    const nurseShowModalBtn = document.getElementById('nurseShowPasswordModalBtn');
    const nursePassportNumber = document.getElementById('nursePassportNumber');
    const nurseModalPasswordPreview = document.getElementById('nurseModalPasswordPreview');
    const nursePasswordSuccess = document.getElementById('nursePasswordSuccess');
    const nurseSuccessPasswordDisplay = document.getElementById('nurseSuccessPasswordDisplay');

    // Passport number dan ma'lumotni olish
    if (nursePassportNumber && nurseModalPasswordPreview) {
        // Modal ochilganda passport raqamini olish
        window.showNursePasswordModal = function() {
            const currentPassportNumber = nursePassportNumber.value || 'N/A';
            nurseModalPasswordPreview.textContent = currentPassportNumber;
            nurseModal.showModal();
        };
        
        // Passport raqami o'zgarganda modal previewni yangilash
        nursePassportNumber.addEventListener('input', function() {
            if (nurseModal.open) {
                nurseModalPasswordPreview.textContent = this.value || 'N/A';
            }
        });
    }

    // Modalni faqat yopish tugmasi bilan yopish
    window.closeNursePasswordModal = function() {
        nurseModal.close();
    };

    if (nurseShowModalBtn) {
        nurseShowModalBtn.addEventListener('click', function() {
            showNursePasswordModal();
        });
    }

    // Modal tashqarisini bosganda hech narsa bo'lmaydi (yopilmaydi)
    if (nurseModal) {
        // Tashqarini bosganda yopilishini oldini olish
        nurseModal.addEventListener('click', function(e) {
            const rect = nurseModal.getBoundingClientRect();
            const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                               rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
            
            // Tashqarini bosganda hech narsa qilma (yopma)
            if (!isInDialog) {
                // Hech narsa qilma - yopilmaydi
                return;
            }
        });

        // ESC tugmasi bosilganda yopilishini oldini olish
        nurseModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            // Hech narsa qilma - yopilmaydi
        });
    }

    // Photo preview
    window.previewPhoto = function(event) {
        const input = event.target;
        const previewContainer = input.closest('.form-group').querySelector('.photo-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Photo preview">`;
            };
            
            reader.readAsDataURL(input.files[0]);
            input.classList.add('changed');
        }
    };

    // Phone number formatting
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                if (value.startsWith('998')) {
                    value = '+998 ' + value.substring(3);
                } else {
                    value = '+998 ' + value;
                }
                if (value.length > 7) value = value.substring(0, 7) + ' ' + value.substring(7);
                if (value.length > 11) value = value.substring(0, 11) + ' ' + value.substring(11);
                if (value.length > 14) value = value.substring(0, 14);
            }
            
            e.target.value = value;
        });
    }

    // Form submit
    const mainForm = document.getElementById('updateNurseForm');
    const submitBtn = document.getElementById('nurseSubmitBtn');
    
    if (mainForm) {
        mainForm.addEventListener('submit', function() {
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    }

    // Session success ni tekshirish
    const passwordCancelled = document.querySelector('.password-cancelled-data');
    if (passwordCancelled) {
        const newPassword = passwordCancelled.dataset.password;
        if (nursePasswordSuccess) {
            nursePasswordSuccess.style.display = 'flex';
        }
        if (nurseSuccessPasswordDisplay) {
            nurseSuccessPasswordDisplay.textContent = newPassword;
        }
        if (nurseShowModalBtn) {
            nurseShowModalBtn.innerHTML = '<i class="fas fa-check"></i> Parol bekor qilingan';
            nurseShowModalBtn.disabled = true;
            nurseShowModalBtn.style.opacity = '0.7';
            nurseShowModalBtn.style.cursor = 'not-allowed';
            nurseShowModalBtn.style.background = 'linear-gradient(135deg, #95a5a6, #7f8c8d)';
        }
    }
});