<x-layouts.main.website>
    <x-slot:title>
        {{ $medicine->name }} - @lang('words.detail')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/suppliers.css') }}" />

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
                    <a href="{{ route('medicines.index') }}">@lang('words.medicines_list')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $medicine->name }}
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $medicine->name }} - @lang('words.detail_info')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="medicine-create-container">
            <div class="info-sections">
                
                <!-- Asosiy ma'lumotlar -->
                <div class="info-section">
                    <div class="section-header">
                        <i class="fas fa-info-circle"></i>
                        <h3>@lang('words.basic_info')</h3>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-capsules"></i>
                                @lang('words.medicine_name')
                            </div>
                            <div class="info-value">
                                <strong>{{ $medicine->name }}</strong>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-tag"></i>
                                @lang('words.category')
                            </div>
                            <div class="info-value">
                                <span class="category-badge">{{ $medicine->category->name ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-chart-line"></i>
                                @lang('words.dose')
                            </div>
                            <div class="info-value">
                                {{ $medicine->strength_value }} {{ $medicine->strength_unit }}
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-tablets"></i>
                                @lang('words.medicine_form')
                            </div>
                            <div class="info-value">
                                {{ $medicine->form ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-box"></i>
                                @lang('words.package_type')
                            </div>
                            <div class="info-value">
                                {{ $medicine->package_type ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-cube"></i>
                                @lang('words.units_per_box')
                            </div>
                            <div class="info-value">
                                {{ $medicine->units_per_box }} @lang('words.piece')
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-align-left"></i>
                                @lang('words.additional_info')
                            </div>
                            <div class="info-value">
                                {{ $medicine->description ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Miqdor va narx ma'lumotlari -->
                <div class="info-section">
                    <div class="section-header">
                        <i class="fas fa-chart-line"></i>
                        <h3>@lang('words.quantity_price_info')</h3>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-warehouse"></i>
                                @lang('words.current_stock')
                            </div>
                            <div class="info-value">
                                <div class="stock-info">
                                    <div class="stock-bar">
                                        <div class="stock-fill {{ $stockClass }}" style="width: {{ $stockPercentage }}%"></div>
                                    </div>
                                    <div class="stock-text">
                                        <strong>{{ $medicine->stock_boxes ?? 0 }}</strong> @lang('words.box') / @lang('words.min_stock'): {{ $medicine->min_stock ?? 0 }} @lang('words.piece')
                                        @if($stockPercentage <= 30)
                                            <span style="color: {{ $stockPercentage <= 10 ? '#e74c3c' : '#f39c12' }};">
                                                ({{ $stockPercentage <= 10 ? __('words.very_low') : __('words.low_stock') }})
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-exclamation-triangle"></i>
                                @lang('words.min_stock')
                            </div>
                            <div class="info-value">
                                {{ $medicine->min_stock ?? 0 }} @lang('words.piece')
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-truck"></i>
                                @lang('words.supplier')
                            </div>
                            <div class="info-value">
                                <i class="fas fa-building"></i>
                                {{ $medicine->supplier->name ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-dollar-sign"></i>
                                @lang('words.price')
                            </div>
                            <div class="info-value">
                                <span class="price-text">{{ $formattedPrice }}</span> @lang('words.sum')
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt"></i>
                                @lang('words.created_at')
                            </div>
                            <div class="info-value">
                                {{ $formattedCreatedAt }}
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-edit"></i>
                                @lang('words.updated_at')
                            </div>
                            <div class="info-value">
                                {{ $formattedUpdatedAt }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main.website>