<x-layouts.main.website>
    <x-slot:title>
        @lang('words.personal_information')
    </x-slot:title>

    <!-- Breadcrumb Navigation -->
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
                        @lang('words.personal_information')
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.personal_information')</h4>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    <!-- Nurse Detail View -->
    <link rel="stylesheet" href="{{ asset('temp2/css/personal-data.css') }}" />

    <div class="container"> 

        <!-- Main Content -->
        <div class="nurse-main-content">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-avatar">
                    {{ $avatarLetters }}
                </div>

                <div class="profile-name">
                    <h2>{{ $fullName }}</h2> 
                </div>

                <div class="profile-status">
                    <div class="status-badge" style="
                        background-color: {{ $status['color'] }}; 
                        color: {{ $status['textColor'] }}; 
                        border-color: {{ $status['borderColor'] }};
                    ">
                        <i class="{{ $status['icon'] }}"></i>
                        {{ $status['label'] }}
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-sign-in-alt"></i>
                            @lang('words.login')
                        </div>
                        <div class="info-value">{{ $login }}</div> 
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            @lang('words.phone')
                        </div>
                        <div class="info-value">{{ $phone }}</div> 
                    </div> 

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-check"></i>
                            @lang('words.hired_date')
                        </div>
                        <div class="info-value">{{ $hiredDate }}</div> 
                    </div> 
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-chart-line"></i>
                            @lang('words.experience')
                        </div>
                        <div class="info-value">{{ $experienceYears }} @lang('words.years')</div> 
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
                            <div class="info-label">
                                <i class="fas fa-user"></i>
                                @lang('words.full_name'):
                            </div>
                            <div class="info-value">{{ $fullName }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-sign-in-alt"></i>
                                @lang('words.login'):
                            </div>
                            <div class="info-value">{{ $login }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-phone"></i>
                                @lang('words.phone_number'):
                            </div>
                            <div class="info-value">{{ $phone }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt"></i>
                                @lang('words.birth_date'):
                            </div>
                            <div class="info-value">
                                @if($birthDateFormatted)
                                    {{ $birthDateFormatted }}
                                    ({{ $age }} @lang('words.years_old'))
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
                            <div class="info-label">
                                <i class="fas fa-hospital"></i>
                                @lang('words.specialization'):
                            </div>
                            <div class="info-value">{{ $specialization }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-chart-line"></i>
                                @lang('words.experience'):
                            </div>
                            <div class="info-value">{{ $experienceYears }} @lang('words.years')</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-calendar-check"></i>
                                @lang('words.hired_date'):
                            </div>
                            <div class="info-value">{{ $hiredDate }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-user-check"></i>
                                @lang('words.status'):
                            </div>
                            <div class="info-value">{{ $status['label'] }}</div>
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
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt"></i>
                                @lang('words.address'):
                            </div>
                            <div class="info-value">{{ $address }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i>
                                @lang('words.email'):
                            </div>
                            <div class="info-value">{{ $email }}</div>
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
                            <div class="info-label">
                                <i class="fas fa-hashtag"></i>
                                @lang('words.id_number'):
                            </div>
                            <div class="info-value">{{ $userId }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-plus-circle"></i>
                                @lang('words.created_at'):
                            </div>
                            <div class="info-value">{{ $createdAtFormatted }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-edit"></i>
                                @lang('words.updated_at'):
                            </div>
                            <div class="info-value">{{ $updatedAtFormatted }}</div>
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
                <p style="color: #4a5568; line-height: 1.6;">
                    {{ $description }}
                </p>
            </div>
        </div>

        <!-- Timeline -->
        <div class="timeline-section">
            <div class="section-header">
                <i class="fas fa-history"></i>
                <h3>@lang('words.activity_history')</h3>
            </div>
            <div style="padding: 15px;">
                @foreach($timeline as $item)
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="{{ $item['icon'] }}"></i>
                    </div>
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

</x-layouts.main.website>