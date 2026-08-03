<x-layouts.main.website>
    <x-slot:title>
        {{ $supplier->name }} - Batafsil
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/suppliers.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('suppliers.index') }}">@lang('words.suppliers')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $supplier->name }}
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $supplier->name }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="show-supplier-container">

        <div class="info-sections">
            
            <!-- 1-INFO SECTION: Asosiy ma'lumotlar -->
            <div class="info-section">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>@lang('words.supplier_basic_info')r</h3>
                </div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-truck"></i>
                            @lang('words.supplier_name')
                        </div>
                        <div class="info-value">
                            <strong>{{ $supplier->name }}</strong>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-tag"></i>
                            @lang('words.type')
                        </div>
                        <div class="info-value">
                            <span class="type-badge">{{ $supplier->type }}</span>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-toggle-on"></i>
                            @lang('words.status')
                        </div>
                        <div class="info-value">
                            @php
                                $statusClass = $supplier->is_active == 1 ? 'status-active' : 'status-inactive';
                                $statusText = $supplier->is_active == 1 ? __('words.active') : __('words.inactive');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="fas {{ $supplier->is_active == 1 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $statusText }}
                            </span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                        <i class="fas fa-align-left"></i>
                            @lang('words.description')
                        </div>
                        <div class="info-value">
                            {{ $supplier->description ?? '--' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2-INFO SECTION: Aloqa ma'lumotlari -->
            <div class="info-section">
                <div class="section-header">
                    <i class="fas fa-address-card"></i>
                    <h3>@lang('words.contact_info')</h3>
                </div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            @lang('words.email')
                        </div>
                        <div class="info-value">
                            {{ $supplier->email ?? '-' }}
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            @lang('words.phone')
                        </div>
                        <div class="info-value">
                            {{ $supplier->phone ?? '-' }}
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            @lang('words.address')
                        </div>
                        <div class="info-value">
                            {{ $supplier->address ?? '-' }}
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-alt"></i>
                            @lang('words.created_at')
                        </div>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($supplier->created_at)->format('d.m.Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.main.website>