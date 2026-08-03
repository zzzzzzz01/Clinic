<x-layouts.main.website>
    <x-slot:title>
        @lang('words.patient_info') - @lang('words.treatment')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/hospitalization-show.css') }}" />

    <div class="container pt-4" style="width: 100%;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('hospitalizations.index') }}">
                        @lang('words.inpatients')
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $hospitalization->appointment->patient->user->name }} {{ $hospitalization->appointment->patient->user->last_name }}
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $hospitalization->appointment->patient->user->name }} {{ $hospitalization->appointment->patient->user->last_name }}</h4>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="profile-body">
            <div class="current-treatment">
                <div class="treatment-tabs">
                    <button class="treatment-tab active" onclick="showTab('staffTab', 'staff')" data-tab="staff">
                        <i class="fas fa-user-md"></i>
                        <span class="treatment-tab-span">@lang('words.medical_staff')</span>
                        <span class="badge badge-primary" id="staffCount">{{ $hospitalization->hospitalizationStaff()->count() }}</span>
                    </button>
                    <button class="treatment-tab" onclick="showTab('medicationTab', 'medication')" data-tab="medication">
                        <i class="fas fa-pills"></i>
                        <span class="treatment-tab-span">@lang('words.medicines')</span>
                        <span class="badge badge-primary">{{ $medicationTotalCount }}</span>
                    </button>
                    <button class="treatment-tab" onclick="showTab('testTab', 'test')" data-tab="test">
                        <i class="fas fa-vial"></i>
                        <span class="treatment-tab-span">@lang('words.lab_tests')</span>
                        <span class="badge badge-primary">{{ $orderItems->count() }}</span>
                    </button>
                    <button class="treatment-tab" onclick="showTab('procedureTab', 'procedure')" data-tab="procedure">
                        <i class="fas fa-procedures"></i>
                        <span class="treatment-tab-span">@lang('words.procedures')</span>
                        <span class="badge badge-primary">{{ $hospitalizationProcedures->count() }}</span>
                    </button>
                    <button class="treatment-tab" onclick="showTab('roomsTab', 'rooms')" data-tab="rooms">
                        <i class="fas fa-bed"></i>
                        <span class="treatment-tab-span">@lang('words.rooms')</span>
                        <span class="badge badge-primary">{{ $roomAssignments->count() }}</span>
                    </button>
                </div>

                <div id="staffTab" class="tab-content active">
                    @include('partials.hospitalization.doctors')
                </div> 
                
                <div id="testTab" class="tab-content" style="display: none;">
                    @include('partials.hospitalization.laboratory-tests')
                </div>
                
                <div id="procedureTab" class="tab-content" style="display: none;">
                    @include('partials.hospitalization.procedures')
                </div>

                <div class="tab-content" id="medicationTab" style="display: none;">
                    @include('partials.hospitalization.medicines')
                </div>
                
                <div id="roomsTab" class="tab-content" style="display: none;">
                    @include('partials.hospitalization.rooms')
                </div> 
            </div>
            
            <!-- Medical History -->
            <div class="medical-history">
                <h3><i class="fas fa-history"></i> @lang('words.medical_history')</h3>
                <div class="timeline" id="medicalTimeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">
                            <i class="far fa-calendar"></i> {{ Carbon\Carbon::parse($hospitalization->admitted_at)->format('Y.m.d | H:i') }}
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-description">
                                <strong>@lang('words.admitted_to_hospital')</strong><br>
                                @php
                                $room = $hospitalization->currentRoom
                                    ?? $hospitalization->hospitalizationRooms()->latest()->first();

                                $roomNumber = $room?->bed?->room?->number;
                                @endphp
                                
                                @if($roomNumber)
                                    @if(app()->getLocale() == 'uz')
                                        Bemor asoratlar bilan kelib, yotqizish tavsiya etildi. {{ $roomNumber }}-xonaga joylashtirildi.
                                    @elseif(app()->getLocale() == 'ru')
                                        Пациент поступил с осложнениями, рекомендована госпитализация. Размещен в палате {{ $roomNumber }}.
                                    @else
                                        Patient presented with complications, hospitalization was recommended. Placed in room {{ $roomNumber }}.
                                    @endif
                                @else
                                    @if(app()->getLocale() == 'uz')
                                        Bemor asoratlar bilan kelib, yotqizish tavsiya etildi.
                                    @elseif(app()->getLocale() == 'ru')
                                        Пациент поступил с осложнениями, рекомендована госпитализация.
                                    @else
                                        Patient presented with complications, hospitalization was recommended.
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- <div class="action-buttons">
                <button class="btn btn-primary" onclick="exportPatientData()">
                    <i class="fas fa-download"></i> @lang('words.download_data')
                </button>
                <button class="btn btn-success" onclick="printTreatmentPlan()">
                    <i class="fas fa-print"></i> @lang('words.print_treatment_plan')
                </button>
                <button class="btn btn-info" onclick="showAllStats()">
                    <i class="fas fa-chart-bar"></i> @lang('words.view_all_stats')
                </button>
            </div> -->
        </div>
    </div>
    
    <script src="{{ asset('temp2/js/hospitalization-show.js') }}"></script>
    <script>
        window.Lang = {
            words: @json(__('words'))
        };
    </script>

</x-layouts.main.website>