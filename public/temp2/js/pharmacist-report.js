document.addEventListener('DOMContentLoaded', function() {
    const filterPanel = document.getElementById('filterPanel');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterCloseBtn = document.getElementById('filterCloseBtn');

    // Elementlar mavjudligini tekshirish
    if (!filterPanel || !filterOverlay || !filterToggleBtn || !filterCloseBtn) {
        console.error('Filter elementlari topilmadi!');
        return;
    }

    function openFilter() {
        filterPanel.classList.add('open');
        filterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeFilter() {
        filterPanel.classList.remove('open');
        filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    filterToggleBtn.addEventListener('click', openFilter);
    filterCloseBtn.addEventListener('click', closeFilter);
    filterOverlay.addEventListener('click', closeFilter);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && filterPanel.classList.contains('open')) {
            closeFilter();
        }
    });

    const filterTypeRadios = document.querySelectorAll('input[name="filter_type"]');
    let filterValueInput = document.getElementById('filterValueInput');
    const filterValueLabel = document.getElementById('filterValueLabel');

    // Radio tugmalar uchun active klass
    document.querySelectorAll('.radio-card input[type="radio"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const parent = this.closest('.radio-card');
            const siblings = parent.parentElement.querySelectorAll('.radio-card');
            siblings.forEach(function(sib) {
                sib.classList.remove('active');
            });
            if (this.checked) {
                parent.classList.add('active');
            }
        });
    });

    // Boshlang'ich active holat
    document.querySelectorAll('.radio-card input[type="radio"]:checked').forEach(function(radio) {
        radio.closest('.radio-card').classList.add('active');
    });

    // Filter type o'zgarganda
    filterTypeRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            const type = this.value;
            filterValueInput = document.getElementById('filterValueInput');
            const currentValue = filterValueInput ? filterValueInput.value : '';
            
            if (type === 'day') {
                if (filterValueLabel) filterValueLabel.textContent = lang.day || 'Kun';
                if (filterValueInput) {
                    const newInput = document.createElement('input');
                    newInput.type = 'date';
                    newInput.className = 'modern-input';
                    newInput.name = 'filter_value';
                    newInput.id = 'filterValueInput';
                    newInput.value = currentValue || defaultDate || new Date().toISOString().split('T')[0];
                    filterValueInput.parentNode.replaceChild(newInput, filterValueInput);
                }
            } else if (type === 'month') {
                if (filterValueLabel) filterValueLabel.textContent = lang.month || 'Oy';
                const currentYear = new Date().getFullYear();
                let optionsHtml = '';
                for (let m = 1; m <= 12; m++) {
                    const monthVal = currentYear + '-' + String(m).padStart(2, '0');
                    const selected = monthVal === currentValue ? 'selected' : '';
                    const label = new Date(monthVal + '-01').toLocaleDateString('en-US', {month: 'long', year: 'numeric'});
                    optionsHtml += `<option value="${monthVal}" ${selected}>${label}</option>`;
                }
                if (filterValueInput) {
                    const newSelect = document.createElement('select');
                    newSelect.className = 'modern-select';
                    newSelect.name = 'filter_value';
                    newSelect.id = 'filterValueInput';
                    newSelect.innerHTML = optionsHtml;
                    filterValueInput.parentNode.replaceChild(newSelect, filterValueInput);
                }
            }
        });
    });

    // Reset filters
    const resetBtn = document.getElementById('resetFilters');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
                if (radio.value === 'all' || radio.value === 'day') {
                    radio.checked = true;
                    const parent = radio.closest('.radio-card');
                    if (parent) {
                        const siblings = parent.parentElement.querySelectorAll('.radio-card');
                        siblings.forEach(function(sib) {
                            sib.classList.remove('active');
                        });
                        parent.classList.add('active');
                    }
                }
            });

            const filterValueInput2 = document.getElementById('filterValueInput');
            if (filterValueInput2) {
                if (filterValueInput2.type === 'date') {
                    filterValueInput2.value = defaultDate || new Date().toISOString().split('T')[0];
                } else if (filterValueInput2.tagName === 'SELECT') {
                    const options = filterValueInput2.querySelectorAll('option');
                    if (options.length > 0) {
                        options[0].selected = true;
                    }
                }
            }

            const filterForm = document.getElementById('filterForm');
            if (filterForm) {
                filterForm.submit();
            }
        });
    }

    // Print
    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            window.print();
        });
    }
});

// Day detail modal
function openDayDetail(date) {
    var dateId = 'dayModal_' + date.replace(/\./g, '_');
    var modal = document.getElementById(dateId);
    if (modal) {
        modal.showModal();
        document.body.style.overflow = 'hidden';
    } else {
        console.error('Modal topilmadi:', dateId);
    }
}