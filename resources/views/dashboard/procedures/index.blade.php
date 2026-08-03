<x-layouts.main.website>
    <x-slot:title>
        @lang('words.hospital_procedures')
    </x-slot:title> 
    
    <div class="main-content">
        <div class="container pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main.page')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('words.hospital_procedures')</li>
                </ol>
            </nav>

            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">@lang('words.hospital_procedures')</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Action Bar -->
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="filterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filters')</span>
                        <span class="filter-count" id="filterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>

                    <a href="{{ route('procedures.create') }}" class="add-nurse-btn">
                        <i class="fas fa-plus"></i> @lang('words.new_procedure')
                    </a>
                </div>
            </div>

            <!-- Filter Panel -->
            <div class="filter-panel" id="filterPanel">
                <div class="filter-panel-header">
                    <h3><i class="fas fa-filter" style="color: #00BFFF;"></i> @lang('words.filters')</h3>
                    <button class="filter-close-btn" id="filterCloseBtn"><i class="fas fa-times"></i></button>
                </div>
                <div class="filter-panel-body">
                    <form id="filterForm" method="GET" action="{{ route('procedures.index') }}">
                        
                        <div class="filter-section">
                            <label class="filter-label"><i class="fas fa-tag"></i> @lang('words.category')</label>
                            <div class="modern-select">
                                <select name="category" id="categorySelect">
                                    <option value="all">@lang('words.all_categories')</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <label class="filter-label"><i class="fas fa-chart-line"></i> @lang('words.status')</label>
                            <div class="status-row">
                                <label class="radio-card">
                                    <input type="radio" name="status" value="all" {{ request('status') == 'all' || !request('status') ? 'checked' : '' }}>
                                    <span class="radio-content"><i class="fas fa-list"></i><span>@lang('words.all')</span></span>
                                </label>
                                <label class="radio-card">
                                    <input type="radio" name="status" value="active" {{ request('status') == 'active' ? 'checked' : '' }}>
                                    <span class="radio-content"><i class="fas fa-check-circle" style="color: #27ae60;"></i><span>@lang('words.active')</span></span>
                                </label>
                                <label class="radio-card">
                                    <input type="radio" name="status" value="inactive" {{ request('status') == 'inactive' ? 'checked' : '' }}>
                                    <span class="radio-content"><i class="fas fa-times-circle" style="color: #dc3545;"></i><span>@lang('words.inactive')</span></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <label class="filter-label"><i class="fas fa-dollar-sign"></i> @lang('words.price_range')</label>
                            <div class="price-range">
                                <input type="number" class="modern-price-input" name="price_min" placeholder="@lang('words.min_price')" value="{{ request('price_min') }}">
                                <span class="price-separator">—</span>
                                <input type="number" class="modern-price-input" name="price_max" placeholder="@lang('words.max_price')" value="{{ request('price_max') }}">
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <label class="filter-label"><i class="fas fa-sort-amount-up"></i> @lang('words.sort')</label>
                            <div class="modern-select">
                                <select name="sort" id="sortSelect">
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>@lang('words.sort_by_name_asc')</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>@lang('words.sort_by_name_desc')</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>@lang('words.sort_by_price_asc')</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>@lang('words.sort_by_price_desc')</option>
                                    <option value="duration_asc" {{ request('sort') == 'duration_asc' ? 'selected' : '' }}>@lang('words.sort_by_duration_asc')</option>
                                    <option value="duration_desc" {{ request('sort') == 'duration_desc' ? 'selected' : '' }}>@lang('words.sort_by_duration_desc')</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-actions">
                            <button type="button" class="btn-clear" id="resetFilters"><i class="fas fa-redo-alt"></i> @lang('words.clear')</button>
                            <button type="submit" class="btn-apply"><i class="fas fa-check"></i> @lang('words.apply')</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="filter-overlay" id="filterOverlay"></div>
            
            <!-- Table -->
            <div class="procedure-table-container">

                 <div class="table-header">
                    <div class="table-actions">
                        <div class="action-right">
                            <div class="search-wrapper">
                                <input type="text" class="modern-input-max" id="tableSearchInput" placeholder="@lang('words.search_procedure_placeholder')">
                                <button type="button" class="clear-search" id="tableClearSearch" style="display: none;"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
                
                <div class="table-wrapper">
                    <table class="procedure-table" id="proceduresTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('words.name')</th>
                                <th>@lang('words.category')</th>
                                <th>@lang('words.price')</th>
                                <th>@lang('words.duration') </th>
                                <th>@lang('words.status')</th>
                                <th>@lang('words.actions')</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach($procedures as $procedure)
                            <tr class="procedure-row" data-name="{{ strtolower($procedure->name) }}" data-category="{{ strtolower($procedure->category) }}">
                                <td class="row-number">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="patient-info">
                                        <div>
                                            <div class="name">{{ Str::limit($procedure->name, 20) }}</div>
                                            <div class="login-procedure-display">{{ Str::limit($procedure->description, 25) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="type-badge">{{ $procedure->category }}</span></td>
                                <td class="price-text">${{ number_format($procedure->price, 2) }}</td>
                                <td>
                                    {{ $procedure->duration }} @lang('words.minutes')
                                </td>
                                <td>
                                    @if($procedure->is_active == 1)
                                        <span class="status-badge status-active"><i class="fas fa-check-circle"></i> @lang('words.active')</span>
                                    @else
                                        <span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> @lang('words.inactive')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-dropdown" data-dropdown-id="dropdown-{{ $procedure->id }}">
                                        <span class="action-dots"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                        <div class="dropdown-content" id="dropdown-{{ $procedure->id }}">
                                            <a href="{{ route('procedures.show', $procedure) }}" class="text-primary view-procedure-btn" data-id="{{ $procedure->id }}">
                                                <i class="fas fa-eye"></i> @lang('words.view')
                                            </a>
                                            <a href="{{ route('procedures.edit', $procedure) }}" class="text-warning edit-procedure-btn" data-id="{{ $procedure->id }}">
                                                <i class="fas fa-edit"></i> @lang('words.edit')
                                            </a>
                                            <a href="#" class="text-danger delete-procedure-btn" data-id="{{ $procedure->id }}" data-name="{{ $procedure->name }}">
                                                <i class="fas fa-trash"></i> @lang('words.delete')
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @include('partials.pagination', ['paginator' => $procedures])
            </div>

            <!-- Stats -->
            @include('partials.stats', ['stats' => $stats])
        </div>
    </div>

    <!-- Delete Modal -->
    <dialog id="deleteProcedureModal" class="delete-modal">
        <div class="modal-header delete-header">
            <h3>@lang('words.delete_procedure')</h3>
            <button class="close-btn" id="closeDeleteModalBtn">✕</button>
        </div>
        <form id="deleteProcedureForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <div class="warning-message">
                    <i class="fas fa-exclamation-triangle warning-icon"></i>
                    <h4>@lang('words.warning_irreversible')</h4>
                    <p>@lang('words.delete_procedure_warning')</p>
                </div>
                <div class="form-group">
                    <label>@lang('words.procedure_information')</label>
                    <div class="info-box">
                        <div class="info-row">
                            <span class="info-label">@lang('words.name'):</span>
                            <span class="info-value" id="deleteProcedureName"></span>
                        </div>
                    </div>
                </div>
                <div class="confirm-box">
                    <label class="confirm-label">
                        <input type="checkbox" id="confirmDeleteCheckbox" required>
                        <span class="confirm-text">@lang('words.confirm_delete_procedure')</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelDeleteBtn">@lang('words.cancel')</button>
                <button type="submit" class="btn-delete" id="confirmDeleteBtn" disabled>@lang('words.delete')</button>
            </div>
        </form>
    </dialog> 

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== FILTER PANEL ==========
            const filterToggleBtn = document.getElementById('filterToggleBtn');
            const filterPanel = document.getElementById('filterPanel');
            const filterOverlay = document.getElementById('filterOverlay');
            const filterCloseBtn = document.getElementById('filterCloseBtn');
            const filterCount = document.getElementById('filterCount');
            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');
            const categorySelect = document.getElementById('categorySelect');
            const sortSelect = document.getElementById('sortSelect');
            const resetFiltersBtn = document.getElementById('resetFilters');
            
            function openFilterPanel() {
                filterPanel.classList.add('open');
                filterOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
                filterToggleBtn.classList.add('active');
            }
            
            function closeFilterPanel() {
                filterPanel.classList.remove('open');
                filterOverlay.classList.remove('active');
                document.body.style.overflow = '';
                filterToggleBtn.classList.remove('active');
            }
            
            if (filterToggleBtn) filterToggleBtn.addEventListener('click', openFilterPanel);
            if (filterCloseBtn) filterCloseBtn.addEventListener('click', closeFilterPanel);
            if (filterOverlay) filterOverlay.addEventListener('click', closeFilterPanel);
            
            function countActiveFilters() {
                let count = 0;
                if (searchInput && searchInput.value) count++;
                if (categorySelect && categorySelect.value !== 'all') count++;
                const selectedStatus = document.querySelector('input[name="status"]:checked');
                if (selectedStatus && selectedStatus.value !== 'all') count++;
                if (document.querySelector('input[name="price_min"]')?.value) count++;
                if (document.querySelector('input[name="price_max"]')?.value) count++;
                if (sortSelect && sortSelect.value !== 'name_asc') count++;
                return count;
            }
            
            function updateFilterCount() {
                const count = countActiveFilters();
                if (filterCount) {
                    filterCount.textContent = count;
                    filterCount.style.display = count > 0 ? 'inline-block' : 'none';
                }
            }
            
            if (clearSearch) {
                clearSearch.addEventListener('click', function() {
                    if (searchInput) searchInput.value = '';
                    updateFilterCount();
                    document.getElementById('filterForm').submit();
                });
            }
            
            if (searchInput) searchInput.addEventListener('input', updateFilterCount);
            if (categorySelect) categorySelect.addEventListener('change', updateFilterCount);
            if (sortSelect) sortSelect.addEventListener('change', updateFilterCount);
            document.querySelectorAll('input[name="status"]').forEach(radio => radio.addEventListener('change', updateFilterCount));
            document.querySelectorAll('input[name="price_min"], input[name="price_max"]').forEach(input => input.addEventListener('input', updateFilterCount));
            
            if (resetFiltersBtn) {
                resetFiltersBtn.addEventListener('click', function() {
                    window.location.href = '{{ route("procedures.index") }}';
                });
            }
            
            updateFilterCount();
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && filterPanel.classList.contains('open')) {
                    closeFilterPanel();
                }
            });
            
            // ========== LIVE SEARCH (TABLE UCHUN) ==========
            const tableSearchInput = document.getElementById('tableSearchInput');
            const tableClearSearch = document.getElementById('tableClearSearch');
            const tableBody = document.getElementById('tableBody');
            const tableRows = document.querySelectorAll('#tableBody .procedure-row');
            let noResultsRow = null;
            
            function filterTableRows() {
                const searchTerm = tableSearchInput.value.toLowerCase().trim();
                let hasVisibleRows = false;
                
                tableRows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const category = row.getAttribute('data-category') || '';
                    const matches = searchTerm === '' || name.includes(searchTerm) || category.includes(searchTerm);
                    
                    if (matches) {
                        row.style.display = '';
                        hasVisibleRows = true;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Clear previous no results row
                if (noResultsRow) {
                    noResultsRow.remove();
                    noResultsRow = null;
                }
                
                // Show no results message if needed
                if (!hasVisibleRows && searchTerm !== '') {
                    noResultsRow = document.createElement('tr');
                    noResultsRow.innerHTML = `
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            <span style="color: #666;">"${escapeHtml(searchTerm)}" bo'yicha hech qanday protsedura topilmadi</span>
                        </td>
                    `;
                    tableBody.appendChild(noResultsRow);
                }
                
                // Update clear button visibility
                if (tableClearSearch) {
                    tableClearSearch.style.display = searchTerm !== '' ? 'block' : 'none';
                }
            }
            
            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            if (tableSearchInput) {
                tableSearchInput.addEventListener('input', filterTableRows);
            }
            
            if (tableClearSearch) {
                tableClearSearch.addEventListener('click', function() {
                    if (tableSearchInput) {
                        tableSearchInput.value = '';
                        filterTableRows();
                        tableSearchInput.focus();
                    }
                });
            } 
            
            // ========== DELETE MODAL ==========
            const deleteModal = document.getElementById('deleteProcedureModal');
            const deleteForm = document.getElementById('deleteProcedureForm');
            const deleteNameSpan = document.getElementById('deleteProcedureName');
            const confirmCheckbox = document.getElementById('confirmDeleteCheckbox');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            
            function disableBodyScroll() {
                document.body.style.overflow = 'hidden';
            }
            
            function enableBodyScroll() {
                document.body.style.overflow = '';
            }
            
            window.openDeleteModal = function(procedureId, procedureName) {
                deleteForm.action = '/procedures/' + procedureId;
                deleteNameSpan.textContent = procedureName;
                confirmCheckbox.checked = false;
                confirmDeleteBtn.disabled = true;
                deleteModal.showModal();
                disableBodyScroll();
            };
            
            function closeDeleteModal() {
                deleteModal.close();
                enableBodyScroll();
            }
            
            document.getElementById('closeDeleteModalBtn')?.addEventListener('click', closeDeleteModal);
            document.getElementById('cancelDeleteBtn')?.addEventListener('click', closeDeleteModal);
            
            if (confirmCheckbox) {
                confirmCheckbox.addEventListener('change', function() {
                    confirmDeleteBtn.disabled = !this.checked;
                });
            }
            
            if (deleteModal) {
                deleteModal.addEventListener('cancel', function(e) {
                    e.preventDefault();
                    closeDeleteModal();
                });
            }
            
            document.querySelectorAll('.delete-procedure-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    openDeleteModal(id, name);
                });
            });
            
            // ========== EDIT ==========
            document.querySelectorAll('.edit-procedure-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    window.location.href = '/procedures/' + id + '/edit';
                });
            }); 
        });
    </script>

</x-layouts.main.website>