
function toggleDropdown(btn) {
    const dropdown = btn.closest('.action-dropdown');
    const menu = dropdown.querySelector('.dropdown-menu');
    
    document.querySelectorAll('.action-dropdown .dropdown-menu.show').forEach(el => {
        if (el !== menu) el.classList.remove('show');
    });
    
    menu.classList.toggle('show');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.action-dropdown')) {
        document.querySelectorAll('.action-dropdown .dropdown-menu.show').forEach(el => {
            el.classList.remove('show');
        });
    }
});

// Filter Panel
const filterToggleBtn = document.getElementById('filterToggleBtn');
const filterPanel = document.getElementById('filterPanel');
const filterOverlay = document.getElementById('filterOverlay');
const filterCloseBtn = document.getElementById('filterCloseBtn');

function openFilterPanel() {
    filterPanel.classList.add('open');
    filterOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeFilterPanel() {
    filterPanel.classList.remove('open');
    filterOverlay.classList.remove('active');
    document.body.style.overflow = '';
}

if (filterToggleBtn) {
    filterToggleBtn.addEventListener('click', openFilterPanel);
}

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

// Reset filters
document.getElementById('resetFilters').addEventListener('click', function() {
    window.location.href = window.location.pathname;
}); 


