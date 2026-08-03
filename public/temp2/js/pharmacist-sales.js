document.addEventListener('DOMContentLoaded', function() {

// ============================================================
// DIALOG SCROLL BLOCK
// ============================================================
function blockScroll() {
    document.body.style.overflow = 'hidden';
}

function unblockScroll() {
    document.body.style.overflow = '';
}

// ============================================================
// LOCALSTORAGE - SAVATLARNI SAQLASH VA TIKLASH
// ============================================================
function saveCartToStorage() {
    const cartItems = document.querySelectorAll('#cartItems .cart-item');
    const items = [];
    cartItems.forEach(function(item) {
        items.push({
            id: item.dataset.id,
            name: item.querySelector('.cart-item-name').textContent,
            strength: item.querySelector('.cart-item-detail').textContent.trim().split(' x ')[0] || '',
            totalPrice: parseFloat(item.dataset.totalPrice),
            price: parseFloat(item.dataset.price),
            qty: parseInt(item.querySelector('.qty-display').textContent),
            type: item.dataset.type || 'dona',
            piecesPerBox: parseInt(item.dataset.piecesPerBox) || 1,
            stock: parseInt(item.dataset.stock) || 100
        });
    });
    localStorage.setItem('pharmacist_cart', JSON.stringify(items));
}

function saveBasketsToStorage() {
    const baskets = document.querySelectorAll('.sale-basket');
    const items = [];
    baskets.forEach(function(basket) {
        const basketItems = basket.querySelectorAll('.basket-item');
        const basketData = [];
        basketItems.forEach(function(item) {
            basketData.push({
                id: item.dataset.id,
                name: item.dataset.name,
                detail: item.dataset.detail || '',
                price: parseFloat(item.dataset.price),
                qty: parseInt(item.querySelector('.qty').textContent),
                type: item.dataset.type || 'dona',
                piecesPerBox: parseInt(item.dataset.piecesPerBox) || 1
            });
        });
        if (basketData.length > 0) {
            items.push({
                basketId: basket.dataset.basketId,
                items: basketData
            });
        }
    });
    localStorage.setItem('pharmacist_baskets', JSON.stringify(items));
}

function restoreCartFromStorage() {
    const cartData = localStorage.getItem('pharmacist_cart');
    if (cartData) {
        const items = JSON.parse(cartData);
        const cartItemsContainer = document.getElementById('cartItems');
        cartItemsContainer.innerHTML = '';
        items.forEach(function(item) {
            const totalPrice = item.price * item.qty;
            addToCart(item.id, item.name, item.strength, totalPrice, item.qty, item.type, item.piecesPerBox);
        });
        updateCartTotal();
        updateCartCount();
    }
}

function restoreBasketsFromStorage() {
    const basketsData = localStorage.getItem('pharmacist_baskets');
    if (basketsData) {
        const baskets = JSON.parse(basketsData);
        const pendingContainer = document.getElementById('pendingBaskets');
        pendingContainer.innerHTML = '';
        baskets.forEach(function(basketData, index) {
            const basketCount = index + 1;
            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0');

            const newBasket = document.createElement('div');
            newBasket.className = 'sale-basket mt-2';
            newBasket.dataset.basketId = basketData.basketId || basketCount;

            let itemsHtml = '';
            let total = 0;

            basketData.items.forEach(function(item) {
                const totalPrice = item.price * item.qty;
                itemsHtml += `
                    <div class="basket-item" data-id="${item.id}" data-name="${item.name}" data-detail="${item.detail}" data-price="${item.price}" data-type="${item.type}" data-pieces-per-box="${item.piecesPerBox}">
                        <span class="basket-item-name">${item.name} ${item.detail} x <span class="qty">${item.qty}</span> ${item.type}</span>
                        <div class="cart-item-actions">
                            <span class="basket-item-price currency-usd">$${totalPrice.toFixed(2)}</span>
                            <div class="basket-item-actions">
                                <button class="btn-minus-sm basket-minus" title="Kamaytirish"><i class="fas fa-minus"></i></button>
                                <span class="qty-display">${item.qty}</span>
                                <button class="btn-plus-sm basket-plus" title="Ko'paytirish"><i class="fas fa-plus"></i></button>
                            </div>
                            <i class="fas fa-trash-alt delete-from-basket" title="O'chirish"></i>   
                        </div>
                    </div>
                `;
                total += totalPrice;
            });

            const letter = String.fromCharCode(64 + basketCount);

            newBasket.innerHTML = `
                <div class="sale-basket-header" onclick="toggleBasket(this)">
                    <div class="basket-header-left">
                        <span class="status-dot status-dot-pending"></span>
                        <strong class="basket-id">Savat ${letter}</strong>
                        <small class="basket-time">${time}</small>
                        <span class="basket-count-badge">${basketData.items.length} ta</span>
                    </div>
                    <div class="basket-header-right">
                        <span class="basket-status-badge">Navbatda</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                </div>
                <div class="basket-content">
                    ${itemsHtml}
                    <div class="basket-total">
                        <span class="basket-total-label">Jami</span>
                        <span class="basket-total-amount currency-usd">$${total.toFixed(2)}</span>
                    </div>
                    <div class="transfer-btns">
                        <button class="btn-move-to-current move-to-current">
                            <i class="fas fa-arrow-right me-1"></i> Joriyga o'tkazish
                        </button>
                        <button class="btn-complete-basket complete-basket">
                            <i class="fas fa-check me-1"></i> To'lash
                        </button>
                        <button class="btn-cancel-basket cancel-basket">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;

            pendingContainer.appendChild(newBasket);
            attachBasketItemEvents(newBasket);
            updatePendingCount();
        });
    }
}

// Sahifa yuklanganda savatlarni tiklash
restoreCartFromStorage();
restoreBasketsFromStorage();

// Sahifa yopilganda yoki yangilanganda saqlash
window.addEventListener('beforeunload', function() {
    saveCartToStorage();
    saveBasketsToStorage();
});

// Har qanday o'zgarishda saqlash
function saveAllToStorage() {
    saveCartToStorage();
    saveBasketsToStorage();
}

// ============================================================
// MODAL (Dori qo'shish)
// ============================================================
const modal = document.getElementById('notificationModal');
const modalCloseBtn = document.getElementById('modalCloseBtn');
const modalCancelBtn = document.getElementById('modalCancelBtn');
const modalAddBtn = document.getElementById('modalAddBtn');
const modalTitle = document.getElementById('modalTitle');
const modalPriceInfo = document.getElementById('modalPriceInfo');
const modalType = document.getElementById('modalType');
const modalQuantity = document.getElementById('modalQuantity');

let currentMedicine = null;

function updatePriceInfo() {
    if (!currentMedicine) return;
    const type = modalType.value;
    const quantity = parseInt(modalQuantity.value) || 0;
    const boxPrice = currentMedicine.price;
    const piecesPerBox = currentMedicine.piecesPerBox;
    const perPiecePrice = boxPrice / piecesPerBox;

    let totalPrice = 0;
    let detail = '';

    if (type === 'dona') {
        totalPrice = perPiecePrice * quantity;
        detail = quantity + ' dona × $' + perPiecePrice.toFixed(2) + ' = $' + totalPrice.toFixed(2);
    } else {
        totalPrice = boxPrice * quantity;
        detail = quantity + ' quti × $' + boxPrice.toFixed(2) + ' = $' + totalPrice.toFixed(2) + ' (' + (quantity * piecesPerBox) + ' dona)';
    }

    modalPriceInfo.innerHTML = detail;
}

function openModal(medicine) {
    currentMedicine = medicine;
    
    modalTitle.textContent = 'Dorini qo\'shish: ' + medicine.name + ' ' + medicine.strength + ' (Qoldiq: ' + medicine.stock + ' ta)';
    
    modalType.value = 'dona';
    modalQuantity.value = 1;
    modalQuantity.max = medicine.stock;
    updatePriceInfo();
    modal.showModal();
    blockScroll();
}

function closeModal() {
    modal.close();
    currentMedicine = null;
    unblockScroll();
}

modalCloseBtn.addEventListener('click', closeModal);
modalCancelBtn.addEventListener('click', closeModal); 

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (modal.open) closeModal();
        if (checkoutModal.open) closeCheckoutModal();
        if (historyModal.open) closeHistoryModal();
    }
});

modalType.addEventListener('change', updatePriceInfo);
modalQuantity.addEventListener('input', updatePriceInfo);

document.querySelectorAll('.open-modal-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const medicine = {
            id: this.dataset.id,
            name: this.dataset.name,
            strength: this.dataset.strength,
            price: parseFloat(this.dataset.price),
            stock: parseInt(this.dataset.stock),
            piecesPerBox: parseInt(this.dataset.piecesPerBox)
        };
        openModal(medicine);
    });
});

modalAddBtn.addEventListener('click', function() {
    if (!currentMedicine) return;

    const type = modalType.value;
    const quantity = parseInt(modalQuantity.value);

    if (quantity < 1) {
        alert('Miqdor 1 dan kam bo\'lishi mumkin emas!');
        return;
    } 

    const boxPrice = currentMedicine.price;
    const piecesPerBox = currentMedicine.piecesPerBox;
    const perPiecePrice = boxPrice / piecesPerBox;

    let finalPrice = (type === 'dona') ? perPiecePrice * quantity : boxPrice * quantity;

    addToCart(
        currentMedicine.id,
        currentMedicine.name,
        currentMedicine.strength,
        finalPrice,
        quantity,
        type,
        currentMedicine.piecesPerBox
    );

    closeModal();
    saveAllToStorage();
});

modalQuantity.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') modalAddBtn.click();
});

// ============================================================
// CHECKOUT MODAL
// ============================================================
const checkoutModal = document.getElementById('checkoutModal');
const checkoutCloseBtn = document.getElementById('checkoutCloseBtn');
const checkoutCancelBtn = document.getElementById('checkoutCancelBtn');
const checkoutForm = document.getElementById('checkoutForm');
const checkoutItems = document.getElementById('checkoutItems');
const checkoutSummary = document.getElementById('checkoutSummary');
const hiddenInputs = document.getElementById('hiddenInputs');

let basketToRemove = null;

// Joriy savat uchun checkout
function openCheckoutModal() {
    const items = document.querySelectorAll('#cartItems .cart-item');
    if (items.length === 0) return;

    let itemsHtml = '';
    let total = 0;
    let itemIndex = 0;

    hiddenInputs.innerHTML = '';

    items.forEach(function(item, index) {
        const id = item.dataset.id;
        const name = item.querySelector('.cart-item-name').textContent;
        const detail = item.querySelector('.cart-item-detail').textContent.trim();
        const totalPrice = parseFloat(item.dataset.totalPrice);
        const qty = parseInt(item.querySelector('.qty-display').textContent);
        const type = item.dataset.type || 'dona';
        const perUnitPrice = totalPrice / qty;
        
        total += totalPrice;

        itemsHtml += ` 
            <div class="checkout-item">
                <span class="item-detail">${index + 1}. ${name} ${detail}</span>
                <span class="item-price">$${totalPrice.toFixed(2)}</span>
            </div> 
        `;

        const unit = type === 'dona' ? 'piece' : 'box';
        hiddenInputs.innerHTML += `
            <input type="hidden" name="items[${itemIndex}][medicine_id]" value="${id}">
            <input type="hidden" name="items[${itemIndex}][unit]" value="${unit}">
            <input type="hidden" name="items[${itemIndex}][quantity]" value="${qty}">
            <input type="hidden" name="items[${itemIndex}][price]" value="${perUnitPrice.toFixed(2)}">
        `;
        itemIndex++;
    });

    const paymentMethod = document.getElementById('paymentMethod');
    const methodText = paymentMethod.options[paymentMethod.selectedIndex].text;

    checkoutItems.innerHTML = itemsHtml;

    checkoutSummary.innerHTML = `
        <div class="summary-row">
            <span>To'lov usuli:</span>
            <span>${methodText}</span>
        </div>
        <div class="summary-row total">
            <span>Jami summa:</span>
            <span class="total-amount">$${total.toFixed(2)}</span>
        </div>
    `;

    hiddenInputs.innerHTML += `
        <input type="hidden" name="payment_method" value="${paymentMethod.value}">
    `;

    basketToRemove = null;
    checkoutModal.showModal();
    blockScroll();
}

// Navbatdagi savat uchun checkout
function openCheckoutModalForBasket(basketItems, basketElement) {
    if (basketItems.length === 0) return;

    let itemsHtml = '';
    let total = 0;
    let itemIndex = 0;

    hiddenInputs.innerHTML = '';

    basketItems.forEach(function(item, index) {
        const id = item.dataset.id;
        const name = item.dataset.name;
        const fullDetail = item.dataset.detail || '';
        const strength = fullDetail.split(' x ')[0] || fullDetail;
        const price = parseFloat(item.dataset.price);
        const qty = parseInt(item.querySelector('.qty').textContent);
        const type = item.dataset.type || 'dona';
        const totalPrice = price * qty;
        
        total += totalPrice;

        itemsHtml += ` 
            <div class="checkout-item">
                <span class="item-detail">${index + 1}. ${name} ${strength} x${qty} ${type}</span>
                <span class="item-price">$${totalPrice.toFixed(2)}</span>
            </div> 
        `;

        const unit = type === 'dona' ? 'piece' : 'box';
        hiddenInputs.innerHTML += `
            <input type="hidden" name="items[${itemIndex}][medicine_id]" value="${id}">
            <input type="hidden" name="items[${itemIndex}][unit]" value="${unit}">
            <input type="hidden" name="items[${itemIndex}][quantity]" value="${qty}">
            <input type="hidden" name="items[${itemIndex}][price]" value="${price.toFixed(2)}">
        `;
        itemIndex++;
    });

    const paymentMethod = document.getElementById('paymentMethod');
    const methodText = paymentMethod.options[paymentMethod.selectedIndex].text;

    checkoutItems.innerHTML = itemsHtml;

    checkoutSummary.innerHTML = `
        <div class="summary-row">
            <span>To'lov usuli:</span>
            <span>${methodText}</span>
        </div>
        <div class="summary-row total">
            <span>Jami summa:</span>
            <span class="total-amount">$${total.toFixed(2)}</span>
        </div>
    `;

    hiddenInputs.innerHTML += `
        <input type="hidden" name="payment_method" value="${paymentMethod.value}">
    `;

    basketToRemove = basketElement;
    checkoutModal.showModal();
    blockScroll();
}

function closeCheckoutModal() {
    checkoutModal.close();
    unblockScroll();
}

checkoutCloseBtn.addEventListener('click', function() {
    basketToRemove = null;
    closeCheckoutModal();
});

checkoutCancelBtn.addEventListener('click', function() {
    basketToRemove = null;
    closeCheckoutModal();
});

checkoutForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const items = document.querySelectorAll('#cartItems .cart-item');
    if (items.length === 0 && !basketToRemove) {
        alert('Savat bo\'sh!');
        return;
    }

    const form = this;
    
    if (basketToRemove) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'basket_id';
        input.value = basketToRemove.dataset.basketId || 'basket';
        form.appendChild(input);
    }

    form.submit();
    
    setTimeout(function() {
        if (basketToRemove) {
            basketToRemove.remove();
            basketToRemove = null;
            updatePendingCount();
            saveAllToStorage();
        } else {
            const cartItems = document.querySelectorAll('#cartItems .cart-item');
            cartItems.forEach(function(item) {
                item.remove();
            });
            updateCartTotal();
            updateCartCount();
            saveAllToStorage();
        }
        closeCheckoutModal();
    }, 500);
});

// ============================================================
// HISTORY MODAL
// ============================================================
const historyModal = document.getElementById('historyModal');
const historyCloseBtn = document.getElementById('historyCloseBtn');
const historyDate = document.getElementById('historyDate');

const today = new Date();
historyDate.textContent = today.getDate().toString().padStart(2, '0') + '.' + 
                        (today.getMonth() + 1).toString().padStart(2, '0') + '.' + 
                        today.getFullYear();

function openHistoryModal() {
    historyModal.showModal();
    blockScroll();
}

function closeHistoryModal() {
    historyModal.close();
    unblockScroll();
}

document.getElementById('historyBtn').addEventListener('click', openHistoryModal);
historyCloseBtn.addEventListener('click', closeHistoryModal); 

// ============================================================
// AJAX SEARCH
// ============================================================
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const clearSearchBtn = document.getElementById('clearSearchBtn');
const clearSearchButton = document.getElementById('clearSearchButton');

// Route ni window dan olish
const searchRoute = window.searchRoute || '/pharmacist/search-medicines';

function updateClearButtonVisibility() {
    if (searchInput.value.trim().length > 0) {
        clearSearchBtn.style.display = 'flex';
    } else {
        clearSearchBtn.style.display = 'none';
    }
}

updateClearButtonVisibility();

let searchTimeout = null;

function performSearch() {
    const search = searchInput.value.trim();
    
    if (search.length === 0) {
        updateClearButtonVisibility();
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.querySelector('#medicineTableBody');
                const newPagination = doc.querySelector('#paginationContainer');
                
                if (newTable) {
                    document.getElementById('medicineTableBody').innerHTML = newTable.innerHTML;
                }
                if (newPagination) {
                    document.getElementById('paginationContainer').innerHTML = newPagination.innerHTML;
                }
                
                document.querySelectorAll('.open-modal-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const medicine = {
                            id: this.dataset.id,
                            name: this.dataset.name,
                            strength: this.dataset.strength,
                            price: parseFloat(this.dataset.price),
                            stock: parseInt(this.dataset.stock),
                            piecesPerBox: parseInt(this.dataset.piecesPerBox)
                        };
                        openModal(medicine);
                    });
                });
            })
            .catch(error => console.error('Xatolik:', error));
        return;
    }
    
    updateClearButtonVisibility();
    
    fetch(searchRoute + '?search=' + encodeURIComponent(search))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateTable(data.data);
            }
        })
        .catch(error => {
            console.error('Xatolik:', error);
            alert('Qidiruvda xatolik yuz berdi');
        });
}

function updateTable(medicines) {
    const tbody = document.getElementById('medicineTableBody');
    tbody.innerHTML = '';
    
    if (medicines.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-3"> 
                ${window.translations.no_medicines}
                </td>
            </tr>
        `;
        return;
    }
    
    medicines.forEach((medicine, index) => {
        const tr = document.createElement('tr');
        tr.dataset.medicineId = medicine.medicine_id;
        tr.dataset.name = medicine.name;
        tr.dataset.strength = medicine.generic_name || '';
        tr.dataset.price = medicine.price || 0;
        tr.dataset.stock = medicine.stock_boxes;
        tr.dataset.piecesPerBox = medicine.units_per_box || 1;
        
        tr.innerHTML = `
            <td class="row-number">${index + 1}</td>
            <td>
                <strong class="medicine-name">${medicine.name}</strong>
                <small class="medicine-strength">${medicine.generic_name || ''}</small>
            </td>
            <td class="table-text">${medicine.form || 'N/A'}</td>
            <td>
                <span class="status-badge"
                    style="color: ${medicine.status.text_color};
                            background-color: ${medicine.status.bg_color};">
                    <i class="${medicine.status.icon}"></i>
                    ${medicine.status.text}
                </span>
            </td>
            <td class="currency-usd">
                $${(medicine.price || 0).toFixed(2)}
            </td>
            <td>
                <button class="btn-add-simple open-modal-btn" 
                        data-id="${medicine.medicine_id}"
                        data-name="${medicine.name}"
                        data-strength="${medicine.generic_name || ''}"
                        data-price="${medicine.price || 0}"
                        data-stock="${medicine.stock_boxes}"
                        data-pieces-per-box="${medicine.units_per_box || 1}">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
    
    document.querySelectorAll('.open-modal-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const medicine = {
                id: this.dataset.id,
                name: this.dataset.name,
                strength: this.dataset.strength,
                price: parseFloat(this.dataset.price),
                stock: parseInt(this.dataset.stock),
                piecesPerBox: parseInt(this.dataset.piecesPerBox)
            };
            openModal(medicine);
        });
    });
}

searchInput.addEventListener('input', function() {
    updateClearButtonVisibility();
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(performSearch, 300);
});

searchInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        clearTimeout(searchTimeout);
        performSearch();
    }
});

searchBtn.addEventListener('click', function(e) {
    e.preventDefault();
    performSearch();
});

if (clearSearchButton) {
    clearSearchButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        searchInput.value = '';
        clearSearchBtn.style.display = 'none';
        
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.querySelector('#medicineTableBody');
                const newPagination = doc.querySelector('#paginationContainer');
                
                if (newTable) {
                    document.getElementById('medicineTableBody').innerHTML = newTable.innerHTML;
                }
                if (newPagination) {
                    document.getElementById('paginationContainer').innerHTML = newPagination.innerHTML;
                }
                
                document.querySelectorAll('.open-modal-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const medicine = {
                            id: this.dataset.id,
                            name: this.dataset.name,
                            strength: this.dataset.strength,
                            price: parseFloat(this.dataset.price),
                            stock: parseInt(this.dataset.stock),
                            piecesPerBox: parseInt(this.dataset.piecesPerBox)
                        };
                        openModal(medicine);
                    });
                });
            })
            .catch(error => console.error('Xatolik:', error));
    });
}

// ============================================================
// 1. JORIY SAVATNI YOPISH
// ============================================================
const closeCartBtn = document.getElementById('closeCartBtn');
const cartBody = document.getElementById('cartBody');
let cartClosed = false;

if (closeCartBtn) {
    closeCartBtn.addEventListener('click', function() {
        if (cartClosed) {
            cartBody.style.display = 'block';
            cartClosed = false;
            this.innerHTML = '<i class="fas fa-times"></i>';
            this.title = 'Savatchani yopish';
        } else {
            cartBody.style.display = 'none';
            cartClosed = true;
            this.innerHTML = '<i class="fas fa-chevron-down"></i>';
            this.title = 'Savatchani ochish';
        }
    });
}

// ============================================================
// 2. JORIY SAVATDAN O'CHIRISH
// ============================================================
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-from-basket') && e.target.closest('.cart-item')) {
        const item = e.target.closest('.cart-item');
        if (confirm('Bu dorini savatchadan o\'chirmoqchimisiz?')) {
            item.remove();
            updateCartTotal();
            updateCartCount();
            saveAllToStorage();
        }
    }
});

// ============================================================
// 3. JORIY SAVATDA "+" VA "-" TUGMALARI
// ============================================================
document.addEventListener('click', function(e) {
    if (e.target.closest('.cart-plus')) {
        const item = e.target.closest('.cart-item');
        const qtyDisplay = item.querySelector('.qty-display');
        const qtySpan = item.querySelector('.qty');
        let qty = parseInt(qtyDisplay.textContent);
        const stock = parseInt(item.dataset.stock);
        if (qty < stock) {
            qty++;
            qtyDisplay.textContent = qty;
            if (qtySpan) qtySpan.textContent = qty;
            updateCartItemTotal(item);
            updateCartTotal();
            saveAllToStorage();
        }
    }

    if (e.target.closest('.cart-minus')) {
        const item = e.target.closest('.cart-item');
        const qtyDisplay = item.querySelector('.qty-display');
        const qtySpan = item.querySelector('.qty');
        let qty = parseInt(qtyDisplay.textContent);
        if (qty > 1) {
            qty--;
            qtyDisplay.textContent = qty;
            if (qtySpan) qtySpan.textContent = qty;
            updateCartItemTotal(item);
            updateCartTotal();
            saveAllToStorage();
        }
    }
});

// ============================================================
// 4. SAVATNI TOZALASH
// ============================================================
const clearCartBtn = document.getElementById('clearCartBtn');
if (clearCartBtn) {
    clearCartBtn.addEventListener('click', function() {
        const items = document.querySelectorAll('#cartItems .cart-item');
        if (items.length === 0) return;

        if (confirm('Savatni tozalashni xohlaysizmi?')) {
            items.forEach(function(item) {
                item.remove();
            });
            updateCartTotal();
            updateCartCount();
            saveAllToStorage();
        }
    });
}

// ============================================================
// 5. NAVBATDAGI SAVATCHADA "+" VA "-" TUGMALARI
// ============================================================
document.addEventListener('click', function(e) {
    if (e.target.closest('.basket-plus')) {
        const item = e.target.closest('.basket-item');
        const qtySpan = item.querySelector('.qty');
        const qtyDisplay = item.querySelector('.qty-display');
        let qty = parseInt(qtySpan.textContent);
        qty++;
        qtySpan.textContent = qty;
        if (qtyDisplay) qtyDisplay.textContent = qty;
        updateBasketItemTotal(item);
        updateBasketTotal(item.closest('.sale-basket'));
        updateBasketCount(item.closest('.sale-basket'));
        saveAllToStorage();
    }

    if (e.target.closest('.basket-minus')) {
        const item = e.target.closest('.basket-item');
        const qtySpan = item.querySelector('.qty');
        const qtyDisplay = item.querySelector('.qty-display');
        let qty = parseInt(qtySpan.textContent);
        if (qty > 1) {
            qty--;
            qtySpan.textContent = qty;
            if (qtyDisplay) qtyDisplay.textContent = qty;
            updateBasketItemTotal(item);
            updateBasketTotal(item.closest('.sale-basket'));
            updateBasketCount(item.closest('.sale-basket'));
            saveAllToStorage();
        }
    }
});

// ============================================================
// 6. NAVBATDAGI SAVATCHADAN O'CHIRISH
// ============================================================
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-from-basket') && e.target.closest('.basket-item')) {
        const item = e.target.closest('.basket-item');
        if (confirm('Bu dorini savatchadan o\'chirmoqchimisiz?')) {
            item.remove();
            updateBasketTotal(item.closest('.sale-basket'));
            updateBasketCount(item.closest('.sale-basket'));
            saveAllToStorage();
        }
    }
});

// ============================================================
// 7. NAVBATDAGI SAVATNI JORIYGA O'TKAZISH
// ============================================================
document.addEventListener('click', function(e) {
    if (e.target.closest('.move-to-current')) {
        const basket = e.target.closest('.sale-basket');
        const basketItems = basket.querySelectorAll('.basket-item');

        if (basketItems.length === 0) return;

        const cartItemsContainer = document.getElementById('cartItems');

        basketItems.forEach(function(item) {
            const id = item.dataset.id;
            const name = item.dataset.name;
            const fullDetail = item.dataset.detail || '';
            const strength = fullDetail.split(' x ')[0] || fullDetail;
            const price = parseFloat(item.dataset.price);
            const qty = parseInt(item.querySelector('.qty').textContent);
            const type = item.dataset.type || 'dona';
            const piecesPerBox = parseInt(item.dataset.piecesPerBox) || 1;
            const totalPrice = price * qty;
            addToCart(id, name, strength, totalPrice, qty, type, piecesPerBox);
        });

        basket.remove();
        updateCartTotal();
        updateCartCount();
        updatePendingCount();
        saveAllToStorage();
    }
});

// ============================================================
// 8. JORIY SAVATNI NAVBATGA O'TKAZISH
// ============================================================
const moveToQueueBtn = document.getElementById('moveToQueueBtn');
if (moveToQueueBtn) {
    moveToQueueBtn.addEventListener('click', function() {
        const cartItems = document.querySelectorAll('#cartItems .cart-item');

        if (cartItems.length === 0) return;

        const pendingContainer = document.getElementById('pendingBaskets');
        const basketCount = document.querySelectorAll('.sale-basket').length + 1;
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ':' +
            now.getMinutes().toString().padStart(2, '0');

        const newBasket = document.createElement('div');
        newBasket.className = 'sale-basket mt-2';
        newBasket.dataset.basketId = basketCount;

        let itemsHtml = '';
        let total = 0;

        cartItems.forEach(function(item) {
            const id = item.dataset.id;
            const name = item.querySelector('.cart-item-name').textContent;
            const detailEl = item.querySelector('.cart-item-detail');
            const fullDetail = detailEl ? detailEl.textContent.trim() : '';
            const strength = fullDetail.split(' x ')[0] || fullDetail;
            const qty = parseInt(item.querySelector('.qty-display').textContent);
            const totalPrice = parseFloat(item.dataset.totalPrice);
            const type = item.dataset.type || 'dona';
            const piecesPerBox = parseInt(item.dataset.piecesPerBox) || 1;
            const perUnitPrice = totalPrice / qty;

            itemsHtml += `
                <div class="basket-item" data-id="${id}" data-name="${name}" data-detail="${strength}" data-price="${perUnitPrice}" data-type="${type}" data-pieces-per-box="${piecesPerBox}">
                    <span class="basket-item-name">${name} ${strength} x <span class="qty">${qty}</span> ${type}</span>
                    <div class="cart-item-actions">
                        <span class="basket-item-price currency-usd">$${totalPrice.toFixed(2)}</span>
                        <div class="basket-item-actions">
                            <button class="btn-minus-sm basket-minus" title="Kamaytirish"><i class="fas fa-minus"></i></button>
                            <span class="qty-display">${qty}</span>
                            <button class="btn-plus-sm basket-plus" title="Ko'paytirish"><i class="fas fa-plus"></i></button>
                        </div>
                        <i class="fas fa-trash-alt delete-from-basket" title="O'chirish"></i>   
                    </div>
                </div>
            `;

            total += totalPrice;
        });

        const letter = String.fromCharCode(64 + basketCount);

        newBasket.innerHTML = `
            <div class="sale-basket-header" onclick="toggleBasket(this)">
                <div class="basket-header-left">
                    <span class="status-dot status-dot-pending"></span>
                    <strong class="basket-id">Savat ${letter}</strong>
                    <small class="basket-time">${time}</small>
                    <span class="basket-count-badge">${cartItems.length} ta</span>
                </div>
                <div class="basket-header-right">
                    <span class="basket-status-badge">Navbatda</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
            </div>
            <div class="basket-content">
                ${itemsHtml}
                <div class="basket-total">
                    <span class="basket-total-label">Jami</span>
                    <span class="basket-total-amount currency-usd">$${total.toFixed(2)}</span>
                </div>
                <div class="transfer-btns">
                    <button class="btn-move-to-current move-to-current">
                        <i class="fas fa-arrow-right me-1"></i> Joriyga o'tkazish
                    </button>
                    <button class="btn-complete-basket complete-basket">
                        <i class="fas fa-check me-1"></i> To'lash
                    </button>
                    <button class="btn-cancel-basket cancel-basket">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;

        pendingContainer.appendChild(newBasket);

        cartItems.forEach(function(item) {
            item.remove();
        });

        attachBasketItemEvents(newBasket);
        updateCartTotal();
        updateCartCount();
        updatePendingCount();
        saveAllToStorage();
    });
}

// ============================================================
// 9. SAVATCHANI YOPISH/OCHISH (TOGGLE)
// ============================================================
window.toggleBasket = function(header) {
    const content = header.nextElementSibling;
    const icon = header.querySelector('.toggle-icon');

    if (content.classList.contains('basket-content-hidden')) {
        content.classList.remove('basket-content-hidden');
        if (icon) {
            icon.className = 'fas fa-chevron-down toggle-icon';
        }
    } else {
        content.classList.add('basket-content-hidden');
        if (icon) {
            icon.className = 'fas fa-chevron-up toggle-icon';
        }
    }
};

// ============================================================
// 10. NAVBATDAGI SAVATNI TO'LASH
// ============================================================
document.addEventListener('click', function(e) {
    if (e.target.closest('.complete-basket')) {
        const basket = e.target.closest('.sale-basket');
        const basketItems = basket.querySelectorAll('.basket-item');
        
        if (basketItems.length === 0) {
            alert('Savat bo\'sh!');
            return;
        }

        openCheckoutModalForBasket(basketItems, basket);
    }
});

// ============================================================
// 11. SAVATCHANI BEKOR QILISH (Navbatdagilar uchun)
// ============================================================
document.addEventListener('click', function(e) {
    if (e.target.closest('.cancel-basket')) {
        const basket = e.target.closest('.sale-basket');
        if (confirm('Ushbu savatchani bekor qilmoqchimisiz?')) {
            basket.remove();
            updatePendingCount();
            saveAllToStorage();
        }
    }
});

// ============================================================
// 12. JORIY SAVATNI SOTISH
// ============================================================
const completeSaleBtn = document.getElementById('completeSaleBtn');
if (completeSaleBtn) {
    completeSaleBtn.addEventListener('click', function() {
        const items = document.querySelectorAll('#cartItems .cart-item');
        if (items.length === 0) {
            alert('Savat bo\'sh!');
            return;
        }
        openCheckoutModal();
    });
}

// ============================================================
// YORDAMCHI FUNKSIYALAR
// ============================================================

function addToCart(id, name, strength, totalPrice, quantity, type, piecesPerBox) {
    const cartItems = document.getElementById('cartItems');

    const uniqueKey = id + '_' + type;
    const existing = cartItems.querySelector(`.cart-item[data-unique="${uniqueKey}"]`);

    if (existing) {
        const qtyDisplay = existing.querySelector('.qty-display');
        const qtySpan = existing.querySelector('.qty');
        let currentQty = parseInt(qtyDisplay.textContent);
        const stock = parseInt(existing.dataset.stock);
        if (currentQty + quantity > stock) {
            alert('Qoldiqda ' + stock + ' ta bor!');
            return;
        }
        currentQty += quantity;
        qtyDisplay.textContent = currentQty;
        if (qtySpan) qtySpan.textContent = currentQty;
        
        const perUnitPrice = parseFloat(existing.dataset.price);
        const newTotal = perUnitPrice * currentQty;
        existing.dataset.totalPrice = newTotal;
        
        const totalSpan = existing.querySelector('.cart-item-total');
        totalSpan.textContent = '$' + newTotal.toFixed(2);
        
        updateCartTotal();
        updateCartCount();
        return;
    }

    const newItem = document.createElement('div');
    newItem.className = 'cart-item';
    newItem.dataset.id = id;
    newItem.dataset.totalPrice = totalPrice;
    newItem.dataset.price = totalPrice / quantity;
    newItem.dataset.stock = 100;
    newItem.dataset.unique = uniqueKey;
    newItem.dataset.type = type;
    newItem.dataset.piecesPerBox = piecesPerBox;
    
    newItem.innerHTML = `
        <div class="cart-item-info">
            <strong class="cart-item-name">${name}</strong>
            <small class="cart-item-detail">${strength} x <span class="qty">${quantity}</span> ${type}</small>
        </div>
        <div class="cart-item-actions">
            <span class="cart-item-total currency-usd">$${totalPrice.toFixed(2)}</span>
            <div class="cart-quantity-group">
                <button class="btn-minus-sm cart-minus" title="Kamaytirish"><i class="fas fa-minus"></i></button>
                <span class="qty-display">${quantity}</span>
                <button class="btn-plus-sm cart-plus" title="Ko'paytirish"><i class="fas fa-plus"></i></button>
            </div>
            <i class="fas fa-trash-alt delete-from-basket" title="O'chirish"></i>
        </div>
    `;
    cartItems.appendChild(newItem);

    updateCartTotal();
    updateCartCount();
}

function attachBasketItemEvents(basket) {
    basket.querySelectorAll('.basket-plus').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const item = this.closest('.basket-item');
            const qtySpan = item.querySelector('.qty');
            const qtyDisplay = item.querySelector('.qty-display');
            let qty = parseInt(qtySpan.textContent);
            qty++;
            qtySpan.textContent = qty;
            if (qtyDisplay) qtyDisplay.textContent = qty;
            updateBasketItemTotal(item);
            updateBasketTotal(item.closest('.sale-basket'));
            updateBasketCount(item.closest('.sale-basket'));
            saveAllToStorage();
        });
    });

    basket.querySelectorAll('.basket-minus').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const item = this.closest('.basket-item');
            const qtySpan = item.querySelector('.qty');
            const qtyDisplay = item.querySelector('.qty-display');
            let qty = parseInt(qtySpan.textContent);
            if (qty > 1) {
                qty--;
                qtySpan.textContent = qty;
                if (qtyDisplay) qtyDisplay.textContent = qty;
                updateBasketItemTotal(item);
                updateBasketTotal(item.closest('.sale-basket'));
                updateBasketCount(item.closest('.sale-basket'));
                saveAllToStorage();
            }
        });
    });

    basket.querySelectorAll('.delete-from-basket').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const item = this.closest('.basket-item');
            if (confirm('Bu dorini savatchadan o\'chirmoqchimisiz?')) {
                item.remove();
                updateBasketTotal(item.closest('.sale-basket'));
                updateBasketCount(item.closest('.sale-basket'));
                saveAllToStorage();
            }
        });
    });

    basket.querySelectorAll('.move-to-current').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const basketEl = this.closest('.sale-basket');
            const basketItems = basketEl.querySelectorAll('.basket-item');

            if (basketItems.length === 0) return;

            const cartItemsContainer = document.getElementById('cartItems');

            basketItems.forEach(function(item) {
                const id = item.dataset.id;
                const name = item.dataset.name;
                const fullDetail = item.dataset.detail || '';
                const strength = fullDetail.split(' x ')[0] || fullDetail;
                const price = parseFloat(item.dataset.price);
                const qty = parseInt(item.querySelector('.qty').textContent);
                const type = item.dataset.type || 'dona';
                const piecesPerBox = parseInt(item.dataset.piecesPerBox) || 1;
                const totalPrice = price * qty;
                addToCart(id, name, strength, totalPrice, qty, type, piecesPerBox);
            });

            basketEl.remove();
            updateCartTotal();
            updateCartCount();
            updatePendingCount();
            saveAllToStorage();
        });
    });

    basket.querySelectorAll('.cancel-basket').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const basketEl = this.closest('.sale-basket');
            if (confirm('Ushbu savatchani bekor qilmoqchimisiz?')) {
                basketEl.remove();
                updatePendingCount();
                saveAllToStorage();
            }
        });
    });
}

