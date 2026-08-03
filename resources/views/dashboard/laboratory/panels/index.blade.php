<x-layouts.main.website>
    <x-slot:title>
        @lang('words.test_panels')
    </x-slot:title>


    <link rel="stylesheet" href="{{ asset('temp2/css/test-panel.css') }}" />

    <div class="main-content">
        <div class="container pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main.page')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @lang('words.test_panels')
                    </li>
                </ol>
            </nav>

            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="mb-0">@lang('words.test_panels')</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="action-bar">
                <div class="left-actions">
                    <button class="filter-toggle-btn" id="testPanelFilterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        <span>@lang('words.filters')</span>
                        <span class="filter-count" id="testPanelFilterCount">0</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    
                    <button class="add-nurse-btn" id="testPanelOpenCreateModal">
                        <i class="fas fa-plus"></i> @lang('words.create_new_test_panel')
                    </button>
                </div>
            </div>

           @include('partials.filters.test-panels')
            
            <div class="cards-container" id="testPanelCardsContainer">
                @forelse($testPanels as $panel)
                @php
                    $testsJson = json_encode($panel->tests->map(function($test) {
                        return [
                            'name' => $test->name,
                            'code' => $test->code,
                            'duration' => $test->duration ?? $test->time ?? __('words.not_available'),
                            'status' => $test->status ?? 1
                        ];
                    }));
                @endphp
                <div class="test-panel-card" 
                     data-id="{{ $panel->id }}" 
                     data-name="{{ $panel->name }}" 
                     data-code="{{ $panel->code }}"
                     data-price="{{ $panel->price }}"
                     data-time="{{ $panel->time }}"
                     data-department="{{ $panel->department->name ?? __('words.not_available') }}"
                     data-tests-count="{{ $panel->tests->count() }}"
                     data-status="{{ $panel->status }}"
                     data-tests='{!! $testsJson !!}'>
                    <div class="card-header">
                        <div class="card-title">{{ $panel->name }}</div>
                        <div class="card-code">{{ $panel->code }}</div>
                    </div>
                    <div class="card-body">
                        <div class="card-info-row">
                            <span class="card-info-label">@lang('words.price'):</span>
                            <span class="card-info-value">${{ number_format($panel->price, 2) }}</span>
                        </div>
                        <div class="card-info-row">
                            <span class="card-info-label">@lang('words.tests_count'):</span>
                            <span class="card-tests-count"><i class="fas fa-vial"></i> {{ $panel->tests->count() }} @lang('words.test')</span>
                        </div>
                        <div class="card-time-location">
                            <div class="time-badge"><i class="fas fa-clock"></i> {{ $panel->time }} @lang('words.hours')</div>
                            <div class="location-badge"><i class="fas fa-map-marker-alt"></i> {{ $panel->department->name ?? __('words.not_available') }}</div>
                        </div>
                        <div class="card-info-row">
                            <span class="card-info-label">@lang('words.status'):</span>
                            @if($panel->status == 1)
                            <span class="status-badge status-active"><i class="fas fa-check-circle"></i> @lang('words.active')</span>
                            @else
                            <span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> @lang('words.inactive')</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-sm testPanelViewBtn" data-panel-id="{{ $panel->id }}"><i class="fas fa-eye"></i> @lang('words.view')</button>
                        <button class="btn btn-warning btn-sm" onclick="window.location.href='{{ route('test-panels.edit', $panel->id) }}'"><i class="fas fa-edit"></i> @lang('words.edit')</button>
                        <button class="btn btn-danger btn-sm testPanelDeleteBtn" data-panel-id="{{ $panel->id }}" data-panel-name="{{ $panel->name }}"><i class="fas fa-trash"></i> @lang('words.delete')</button>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>@lang('words.no_panels_found')</h3>
                    <button class="btn btn-primary" id="testPanelOpenCreateModalEmpty">@lang('words.add_new_panel')</button>
                </div>
                @endforelse
            </div>
             

            @include('partials.paginations.test-panels')
        </div>
    </div>

    <!-- KO'RISH MODALI (HTML da to'liq) -->
    @include('partials.modals.show-modals.test-panel')

    <!-- O'CHIRISH MODALI -->
    @include('partials.modals.delete-modals.test-panel')

    <!-- YARATISH MODALI -->
    @include('partials.modals.create-modals.test-panel')

    <script>
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // ========== FILTER PANEL ==========
        const testPanelFilterToggleBtn = document.getElementById('testPanelFilterToggleBtn');
        const testPanelFilterPanel = document.getElementById('testPanelFilterPanel');
        const testPanelFilterOverlay = document.getElementById('testPanelFilterOverlay');
        const testPanelFilterCloseBtn = document.getElementById('testPanelFilterCloseBtn');
        const testPanelFilterCount = document.getElementById('testPanelFilterCount');
        const testPanelSearchInput = document.getElementById('testPanelSearchInput');
        const testPanelClearSearch = document.getElementById('testPanelClearSearch');
        const testPanelResetFiltersBtn = document.getElementById('testPanelResetFilters');
        const testPanelDepartmentSelect = document.getElementById('testPanelDepartmentSelect');
        
        function openFilterPanel() {
            testPanelFilterPanel.classList.add('open');
            testPanelFilterOverlay.classList.add('active');
            document.body.classList.add('modal-open');
            testPanelFilterToggleBtn.classList.add('active');
        }
        
        function closeFilterPanel() {
            testPanelFilterPanel.classList.remove('open');
            testPanelFilterOverlay.classList.remove('active');
            document.body.classList.remove('modal-open');
            testPanelFilterToggleBtn.classList.remove('active');
        }
        
        if (testPanelFilterToggleBtn) testPanelFilterToggleBtn.addEventListener('click', openFilterPanel);
        if (testPanelFilterCloseBtn) testPanelFilterCloseBtn.addEventListener('click', closeFilterPanel);
        if (testPanelFilterOverlay) testPanelFilterOverlay.addEventListener('click', closeFilterPanel);
        
        if (testPanelClearSearch) {
            testPanelClearSearch.addEventListener('click', function() {
                testPanelSearchInput.value = '';
                updateFilterCount();
            });
        }
        
        function updateFilterCount() {
            let count = 0;
            if (testPanelSearchInput && testPanelSearchInput.value) count++;
            const selectedStatus = document.querySelector('input[name="status"]:checked');
            if (selectedStatus && selectedStatus.value !== 'all') count++;
            if (testPanelDepartmentSelect && testPanelDepartmentSelect.value !== 'all') count++;
            if (testPanelFilterCount) {
                testPanelFilterCount.textContent = count;
                testPanelFilterCount.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }
        
        if (testPanelSearchInput) testPanelSearchInput.addEventListener('input', updateFilterCount);
        document.querySelectorAll('input[name="status"]').forEach(r => r.addEventListener('change', updateFilterCount));
        if (testPanelDepartmentSelect) testPanelDepartmentSelect.addEventListener('change', updateFilterCount);
        
        if (testPanelResetFiltersBtn) {
            testPanelResetFiltersBtn.addEventListener('click', function() {
                window.location.href = window.location.pathname;
            });
        }
        
        updateFilterCount();
        
        // ========== KO'RISH MODALI ==========
        const testPanelViewModal = document.getElementById('testPanelViewModal');
        const testPanelViewModalTitle = document.getElementById('testPanelViewModalTitle');
        const testPanelViewCode = document.getElementById('testPanelViewCode');
        const testPanelViewPrice = document.getElementById('testPanelViewPrice');
        const testPanelViewTime = document.getElementById('testPanelViewTime');
        const testPanelViewDepartment = document.getElementById('testPanelViewDepartment');
        const testPanelViewTestsCount = document.getElementById('testPanelViewTestsCount');
        const testPanelViewStatus = document.getElementById('testPanelViewStatus');
        const testPanelViewTestsCountBadge = document.getElementById('testPanelViewTestsCountBadge');
        const testPanelViewTestsList = document.getElementById('testPanelViewTestsList');
        
        function openViewModal(panelId) {
            const card = document.querySelector(`.test-panel-card[data-id="${panelId}"]`);
            if (!card) return;
            
            const nameUz = card.dataset.nameUz || '';
            const nameRu = card.dataset.nameRu || '';
            const nameEn = card.dataset.nameEn || '';
            const code = card.dataset.code || '';
            const price = card.dataset.price || '0';
            const time = card.dataset.time || '0';
            const department = card.dataset.department || 'Noma\'lum';
            const testsCount = card.dataset.testsCount || '0';
            const status = card.dataset.status == '1' ? '@lang('words.active')' : '@lang('words.inactive')';
            const statusClass = card.dataset.status == '1' ? 'active' : 'inactive';
            
            let tests = [];
            try {
                tests = JSON.parse(card.dataset.tests || '[]');
            } catch(e) { tests = []; }
            
            testPanelViewModalTitle.textContent = nameUz || nameRu || nameEn;
            testPanelViewCode.textContent = code;
            testPanelViewPrice.textContent = '$' + parseFloat(price).toFixed(2);
            testPanelViewTime.textContent = time + ' @lang('words.hours')';
            testPanelViewDepartment.textContent = department;
            testPanelViewTestsCount.textContent = testsCount + ' @lang('words.test')';
            testPanelViewTestsCountBadge.textContent = testsCount + ' @lang('words.tests_count_badge')';
            testPanelViewStatus.textContent = status;
            testPanelViewStatus.className = 'modal-info-value status-' + statusClass;
            
            if (tests.length > 0) {
                testPanelViewTestsList.innerHTML = tests.map(test => `
                    <div class="modal-test-item">
                        <div class="test-info">
                            <div class="test-name">${escapeHtml(test.name)}</div>
                            <div class="test-code">@lang('words.test_code_prefix'): ${escapeHtml(test.code)}</div>
                        </div>
                        <div class="test-meta">
                            <div class="test-duration"><i class="fas fa-clock"></i> ${escapeHtml(test.duration)}</div>
                            <span class="test-status ${test.status == 1 ? 'active' : 'inactive'}">${test.status == 1 ? '@lang('words.active')' : '@lang('words.inactive')'}</span>
                        </div>
                    </div>
                `).join('');
            } else {
                testPanelViewTestsList.innerHTML = `
                    <div class="empty-tests">
                        <i class="fas fa-flask"></i>
                        <p>@lang('words.no_tests_found')</p>
                    </div>
                `;
            }
            
            testPanelViewModal.showModal();
            document.body.classList.add('modal-open');
        }
        
        function closeViewModal() {
            if (testPanelViewModal) testPanelViewModal.close();
            document.body.classList.remove('modal-open');
        }
        
        document.getElementById('testPanelCloseViewModalBtn')?.addEventListener('click', closeViewModal);
        document.getElementById('testPanelCloseViewFooterBtn')?.addEventListener('click', closeViewModal);
        if (testPanelViewModal) {
            testPanelViewModal.addEventListener('cancel', (e) => { e.preventDefault(); closeViewModal(); });
        }
        
        document.querySelectorAll('.testPanelViewBtn').forEach(btn => {
            btn.addEventListener('click', function() { openViewModal(this.dataset.panelId); });
        });
        
        // ========== O'CHIRISH MODALI ==========
        const testPanelDeleteModal = document.getElementById('testPanelDeleteModal');
        const testPanelDeleteForm = document.getElementById('testPanelDeleteForm');
        const testPanelDeleteName = document.getElementById('testPanelDeleteName');
        const testPanelDeleteCode = document.getElementById('testPanelDeleteCode');
        const testPanelConfirmCheckbox = document.getElementById('testPanelConfirmDeleteCheckbox');
        const testPanelDeleteSubmitBtn = document.getElementById('testPanelDeleteSubmitBtn');
        
        function openDeleteModal(panelId, panelName, panelCode) {
            testPanelDeleteForm.action = '/test-panels/' + panelId;
            testPanelDeleteName.textContent = panelName;
            testPanelDeleteCode.textContent = panelCode;
            if (testPanelConfirmCheckbox) testPanelConfirmCheckbox.checked = false;
            if (testPanelDeleteSubmitBtn) testPanelDeleteSubmitBtn.disabled = true;
            testPanelDeleteModal.showModal();
            document.body.classList.add('modal-open');
        }
        
        function closeDeleteModal() {
            testPanelDeleteModal.close();
            document.body.classList.remove('modal-open');
        }
        
        if (testPanelConfirmCheckbox) {
            testPanelConfirmCheckbox.addEventListener('change', function() {
                if (testPanelDeleteSubmitBtn) testPanelDeleteSubmitBtn.disabled = !this.checked;
            });
        }
        
        document.getElementById('testPanelCloseDeleteModalBtn')?.addEventListener('click', closeDeleteModal);
        document.getElementById('testPanelCancelDeleteBtn')?.addEventListener('click', closeDeleteModal);
        if (testPanelDeleteModal) {
            testPanelDeleteModal.addEventListener('cancel', (e) => { e.preventDefault(); closeDeleteModal(); });
        }
        
        document.querySelectorAll('.testPanelDeleteBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.panelId;
                const name = this.dataset.panelName;
                const card = document.querySelector(`.test-panel-card[data-id="${id}"]`);
                const code = card?.dataset.code || '';
                openDeleteModal(id, name, code);
            });
        });
        
        // ========== YARATISH MODALI ==========
        const testPanelCreateModal = document.getElementById('testPanelCreateModal');
        
        function openCreateModal() {
            document.getElementById('testPanelNameUz').value = '';
            document.getElementById('testPanelNameRu').value = '';
            document.getElementById('testPanelNameEn').value = '';
            document.getElementById('testPanelCode').value = '';
            document.getElementById('testPanelPrice').value = '';
            document.getElementById('testPanelTime').value = '';
            document.getElementById('testPanelDescriptionUz').value = '';
            document.getElementById('testPanelDescriptionRu').value = '';
            document.getElementById('testPanelDescriptionEn').value = '';
            document.getElementById('testPanelStatus').value = '1';
            document.getElementById('testPanelDepartment').value = '';
            testPanelCreateModal.showModal();
            document.body.classList.add('modal-open');
        }
        
        function closeCreateModal() {
            testPanelCreateModal.close();
            document.body.classList.remove('modal-open');
        }
        
        document.getElementById('testPanelOpenCreateModal')?.addEventListener('click', openCreateModal);
        document.getElementById('testPanelOpenCreateModalEmpty')?.addEventListener('click', openCreateModal);
        document.getElementById('testPanelCloseCreateModalBtn')?.addEventListener('click', closeCreateModal);
        document.getElementById('testPanelCancelCreateBtn')?.addEventListener('click', closeCreateModal);
        if (testPanelCreateModal) {
            testPanelCreateModal.addEventListener('cancel', (e) => { e.preventDefault(); closeCreateModal(); });
        }
        
        // ========== ESC TUGMASI ==========
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (testPanelFilterPanel && testPanelFilterPanel.classList.contains('open')) closeFilterPanel();
            }
        });
    });
</script>

</x-layouts.main.website>