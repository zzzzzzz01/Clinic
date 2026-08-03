<x-layouts.main.website>
    <x-slot:title>
        @lang('words.faqs.page_title')
    </x-slot:title>

    <style>
        .btn-primary, .btn-delete  {
            padding: 7px 20px;
            font-size: 11px; 
        } 

        .btn-primary.create {
            padding: 13px 20px;
            font-size: 14px;
        }   
    </style>

    <style>
        /* ==================== FAQS STYLES ==================== */
        
        /* Header */
        .faqs-header {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .faqs-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .faqs-title i {
            margin-right: 12px;
        }

        .faqs-subtitle {
            font-size: 16px;
            margin-bottom: 0;
        }

        /* Search and Filter */
        .faqs-search-filter {
            background: white;
            border-radius: 12px;
            padding: 20px 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .search-wrapper {
            position: relative;
            margin-bottom: 0;

        }

        .search-wrapper .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }

        .search-wrapper input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f7fafc;
        }

        .search-wrapper input:focus {
            border-color: #00BFFF;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            background: white;
            color: #4a5568;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .filter-btn:hover {
            border-color: #00BFFF;
            color: #00BFFF;
        }

        .filter-btn.active {
            background: #00BFFF;
            color: white;
            border-color: #00BFFF;
        }

        .filter-btn .badge-count {
            background: rgba(255,255,255,0.3);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 5px;
        }

        .filter-btn.active .badge-count {
            background: rgba(255,255,255,0.2);
        }

        /* FAQ Items */
        .faqs-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .faq-item {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .faq-item:hover {
            border-color: #e2e8f0;
        }

        .faq-item.active {
            border-color: #00BFFF;
        }

        .faq-question {
            padding: 18px 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            transition: background 0.3s;
            user-select: none;
        }

        .faq-question:hover {
            background: #f7fafc;
        }

        .faq-question-left {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .faq-category-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .faq-category-badge.general {
            background: #ebf8ff;
            color: #2b6cb0;
        }

        .faq-category-badge.payment {
            background: #fefcbf;
            color: #975a16;
        }

        .faq-category-badge.medical {
            background: #f0fff4;
            color: #276749;
        }

        .faq-category-badge.technical {
            background: #faf5ff;
            color: #6b46c1;
        }

        .faq-category-badge.other {
            background: #f7fafc;
            color: #4a5568;
        }

        .faq-question-text {
            font-size: 16px;
            font-weight: 600;
            color: #1a202c;
            flex: 1;
        }

        .faq-question-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .faq-date {
            font-size: 13px;
            color: #a0aec0;
        }

        .faq-status {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .faq-status.active {
            background: #c6f6d5;
            color: #276749;
        }

        .faq-status.inactive {
            background: #fed7d7;
            color: #9b2c2c;
        }

        .faq-toggle-icon {
            color: #a0aec0;
            font-size: 14px;
            transition: transform 0.3s;
            flex-shrink: 0;
        }

        .faq-item.active .faq-toggle-icon {
            transform: rotate(180deg);
        }

        /* FAQ Answer */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.3s ease;
            padding: 0 25px;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 25px 20px 25px;
        }

        .faq-answer-content {
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            color: #4a5568;
            font-size: 15px;
            line-height: 1.8;
        }

        .faq-answer-content p {
            margin-bottom: 10px;
        }

        .faq-answer-content ul, 
        .faq-answer-content ol {
            padding-left: 20px;
            margin-bottom: 10px;
        }

        .faq-answer-content li {
            margin-bottom: 5px;
        }

        /* FAQ Actions */
        .faq-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .faq-actions .btn-sm {
            padding: 4px 12px;
            font-size: 13px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: none;
            cursor: pointer;
        }

        .faq-actions .btn-edit {
            background: #ebf8ff;
            color: #2b6cb0;
        }

        .faq-actions .btn-edit:hover {
            background: #bee3f8;
        } 

        /* Empty State */
        .faqs-empty {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .faqs-empty i {
            font-size: 50px;
            color: #cbd5e0;
            margin-bottom: 15px;
        }

        .faqs-empty h4 {
            color: #4a5568;
            margin-bottom: 10px;
        }

        .faqs-empty p {
            color: #a0aec0;
        }

        /* No Results */
        .no-results-found {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .no-results-found i {
            font-size: 40px;
            color: #cbd5e0;
            margin-bottom: 10px;
        }

        .no-results-found h5 {
            color: #4a5568;
            margin-bottom: 5px;
        }

        .no-results-found p {
            color: #a0aec0;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .faqs-header {
                padding: 20px;
            }

            .faqs-title {
                font-size: 22px;
            }

            .faqs-search-filter {
                padding: 15px 20px;
            }

            .faq-question {
                padding: 15px 18px;
                flex-wrap: wrap;
            }

            .faq-question-left {
                flex-wrap: wrap;
                gap: 10px;
            }

            .faq-question-text {
                font-size: 14px;
                width: 100%;
                order: 3;
            }

            .faq-question-meta {
                width: 100%;
                justify-content: flex-end;
                gap: 10px;
            }

            .faq-date {
                font-size: 12px;
            }

            .faq-answer {
                padding: 0 18px;
            }

            .faq-item.active .faq-answer {
                padding: 0 18px 15px 18px;
            }

            .faq-answer-content {
                font-size: 14px;
            }

            .filter-buttons {
                gap: 6px;
            }

            .filter-btn {
                padding: 6px 14px;
                font-size: 13px;
            }

            /* ===== MOBILE UCHUN TUZATISH ===== */
            .faq-actions {
                display: flex;
                gap: 8px;
                margin-top: 12px;
            }

            .faq-actions > * {
                flex: 1;
            }

            .faq-actions form {
                flex: 1;
                margin: 0;
            }

            .faq-actions .btn-primary,
            .faq-actions .btn-delete {
                width: 100%;
                flex: 1;
                padding: 7px 5px;
            }

            .btn-primary.create {
                padding: 7px 20px;
            }

            /* ===== SEARCH VA BUTTON MOBILE UCHUN ===== */
            .search-row {
                flex-direction: column;
            }

            .search-row .search-col {
                width: 100% !important;
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }

            .search-row .button-col {
                width: 100% !important;
                flex: 0 0 100% !important;
                max-width: 100% !important;
                margin-top: 10px;
            }

            .search-row .button-col .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .faqs-header .col-md-4 {
                margin-top: 15px;
                text-align: left !important;
            }

            .faq-category-badge {
                font-size: 11px;
                padding: 3px 10px;
            }

            .faq-status {
                font-size: 11px;
                padding: 2px 8px;
            }
        }

        /* ===== DESKTOP UCHUN SEARCH ROW ===== */
        .search-row {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-row .search-col {
            flex: 0 0 80%;
            max-width: 80%;
        }

        .search-row .button-col {
            flex: 0 0 20%;
            max-width: 20%;
        }

        .search-row .button-col .btn {
            width: 100%;
            white-space: nowrap;
        }
    </style>

    <div class="container-fluid px-0">
        <!-- Title --> 

        <div class="container pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main.page')
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" style="color: #808080;" class="text-decoration-none">
                            @lang('words.faqs.breadcrumb')
                        </a>
                    </li>
                </ol>
            </nav>
            
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.faqs.page_title')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container">
            <div class="faqs-content">
                <!-- Search and Filter -->
                <div class="faqs-search-filter">
                    <!-- ===== YANGI SEARCH ROW ===== -->
                    <div class="search-row">
                        <div class="search-col">
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" 
                                       id="faqSearch" 
                                       class="form-control" 
                                       placeholder="@lang('words.faqs.search_placeholder')"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="button-col">
                            <a href="{{ route('faqs.create') }}" class="btn-primary create">
                                <i class="fas fa-plus"></i> @lang('words.faqs.add_new')
                            </a>
                        </div>
                    </div> 
                </div>

                <!-- FAQ List -->
                <div class="faqs-list" id="faqsList">
                @forelse($faqs as $faq)
                    <div class="faq-item" 
                        data-category="{{ $faq['category'] ?? 'general' }}"
                        data-search="{{ strtolower($faq['question'] . ' ' . ($faq['answer'] ?? '')) }}">
                        
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <div class="faq-question-left">
                                <span class="faq-category-badge general">
                                    {{ $faq['sort_order'] }}
                                </span>
                                <span class="faq-question-text">{{ $faq['question'] }}</span>
                            </div>
                            <div class="faq-question-meta">
                                <span class="faq-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $faq['created_at'] ? $faq['created_at']->format('d.m.Y') : 'Noma\'lum' }}
                                </span>
                                <span class="faq-status" 
                                    style="background: {{ $faq['status_bg_color'] }}; color: {{ $faq['status_text_color'] }}; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    <i class="{{ $faq['status_icon'] }}"></i> {{ $faq['status_text'] }}
                                </span>
                                <i class="fas fa-chevron-down faq-toggle-icon"></i>
                            </div>
                        </div>
                        
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                {!! nl2br(e($faq['answer'] ?? 'Javob mavjud emas')) !!}
                                
                                <div class="faq-actions">
                                    <a href="{{ route('faqs.edit', $faq['id']) }}" class="btn-primary">
                                        <i class="fas fa-edit"></i> @lang('words.faqs.edit')
                                    </a>
                                    <form action="{{ route('faqs.destroy', $faq['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('@lang('words.faqs.delete_confirm')')">
                                            <i class="fas fa-trash"></i> @lang('words.faqs.delete')
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="faqs-empty"> 
                        <h4>@lang('words.faqs.no_faqs')</h4> 
                    </div>
                @endforelse
                </div>

                <!-- Pagination -->
                @if(isset($faqs) && method_exists($faqs, 'links'))
                    <div class="mt-4">
                        {{ $faqs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // ==================== TOGGLE FAQ ====================
        function toggleFaq(element) {
            const item = element.closest('.faq-item');
            
            // Agar allaqachon ochiq bo'lsa, yopamiz
            if (item.classList.contains('active')) {
                item.classList.remove('active');
                return;
            }
            
            // Boshqa ochiq faq larni yopamiz
            document.querySelectorAll('.faq-item.active').forEach(openItem => {
                openItem.classList.remove('active');
            });
            
            // Yangisini ochamiz
            item.classList.add('active');
        }

        // ==================== SEARCH ====================
        const searchInput = document.getElementById('faqSearch');
        const faqItems = document.querySelectorAll('.faq-item');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                
                faqItems.forEach(item => {
                    const searchData = item.dataset.search || '';
                    const matches = searchData.includes(query);
                    item.style.display = matches ? 'block' : 'none';
                });
                
                // Hech qanday natija topilmasa
                const visibleItems = document.querySelectorAll('.faq-item[style*="display: block"]');
                const noResults = document.getElementById('noResults');
                
                if (visibleItems.length === 0 && faqItems.length > 0) {
                    if (!noResults) {
                        const container = document.getElementById('faqsList');
                        const empty = document.createElement('div');
                        empty.id = 'noResults';
                        empty.className = 'no-results-found';
                        empty.innerHTML = `
                            <i class="fas fa-search"></i>
                            <h5>@lang('words.faqs.no_results_title')</h5>
                            <p>"${this.value}" @lang('words.faqs.no_results_text')</p>
                        `;
                        container.appendChild(empty);
                    }
                } else {
                    const noResultsEl = document.getElementById('noResults');
                    if (noResultsEl) {
                        noResultsEl.remove();
                    }
                }
            });
        }

        // ==================== CATEGORY FILTER ====================
        const filterButtons = document.querySelectorAll('.filter-btn');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Active class ni o'zgartiramiz
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const category = this.dataset.category;
                
                faqItems.forEach(item => {
                    const itemCategory = item.dataset.category;
                    
                    if (category === 'all' || itemCategory === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                // Qidiruv inputini tozalaymiz
                if (searchInput) {
                    searchInput.value = '';
                }
                
                // No results ni olib tashlaymiz
                const noResults = document.getElementById('noResults');
                if (noResults) {
                    noResults.remove();
                }
            });
        });

        // ==================== KEYBOARD SHORTCUTS ====================
        document.addEventListener('keydown', function(e) {
            // Ctrl + F - qidiruvga fokus
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                if (searchInput) {
                    searchInput.focus();
                }
            }
            
            // Escape - qidiruvni tozalash
            if (e.key === 'Escape' && searchInput && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.blur();
            }
        });

        // ==================== DOM READY ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Agar bitta faq bo'lsa, uni ochib qo'yamiz
            const items = document.querySelectorAll('.faq-item');
            if (items.length === 1) {
                items[0].classList.add('active');
            }
        });
    </script>
    
</x-layouts.main.website>