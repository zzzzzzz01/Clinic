document.addEventListener('DOMContentLoaded', function() {
    const selectedTestsInput = document.getElementById('selectedTestsInput');
    const selectedTestsContainer = document.getElementById('selectedTestsContainer');
    const totalTestsCount = document.getElementById('totalTestsCount');
    const selectedTestsCount = document.getElementById('selectedTestsCount');
    const totalPrice = document.getElementById('totalPrice');
    const totalTime = document.getElementById('totalTime');
    
    const testModal = document.getElementById('testModal');
    
    // So'zlarni JS uchun olish
    const hoursText = document.querySelector('meta[name="hours-text"]')?.content || 'soat';
    const noTestsAddedText = document.querySelector('meta[name="no-tests-added"]')?.content || 'Hech qanday test qo\'shilmagan';
    const addTestsText = document.querySelector('meta[name="add-tests-text"]')?.content || 'Test qo\'shish';
    const laboratoryText = document.querySelector('meta[name="laboratory-text"]')?.content || 'Laboratoriya';
    const activeText = document.querySelector('meta[name="active-text"]')?.content || 'Faol';
    
    function updateStats() {
        const testCards = document.querySelectorAll('#selectedTestsContainer .selected-test-card');
        const count = testCards.length;
        let price = 0;
        let time = 0;
        
        testCards.forEach(card => {
            const priceText = card.querySelector('.selected-test-price')?.textContent || '0';
            const timeText = card.querySelector('.selected-test-duration')?.textContent || '0 ' + hoursText;
            price += parseFloat(priceText.replace('$', '')) || 0;
            time += parseInt(timeText) || 0;
        });
        
        if (totalTestsCount) totalTestsCount.textContent = count;
        if (selectedTestsCount) selectedTestsCount.textContent = count;
        if (totalPrice) totalPrice.textContent = '$' + price.toFixed(2);
        if (totalTime) totalTime.textContent = time + ' ' + hoursText;
    }
    
    function resetModal() {
        const container = document.getElementById('availableTestsContainer');
        if (!container) return;
        
        const cards = Array.from(container.children);
        const testSearch = document.getElementById('testSearch');
        
        if (testSearch) testSearch.value = '';
        
        container.style.display = 'grid';
        container.style.gridTemplateColumns = 'repeat(auto-fill, minmax(300px, 1fr))';
        container.style.gap = '15px';
        
        cards.forEach(card => {
            card.style.display = 'flex';
            card.style.flexDirection = 'column';
            card.classList.remove('selected');
        });
        
        const currentSelectedIds = selectedTestsInput.value.split(',').filter(id => id && id.trim());
        cards.forEach(card => {
            if (currentSelectedIds.includes(card.dataset.testId)) {
                card.classList.add('selected');
            }
        });
        
        const selectedCount = cards.filter(card => card.classList.contains('selected')).length;
        const modalSelectedCount = document.getElementById('modalSelectedCount');
        if (modalSelectedCount) modalSelectedCount.textContent = selectedCount;
        
        const selectedCards = cards.filter(card => card.classList.contains('selected'));
        const unselectedCards = cards.filter(card => !card.classList.contains('selected'));
        
        container.innerHTML = '';
        selectedCards.forEach(card => container.appendChild(card));
        unselectedCards.forEach(card => container.appendChild(card));
    }
    
    function openTestModal() {
        if (testModal) {
            resetModal();
            testModal.showModal();
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeTestModal() {
        if (testModal) {
            testModal.close();
            document.body.style.overflow = 'auto';
        }
    }
    
    function filterTests() {
        const searchTerm = document.getElementById('testSearch')?.value.toLowerCase().trim() || '';
        const container = document.getElementById('availableTestsContainer');
        if (!container) return;
        
        const cards = Array.from(container.children);
        
        if (!searchTerm) {
            cards.forEach(card => {
                card.style.display = 'flex';
            });
        } else {
            cards.forEach(card => {
                const name = card.dataset.testName?.toLowerCase() || '';
                const code = card.dataset.testCode?.toLowerCase() || '';
                const matches = name.includes(searchTerm) || code.includes(searchTerm);
                card.style.display = matches ? 'flex' : 'none';
            });
        }
        
        const visibleCards = cards.filter(card => card.style.display !== 'none');
        const selected = visibleCards.filter(card => card.classList.contains('selected'));
        const unselected = visibleCards.filter(card => !card.classList.contains('selected'));
        
        container.innerHTML = '';
        selected.forEach(card => container.appendChild(card));
        unselected.forEach(card => container.appendChild(card));
        
        container.style.display = 'grid';
        container.style.gridTemplateColumns = 'repeat(auto-fill, minmax(300px, 1fr))';
    }
    
    document.getElementById('modalSave')?.addEventListener('click', function() {
        const selectedIds = [];
        document.querySelectorAll('#availableTestsContainer .test-card.selected').forEach(card => {
            selectedIds.push(card.dataset.testId);
        });
        
        selectedTestsInput.value = selectedIds.join(',');
        renderSelectedTests(selectedIds);
        closeTestModal();
    });
    
    function renderSelectedTests(selectedIds) {
        const container = selectedTestsContainer;
        const allTests = document.querySelectorAll('#availableTestsContainer .test-card');
        
        if (selectedIds.length === 0) {
            container.innerHTML = `
                <div class="no-tests">
                    <i class="fas fa-vial"></i>
                    <h5>${noTestsAddedText}</h5>
                    <button type="button" class="btn btn-outline" id="openTestModal2">${addTestsText}</button>
                </div>`;
            
            const newBtn = document.getElementById('openTestModal2');
            if (newBtn) {
                const newBtnClone = newBtn.cloneNode(true);
                newBtn.parentNode.replaceChild(newBtnClone, newBtn);
                newBtnClone.addEventListener('click', openTestModal);
            }
            updateStats();
            return;
        }
        
        let html = '';
        selectedIds.forEach(id => {
            const testCard = Array.from(allTests).find(card => card.dataset.testId === id);
            if (testCard) {
                html += `
                    <div class="selected-test-card" data-test-id="${id}" style="cursor: default;">
                        <div class="selected-test-info">
                            <div class="selected-test-header">
                                <span class="selected-test-name">${escapeHtml(testCard.dataset.testName)}</span>
                                <span class="selected-test-code"><i class="fas fa-hashtag"></i> ${escapeHtml(testCard.dataset.testCode)}</span>
                                <div class="selected-test-price">$${parseFloat(testCard.dataset.testPrice).toFixed(2)}</div>
                            </div>
                            <div class="selected-test-duration"><i class="fas fa-clock"></i> ${testCard.dataset.testDuration} ${hoursText}</div>
                            <div class="selected-test-meta">
                                <div class="meta-item"><i class="fas fa-flask"></i> ${laboratoryText}</div>
                                <div class="meta-item"><i class="fas fa-check-circle"></i> ${activeText}</div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
        
        container.innerHTML = html;
        updateStats();
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    document.getElementById('openTestModal')?.addEventListener('click', openTestModal);
    
    const openTestModal2 = document.getElementById('openTestModal2');
    if (openTestModal2) {
        openTestModal2.addEventListener('click', openTestModal);
    }
    
    document.getElementById('modalClose')?.addEventListener('click', closeTestModal);
    document.getElementById('modalCancel')?.addEventListener('click', closeTestModal);
    
    const testSearch = document.getElementById('testSearch');
    if (testSearch) {
        testSearch.addEventListener('input', filterTests);
    }
    
    document.getElementById('availableTestsContainer')?.addEventListener('click', function(e) {
        const card = e.target.closest('.test-card');
        if (card) {
            card.classList.toggle('selected');
            filterTests();
            const count = document.querySelectorAll('#availableTestsContainer .test-card.selected').length;
            const modalSelectedCount = document.getElementById('modalSelectedCount');
            if (modalSelectedCount) modalSelectedCount.textContent = count;
        }
    });
    
    if (testModal) {
        testModal.addEventListener('cancel', function(e) {
            e.preventDefault();
            closeTestModal();
        });
    }
    
    updateStats();
});