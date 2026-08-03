<x-layouts.main.website>
    <x-slot:title>
        {{ $procedure->name }} - @lang('words.detail')
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
                    <a href="{{ route('procedures.index') }}">@lang('words.procedures_list')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $procedure->name }}
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $procedure->name }} - @lang('words.detail_info')</h4>
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
                            <div class="info-label" style="width: 65%;">
                                <i class="fas fa-capsules"></i>
                                @lang('words.procedure_name')
                            </div>
                            <div class="info-value">
                                <strong>{{ $procedure->name }}</strong>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-tag"></i>
                                @lang('words.category')
                            </div>
                            <div class="info-value">
                                <span class="category-badge">{{ $procedure->category ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-dollar"></i>
                                @lang('words.price')
                            </div>
                            <div class="info-value">
                                {{ $procedure->price }} $
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Miqdor va narx ma'lumotlari -->
                <div class="info-section">
                    <div class="section-header">
                        <i class="fas fa-chart-line"></i>
                        <h3>@lang('words.additional_info')</h3>
                    </div>
                    <div class="info-grid"> 
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fa-regular fa-clock"></i>
                                @lang('words.duration')
                            </div>
                            <div class="info-value">
                                {{ $procedure->duration ?? '-' }} @lang('words.minutes')
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-box"></i>
                                @lang('words.status')
                            </div>
                            <div class="info-value">
                                @if($procedure->is_active == 1)
                                    <span class="status-badge status-active"><i class="fas fa-check-circle"></i> Mavjud</span>
                                @else
                                    <span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> Mavjud emas</span>
                                @endif
                            </div>
                        </div> 

                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-align-left"></i>
                                @lang('words.description')
                            </div>
                            <div class="info-value">
                                {{ $procedure->description ?? '-' }}
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main.website>