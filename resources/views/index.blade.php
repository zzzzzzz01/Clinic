<x-layouts.main.app>
    <x-slot:title>
        @lang('words.empty_page')
    </x-slot:title>

    <!-- Carousel Start -->
    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <img src="{{ asset('temp/img/carousel-1.jpg') }}" class="img-fluid w-100" alt="@lang('words.hospital_image')">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">@lang('words.clinic')</h5>
                    <h1 class="display-1 text-capitalize text-white mb-4">@lang('words.health_our_priority')</h1>
                    <p class="mb-5 fs-5">@lang('words.carousel_text_1')</p>
                </div>
            </div>
        </div>
        <div class="header-carousel-item">
            <img src="{{ asset('temp/img/Clinic2.jpg') }}" class="img-fluid w-100" alt="@lang('words.doctors_image')">
            <div class="carousel-caption">
                <div class="carousel-caption-content p-3">
                    <h5 class="text-white text-uppercase fw-bold mb-4" style="letterspacing: 3px;">@lang('words.professional_team')</h5>
                    <h1 class="display-1 text-capitalize text-white mb-4">@lang('words.carousel_title_2')</h1>
                    <p class="mb-5 fs-5 animated slideInDown">@lang('words.carousel_text_2')</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Services Start -->
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">@lang('words.our_services')</h4>
                </div>
                <h1 class="display-3 mb-4">@lang('words.services_title')</h1>
                <p class="mb-0">@lang('words.services_description')</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($departments as $department)
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top">
                            <img src="{{ asset('storage/' . $department->photo) }}" class="img-fluid rounded-top w-100" alt="{{ $department->name }}">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">{{ $department->name }}</h5>
                                <p class="mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($department->description), 40) }}</p>
                                <a href="{{ route('services.detail', $department->slug) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">@lang('words.detail')</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach 
                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ route('services.page') }}">@lang('words.all_services')</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- About Start -->
    <div class="container-fluid about bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-img pb-5 ps-5">
                        <img src="{{ asset('temp/img/about-1.jpg') }}" class="img-fluid rounded w-100" style="object-fit: cover;" alt="@lang('words.hospital_building')">
                        <div class="about-img-inner">
                            <img src="{{ asset('temp/img/about-2.jpg') }}" class="img-fluid rounded-circle w-100 h-100" alt="@lang('words.doctor')">
                        </div>
                        <div class="about-experience">@lang('words.about_experience')</div>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="section-title text-start mb-5">
                        <h4 class="sub-title pe-3 mb-0">@lang('words.about_us')</h4>
                        <h1 class="display-3 mb-4">@lang('words.about_title')</h1>
                        <p class="mb-4">@lang('words.about_text')</p>
                        <div class="mb-4">
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> @lang('words.about_feature_1')</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> @lang('words.about_feature_2')</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> @lang('words.about_feature_3')</p>
                        </div>
                        <a href="{{ route('contact.page') }}" class="btn btn-primary rounded-pill text-white py-3 px-5">@lang('words.more_info')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Feature Start -->
    <div class="container-fluid feature py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">@lang('words.why_choose_us')</h4>
                </div>
                <h1 class="display-3 mb-4">@lang('words.why_choose_us_title')</h1>
                <p class="mb-0">@lang('words.why_choose_us_description')</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-user-md fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_qualified_doctors')</h5>
                                <p class="mb-0">@lang('words.feature_qualified_doctors_text')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-stethoscope fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_individual_treatment')</h5>
                                <p class="mb-0">@lang('words.feature_individual_treatment_text')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-bullseye fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_accurate_diagnosis')</h5>
                                <p class="mb-0">@lang('words.feature_accurate_diagnosis_text')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-users fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_team')</h5>
                                <p class="mb-0">@lang('words.feature_team_text')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-procedures fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_comfortable')</h5>
                                <p class="mb-0">@lang('words.feature_comfortable_text')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-heart fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_caring_staff')</h5>
                                <p class="mb-0">@lang('words.feature_caring_staff_text')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-microscope fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_modern_equipment')</h5>
                                <p class="mb-0">@lang('words.feature_modern_equipment_text')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row-cols-1 feature-item p-4">
                        <div class="col-12">
                            <div class="feature-icon mb-4">
                                <div class="p-3 d-inline-flex bg-white rounded">
                                    <i class="fas fa-clock fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="feature-content d-flex flex-column">
                                <h5 class="mb-4">@lang('words.feature_24_7_support')</h5>
                                <p class="mb-0">@lang('words.feature_24_7_support_text')</p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <!-- Feature End -->

    <!-- Team Start -->
    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">@lang('words.our_team')</h4>
                </div>
                <h1 class="display-3 mb-4">@lang('words.team_title_main')</h1>
                <p class="mb-0">@lang('words.team_description_main')</p>
            </div>
            <div class="row g-4 justify-content-center">
            @foreach($headDoctors as $doctor)
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top">
                            <img src="{{ asset('storage/' . $doctor->photo) }}"
                                class="doctor-img img-fluid w-100 rounded-top"
                                alt="{{ $doctor->user->name }}">

                            <div class="team-icon d-flex justify-content-center">
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href="">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href="">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>

                        <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                            <h5>@lang('words.dr') {{ $doctor->user->name }} {{ $doctor->user->last_name }}</h5>
                            <p class="mb-0">
                                @lang('words.head_doctor'), {{ optional($doctor->departments->first())->name }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Team End -->

    <style>
        .team-img {
            height: 380px;
            overflow: hidden;
            border-top: 1px solid #15b9d9;
            border-right: 1px solid #15b9d9;
            border-bottom: 0;
            border-left: 1px solid #15b9d9;
        }

        .team-img .doctor-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }

        @media (max-width: 768px) {
            .team-img {
                height: 300px;
            }
        }
    </style>

    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5 wow zoomInDown" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title mb-5">
                <div class="sub-style">
                    <h4 class="sub-title text-white px-3 mb-0">@lang('words.patient_reviews')</h4>
                </div>
                <h1 class="display-3 mb-4">@lang('words.patient_reviews_title')</h1>
            </div>
            <div class="testimonial-carousel owl-carousel">
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="{{ asset('temp/img/testimonial-img.jpg') }}" class="img-fluid rounded-circle" alt="@lang('words.patient')">
                        </div>
                        <p class="text-white fs-7">@lang('words.review_1')</p>
                        <div class="text-center">
                            <h5 class="mb-2">@lang('words.review_1_name')</h5>
                            <p class="mb-2 text-white-50">@lang('words.review_1_city')</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="{{ asset('temp/img/testimonial-img.jpg') }}" class="img-fluid rounded-circle" alt="@lang('words.patient')">
                        </div>
                        <p class="text-white fs-7">@lang('words.review_2')</p>
                        <div class="text-center">
                            <h5 class="mb-2">@lang('words.review_2_name')</h5>
                            <p class="mb-2 text-white-50">@lang('words.review_2_city')</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item">
                    <div class="testimonial-inner p-5">
                        <div class="testimonial-inner-img mb-4">
                            <img src="{{ asset('temp/img/testimonial-img.jpg') }}" class="img-fluid rounded-circle" alt="@lang('words.patient')">
                        </div>
                        <p class="text-white fs-7">@lang('words.review_3')</p>
                        <div class="text-center">
                            <h5 class="mb-2">@lang('words.review_3_name')</h5>
                            <p class="mb-2 text-white-50">@lang('words.review_3_city')</p>
                            <div class="d-flex justify-content-center">
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                                <i class="fas fa-star text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Blog Start -->
    <div class="container-fluid blog py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">@lang('words.news')</h4>
                </div>
                <h1 class="display-3 mb-4">@lang('words.blog_title')</h1>
                <p class="mb-0">@lang('words.blog_description')</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($popularPosts as $post)
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="blog-item rounded">
                        <div class="blog-img">
                            <img src="{{ asset('storage/' . $post->photo) }}" class="img-fluid w-100" alt="{{ $post->title }}">
                        </div>
                        <div class="blog-centent p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-primary"></i> {{ $post->created_at->format('d M Y') }}</p>
                                <p><span class="fa fa-comments text-primary"></span> {{ $post->comments()->count() }} @lang('words.comments')</p>
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="h4">{{ $post->title }}</a>
                            <p class="my-4">{{ \Illuminate\Support\Str::limit(strip_tags($post->description), 40) }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">@lang('words.detail')</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Blog End -->

</x-layouts.main.app>