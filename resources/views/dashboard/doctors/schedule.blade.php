<x-layouts.main.website>
    <x-slot:title>
        {{ $schedulable->user->last_name }} {{ $schedulable->user->name }} - @lang('words.schedule')
    </x-slot:title>

    <div class="container pt-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    @if($type == 'doctor')
                        <a href="{{ route('doctors.index') }}">@lang('words.doctors.list')</a>
                    @elseif($type == 'nurse')
                        <a href="{{ route('nurses.index') }}">@lang('words.nurses_list')</a>
                    @else
                        <a href="#">@lang('words.staff')</a>
                    @endif
                </li>
                <li class="breadcrumb-item active">
                    {{ $schedulable->user->last_name }} {{ $schedulable->user->name }} - @lang('words.schedule')
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="search-wrapper">
            <div class="search-card">
                <h4 class="mb-0">{{ $schedulable->user->last_name }} {{ $schedulable->user->name }} - @lang('words.schedule')</h4>
            </div>
        </div>
        
        {{-- Form --}}
        <form action="{{ route('schedule.save', ['type' => $type, 'id' => $schedulable->id]) }}" 
              method="POST" 
              id="scheduleForm">
            @csrf
            @if($hasSchedule) @method('PUT') @endif
            
            {{-- Tugmalar --}}
            <div class="schedule-buttons">
                <a href="#quick-settings" class="btn-secondary" data-bs-toggle="collapse">
                    <i class="fas fa-cog"></i>@lang('words.quick_settings')
                </a>
                <button type="submit" class="btn-primary">
                    {{ $hasSchedule ? __('words.update') : __('words.save') }}
                </button>
            </div>

            {{-- Tez sozlamalar --}}
            <div class="collapse mb-4" id="quick-settings">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn-primary-outline w-100" onclick="applyTemplate('weekday')">
                                    @lang('words.weekday_template')
                                </button>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn-success-outline w-100" onclick="applyTemplate('weekend')">
                                    @lang('words.weekend_template')
                                </button>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn-warning-outline w-100" onclick="applyTemplate('clear')">
                                    @lang('words.clear_all_days')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($daysOfWeek as $day)
                @php
                    $isWorking = $day->schedule->is_working ?? false;
                @endphp
                
                <div class="schedule-day" data-day-id="{{ $day->id }}">
                    <div class="day-header">
                        <div class="day-title">
                            <div class="day-icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="day-info">
                                @php
                                    $locale = app()->getLocale();
                                    $dayName = match($locale) {
                                        'ru' => $day->name_ru ?? $day->name_uz,
                                        'en' => $day->name_en ?? $day->name_uz,
                                        default => $day->name_uz,
                                    };
                                @endphp
                                <h5>{{ $dayName }}</h5>
                            </div>
                        </div>

                        <div class="day-switch">
                            <label class="schedule-switch">
                                <input type="hidden" name="days[{{ $day->id }}][is_working]" value="0">
                                <input type="checkbox"
                                    name="days[{{ $day->id }}][is_working]"
                                    value="1" 
                                    {{ $isWorking ? 'checked' : '' }}
                                    class="working-checkbox"
                                    data-day="{{ $day->id }}">
                                <span class="schedule-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="time-controls">
                        <div class="time-group">
                            <label>@lang('words.working_hours')</label>
                            <div class="time-input-group">
                                <input type="time" class="time-input start-time"
                                    name="days[{{ $day->id }}][start_time]"
                                    value="{{ $day->schedule->start_time ?? '' }}"
                                    {{ !$isWorking ? 'disabled' : '' }}>
                                <span class="time-separator">—</span>
                                <input type="time" class="time-input end-time"
                                    name="days[{{ $day->id }}][end_time]"
                                    value="{{ $day->schedule->end_time ?? '' }}"
                                    {{ !$isWorking ? 'disabled' : '' }}>
                            </div>
                        </div>

                        <div class="time-group">
                            <label>@lang('words.lunch_break')</label>
                            <div class="time-input-group">
                                <input type="time" class="time-input"
                                    name="days[{{ $day->id }}][lunch_start]"
                                    value="{{ $day->schedule->lunch_start ?? '' }}"
                                    {{ !$isWorking ? 'disabled' : '' }}>
                                <span class="time-separator">—</span>
                                <input type="time" class="time-input"
                                    name="days[{{ $day->id }}][lunch_end]"
                                    value="{{ $day->schedule->lunch_end ?? '' }}"
                                    {{ !$isWorking ? 'disabled' : '' }}>
                            </div>
                        </div>

                        <div class="time-group">
                            <label>@lang('words.appointment_duration')</label>
                            <select class="duration-select"
                                    name="days[{{ $day->id }}][appointment_duration]"
                                    {{ !$isWorking ? 'disabled' : '' }}>
                                <option value="15" {{ ($day->schedule->appointment_duration ?? 30) == 15 ? 'selected' : '' }}>15 @lang('words.minutes')</option>
                                <option value="20" {{ ($day->schedule->appointment_duration ?? 30) == 20 ? 'selected' : '' }}>20 @lang('words.minutes')</option>
                                <option value="30" {{ ($day->schedule->appointment_duration ?? 30) == 30 ? 'selected' : '' }}>30 @lang('words.minutes')</option>
                                <option value="45" {{ ($day->schedule->appointment_duration ?? 30) == 45 ? 'selected' : '' }}>45 @lang('words.minutes')</option>
                                <option value="60" {{ ($day->schedule->appointment_duration ?? 30) == 60 ? 'selected' : '' }}>1 @lang('words.hour')</option>
                            </select>
                        </div>
                    </div>

                    <div class="day-actions">
                        <button type="button" class="btn-secondary" onclick="resetDay({{ $day->id }})">
                            <i class="fas fa-undo"></i> @lang('words.reset_to_default')
                        </button>
                        <button type="button" class="btn-primary" onclick="copyToNextDay({{ $day->id }})">
                            <i class="fas fa-arrow-right"></i> @lang('words.copy_to_next_day')
                        </button>
                    </div>
                </div>
            @endforeach
        </form>

        {{-- Statistikalar --}}
        <div class="stats-grid">
            <div class="stat-card-stat primary">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $workingDaysCount }}</div>
                        <div class="stat-label">@lang('words.working_days')</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card-stat primary">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $totalWorkingHours }}</div>
                        <div class="stat-label">@lang('words.weekly_working_hours')</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.alert')
    
</x-layouts.main.website>