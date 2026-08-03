// public/js/dropdown.js
document.addEventListener('DOMContentLoaded', function () {
    let activeDropdown = null;
    
    document.querySelectorAll('.action-dots').forEach(dot => {
        dot.addEventListener('click', function (e) {
            e.stopPropagation();
            
            const dropdownId = this.parentElement.getAttribute('data-dropdown-id');
            const dropdown = document.getElementById(dropdownId);
            
            if (!dropdown) return;
            
            if (activeDropdown === dropdown && dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                activeDropdown = null;
                return;
            }
            
            document.querySelectorAll('.dropdown-content').forEach(d => {
                d.style.display = 'none';
            });
            
            const rect = this.getBoundingClientRect();
            
            dropdown.style.display = 'block';
            dropdown.style.position = 'fixed';
            dropdown.style.visibility = 'hidden';
            const dropdownRect = dropdown.getBoundingClientRect();
            dropdown.style.visibility = '';
            
            let left = rect.right - dropdownRect.width;
            let top = rect.bottom + 5;
            
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            
            if (left < 0) left = 10;
            if (left + dropdownRect.width > windowWidth) {
                left = windowWidth - dropdownRect.width - 10;
            }
            if (top + dropdownRect.height > windowHeight) {
                top = rect.top - dropdownRect.height - 5;
            }
            
            dropdown.style.left = left + 'px';
            dropdown.style.top = top + 'px';
            dropdown.style.zIndex = '10000';
            dropdown.style.visibility = 'visible';
            
            activeDropdown = dropdown;
        });
    });
    
    document.addEventListener('click', function (e) {
        if (activeDropdown && !activeDropdown.contains(e.target) && !e.target.closest('.action-dots')) {
            activeDropdown.style.display = 'none';
            activeDropdown = null;
        }
    });
    
    window.addEventListener('scroll', function () {
        if (activeDropdown) {
            activeDropdown.style.display = 'none';
            activeDropdown = null;
        }
    });
    
    window.addEventListener('resize', function () {
        if (activeDropdown) {
            activeDropdown.style.display = 'none';
            activeDropdown = null;
        }
    });
});