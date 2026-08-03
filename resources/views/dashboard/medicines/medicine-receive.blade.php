<x-layouts.main.website>
    <x-slot:title>
        @lang('words.medication_intake')
    </x-slot:title>

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('medicine.inventory') }}" class="text-decoration-none">
                        @lang('words.pharmacy_inventory')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.medication_intake')
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container pt-4">
        <!-- Action Bar -->
        <div class="action-bar">
            <div class="left-actions">
                <button class="add-nurse-btn" id="addMedicineBtn">
                    <i class="fas fa-plus"></i> @lang('words.add_another_medicine')
                </button>
            </div>
        </div>

        <!-- Receive Form -->
        <div class="inventory-medicine-table-container">
            <div class="table-header">
                <div class="table-actions"></div>
            </div>
            <form method="POST" action="{{ route('medicine.receive.complete') }}" id="receiveForm">
                @csrf
                
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th class="table-text">#</th>
                                <th class="table-text">@lang('words.name')</th>
                                <th class="table-text">@lang('words.stock_boxes')</th>
                                <th class="table-text">@lang('words.pieces_per_box')</th>
                                <th class="table-text">@lang('words.total_pieces')</th>
                                <th class="table-text">@lang('words.receive_date')</th>
                                <th class="table-text">@lang('words.status')</th>
                                <th class="table-text">@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @include('partials.table-body.medicine-receive')
                        </tbody>
                    </table>
                </div>
                
                <div class="submit-section">
                    <div class="submit-actions">
                        <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('medicine.inventory') }}'">
                            <i class="fas fa-times"></i> @lang('words.cancel')
                        </button>
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <i class="fas fa-check"></i> @lang('words.save_and_finish')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('partials.modals.create-modals.medicine-receive')
    @include('partials.modals.edit-modals.medicine-receive')
    @include('partials.modals.show-modals.medicine-receive')
    @include('partials.modals.delete-modals.medicine-receive')

    <style>
        /* ===== DIALOG SCROLL BLOCK ===== */
        /* Dialog ochilganda body scrollni bloklash */
        body.dialog-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        /* Dialog backdrop */
        dialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }

        /* Dialog ochilganda scrollbar yo'qolishining oldini olish */
        body.dialog-open {
            padding-right: var(--scrollbar-width, 0px);
        }

        /* Modal ichida scroll */
        .notification-modal .modal-body {
            max-height: 60vh;
            overflow-y: auto; 
        }

        /* Modal ichidagi scrollbar stilizatsiyasi */
        .notification-modal .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .notification-modal .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .notification-modal .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .notification-modal .modal-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* ===== MAVJUD STILLAR ===== */
        .inventory-table-container th {
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .inventory-table-container td,
            .inventory-table-container th { 
                font-size: 11px;
            }

            .inventory-table-container table th:nth-child(6),
            .inventory-table-container table td:nth-child(6) {
                display: none !important;
            }

            .inventory-medicine-table-container th {
            font-size: 11px;
            }
        }

        /* Form row - katta ekranda 2 ta, mobileda 1 ta */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-row:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style> 

    <script>
        // ===== DIALOG OPEN =====
        function openDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            if (dialog) {
                const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
                document.documentElement.style.setProperty('--scrollbar-width', scrollbarWidth + 'px');
                dialog.showModal();
                document.body.classList.add('dialog-open');
            }
        }

        // ===== DIALOG CLOSE =====
        function closeDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            if (dialog) {
                dialog.close();
                const openDialogs = document.querySelectorAll('dialog[open]');
                if (openDialogs.length === 0) {
                    document.body.classList.remove('dialog-open');
                    document.documentElement.style.setProperty('--scrollbar-width', '0px');
                }
            }
        }

        // ===== ESC KEY =====
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openDialogs = document.querySelectorAll('dialog[open]');
                if (openDialogs.length > 0) {
                    const dialog = openDialogs[openDialogs.length - 1];
                    closeDialog(dialog.id);
                }
            }
        });

        // ===== DIALOG CLOSE EVENT =====
        document.querySelectorAll('dialog').forEach(function(dialog) {
            dialog.addEventListener('close', function() {
                const openDialogs = document.querySelectorAll('dialog[open]');
                if (openDialogs.length === 0) {
                    document.body.classList.remove('dialog-open');
                    document.documentElement.style.setProperty('--scrollbar-width', '0px');
                }
            });
        });

        // ===== DIALOG BACKDROP CLICK =====
        document.querySelectorAll('dialog').forEach(function(dialog) {
            dialog.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDialog(this.id);
                }
            });
        });

        // ===== ADD MEDICINE BUTTON =====
        document.getElementById('addMedicineBtn').addEventListener('click', function() {
            openDialog('medicineDialog');
        });

        // ===== DELETE CHECKBOX =====
        document.getElementById('deleteCheckbox').addEventListener('change', function() {
            document.getElementById('confirmDeleteBtn').disabled = !this.checked;
        });

        // ===== OPEN EDIT DIALOG =====
        function openEditDialog(element) {
            const row = element.closest('tr');
            const id = row.getAttribute('data-id');
            const medicineName = row.cells[1].textContent.trim();
            const boxes = row.cells[2].textContent.trim();
            const pieces = row.cells[3].textContent.trim();
            const date = row.cells[5].textContent.trim();
            
            // Set form action
            const form = document.getElementById('editMedicineForm');
            form.action = "{{ route('medicine.receive.update', '') }}/" + id;
            
            // Set values
            document.getElementById('editMedicineName').value = medicineName;
            document.getElementById('editQuantityBoxes').value = boxes;
            document.getElementById('editPiecesPerBox').value = pieces;
            
            if (date) {
                const dateParts = date.split('.');
                if (dateParts.length === 3) {
                    const formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                    document.getElementById('editReceiveDate').value = formattedDate;
                }
            }
            
            const total = parseInt(boxes) * parseInt(pieces);
            document.getElementById('editTotalPieces').textContent = total;
            
            openDialog('editDialog');
        }

        // ===== OPEN DELETE DIALOG =====
        function openDeleteDialog(element) {
            const row = element.closest('tr');
            const id = row.getAttribute('data-id');
            const medicineName = row.cells[1].textContent.trim();
            
            // Set form action
            const form = document.getElementById('deleteMedicineForm');
            form.action = "{{ route('medicine.receive.delete', '') }}/" + id;
            
            // Set values
            document.getElementById('deleteMedicineName').textContent = medicineName;
            
            const checkbox = document.getElementById('deleteCheckbox');
            checkbox.checked = false;
            document.getElementById('confirmDeleteBtn').disabled = true;
            
            openDialog('deleteDialog');
        }

        // ===== OPEN VIEW DIALOG =====
        function openViewDialog(element) {
            const row = element.closest('tr');
            const medicineName = row.cells[1].textContent.trim();
            const boxes = row.cells[2].textContent.trim();
            const pieces = row.cells[3].textContent.trim();
            const total = row.cells[4].textContent.trim();
            const date = row.cells[5].textContent.trim();
            
            document.getElementById('viewMedicineName').textContent = medicineName;
            document.getElementById('viewQuantityBoxes').textContent = boxes;
            document.getElementById('viewPiecesPerBox').textContent = pieces;
            document.getElementById('viewTotalPieces').textContent = total;
            document.getElementById('viewReceiveDate').textContent = date;
            document.getElementById('viewManufacturer').textContent = '{{ $medicine->supplier->name ?? "-" }}';
            
            openDialog('viewDialog');
        }

        // ===== CALCULATE TOTAL =====
        document.addEventListener('DOMContentLoaded', function() {
            // Add dialog total
            const modalQuantity = document.getElementById('modalQuantityBoxes');
            const modalPieces = document.getElementById('modalPiecesPerBox');
            const modalTotal = document.getElementById('modalTotalPieces');
            
            function updateModalTotal() {
                const qty = parseInt(modalQuantity.value) || 0;
                const pieces = parseInt(modalPieces.value) || 0;
                modalTotal.textContent = qty * pieces;
            }
            
            modalQuantity.addEventListener('input', updateModalTotal);
            modalPieces.addEventListener('input', updateModalTotal);

            // Edit dialog total
            const editQuantity = document.getElementById('editQuantityBoxes');
            const editPieces = document.getElementById('editPiecesPerBox');
            const editTotal = document.getElementById('editTotalPieces');
            
            function updateEditTotal() {
                const qty = parseInt(editQuantity.value) || 0;
                const pieces = parseInt(editPieces.value) || 0;
                editTotal.textContent = qty * pieces;
            }
            
            editQuantity.addEventListener('input', updateEditTotal);
            editPieces.addEventListener('input', updateEditTotal);
        });
    </script>
</x-layouts.main.website>