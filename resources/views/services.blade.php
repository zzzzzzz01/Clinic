<x-layouts.main.app>

<style>
    .form-control-service {
        border-radius: 50rem !important;
        padding: 21px 36px;
        font-size: 18px;
        border-color: #15b9d9 !important;
        display: block;
        width: 100%;
        font-weight: 400;
        line-height: 1.5;
        color: #8d8d8d;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        appearance: none;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        padding-right: 60px;
    }

    .form-control-service:focus {
        color: #8d8d8d;
        background-color: #fff;
        border-color: #8adcec;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(21, 185, 217, .25);
    }

    .service-img {
        height: 195px;
        overflow: hidden;
        border-top: 1px solid #15b9d9;
        border-right: 1px solid #15b9d9;
        border-bottom: 0;
        border-left: 1px solid #15b9d9;
    }

    .service-img .doctor-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        display: block;
    }

    @media (max-width: 576px) {
        .service-img .doctor-img {
            /* height: 300px; */
        }
    }

    @media (max-width: 480px) {
        .form-control-service {
            padding: 12px 12px 12px 17px;
            font-size: 13px;
            padding-right: 50px;
        }
    }

    .search-box {
        position: relative;
    }

    .search-box .search-icon {
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        color: #15b9d9;
        font-size: 18px;
        pointer-events: none;
    }

    .search-box .clear-btn {
        position: absolute;
        top: 50%;
        right: 50px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        font-size: 18px;
        cursor: pointer;
        display: none;
        padding: 5px;
    }

    .search-box .clear-btn:hover {
        color: #333;
    }

    .search-box .clear-btn.visible {
        display: block;
    }

    @media (max-width: 480px) {
        .search-box .clear-btn {
            right: 40px;
            font-size: 14px;
        }
        .search-box .search-icon {
            right: 15px;
            font-size: 14px;
        }
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">@lang('words.services')</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main.page')</a></li>
            <li class="breadcrumb-item"><a href="#">@lang('words.pages')</a></li>
            <li class="breadcrumb-item active text-primary">@lang('words.services')</li>
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
                    <form action="{{ route('services.page') }}" method="GET" id="searchForm">
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
        
        <div class="row g-4 justify-content-center">
            @forelse($departments as $department)
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp">
                <div class="service-item rounded">
                    <div class="service-img rounded-top">
                        <img src="{{ asset('storage/' . $department->photo) }}"
                            class="img-fluid rounded-top w-100 doctor-img"
                            alt="{{ $department->name }}">
                    </div>
                    <div class="service-content rounded-bottom bg-light p-3">
                        <div class="service-content-inner">
                            <h5 class="mb-4">{{ $department->name }}</h5>
                            <p class="mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($department->description), 40) }}</p>
                            <a href="{{ route('services.detail', $department->slug) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">@lang('words.detail')</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                <h4 class="text-muted">@lang('words.no_services_found')</h4>
                <p class="text-muted">@lang('words.try_another_search')</p>
            </div>
            @endforelse  
        </div> 
            <!-- Pagination -->
            <div class="pagination-wrapper wow fadeInUp">
                <ul class="pagination-list">
                    @if($departments->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $departments->previousPageUrl() }}">&laquo;</a></li>
                    @endif

                    @for($i = 1; $i <= $departments->lastPage(); $i++)
                        @if($i == $departments->currentPage())
                            <li class="active"><span>{{ $i }}</span></li>
                        @else
                            <li><a href="{{ $departments->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor

                    @if($departments->hasMorePages())
                        <li><a href="{{ $departments->nextPageUrl() }}">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>
            </div>
    </div>
</div>
<!-- Services End --> 

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearBtn');

        clearBtn.addEventListener('click', function () {
            window.location.href = "{{ route('services.page') }}";
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
</script>

</x-layouts.main.app>