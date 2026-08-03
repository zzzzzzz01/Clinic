<x-layouts.main.app>

<link href="{{ asset('temp/css/doctors.css') }}" rel="stylesheet">

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">@lang('words.doctors')</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main.page')</a></li> 
            <li class="breadcrumb-item active text-primary">@lang('words.doctors')</li>
        </ol>    
    </div>
</div>
<!-- Header End -->

<!-- Services Start -->
<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">@lang('words.our_services')</h4>
            </div>
            <h1 class="display-3 mb-4">@lang('words.services_title')</h1>
            <p class="mb-0">@lang('words.services_page_description')</p>
        </div>
        <!-- Search Inputi -->
        <div class="row mb-4 wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-lg-12 mx-auto">
                <div class="search-box position-relative">
                    <form action="{{ route('doctors.service.index') }}" method="GET" id="searchForm">
                        <input
                            type="text"
                            name="q"
                            id="searchInput"
                            value="{{ request('q') }}"
                            class="form-control-service"
                            placeholder="@lang('words.search_department_placeholder')"
                            autocomplete="off">
                        
                        <button type="button" class="clear-btn" id="clearBtn" style="{{ request('q') ? 'display:block;' : 'display:none;' }}">
                            <i class="fas fa-times"></i>
                        </button>
                        
                        <i class="fas fa-search search-icon"></i>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="services-grid">
            @forelse($doctors as $doctor)
                <div class="service-item-wrapper wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top">
                            @if($doctor->photo)
                            <img src="{{ asset('storage/' . $doctor->photo) }}"
                                class="doctor-img img-fluid w-100 rounded-top"
                                alt="{{ $doctor->user->name }}">
                            @else
                            <img src="{{ asset('temp/img/profile-human.png') }}"
                                class="doctor-img img-fluid w-100 rounded-top">
                            @endif
                            <div class="team-icon d-flex justify-content-center">
                                <a class="btn-action" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="btn-action" href="">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a class="btn-action" href="">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>

                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5>@lang('words.dr') {{ $doctor->user->name }} {{ $doctor->user->last_name }}</h5>
                            <p class="mb-0">
                                @if(auth()->user())
                                <div class="action-buttons">
                                    <a href="{{ route('services.appointment', ['doctor' => $doctor, 'slug' => $doctor->departments->first()->slug]) }}" class="btn-outline"> 
                                        <button type="button" class="btn btn-outline-primary btn-sm">@lang('words.appointment')</button>
                                    </a> 
                                    <a href="" class="btn-outline"> 
                                        <button type="button" class="btn btn-outline-primary btn-sm">@lang('words.detail')</button>
                                    </a> 
                                </div>
                                @else
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="openAuthDialog()">@lang('words.book_appointment')</button>
                                @endif
                            </p>
                        </div>
                    </div>
                </div> 
            @empty
                <div class="col-12 text-center py-5" style="grid-column: 1 / -1;">
                    <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                    <h4 class="text-muted">@lang('words.no_services_found')</h4>
                    <p class="text-muted">@lang('words.try_another_search')</p>
                </div>
            @endforelse  
        </div> 
            <!-- Pagination -->
            <div class="pagination-wrapper wow fadeInUp">
                <ul class="pagination-list">
                    @if($doctors->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $doctors->previousPageUrl() }}">&laquo;</a></li>
                    @endif

                    @for($i = 1; $i <= $doctors->lastPage(); $i++)
                        @if($i == $doctors->currentPage())
                            <li class="active"><span>{{ $i }}</span></li>
                        @else
                            <li><a href="{{ $doctors->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor

                    @if($doctors->hasMorePages())
                        <li><a href="{{ $doctors->nextPageUrl() }}">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Services End --> 

@include('partials.modals.others.auth')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearBtn');

        clearBtn.addEventListener('click', function () {
            window.location.href = "{{ route('doctors.service.index') }}";
        });

        searchInput.addEventListener('input', function () {
            if (this.value.trim().length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                document.getElementById('searchForm').submit();
            }
        });
    });

    function openAuthDialog() {
            const dialog = document.getElementById('authDialog');
            dialog.showModal();
            document.body.style.overflow = 'hidden';
        }

        function closeAuthDialog() {
            const dialog = document.getElementById('authDialog');
            dialog.close();
            document.body.style.overflow = 'auto';
        } 
</script>

</x-layouts.main.app>