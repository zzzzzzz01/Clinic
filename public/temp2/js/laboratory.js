document.addEventListener('DOMContentLoaded', function() {
    // CREATE MODAL
    const createModal = document.getElementById('createTestModal');
    const openCreateBtn = document.getElementById('openTestCreateModal');
    const closeCreateModalBtn = document.getElementById('closeCreateModalBtn');
    const cancelCreateModalBtn = document.getElementById('cancelCreateModalBtn');

    function disableBodyScroll() {
        document.body.style.overflow = 'hidden';
    }

    function enableBodyScroll() {
        document.body.style.overflow = '';
    }

    if (openCreateBtn) {
        openCreateBtn.addEventListener('click', () => {
            if (createModal) createModal.showModal();
            disableBodyScroll();
        });
    }

    if (closeCreateModalBtn) {
        closeCreateModalBtn.addEventListener('click', () => {
            if (createModal) createModal.close();
            enableBodyScroll();
        });
    }

    if (cancelCreateModalBtn) {
        cancelCreateModalBtn.addEventListener('click', () => {
            if (createModal) createModal.close();
            enableBodyScroll();
        });
    }

    // UPDATE MODAL
    const updateModal = document.getElementById('updateTestModal');
    const closeUpdateModalBtn = document.getElementById('closeUpdateModalBtn');
    const cancelUpdateModalBtn = document.getElementById('cancelUpdateModalBtn');

    window.openUpdateModal = function(button) {
        const card = button.closest('.test-card');
        
        document.getElementById('updateTestId').value = card.getAttribute('data-id');
        document.getElementById('updateTestCode').value = card.getAttribute('data-code');
        document.getElementById('updateTestName').value = card.getAttribute('data-name');
        document.getElementById('updateTestUnit').value = card.getAttribute('data-unit');
        document.getElementById('updateTestLow').value = card.getAttribute('data-low'); 
        document.getElementById('updateTestHigh').value = card.getAttribute('data-high');
        document.getElementById('updateTestPrice').value = card.getAttribute('data-price');
        document.getElementById('updateTestDuration').value = card.getAttribute('data-duration');
        document.getElementById('updateTestStatus').value = card.getAttribute('data-status');
        
        const form = document.getElementById('updateTestForm');
        form.action = '/tests/' + card.getAttribute('data-id');
        
        if (updateModal) updateModal.showModal();
        disableBodyScroll();
    };

    if (closeUpdateModalBtn) {
        closeUpdateModalBtn.addEventListener('click', () => {
            if (updateModal) updateModal.close();
            enableBodyScroll();
        });
    }

    if (cancelUpdateModalBtn) {
        cancelUpdateModalBtn.addEventListener('click', () => {
            if (updateModal) updateModal.close();
            enableBodyScroll();
        });
    }

    // VIEW MODAL
    const viewModal = document.getElementById('viewTestModal');
    const closeViewModalBtn = document.getElementById('closeViewModalBtn');
    const closeViewBtn = document.getElementById('closeViewBtn');

    window.viewTest = function(button) {
        const card = button.closest('.test-card');
        
        const viewId = document.getElementById('viewTestId');
        const viewCode = document.getElementById('viewTestCode');
        const viewName = document.getElementById('viewTestName');
        const viewUnit = document.getElementById('viewTestUnit');
        const viewPrice = document.getElementById('viewTestPrice');
        const viewDuration = document.getElementById('viewTestDuration');
        const viewRange = document.getElementById('viewTestRange');
        const viewStatus = document.getElementById('viewTestStatus');
        
        if (viewId) viewId.textContent = card.getAttribute('data-id');
        if (viewCode) viewCode.textContent = card.getAttribute('data-code');
        if (viewName) viewName.textContent = card.getAttribute('data-name');
        if (viewUnit) viewUnit.textContent = card.getAttribute('data-unit');
        if (viewPrice) viewPrice.textContent = card.getAttribute('data-price') + ' $';
        if (viewDuration) viewDuration.textContent = card.getAttribute('data-duration') ? card.getAttribute('data-duration') + ' min' : '-';
        if (viewRange) viewRange.textContent = card.getAttribute('data-low') + ' — ' + card.getAttribute('data-high');
        
        const status = card.getAttribute('data-status');
        const statusText = status == '1' ? 'Mavjud' : 'Mavjud emas';
        const statusColor = status == '1' ? '#27ae60' : '#e74c3c';
        if (viewStatus) {
            viewStatus.textContent = statusText;
            viewStatus.style.color = statusColor;
        }
        
        if (viewModal) viewModal.showModal();
        disableBodyScroll();
    };

    if (closeViewModalBtn) {
        closeViewModalBtn.addEventListener('click', () => {
            if (viewModal) viewModal.close();
            enableBodyScroll();
        });
    }

    if (closeViewBtn) {
        closeViewBtn.addEventListener('click', () => {
            if (viewModal) viewModal.close();
            enableBodyScroll();
        });
    }

    // DELETE MODAL - TESTga moslashtirilgan
const testDeleteModal = document.getElementById('testDeleteModal');
const testCloseDeleteModalBtn = document.getElementById('testCloseDeleteModalBtn');
const testCancelDeleteBtn = document.getElementById('testCancelDeleteBtn');
const testConfirmCheckbox = document.getElementById('testConfirmDeleteCheckbox');
const testConfirmDeleteBtn = document.getElementById('testConfirmDeleteBtn');
const testDeleteForm = document.getElementById('testDeleteForm');

window.openTestDeleteModal = function(button) {
    const card = button.closest('.test-card');
    
    document.getElementById('testDeleteName').textContent = card.getAttribute('data-name');
    document.getElementById('testDeleteCode').textContent = card.getAttribute('data-code');
    document.getElementById('testDeletePrice').textContent = card.getAttribute('data-price') + ' $';
    
    if (testDeleteForm) {
        testDeleteForm.action = '/tests/' + card.getAttribute('data-id');
    }
    
    if (testConfirmCheckbox) {
        testConfirmCheckbox.checked = false;
    }
    
    if (testConfirmDeleteBtn) {
        testConfirmDeleteBtn.disabled = true;
    }
    
    if (testDeleteModal) {
        testDeleteModal.showModal();
    }
    disableBodyScroll();
};

if (testCloseDeleteModalBtn) {
    testCloseDeleteModalBtn.addEventListener('click', function() {
        if (testDeleteModal) testDeleteModal.close();
        enableBodyScroll();
    });
}

if (testCancelDeleteBtn) {
    testCancelDeleteBtn.addEventListener('click', function() {
        if (testDeleteModal) testDeleteModal.close();
        enableBodyScroll();
    });
}

// Checkbox o'zgarganda button holatini o'zgartirish
if (testConfirmCheckbox && testConfirmDeleteBtn) {
    testConfirmCheckbox.addEventListener('change', function() {
        testConfirmDeleteBtn.disabled = !this.checked;
    });
}

// Modal yopilganda scroll ni qayta tiklash
if (testDeleteModal) {
    testDeleteModal.addEventListener('close', function() {
        enableBodyScroll();
        if (testConfirmCheckbox) testConfirmCheckbox.checked = false;
        if (testConfirmDeleteBtn) testConfirmDeleteBtn.disabled = true;
    });
    
    testDeleteModal.addEventListener('cancel', function(e) {
        e.preventDefault();
        testDeleteModal.close();
    });
}
    // ESC bilan yopish
    if (createModal) {
        createModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            createModal.close();
            enableBodyScroll();
        });
    }

    if (updateModal) {
        updateModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            updateModal.close();
            enableBodyScroll();
        });
    }

    if (viewModal) {
        viewModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            viewModal.close();
            enableBodyScroll();
        });
    }

    // FILTER PANEL
    const testFilterToggleBtn = document.getElementById('testFilterToggleBtn');
    const testFilterPanel = document.getElementById('testFilterPanel');
    const testFilterOverlay = document.getElementById('testFilterOverlay');
    const testFilterCloseBtn = document.getElementById('testFilterCloseBtn');
    const testFilterCount = document.getElementById('testFilterCount');
    const testSearchInput = document.getElementById('testSearchInput');
    const testClearSearch = document.getElementById('testClearSearch');
    const testStatusRadios = document.querySelectorAll('input[name="status"]');
    const testPriceMin = document.getElementById('testPriceMin');
    const testPriceMax = document.getElementById('testPriceMax');
    const testSortFilter = document.getElementById('testSortFilter');
    const testResetFiltersBtn = document.getElementById('testResetFilters');

    function openFilterPanel() {
        if (testFilterPanel) {
            testFilterPanel.classList.add('open');
            testFilterOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            testFilterToggleBtn.classList.add('active');
        }
    }
    
    function closeFilterPanel() {
        if (testFilterPanel) {
            testFilterPanel.classList.remove('open');
            testFilterOverlay.classList.remove('active');
            document.body.style.overflow = '';
            testFilterToggleBtn.classList.remove('active');
        }
    }
    
    if (testFilterToggleBtn) testFilterToggleBtn.addEventListener('click', openFilterPanel);
    if (testFilterCloseBtn) testFilterCloseBtn.addEventListener('click', closeFilterPanel);
    if (testFilterOverlay) testFilterOverlay.addEventListener('click', closeFilterPanel);
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && testFilterPanel && testFilterPanel.classList.contains('open')) {
            closeFilterPanel();
        }
    });
    
    function countActiveFilters() {
        let count = 0;
        if (testSearchInput && testSearchInput.value) count++;
        
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        if (selectedStatus && selectedStatus.value !== 'all') count++;
        
        if (testPriceMin && testPriceMin.value) count++;
        if (testPriceMax && testPriceMax.value) count++;
        
        if (testSortFilter && testSortFilter.value !== 'name_asc') count++;
        
        return count;
    }
    
    function updateFilterCount() {
        const count = countActiveFilters();
        if (testFilterCount) {
            testFilterCount.textContent = count;
            testFilterCount.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }
    
    if (testClearSearch) {
        testClearSearch.addEventListener('click', function() {
            if (testSearchInput) testSearchInput.value = '';
            updateFilterCount();
            const form = document.getElementById('testFilterForm');
            if (form) form.submit();
        });
    }
    
    if (testResetFiltersBtn) {
        testResetFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/tests';
        });
    }
    
    if (testSearchInput) testSearchInput.addEventListener('input', updateFilterCount);
    if (testPriceMin) testPriceMin.addEventListener('input', updateFilterCount);
    if (testPriceMax) testPriceMax.addEventListener('input', updateFilterCount);
    if (testSortFilter) testSortFilter.addEventListener('change', updateFilterCount);
    testStatusRadios.forEach(radio => radio.addEventListener('change', updateFilterCount));
    
    updateFilterCount();
});