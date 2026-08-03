<!DOCTYPE html>
<html lang="uz">

    <head>
        <meta charset="utf-8">
        <title>Terapia - Physical Therapy Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('temp/lib/animate/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('temp/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('temp/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('temp/css/style.css') }}" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Yuklanmoqda...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Topbar Start -->
        <div class="container-fluid bg-dark px-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-light me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Manzilni topish</a>
                        <a href="#" class="text-light me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+998901234567</a>
                        <a href="#" class="text-light me-0"><i class="fas fa-envelope text-primary me-2"></i>info@kasalxona.uz</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-0"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->


        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{ route('home.page') }}" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fas fa-star-of-life me-3"></i>Clinic</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="" class="nav-item nav-link active">@lang('words.main_page')</a>
                        <a href="{{ route('doctors.service.index') }}" class="nav-item nav-link">@lang('words.doctors')</a>
                        <a href="{{ route('services.page') }}" class="nav-item nav-link">@lang('words.services')</a>
                        <a href="{{ route('blogs.page') }}" class="nav-item nav-link">@lang('words.news')</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">@lang('words.pages')</a>
                            <div class="dropdown-menu m-0">
                                @if(auth()->user())
                                <a href="{{ route('patient.appointments') }}" class="dropdown-item">@lang('words.my_appointments')</a>
                                @endif
                                <a href="{{ route('questions.page') }}" class="dropdown-item">Ko'p beriladigan savollar</a>
                                <a href="{{ route('chief.doctors') }}" class="dropdown-item">@lang('words.department_heads')</a>
                                <!-- <a href="" class="dropdown-item">Nima uchun biz batafsiz</a> -->
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            @if(app()->getLocale() == 'uz')
                            <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset('temp/img/uzbekistan-flag.png') }}" alt="UZ" width="20" height="14" class="me-1"> Uz
                            </a>
                            @elseif(app()->getLocale() == 'ru')
                            <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset('temp/img/russia-flag.png') }}" alt="UZ" width="20" height="14" class="me-1"> Ру
                            </a>
                            @elseif(app()->getLocale() == 'en')
                            <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset('temp/img/united-kingdom-flag.png') }}" alt="UZ" width="20" height="14" class="me-1"> En
                            </a>
                            @endif

                            <div class="dropdown-menu m-0">
                                <a href="/uz" class="dropdown-item">
                                    <img src="{{ asset('temp/img/uzbekistan-flag.png') }}"
                                        alt="UZ"
                                        width="20"
                                        height="14"
                                        class="me-2">
                                    O'zbekcha
                                </a>

                                <a href="/ru" class="dropdown-item">
                                    <img src="{{ asset('temp/img/russia-flag.png') }}"
                                        alt="RU"
                                        width="20"
                                        height="14"
                                        class="me-2">
                                    Русский
                                </a>

                                <a href="/en" class="dropdown-item">
                                    <img src="{{ asset('temp/img/united-kingdom-flag.png') }}"
                                        alt="EN"
                                        width="20"
                                        height="14"
                                        class="me-2">
                                    English
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('contact.page') }}" class="nav-item nav-link">@lang('words.contact')</a>
                    </div>
                    @auth
                    <!-- Agar foydalanuvchi tizimga kirgan bo'lsa -->
                    <div class="d-flex align-items-center">
                    @if(auth()->check() && !auth()->user()->hasRole('patient'))
                        <a href="{{ route('dashboard.index') }}" class="btn btn-success rounded-pill text-white py-2 px-3 me-2 flex-wrap flex-sm-shrink-0">
                            Admin Panel
                        </a>
                    @endif
                        <div class="dropdown">
                            <button class="btn btn-primary rounded-pill text-white py-2 px-3 dropdown-toggle flex-wrap flex-sm-shrink-0" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ auth()->user()->last_name }} {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text"><small>{{ auth()->user()->roles()->first()->name }}</small></span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-1"></i> @lang('words.exit')
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @else
                    <!-- Agar foydalanuvchi tizimga kirmagan bo'lsa -->
                    <a href="{{ route('auth.login') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">
                        <i class="fas fa-sign-in-alt me-1"></i> @lang('words.login_to_system')
                    </a>
                    @endauth
                </div>
            </nav>
            @include('partials.alert')





            {{ $slot }}





        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4"><i class="fas fa-star-of-life me-3"></i>Clinic</h4>
                            <p>@lang('words.health_our_priority'). @lang('words.carousel_text_1').</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-share fa-2x text-white me-2"></i>
                                <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-telegram"></i></a>
                                <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                                        <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">Tezkor Havolalar</h4>
                            
                            <a href="{{ route('doctors.service.index') }}"><i class="fas fa-angle-right me-2"></i> @lang('words.doctors')</a> 
                            <a href="{{ route('contact.page') }}"><i class="fas fa-angle-right me-2"></i> @lang('words.contact')</a>
                            <a href="{{ route('questions.page') }}"><i class="fas fa-angle-right me-2"></i> Ko'p beriladigan savollar</a> 
                            <a href="{{ route('blogs.page') }}"><i class="fas fa-angle-right me-2"></i> @lang('words.news')</a>
                            <a href="{{ route('chief.doctors') }}"><i class="fas fa-angle-right me-2"></i> @lang('words.department_heads')</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">Kasalxona Xizmatlari</h4>
                            @php
                                $departments = \App\Models\Department::latest()->limit(3)->get();
                            @endphp
                            @foreach($departments as $department)
                            <a href="{{ route('services.detail', $department->slug) }}"><i class="fas fa-angle-right me-2"></i> {{ $department->name }}</a>
                            @endforeach
                            <a href="{{ route('services.page' ) }}"><i class="fas fa-angle-right me-2"></i> @lang('words.all_services')</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">Aloqa Ma'lumotlari</h4>
                            <a href=""><i class="fa fa-map-marker-alt me-2"></i> Toshkent shahar, Yunusobod tumani</a>
                            <a href=""><i class="fas fa-envelope me-2"></i> info@kasalxona.uz</a>
                            <a href=""><i class="fas fa-envelope me-2"></i> qabul@kasalxona.uz</a>
                            <a href=""><i class="fas fa-phone me-2"></i> +998 71 123 45 67</a>
                            <a href="" class="mb-3"><i class="fas fa-print me-2"></i> +998 71 123 45 68</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-white"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Clinic</a>, Barcha huquqlar himoyalangan.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-white">
                        Dizayn: <a class="border-bottom" href="#">Kasalxona IT Bo'limi</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('temp/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('temp/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('temp/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('temp/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        

        <!-- Template Javascript -->
        <script src="{{ asset('temp/js/main.js') }}"></script>
        
    </body>

</html>