function updateCartItemTotal(item) {
    const qty = parseInt(item.querySelector('.qty-display').textContent);
    const price = parseFloat(item.dataset.price);
    const newTotal = price * qty;
    item.dataset.totalPrice = newTotal;
    const totalSpan = item.querySelector('.cart-item-total');
    totalSpan.textContent = '$' + newTotal.toFixed(2);
}

function updateBasketItemTotal(item) {
    const price = parseFloat(item.dataset.price);
    const qty = parseInt(item.querySelector('.qty').textContent);
    const total = price * qty;
    const priceEl = item.querySelector('.basket-item-price');
    if (priceEl) {
        priceEl.textContent = '$' + total.toFixed(2);
    }
}

function updateCartTotal() {
    const items = document.querySelectorAll('#cartItems .cart-item');
    let total = 0;
    items.forEach(function(item) {
        const totalSpan = item.querySelector('.cart-item-total');
        if (totalSpan) {
            const val = parseFloat(totalSpan.textContent.replace('$', ''));
            total += val || 0;
        }
    });
    const totalEl = document.getElementById('cartTotal');
    if (totalEl) {
        totalEl.textContent = '$' + total.toFixed(2);
    }
}

function updateCartCount() {
    const count = document.querySelectorAll('#cartItems .cart-item').length;
    const countEl = document.getElementById('cartItemCount');
    const countEl2 = document.getElementById('cartCount');
    if (countEl) countEl.textContent = count;
    if (countEl2) countEl2.textContent = count;
}

function updateBasketTotal(basket) {
    const items = basket.querySelectorAll('.basket-item');
    let total = 0;
    items.forEach(function(item) {
        const priceEl = item.querySelector('.basket-item-price');
        if (priceEl) {
            const val = parseFloat(priceEl.textContent.replace('$', ''));
            total += val || 0;
        }
    });
    const totalEl = basket.querySelector('.basket-total .basket-total-amount');
    if (totalEl) {
        totalEl.textContent = '$' + total.toFixed(2);
    }
}

function updateBasketCount(basket) {
    const count = basket.querySelectorAll('.basket-item').length;
    const badge = basket.querySelector('.sale-basket-header .basket-count-badge');
    if (badge) {
        badge.textContent = count + ' ta';
    }
}

function updatePendingCount() {
    const count = document.querySelectorAll('.sale-basket').length;
    const el = document.getElementById('pendingCount');
    if (el) {
        el.textContent = count + ' ta';
    }
}
}); 