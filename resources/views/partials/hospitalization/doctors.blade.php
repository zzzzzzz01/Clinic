<div class="tab-header">
    <h3>@lang('words.medical_staff')</h3>

    @if(auth()->user()->hasRole('Admin'))
        <button class="btn-primary" onclick="showAddDoctorModal()">
            <i class="fas fa-plus"></i>
        </button>
    @endif
</div>

<div class="content-grid" id="staffContent">

    @foreach($sortedStaff as $item)
        <div class="staff-card">

            <div class="staff-main">

                <div class="staff-avatar">
                    {{ $item['avatar'] }}
                </div>

                <div class="staff-info">

                    <div class="staff-name">
                        {{ $item['full_name'] }} ({{ $item['role_text'] }})
                    </div>

                    <!-- <div class="staff-specialization">
                        {{ $item['specialization'] }}
                    </div> -->

                    <div class="staff-badges">
                        <span class="badge badge-primary">
                            {{ $item['role_badge'] }}
                        </span>

                        <span class="badge badge-secondary">
                            {{ $item['type_label'] }}
                        </span>
                    </div>

                </div>
            </div>

            <div class="staff-contact">
                <i class="fas fa-phone"></i>
                <span>{{ $item['phone'] }}</span>
            </div>

        </div>
    @endforeach

</div>

@include('partials.hospitalization-modals.assign-staff-hp')