<x-layouts.main.website>
    <x-slot:title>{{ $fd->full_name }}</x-slot:title>
    
    <link href="{{ asset('temp2/css/doctor-show.css') }}" rel="stylesheet">
    
    <div class="container pt-4 no-print">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctors.index') }}">@lang('words.doctors.list')</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $fd->full_name }}
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $fd->full_name }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="nurse-header no-print">
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> @lang('words.print')
            </button>
        </div>

        <div class="print-content">
            <!-- Web View -->
            <div class="web-view">
                <div class="nurse-main-content">
                    <!-- Profile Card -->
                    <div class="profile-card">
                        <div class="profile-avatar">{{ $fd->avatar_initials }}</div>

                        <div class="profile-name">
                            <h2>{{ $fd->full_name }}</h2>
                            <div class="profile-specialization">
                                <i class="fas fa-stethoscope"></i>
                                {{ $fd->specialization }}
                            </div>
                        </div>

                        <div class="profile-status">
                            <div class="status-badge" style="{{ $fd->status_badge_style }}">
                                <i class="{{ $fd->status_icon }}"></i>
                                {{ $fd->status_text }}
                            </div>
                        </div>

                        <div class="profile-info-list">
                            <div class="profile-info-item">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>@lang('words.login'): {{ $fd->login }}</span>
                            </div>
                            <div class="profile-info-item">
                                <i class="fas fa-phone"></i>
                                <span>@lang('words.phone'): {{ $fd->phone }}</span>
                            </div>
                            <div class="profile-info-item">
                                <i class="fas fa-calendar-check"></i>
                                <span>@lang('words.hired_date'): {{ $fd->created_at_date }}</span>
                            </div>
                            <div class="profile-info-item">
                                <i class="fas fa-chart-line"></i>
                                <span>@lang('words.experience'): {{ $fd->experience_years }} @lang('words.years')</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Sections -->
                    <div class="info-sections">
                        <!-- Shaxsiy ma'lumotlar -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-id-card"></i>
                                <h3>@lang('words.personal_info')</h3>
                            </div>
                            <div class="info-grid">
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-user"></i> @lang('words.full_name'):</div>
                                    <div class="info-value">{{ $fd->full_name }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-sign-in-alt"></i> @lang('words.login'):</div>
                                    <div class="info-value">{{ $fd->login }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-phone"></i> @lang('words.phone'):</div>
                                    <div class="info-value">{{ $fd->phone }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-calendar-alt"></i> @lang('words.birth_date'):</div>
                                    <div class="info-value">
                                        @if($fd->has_birth_date)
                                            {{ $fd->birth_date }} ({{ $fd->age }} @lang('words.years_old'))
                                        @else
                                            @lang('words.not_available')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kasbiy ma'lumotlar -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-briefcase-medical"></i>
                                <h3>@lang('words.professional_info')</h3>
                            </div>
                            <div class="info-grid">
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-hospital"></i> @lang('words.specialization'):</div>
                                    <div class="info-value">{{ $fd->specialization }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-chart-line"></i> @lang('words.experience'):</div>
                                    <div class="info-value">{{ $fd->experience_years }} @lang('words.years')</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-calendar-check"></i> @lang('words.hired_date'):</div>
                                    <div class="info-value">{{ $fd->created_at_date }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-user-check"></i> @lang('words.status'):</div>
                                    <div class="info-value">{{ $fd->status_text }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Aloqa ma'lumotlari -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-location-dot"></i>
                                <h3>@lang('words.contact_info')</h3>
                            </div>
                            <div class="info-grid">
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-map-marker-alt"></i> @lang('words.address'):</div>
                                    <div class="info-value">{{ $fd->address }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-envelope"></i> @lang('words.email'):</div>
                                    <div class="info-value">{{ $fd->email }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Sistema ma'lumotlari -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-database"></i>
                                <h3>@lang('words.system_info')</h3>
                            </div>
                            <div class="info-grid">
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-hashtag"></i> @lang('words.id_number'):</div>
                                    <div class="info-value">{{ $fd->formatted_id }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-plus-circle"></i> @lang('words.created_at'):</div>
                                    <div class="info-value">{{ $fd->created_at_datetime }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><i class="fas fa-edit"></i> @lang('words.updated_at'):</div>
                                    <div class="info-value">{{ $fd->updated_at_datetime }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="additional-info">
                    <div class="section-header">
                        <i class="fas fa-sticky-note"></i>
                        <h3>@lang('words.additional_information')</h3>
                    </div>
                    <div style="padding: 15px;">
                        <p style="color: #4a5568; line-height: 1.6;">{{ $fd->description }}</p>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="timeline-section">
                    <div class="section-header">
                        <i class="fas fa-history"></i>
                        <h3>@lang('words.activity_history')</h3>
                    </div>
                    <div style="padding: 15px;">
                        @foreach($fd->timeline_items as $item)
                        <div class="timeline-item">
                            <div class="timeline-icon"><i class="{{ $item['icon'] }}"></i></div>
                            <div class="timeline-content">
                                <div class="timeline-title">{{ $item['title'] }}</div>
                                <div class="timeline-date">{{ $item['date'] }}</div>
                                <div class="timeline-description">{{ $item['description'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Print View -->
            <div class="print-view">
                <h1 class="print-title">@lang('words.doctor_information')</h1>
                
                <table class="doctor-info-table">
                    <caption>{{ $fd->full_name }}</caption>
                    <tr><th>@lang('words.specialization')</th><td>{{ $fd->specialization }}</td></tr>
                    <tr><th>@lang('words.status')</th><td>{{ $fd->print_status_text }}</td></tr>
                    <tr><th>@lang('words.login')</th><td>{{ $fd->login }}</td></tr>
                    <tr><th>@lang('words.phone')</th><td>{{ $fd->phone }}</td></tr>
                    <tr><th>@lang('words.birth_date')</th>
                        <td>
                            @if($fd->has_birth_date)
                                {{ $fd->birth_date }} ({{ $fd->age }} @lang('words.years_old'))
                            @else
                                @lang('words.not_available')
                            @endif
                          </td>
                    </tr>
                    <tr><th>@lang('words.experience')</th><td>{{ $fd->experience_years }} @lang('words.years')</td></tr>
                    <tr><th>@lang('words.address')</th><td>{{ $fd->address }}</td></tr>
                    <tr><th>@lang('words.email')</th><td>{{ $fd->email }}</td></tr>
                    <tr><th>@lang('words.id_number')</th><td>{{ $fd->formatted_id }}</td></tr>
                    <tr><th>@lang('words.hired_date')</th><td>{{ $fd->created_at_date }}</td></tr>
                    <tr><th>@lang('words.created_at')</th><td>{{ $fd->created_at_datetime }}</td></tr>
                    <tr><th>@lang('words.updated_at')</th><td>{{ $fd->updated_at_datetime }}</td></tr>
                    @if($fd->has_status_changed)
                    <tr><th>@lang('words.status_changed_at')</th><td>{{ $fd->status_changed_at }}</td></tr>
                    @endif
                </table>

                @if($doctor->description)
                <div class="print-description">
                    <h3>@lang('words.additional_information')</h3>
                    <p>{{ $doctor->description }}</p>
                </div>
                @endif

                <div class="print-footer">
                    @lang('words.document_created_at'): {{ now()->format('d.m.Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main.website>