<!-- patient-appointments.blade.php -->
<x-layouts.main.app>
    <x-slot:title>
        @lang('words.my_appointments')
    </x-slot:title>

    
    <link href="{{ asset('temp/css/patient-appointments..css') }}" rel="stylesheet">

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">@lang('words.my_appointments')</h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main.page')</a></li>
                <li class="breadcrumb-item"><a href="#">@lang('words.pages')</a></li>
                <li class="breadcrumb-item active text-primary">@lang('words.my_appointments')</li>
            </ol>    
        </div>
    </div>
    <!-- Header End -->

    <!-- Main Content Start -->
    <div class="appointment-main-wrapper">
        <div class="appointment-main-row">
            <div class="appointment-content-column">
                <div class="appointment-header-section">
                    <h2 class="appointment-page-title">@lang('words.my_appointments')</h2>
                    <span class="appointment-total-count"> @lang('words.admissions') ({{ $appointments->total() }})</span>
                </div>
                
                @if($appointments->isEmpty())
                    <!-- Empty State Start -->
                    <div class="appointment-empty-state">
                        <div class="appointment-empty-icon-wrapper">
                            <i class="fas fa-calendar-check appointment-empty-icon"></i>
                        </div>
                        <h4 class="appointment-empty-title">@lang('words.no_appointments_found')</h4>
                        <p class="appointment-empty-text">@lang('words.you_have_no_appointments')</p>
                        <a href="{{ route('services.page') }}" class="appointment-empty-btn">
                            <i class="fas fa-plus"></i> @lang('words.book_appointment')
                        </a>
                    </div>
                    <!-- Empty State End -->
                @else
                    <!-- Desktop Table Start -->
                    <div class="appointment-table-desktop">
                        <table class="appointment-table">
                            <thead class="appointment-table-head">
                                <tr class="appointment-table-row">
                                    <th class="appointment-table-header">#</th>
                                    <th class="appointment-table-header">@lang('words.doctor')</th>
                                    <th class="appointment-table-header">@lang('words.department')</th>
                                    <th class="appointment-table-header">@lang('words.date')</th>
                                    <th class="appointment-table-header">@lang('words.status')</th>
                                    <th class="appointment-table-header">@lang('words.actions')</th>
                                </tr>
                            </thead>
                            <tbody class="appointment-table-body">
                                @foreach($appointments as $appointment)
                                    <tr class="appointment-table-row-item" data-appointment-id="{{ $appointment['appointmentId'] }}">
                                        <td class="appointment-table-cell appointment-number">{{ $loop->iteration }}</td>
                                        <td class="appointment-table-cell appointment-doctor-cell">
                                            <div class="appointment-doctor-info">
                                                <img src="{{ $appointment['doctorPhoto'] }}" 
                                                     alt="{{ $appointment['doctorName'] }}"
                                                     class="appointment-doctor-image">
                                                <div class="appointment-doctor-details">
                                                    <div class="appointment-doctor-name">@lang('words.dr') {{ $appointment['doctorFullName'] }}</div>
                                                    <span class="appointment-doctor-specialization">{{ $appointment['doctorSpecialization'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="appointment-table-cell appointment-department">
                                            <span class="appointment-department-badge">{{ $appointment['departmentName'] }}</span>
                                        </td>
                                        <td class="appointment-table-cell appointment-date">
                                            <i class="fas fa-calendar-day" style="color: #0dcaf0; margin-right: 6px;"></i>
                                            {{ $appointment['appointmentDate'] }}
                                        </td>
                                        <td class="appointment-table-cell appointment-status-cell">
                                            <span class="appointment-status-badge" 
                                                  style="background-color: {{ $appointment['status_bg_color'] }}; 
                                                         color: {{ $appointment['status_text_color'] }};">
                                                <i class="{{ $appointment['status_icon'] }}"></i>
                                                {{ $appointment['status_text'] }}
                                            </span>
                                        </td>
                                        <td class="appointment-table-cell appointment-actions-cell">
                                            @if($appointment['status'] === 'booked')
                                                <form action="{{ route('appointments.cancel', $appointment['appointmentId']) }}" 
                                                      method="POST" 
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Qabulni bekor qilmoqchimisiz?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="appointment-cancel-btn">
                                                        <i class="fas fa-times"></i> @lang('words.cancel')
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('appointments.show', $appointment['appointmentId']) }}" class="appointment-view-btn">
                                                    <i class="fas fa-eye"></i> @lang('words.view')
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Desktop Table End -->

                    <!-- Mobile Cards Start -->
                    <div class="appointment-mobile-cards">
                        @foreach($appointments as $appointment)
                            <div class="appointment-mobile-card" data-appointment-id="{{ $appointment['appointmentId'] }}">
                                <!-- Sana va vaqt -->
                                <div class="appointment-mobile-date">
                                    <i class="fas fa-calendar-day" style="color: #0dcaf0; margin-right: 6px;"></i>
                                    {{ $appointment['appointmentDate'] }}
                                </div>
                                
                                <!-- Doctor rasmi va ismi -->
                                <div class="appointment-mobile-doctor-wrapper">
                                    <img src="{{ $appointment['doctorPhoto'] }}" 
                                         alt="{{ $appointment['doctorName'] }}"
                                         class="appointment-mobile-doctor-image">
                                    <div class="appointment-mobile-doctor-info">
                                        <a href="{{ route('appointments.show', $appointment['appointmentId']) }}" class="appointment-mobile-doctor-name">
                                            Dr. {{ $appointment['doctorFullName'] }}
                                        </a>
                                        <div class="appointment-mobile-specialization">
                                            {{ $appointment['doctorSpecialization'] }}
                                        </div>
                                        <div class="appointment-mobile-department">
                                            <i class="fas fa-building" style="color: #0dcaf0; font-size: 11px;"></i>
                                            {{ $appointment['departmentName'] }}
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status va tugmalar -->
                                <div class="appointment-mobile-footer">
                                    <span class="appointment-mobile-status-badge" 
                                          style="background-color: {{ $appointment['status_bg_color'] }}; 
                                                 color: {{ $appointment['status_text_color'] }};">
                                        <i class="{{ $appointment['status_icon'] }}"></i>
                                        {{ $appointment['status_text'] }}
                                    </span>
                                    <div class="appointment-mobile-actions">
                                        <a href="{{ route('appointments.show', $appointment['appointmentId']) }}" class="appointment-mobile-view-btn">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($appointment['status'] == 'booked')
                                            <form action="{{ route('appointments.cancel', $appointment['appointmentId']) }}" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Qabulni bekor qilmoqchimisiz?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="appointment-mobile-cancel-btn">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Mobile Cards End -->
                    
                    <!-- Pagination Start -->
                    <div class="appointment-pagination-wrapper">
                        {{ $appointments->links() }}
                    </div>
                    <!-- Pagination End -->
                @endif
            </div>
        </div>
    </div>
    <!-- Main Content End --> 

    @include('partials.alert')

    <!-- Custom CSS -->

</x-layouts.main.app>