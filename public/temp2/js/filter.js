// public/js/filter.js
document.addEventListener('DOMContentLoaded', function () {
    // ========== MAVJUD FILTER (DOCTOR/OTHER) ==========
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterPanel = document.getElementById('filterPanel');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterCloseBtn = document.getElementById('filterCloseBtn');
    const filterCount = document.getElementById('filterCount');
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const departmentSelect = document.getElementById('departmentSelect');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    // Elementlar mavjudligini tekshirish
    if (filterToggleBtn && filterPanel) {
        
        function openFilterPanel() {
            filterPanel.classList.add('open');
            if (filterOverlay) filterOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            filterToggleBtn.classList.add('active');
        }
        
        function closeFilterPanel() {
            filterPanel.classList.remove('open');
            if (filterOverlay) filterOverlay.classList.remove('active');
            document.body.style.overflow = '';
            filterToggleBtn.classList.remove('active');
        }
        
        filterToggleBtn.addEventListener('click', openFilterPanel);
        
        if (filterCloseBtn) {
            filterCloseBtn.addEventListener('click', closeFilterPanel);
        }
        
        if (filterOverlay) {
            filterOverlay.addEventListener('click', closeFilterPanel);
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && filterPanel.classList.contains('open')) {
                closeFilterPanel();
            }
        });
        
        function updateFilterCount() {
            let count = 0;
            if (searchInput && searchInput.value && searchInput.value !== '') count++;
            
            const selectedStatus = document.querySelector('input[name="status"]:checked');
            if (selectedStatus && selectedStatus.value && selectedStatus.value !== 'all') count++;
            
            if (departmentSelect && departmentSelect.value && departmentSelect.value !== 'all') count++;
            
            if ((startDate && startDate.value) || (endDate && endDate.value)) count++;
            
            if (filterCount) {
                filterCount.textContent = count;
                filterCount.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }
        
        if (clearSearch) {
            clearSearch.addEventListener('click', function(e) {
                e.preventDefault();
                if (searchInput) {
                    searchInput.value = '';
                    this.style.display = 'none';
                    updateFilterCount();
                    const filterForm = document.getElementById('filterForm');
                    if (filterForm) filterForm.submit();
                }
            });
        }
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                if (clearSearch) {
                    clearSearch.style.display = this.value && this.value !== '' ? 'block' : 'none';
                }
                updateFilterCount();
            });
        }
        
        if (statusRadios.length) {
            statusRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateFilterCount();
                });
            });
        }
        
        if (departmentSelect) {
            departmentSelect.addEventListener('change', function() {
                updateFilterCount();
            });
        }
        
        if (startDate) {
            startDate.addEventListener('change', function() {
                updateFilterCount();
            });
        }
        
        if (endDate) {
            endDate.addEventListener('change', function() {
                updateFilterCount();
            });
        }
        
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', function() {
                window.location.href = window.location.pathname;
            });
        }
        
        updateFilterCount();
        console.log('Filter.js yuklandi ( doctor)'); 

    }

    // ========== NURSE FILTER QO'SHIMCHA ==========
    const nurseFilterToggleBtn = document.getElementById('nurseFilterToggleBtn');
    const nurseFilterPanel = document.getElementById('nurseFilterPanel');
    const nurseFilterOverlay = document.getElementById('nurseFilterOverlay');
    const nurseFilterCloseBtn = document.getElementById('nurseFilterCloseBtn');
    const nurseFilterCount = document.getElementById('nurseFilterCount');
    const nurseSearchInput = document.getElementById('nurseSearchInput');
    const nurseClearSearch = document.getElementById('nurseClearSearch');
    const nurseStatusRadios = document.querySelectorAll('input[name="status"]');
    const nurseDepartmentSelect = document.getElementById('nurseDepartmentSelect');
    const nurseStartDate = document.getElementById('nurseStartDate');
    const nurseEndDate = document.getElementById('nurseEndDate');
    const nurseResetFiltersBtn = document.getElementById('nurseResetFilters');
    
    if (nurseFilterToggleBtn && nurseFilterPanel) {
        
        function openNurseFilterPanel() {
            nurseFilterPanel.classList.add('open');
            if (nurseFilterOverlay) nurseFilterOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            nurseFilterToggleBtn.classList.add('active');
        }
        
        function closeNurseFilterPanel() {
            nurseFilterPanel.classList.remove('open');
            if (nurseFilterOverlay) nurseFilterOverlay.classList.remove('active');
            document.body.style.overflow = '';
            nurseFilterToggleBtn.classList.remove('active');
        }
        
        nurseFilterToggleBtn.addEventListener('click', openNurseFilterPanel);
        
        if (nurseFilterCloseBtn) {
            nurseFilterCloseBtn.addEventListener('click', closeNurseFilterPanel);
        }
        
        if (nurseFilterOverlay) {
            nurseFilterOverlay.addEventListener('click', closeNurseFilterPanel);
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && nurseFilterPanel.classList.contains('open')) {
                closeNurseFilterPanel();
            }
        });
        
        function updateNurseFilterCount() {
            let count = 0;
            if (nurseSearchInput && nurseSearchInput.value && nurseSearchInput.value !== '') count++;
            
            const selectedStatus = document.querySelector('input[name="status"]:checked');
            if (selectedStatus && selectedStatus.value && selectedStatus.value !== 'all') count++;
            
            if (nurseDepartmentSelect && nurseDepartmentSelect.value && nurseDepartmentSelect.value !== 'all') count++;
            
            if ((nurseStartDate && nurseStartDate.value) || (nurseEndDate && nurseEndDate.value)) count++;
            
            if (nurseFilterCount) {
                nurseFilterCount.textContent = count;
                nurseFilterCount.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }
        
        if (nurseClearSearch) {
            nurseClearSearch.addEventListener('click', function(e) {
                e.preventDefault();
                if (nurseSearchInput) {
                    nurseSearchInput.value = '';
                    this.style.display = 'none';
                    updateNurseFilterCount();
                    const nurseFilterForm = document.getElementById('nurseFilterForm');
                    if (nurseFilterForm) nurseFilterForm.submit();
                }
            });
        }
        
        if (nurseSearchInput) {
            nurseSearchInput.addEventListener('input', function() {
                if (nurseClearSearch) {
                    nurseClearSearch.style.display = this.value && this.value !== '' ? 'block' : 'none';
                }
                updateNurseFilterCount();
            });
        }
        
        if (nurseStatusRadios.length) {
            nurseStatusRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateNurseFilterCount();
                });
            });
        }
        
        if (nurseDepartmentSelect) {
            nurseDepartmentSelect.addEventListener('change', function() {
                updateNurseFilterCount();
            });
        }
        
        if (nurseStartDate) {
            nurseStartDate.addEventListener('change', function() {
                updateNurseFilterCount();
            });
        }
        
        if (nurseEndDate) {
            nurseEndDate.addEventListener('change', function() {
                updateNurseFilterCount();
            });
        }
        
        if (nurseResetFiltersBtn) {
            nurseResetFiltersBtn.addEventListener('click', function() {
                window.location.href = window.location.pathname;
            });
        }
        
        updateNurseFilterCount();
    }
    console.log('Filter.js yuklandi ( nurse)'); 



    // Department Filter elementlari
    const departmentFilterToggleBtn = document.getElementById('departmentFilterToggleBtn');
    const departmentFilterPanel = document.getElementById('departmentFilterPanel');
    const departmentFilterOverlay = document.getElementById('departmentFilterOverlay');
    const departmentFilterCloseBtn = document.getElementById('departmentFilterCloseBtn');
    const departmentFilterCount = document.getElementById('departmentFilterCount');
    const departmentSearchInput = document.getElementById('departmentSearchInput');
    const departmentClearSearch = document.getElementById('departmentClearSearch');
    const departmentStatusRadios = document.querySelectorAll('input[name="department_status"]');
    const departmentFloorSelect = document.getElementById('departmentFloorSelect');
    const departmentResetFiltersBtn = document.getElementById('departmentResetFilters');
    
    // Elementlar mavjudligini tekshirish
    if (departmentFilterToggleBtn && departmentFilterPanel) {
        
        function openDepartmentFilterPanel() {
            departmentFilterPanel.classList.add('open');
            if (departmentFilterOverlay) departmentFilterOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            departmentFilterToggleBtn.classList.add('active');
        }
        
        function closeDepartmentFilterPanel() {
            departmentFilterPanel.classList.remove('open');
            if (departmentFilterOverlay) departmentFilterOverlay.classList.remove('active');
            document.body.style.overflow = '';
            departmentFilterToggleBtn.classList.remove('active');
        }
        
        departmentFilterToggleBtn.addEventListener('click', openDepartmentFilterPanel);
        
        if (departmentFilterCloseBtn) {
            departmentFilterCloseBtn.addEventListener('click', closeDepartmentFilterPanel);
        }
        
        if (departmentFilterOverlay) {
            departmentFilterOverlay.addEventListener('click', closeDepartmentFilterPanel);
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && departmentFilterPanel.classList.contains('open')) {
                closeDepartmentFilterPanel();
            }
        });
        
        function updateDepartmentFilterCount() {
            let count = 0;
            if (departmentSearchInput && departmentSearchInput.value && departmentSearchInput.value !== '') count++;
            
            const selectedStatus = document.querySelector('input[name="department_status"]:checked');
            if (selectedStatus && selectedStatus.value && selectedStatus.value !== 'all') count++;
            
            if (departmentFloorSelect && departmentFloorSelect.value && departmentFloorSelect.value !== 'all') count++;
            
            if (departmentFilterCount) {
                departmentFilterCount.textContent = count;
                departmentFilterCount.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }
        
        if (departmentClearSearch) {
            departmentClearSearch.addEventListener('click', function(e) {
                e.preventDefault();
                if (departmentSearchInput) {
                    departmentSearchInput.value = '';
                    this.style.display = 'none';
                    updateDepartmentFilterCount();
                    const departmentFilterForm = document.getElementById('departmentFilterForm');
                    if (departmentFilterForm) departmentFilterForm.submit();
                }
            });
        }
        
        if (departmentSearchInput) {
            departmentSearchInput.addEventListener('input', function() {
                if (departmentClearSearch) {
                    departmentClearSearch.style.display = this.value && this.value !== '' ? 'block' : 'none';
                }
                updateDepartmentFilterCount();
            });
        }
        
        if (departmentStatusRadios.length) {
            departmentStatusRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateDepartmentFilterCount();
                });
            });
        }
        
        if (departmentFloorSelect) {
            departmentFloorSelect.addEventListener('change', function() {
                updateDepartmentFilterCount();
            });
        }
        
        if (departmentResetFiltersBtn) {
            departmentResetFiltersBtn.addEventListener('click', function() {
                window.location.href = window.location.pathname;
            });
        }
        
        updateDepartmentFilterCount();
    }
    
    // Department table search
    const departmentTableSearch = document.getElementById('departmentTableSearchInput');
    if (departmentTableSearch) {
        departmentTableSearch.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.department-row');
            
            rows.forEach(row => {
                const departmentName = row.querySelector('.department-name')?.textContent.toLowerCase() || '';
                if (departmentName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    console.log('Department filter.js yuklandi');

    // ==================== ROOM FILTER (XONALAR UCHUN) ====================
    const roomFilterToggleBtn = document.getElementById('roomFilterToggleBtn');
    const roomFilterPanel = document.getElementById('roomFilterPanel');
    const roomFilterOverlay = document.getElementById('roomFilterOverlay');
    const roomFilterCloseBtn = document.getElementById('roomFilterCloseBtn');
    const roomFilterCountSpan = document.getElementById('filterCount');
    const roomSearchInput = document.getElementById('roomSearchInput');
    const roomClearSearchBtn = document.getElementById('roomClearSearch');
    const roomStatusRadios = document.querySelectorAll('input[name="status"]');
    const roomDepartmentSelect = document.getElementById('roomDepartmentSelect');
    const roomFloorSelect = document.getElementById('roomFloorSelect');
    const roomResetBtn = document.getElementById('roomResetFilters');

    function openRoomFilterPanel() {
        if (roomFilterPanel) roomFilterPanel.classList.add('open');
        if (roomFilterOverlay) roomFilterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        if (roomFilterToggleBtn) roomFilterToggleBtn.classList.add('active');
    }

    function closeRoomFilterPanel() {
        if (roomFilterPanel) roomFilterPanel.classList.remove('open');
        if (roomFilterOverlay) roomFilterOverlay.classList.remove('active');
        document.body.style.overflow = '';
        if (roomFilterToggleBtn) roomFilterToggleBtn.classList.remove('active');
    }

    function updateRoomFilterCount() {
        let count = 0;
        if (roomSearchInput && roomSearchInput.value) count++;
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        if (selectedStatus && selectedStatus.value !== 'all') count++;
        if (roomDepartmentSelect && roomDepartmentSelect.value !== 'all') count++;
        if (roomFloorSelect && roomFloorSelect.value !== 'all') count++;
        if (roomFilterCountSpan) {
            roomFilterCountSpan.textContent = count;
            roomFilterCountSpan.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    if (roomFilterToggleBtn) roomFilterToggleBtn.addEventListener('click', openRoomFilterPanel);
    if (roomFilterCloseBtn) roomFilterCloseBtn.addEventListener('click', closeRoomFilterPanel);
    if (roomFilterOverlay) roomFilterOverlay.addEventListener('click', closeRoomFilterPanel);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && roomFilterPanel && roomFilterPanel.classList.contains('open')) {
            closeRoomFilterPanel();
        }
    });

    if (roomClearSearchBtn) {
        roomClearSearchBtn.addEventListener('click', function() {
            if (roomSearchInput) {
                roomSearchInput.value = '';
                this.style.display = 'none';
                updateRoomFilterCount();
            }
        });
    }

    if (roomSearchInput) {
        roomSearchInput.addEventListener('input', function() {
            if (roomClearSearchBtn) {
                roomClearSearchBtn.style.display = this.value ? 'block' : 'none';
            }
            updateRoomFilterCount();
        });
    }

    roomStatusRadios.forEach(radio => radio.addEventListener('change', updateRoomFilterCount));
    if (roomDepartmentSelect) roomDepartmentSelect.addEventListener('change', updateRoomFilterCount);
    if (roomFloorSelect) roomFloorSelect.addEventListener('change', updateRoomFilterCount);

    if (roomResetBtn) {
        roomResetBtn.addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
    }

    updateRoomFilterCount();
    console.log('Room filter.js yuklandi');






    // ==================== SUPPLIER FILTER ====================
    const supplierFilterToggleBtn = document.getElementById('supplierFilterToggleBtn');
    const supplierFilterPanel = document.getElementById('supplierFilterPanel');
    const supplierFilterOverlay = document.getElementById('supplierFilterOverlay');
    const supplierFilterCloseBtn = document.getElementById('supplierFilterCloseBtn');
    const supplierFilterCount = document.getElementById('filterCount');

    const supplierFilterType = document.getElementById('supplierTypeSelect');
    const supplierFilterStatus = document.getElementById('supplierStatusSelect');

    // Jadval tepasidagi search input
    const tableSearchInput = document.getElementById('mainSearchInput');

    function openSupplierFilterPanel() {
        if (supplierFilterPanel) supplierFilterPanel.classList.add('open');
        if (supplierFilterOverlay) supplierFilterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        if (supplierFilterToggleBtn) supplierFilterToggleBtn.classList.add('active');
    }

    function closeSupplierFilterPanel() {
        if (supplierFilterPanel) supplierFilterPanel.classList.remove('open');
        if (supplierFilterOverlay) supplierFilterOverlay.classList.remove('active');
        document.body.style.overflow = '';
        if (supplierFilterToggleBtn) supplierFilterToggleBtn.classList.remove('active');
    }

    if (supplierFilterToggleBtn) {
        supplierFilterToggleBtn.addEventListener('click', openSupplierFilterPanel);
    }

    if (supplierFilterCloseBtn) {
        supplierFilterCloseBtn.addEventListener('click', closeSupplierFilterPanel);
    }

    if (supplierFilterOverlay) {
        supplierFilterOverlay.addEventListener('click', closeSupplierFilterPanel);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && supplierFilterPanel && supplierFilterPanel.classList.contains('open')) {
            closeSupplierFilterPanel();
        }
    });

    // REAL-TIME TABLE SEARCH (jadval tepasidagi input)
    if (tableSearchInput) {
        tableSearchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.supplier-row');
            
            rows.forEach(row => {
                const supplierName = row.querySelector('.supplier-name')?.textContent.toLowerCase() || '';
                if (supplierName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    function countSupplierActiveFilters() {
        let count = 0;
        if (supplierFilterType && supplierFilterType.value !== 'all') count++;
        if (supplierFilterStatus && supplierFilterStatus.value !== 'all') count++;
        return count;
    }

    function updateSupplierFilterCount() {
        const count = countSupplierActiveFilters();
        if (supplierFilterCount) {
            supplierFilterCount.textContent = count;
            supplierFilterCount.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    const supplierFilterApply = document.getElementById('supplierApplyFilters');
    if (supplierFilterApply) {
        supplierFilterApply.addEventListener('click', function(e) {
            e.preventDefault();
            const params = new URLSearchParams();
            if (supplierFilterType && supplierFilterType.value !== 'all') params.append('type', supplierFilterType.value);
            if (supplierFilterStatus && supplierFilterStatus.value !== 'all') params.append('status', supplierFilterStatus.value);
            window.location.href = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        });
    }

    const supplierFilterReset = document.getElementById('supplierResetFilters');
    if (supplierFilterReset) {
        supplierFilterReset.addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
    }

    updateSupplierFilterCount();
    console.log('Supplier filter.js yuklandi');


    // ==================== Medicine FILTER ====================
    const medicineFilterToggleBtn = document.getElementById('medicineFilterToggleBtn');
    const medicineFilterPanel = document.getElementById('medicineFilterPanel');
    const medicineFilterOverlay = document.getElementById('medicineFilterOverlay');
    const medicineFilterCloseBtn = document.getElementById('medicineFilterCloseBtn');
    const medicineFilterCount = document.getElementById('medicineFilterCount');
    const medicineFormSelect = document.getElementById('medicineFormSelect');
    const medicineCategorySelect = document.getElementById('medicineCategorySelect');
    const medicineMinPrice = document.getElementById('medicineMinPrice');
    const medicineMaxPrice = document.getElementById('medicineMaxPrice');

    const medicineTableSearchInput = document.getElementById('medicineMainSearchInput');

    function openMedicineFilterPanel() {
        medicineFilterPanel.classList.add('open');
        medicineFilterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        medicineFilterToggleBtn.classList.add('active');
    }

    function closeMedicineFilterPanel() {
        medicineFilterPanel.classList.remove('open');
        medicineFilterOverlay.classList.remove('active');
        document.body.style.overflow = '';
        medicineFilterToggleBtn.classList.remove('active');
    }

    medicineFilterToggleBtn.addEventListener('click', openMedicineFilterPanel);
    medicineFilterCloseBtn.addEventListener('click', closeMedicineFilterPanel);
    medicineFilterOverlay.addEventListener('click', closeMedicineFilterPanel);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && medicineFilterPanel.classList.contains('open')) {
            closeMedicineFilterPanel();
        }
    });

    // REAL-TIME TABLE SEARCH
    if (medicineTableSearchInput) {
        medicineTableSearchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.medicine-row');
            
            rows.forEach(row => {
                const medicineName = row.querySelector('.full-name')?.textContent.toLowerCase() || '';
                const categoryName = row.querySelector('.login-display')?.textContent.toLowerCase() || '';
                
                if (medicineName.includes(searchTerm) || categoryName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateMedicineFilterCount();
        });
    }

    if (medicineFormSelect) {
        medicineFormSelect.addEventListener('change', function() {
            applyMedicineClientFilters();
        });
    }

    if (medicineCategorySelect) {
        medicineCategorySelect.addEventListener('change', function() {
            applyMedicineClientFilters();
        });
    }

    if (medicineMinPrice) {
        medicineMinPrice.addEventListener('input', function() {
            applyMedicineClientFilters();
        });
    }

    if (medicineMaxPrice) {
        medicineMaxPrice.addEventListener('input', function() {
            applyMedicineClientFilters();
        });
    }

    function applyMedicineClientFilters() {
        const searchTerm = medicineTableSearchInput?.value.toLowerCase() || '';
        const formValue = medicineFormSelect?.value || 'all';
        const categoryValue = medicineCategorySelect?.value || 'all';
        const minPriceValue = parseFloat(medicineMinPrice?.value) || 0;
        const maxPriceValue = parseFloat(medicineMaxPrice?.value) || Infinity;
        
        const rows = document.querySelectorAll('.medicine-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            let show = true;
            
            const medicineName = row.querySelector('.full-name')?.textContent.toLowerCase() || '';
            const categoryName = row.querySelector('.login-display')?.textContent.toLowerCase() || '';
            
            if (searchTerm && !medicineName.includes(searchTerm) && !categoryName.includes(searchTerm)) {
                show = false;
            }
            
            if (show && formValue !== 'all') {
                const formText = row.querySelector('.type-badge')?.textContent.toLowerCase() || '';
                if (!formText.includes(formValue.toLowerCase())) {
                    show = false;
                }
            }
            
            if (show && categoryValue !== 'all') {
                const categoryText = row.querySelector('.login-display')?.textContent.toLowerCase() || '';
                if (!categoryText.includes(categoryValue.toLowerCase())) {
                    show = false;
                }
            }
            
            if (show && (minPriceValue > 0 || maxPriceValue !== Infinity)) {
                const priceText = row.querySelector('.price-text')?.textContent.replace(/\s/g, '') || '0';
                const price = parseFloat(priceText) || 0;
                
                if (price < minPriceValue) show = false;
                if (price > maxPriceValue) show = false;
            }
            
            if (show) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        updateMedicineFilterCount();
        
        const tbody = document.getElementById('medicinesTableBody');
        const noDataRow = document.getElementById('medicineNoDataRow');
        
        if (visibleCount === 0) {
            if (!noDataRow) {
                const tr = document.createElement('tr');
                tr.id = 'medicineNoDataRow';
                tr.innerHTML = '<td colspan="8" style="text-align: center; padding: 40px;">Hech qanday dori topilmadi<\/td>';
                tbody?.appendChild(tr);
            }
        } else {
            if (noDataRow) {
                noDataRow.remove();
            }
        }
    }

    function countMedicineActiveFilters() {
        let count = 0;
        if (medicineTableSearchInput && medicineTableSearchInput.value) count++;
        if (medicineFormSelect && medicineFormSelect.value !== 'all') count++;
        if (medicineCategorySelect && medicineCategorySelect.value !== 'all') count++;
        if (medicineMinPrice && medicineMinPrice.value) count++;
        if (medicineMaxPrice && medicineMaxPrice.value) count++;
        return count;
    }

    function updateMedicineFilterCount() {
        const count = countMedicineActiveFilters();
        if (medicineFilterCount) {
            medicineFilterCount.textContent = count;
            medicineFilterCount.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    const medicineResetFiltersBtn = document.getElementById('medicineResetFilters');
    if (medicineResetFiltersBtn) {
        medicineResetFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (medicineTableSearchInput) medicineTableSearchInput.value = '';
            if (medicineFormSelect) medicineFormSelect.value = 'all';
            if (medicineCategorySelect) medicineCategorySelect.value = 'all';
            if (medicineMinPrice) medicineMinPrice.value = '';
            if (medicineMaxPrice) medicineMaxPrice.value = '';
            
            const rows = document.querySelectorAll('.medicine-row');
            rows.forEach(row => row.style.display = '');
            
            updateMedicineFilterCount();
            
            const noDataRow = document.getElementById('medicineNoDataRow');
            if (noDataRow) noDataRow.remove();
            
            closeMedicineFilterPanel();
        });
    }

    const medicineApplyFiltersBtn = document.getElementById('medicineApplyFilters');
    if (medicineApplyFiltersBtn) {
        medicineApplyFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            applyMedicineClientFilters();
            closeMedicineFilterPanel();
        });
    }

    updateMedicineFilterCount();
    console.log('Medicine filter.js yuklandi');



});