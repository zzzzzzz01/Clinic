document.addEventListener('DOMContentLoaded', function() {
    let activeHospitalizationDropdown = null;
    
    function closeActiveHospitalizationDropdown() {
        if (activeHospitalizationDropdown) {
            activeHospitalizationDropdown.style.display = 'none';
            activeHospitalizationDropdown = null;
        }
    }
    
    document.querySelectorAll('.action-dots').forEach(dot => {
        dot.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const dropdownId = this.parentElement.getAttribute('data-dropdown-id');
            const dropdown = document.getElementById(dropdownId);
            
            if (activeHospitalizationDropdown === dropdown && dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                activeHospitalizationDropdown = null;
                return;
            }
            
            document.querySelectorAll('.dropdown-content').forEach(d => {
                d.style.display = 'none';
            });
            
            const rect = this.getBoundingClientRect();
            dropdown.style.display = 'block';
            dropdown.style.position = 'fixed';
            
            dropdown.style.visibility = 'hidden';
            dropdown.style.display = 'block';
            const dropdownRect = dropdown.getBoundingClientRect();
            dropdown.style.display = 'none';
            
            let left = rect.right - dropdownRect.width;
            let top = rect.bottom + 5;
            
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            
            if (left < 0) left = rect.left;
            if (left + dropdownRect.width > windowWidth) left = windowWidth - dropdownRect.width - 10;
            if (top + dropdownRect.height > windowHeight) top = rect.top - dropdownRect.height - 5;
            
            dropdown.style.left = left + 'px';
            dropdown.style.top = top + 'px';
            dropdown.style.zIndex = '10000';
            dropdown.style.display = 'block';
            dropdown.style.visibility = 'visible';
            
            activeHospitalizationDropdown = dropdown;
        });
    });
    
    window.addEventListener('scroll', function() {
        closeActiveHospitalizationDropdown();
    });
    
    window.addEventListener('resize', function() {
        closeActiveHospitalizationDropdown();
    });
    
    document.addEventListener('click', function(e) {
        if (activeHospitalizationDropdown && !activeHospitalizationDropdown.contains(e.target) && !e.target.closest('.action-dots')) {
            closeActiveHospitalizationDropdown();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeActiveHospitalizationDropdown();
        }
    });
    
    const filterToggleBtn = document.getElementById('hospitalizationFilterToggleBtn');
    const filterPanel = document.getElementById('hospitalizationFilterPanel');
    const filterOverlay = document.getElementById('hospitalizationFilterOverlay');
    const filterCloseBtn = document.getElementById('hospitalizationFilterCloseBtn');
    const filterCount = document.getElementById('hospitalizationFilterCount');
    const searchInput = document.getElementById('hospitalizationSearchInput');
    const clearSearch = document.getElementById('clearHospitalizationSearch');
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const departmentSelect = document.getElementById('hospitalizationDepartmentSelect');
    
    function countActiveHospitalizationFilters() {
        let count = 0;
        if (searchInput && searchInput.value) count++;
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        if (selectedStatus && selectedStatus.value !== 'all') count++;
        if (departmentSelect && departmentSelect.value !== 'all') count++;
        return count;
    }
    
    function updateHospitalizationFilterCount() {
        const count = countActiveHospitalizationFilters();
        if (filterCount) {
            filterCount.textContent = count;
            filterCount.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }
    
    function openHospitalizationFilterPanel() {
        if (filterPanel) filterPanel.classList.add('open');
        if (filterOverlay) filterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        if (filterToggleBtn) filterToggleBtn.classList.add('active');
    }
    
    function closeHospitalizationFilterPanel() {
        if (filterPanel) filterPanel.classList.remove('open');
        if (filterOverlay) filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
        if (filterToggleBtn) filterToggleBtn.classList.remove('active');
    }
    
    if (filterToggleBtn) filterToggleBtn.addEventListener('click', openHospitalizationFilterPanel);
    if (filterCloseBtn) filterCloseBtn.addEventListener('click', closeHospitalizationFilterPanel);
    if (filterOverlay) filterOverlay.addEventListener('click', closeHospitalizationFilterPanel);
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && filterPanel && filterPanel.classList.contains('open')) {
            closeHospitalizationFilterPanel();
        }
    });
    
    if (clearSearch) {
        clearSearch.addEventListener('click', function() {
            if (searchInput) {
                searchInput.value = '';
                this.style.display = 'none';
                updateHospitalizationFilterCount();
            }
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            if (clearSearch) {
                clearSearch.style.display = this.value ? 'block' : 'none';
            }
            updateHospitalizationFilterCount();
        });
    }
    
    statusRadios.forEach(radio => radio.addEventListener('change', updateHospitalizationFilterCount));
    if (departmentSelect) departmentSelect.addEventListener('change', updateHospitalizationFilterCount);
    
    const resetBtn = document.getElementById('resetHospitalizationFilters');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
    }
    
    updateHospitalizationFilterCount();
});

function deleteHospitalization(id) {
    if (confirm("@lang('words.confirm_delete_patient')")) {
        alert("@lang('words.patient_deleted')");
    }
} 