<x-layouts.main.website>
    <x-slot:title>
        @lang('words.create_page_title')
    </x-slot:title>

    <style>
        .form-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 11px;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
        }

    </style> 

    <div class="container pt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('faqs.index') }}" class="text-decoration-none">
                        @lang('words.faqs.breadcrumb')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.create_breadcrumb')
                    </a>
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.create_page_title')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <form action="{{ route('faqs.store') }}" method="POST">
            @csrf
            <div class="form-container"> 
                <!-- 3 ta input ketma-ket -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="question_uz" class="notification-label">@lang('words.question_uz')</label>
                        <input type="text" 
                                class="form-control" 
                                id="question_uz" 
                                name="question_uz" 
                                placeholder="@lang('words.question_uz_placeholder')"
                                value="{{ old('question_uz') }}">
                    </div>

                    <div class="form-group">
                        <label for="question_ru" class="notification-label">
                            @lang('words.question_ru')
                        </label>
                        <input type="text" 
                                class="form-control" 
                                id="question_ru" 
                                name="question_ru" 
                                placeholder="@lang('words.question_ru_placeholder')"
                                value="{{ old('question_ru') }}">
                    </div>

                    <div class="form-group">
                        <label for="question_en" class="notification-label">
                            @lang('words.question_en')
                        </label>
                        <input type="text" 
                                class="form-control" 
                                id="question_en" 
                                name="question_en" 
                                placeholder="@lang('words.question_en_placeholder')"
                                value="{{ old('question_en') }}">
                    </div>

                    <!-- 3 ta textarea ketma-ket -->
                    <div class="form-group">
                        <label for="answer_uz" class="notification-label">
                            @lang('words.answer_uz')
                        </label>
                        <textarea class="form-control" 
                                    id="answer_uz" 
                                    name="answer_uz" 
                                    placeholder="@lang('words.answer_uz_placeholder')">{{ old('answer_uz') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="answer_ru" class="notification-label">
                            @lang('words.answer_ru')
                        </label>
                        <textarea class="form-control" 
                                    id="answer_ru" 
                                    name="answer_ru" 
                                    placeholder="@lang('words.answer_ru_placeholder')">{{ old('answer_ru') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="answer_en" class="notification-label">
                            @lang('words.answer_en')
                        </label>
                        <textarea class="form-control" 
                                    id="answer_en" 
                                    name="answer_en" 
                                    placeholder="@lang('words.answer_en_placeholder')">{{ old('answer_en') }}</textarea>
                    </div>

                    <!-- Tartib raqami -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="sort_order" class="notification-label">
                                @lang('words.sort_order')
                            </label>
                            <input type="number" 
                                class="form-control" 
                                id="sort_order" 
                                name="sort_order" 
                                placeholder="@lang('words.sort_order_placeholder')"
                                value="{{ old('sort_order', $nextSortOrder ?? 1) }}">
                            <div class="form-text">
                                @lang('words.sort_order_help')
                            </div>
                        </div>

                        <!-- Holat -->
                        <div class="form-group">
                            <label class="notification-label">@lang('words.status')</label> 
                            <select name="status" id="" class="form-control">
                                <option value="" selected disabled>@lang('words.status_select')</option>
                                <option value="1">@lang('words.status_active')</option>
                                <option value="0">@lang('words.status_inactive')</option>
                            </select>   
                        </div>
                    </div>
                </div>

            </div>
            <!-- Tugmalar -->
            <div class="submit-section">
                <div class="submit-actions">
                    <a href="{{ route('faqs.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> @lang('words.cancel')
                    </a>
                    <button type="submit" class="btn-primary">
                        @lang('words.save')
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-layouts.main.website>