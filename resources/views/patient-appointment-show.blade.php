<!-- appointment-show.blade.php -->
<x-layouts.main.app> 
    <x-slot:title>
        Qabul ma'lumotlari
    </x-slot:title> 

    <link href="{{ asset('temp/css/patient-appointment-show.css') }}" rel="stylesheet">

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Qabul ma'lumotlari</h3>
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main.page')</a></li>
                <li class="breadcrumb-item"><a href="#">@lang('words.pages')</a></li>
                <li class="breadcrumb-item"><a href="{{ route('patient.appointments') }}">Mening qabullarim</a></li>
                <li class="breadcrumb-item active text-primary">Qabul ma'lumotlari</li>
            </ol>    
        </div>
    </div>
    <!-- Header End -->

    <!-- Main Content Start -->
    <div class="appointment-show-wrapper">
        <div class="appointment-show-container"> 

            <div class="appointment-show-grid">
                <!-- Chap qism -->
                <div class="appointment-show-left">
                    <!-- Doctor Card -->
                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <span>@lang('words.doctor')</span>
                        </div>
                        <div class="appointment-card-body">
                            <div class="appointment-show-doctor">
                                <img src="{{ $formattedAppointment['doctorPhoto'] }}" 
                                    alt="{{ $formattedAppointment['doctorName'] }}"
                                    class="appointment-show-doctor-image">
                                <div class="appointment-show-doctor-info">
                                    <div class="appointment-show-doctor-name">Dr. {{ $formattedAppointment['doctorFullName'] }}</div>
                                    <div class="appointment-show-doctor-specialization">{{ $formattedAppointment['doctorSpecialization'] }}</div>
                                    <div class="appointment-show-doctor-experience">
                                        <i class="fas fa-briefcase"></i>
                                        @lang('words.experience'):
                                        {{ $formattedAppointment['doctorExperienceYears'] ?? __('words.unknown') }}
                                        @lang('words.year')
                                    </div>
                                    <div class="appointment-show-doctor-department">
                                        <i class="fas fa-building"></i> {{ $formattedAppointment['departmentName'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bemor Card -->
                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <span>@lang('words.patient_info')</span>
                        </div>
                        <div class="appointment-card-body">
                            <div class="appointment-patient-info">
                                <div class="appointment-patient-row">
                                    <span class="appointment-patient-label">@lang('words.name'):</span>
                                    <span class="appointment-patient-value">{{ $formattedAppointment['patient_name'] ?? 'Noma\'lum' }}</span>
                                </div>
                                <div class="appointment-patient-row">
                                    <span class="appointment-patient-label">@lang('words.birth_date'):</span>
                                    <span class="appointment-patient-value">{{ $formattedAppointment['patient_birthdate'] ?? 'Noma\'lum' }}</span>
                                </div>
                                <div class="appointment-patient-row">
                                    <span class="appointment-patient-label">@lang('words.phone'):</span>
                                    <span class="appointment-patient-value">{{ $formattedAppointment['patient_phone'] ?? 'Noma\'lum' }}</span>
                                </div>
                                <div class="appointment-patient-row">
                                    <span class="appointment-patient-label">@lang('words.gender'):</span>
                                    <span class="appointment-patient-value">{{ $formattedAppointment['patient_gender'] ?? 'Noma\'lum' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sana va Holat Card -->
                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <span>Qabul vaqti</span>
                        </div>
                        <div class="appointment-card-body">
                            <div class="appointment-info-row">
                                <div class="appointment-info-label">@lang('words.time_date'):</div>
                                <div class="appointment-info-value">{{ $formattedAppointment['appointmentDate'] }} | {{ $formattedAppointment['appointmentTime'] ?? 'Noma\'lum' }}</div>
                            </div>
                            <div class="appointment-info-row">
                                <div class="appointment-info-label">@lang('words.status'):</div>
                                <div class="appointment-info-value">
                                    <span class="appointment-status-badge" 
                                          style="background-color: {{ $formattedAppointment['status_bg_color'] }}; 
                                                 color: {{ $formattedAppointment['status_text_color'] }};">
                                        <i class="{{ $formattedAppointment['status_icon'] }}"></i>
                                        {{ $formattedAppointment['status_text'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- O'ng qism -->
                <div class="appointment-show-right">
                    <!-- Shikoyatlar Card --> 
                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <span>@lang('words.appointment_reason')</span>
                        </div>
                        <div class="appointment-card-body">
                            <div class="appointment-diagnosis-item">
                                <span class="appointment-diagnosis-label">@lang('words.main_'):</span>
                                <span class="appointment-diagnosis-value">{{ $formattedAppointment['appointment_reason'] ?? 'Tashxis qo\'yilmagan' }}</span>
                            </div> 
                            <div class="appointment-diagnosis-item">
                                <span class="appointment-diagnosis-label">@lang('words.additional'):</span>
                                <span class="appointment-diagnosis-value">{{ $formattedAppointment['appointment_notes'] }}</span>
                            </div> 
                        </div> 
                    </div> 

                    <!-- Tashxis Card -->
                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <span>@lang('words.diagnosis')</span>
                        </div>
                        <div class="appointment-card-body">
                            <div class="appointment-diagnosis-item">
                                <span class="appointment-diagnosis-label">@lang('words.main_'):</span>
                                <span class="appointment-diagnosis-value">{{ $formattedAppointment['diagnosis'] ?? 'Tashxis qo\'yilmagan' }}</span>
                            </div>
                            @if(!empty($formattedAppointment['full_diagnosis']))
                            <div class="appointment-diagnosis-item">
                                <span class="appointment-diagnosis-label">@lang('words.additional'):</span>
                                <span class="appointment-diagnosis-value">{{ $formattedAppointment['full_diagnosis'] }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <span>@lang('words.prescriptions')</span>
                        </div>
                        <div class="appointment-card-body">
                            @if(isset($prescriptions) && !empty($prescriptions))
                                @foreach($prescriptions as $prescription)
                                    @foreach($prescription['items'] as $item)
                                        <div class="appointment-prescription-item">
                                            <div class="appointment-prescription-row">
                                                <p class="appointment-prescription-name">
                                                    <i class="fas fa-check-circle" style="color: #0dcaf0;"></i>
                                                    {{ $item['medicine'] ?? 'Dori' }}
                                                </p>
                                                <p class="appointment-prescription-dosage">
                                                    {{ $item['formatted_text'] }}
                                                </p>
                                            </div>
                                            @if(isset($item['usage_instructions']) && $item['usage_instructions'])
                                                <p class="appointment-prescription-instruction">
                                                    <small>{{ $item['usage_instructions'] }}</small>
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            @else
                                <p class="text-muted">Retsept mavjud emas</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tugmalar -->
            <div class="appointment-show-actions"> 
                @if($formattedAppointment['status'] == 'booked')
                    <form action="{{ route('appointments.cancel', $formattedAppointment['id']) }}" method="POST" class="appointment-show-cancel-form" onsubmit="return confirm('Qabulni bekor qilmoqchimisiz?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="appointment-show-cancel-btn">
                            <i class="fas fa-times"></i> Bekor qilish
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <!-- Main Content End -->

    @include('partials.alert')

    

</x-layouts.main.app>