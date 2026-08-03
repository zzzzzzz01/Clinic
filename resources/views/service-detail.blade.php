<x-layouts.main.app>

    <link href="{{ asset('temp/css/service-detail.css') }}" rel="stylesheet">

    <style> 
    </style>
    
    <!-- Hero Section -->
    <section class="service-hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('storage/' . $department->photo) }}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('services.page') }}">Xizmatlar</a></li>
                            <li class="breadcrumb-item active">{{ $department->name }}</li>
                        </ol>
                    </nav>
                    
                    <h1 class="display-3 fw-bold mb-4 wow fadeInDown">{{ $department->name }}</h1>
                    <p class="lead mb-4 wow fadeInDown" data-wow-delay="0.2s">{{ $department->description }}</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap wow fadeInUp" data-wow-delay="0.3s">
                        <span class="stat-badge"><i class="fas fa-heartbeat me-2"></i>96% Muvaffaqiyat</span>
                        <span class="stat-badge"><i class="fas fa-user-md me-2"></i>12 Mutaxassis</span>
                        <span class="stat-badge"><i class="fas fa-procedures me-2"></i>850+ Operatsiya</span>
                        <span class="stat-badge"><i class="fas fa-clock me-2"></i>24/7 Xizmat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kardiologiya Haqida -->
    <section class="service-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 wow fadeInLeft">
                    <div class="section-title">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0">
                            @if(app()->getLocale() == 'uz')
                                {{ $department->name_uz }} Haqida
                            @elseif(app()->getLocale() == 'ru')
                                О {{ $department->name_ru }}
                            @elseif(app()->getLocale() == 'en')
                                About {{ $department->name_en }}
                            @endif
                        </h4>
                    </div>
                        <h1 class="display-4 mb-4">@lang('words.health_is_our_trust')</h1>
                    </div>
                    <p class="lead mb-4">{{ $department->description }}</p>
                    
                    <div class="row">
                        @foreach($diseases->chunk(ceil($diseases->count() / 2)) as $chunk)
                            <div class="col-md-6">
                                <ul class="disease-list">
                                    @foreach($chunk as $disease)
                                        <li>
                                            <i class="fas fa-check text-primary me-2"></i>
                                            <strong>{{ $disease->name }}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight">
                    <div class="info-card">
                        <h4 class="mb-4">@lang('words.why_choose_us')</h4>
                        <div class="timeline">
                            @foreach($features as $feature)
                            <div class="timeline-item">
                                <h5>{{ $feature->title }}</h5>
                                <p class="mb-0">{{ $feature->description }}</p>
                            </div> 
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Asosiy Xizmatlar -->
    <section class="service-section bg-light-custom">
        <div class="container">
            <div class="section-title text-center wow fadeInUp">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">@lang('words.main_services')</h4>
                </div>
                <h1 class="display-4 mb-4">{{ $department->name }} Xizmatlar</h1>
            </div>

            <div class="row g-4">

                @foreach($doctors as $doctor)
                <div class="col-md-4 col-lg-3 col-xl-3 com-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item rounded">
                        <div class="team-img rounded-top">
                            <img src="{{ asset('storage/' . $doctor->photo) }}"
                                class="doctor-img img-fluid w-100 rounded-top"
                                alt="{{ $doctor->user->name }}">

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
                                <a href="{{ route('services.appointment', ['doctor' => $doctor, 'slug' => $department->slug]) }}">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Qabulga yozilish</button>
                                </a> 
                                @else
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="openAuthDialog()">Qabulga yozilish</button>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Narxlar Jadvali -->
    <section class="service-section">
        <div class="container">
            <div class="section-title text-center wow fadeInUp">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">@lang('words.prices')</h4>
                </div>
                <h1 class="display-4 mb-4">@lang('words.service_prices')</h1>
                <p class="lead mb-0">@lang('words.price_description')</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="price-table wow fadeInUp">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('words.procedure_name')</th>
                                    <th>@lang('words.duration')</th>
                                    <th>@lang('words.price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($procedures as $procedure)
                                <tr>
                                    <td><strong>{{ $procedure->name }}</strong><br><small>{{ $procedure->description }}</small></td>
                                    <td>{{ $procedure->duration }} @lang('words.minutes')</td>
                                    <td><strong>{{ $procedure->price }} $</strong></td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>

            <div class="row justify-content-center pt-3">
                <div class="col-lg-10">
                    <div class="price-table wow fadeInUp">
                        <table class="table table-hover mb-0"> 
                            <thead>
                                <tr>
                                    <th>@lang('words.test_name')</th>
                                    <th>@lang('words.tests_count_min')</th> 
                                    <th>@lang('words.time')</th>
                                    <th>@lang('words.price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($panels as $panel)
                                <tr>
                                    <td><strong>{{ $panel->name }}</strong><br><small>{{ Str::limit($panel->description, 27) }}</small></td>
                                    <td>{{ $panel->tests->count() }} @lang('words.test')</td>
                                    <td>{{ $panel->time }} @lang('words.hour')</td>
                                    <td><strong>{{ $panel->price }} $</strong></td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- AUTH DIALOGI (Ro'yxatdan o'tmaganlik haqida)               -->
    <!-- ========================================================= -->
    @include('partials.modals.others.auth')

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('temp/lib/wow/wow.min.js') }}"></script>
    <script>
        new WOW().init();
        
        // Silliq skroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Emergency checkbox handler
        const emergencyCheck = document.getElementById('emergency');
        if (emergencyCheck) {
            emergencyCheck.addEventListener('change', function() {
                if (this.checked) {
                    alert('Shoshilinch holat uchun sizga 24 soat ichida qabul tashkil qilinadi. Tez orada operator siz bilan bog\'lanadi.');
                }
            });
        }

        // =============================================================
        // AUTH DIALOG FUNKSIYALARI
        // =============================================================
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

    <!-- ========================================================= -->
    <!-- REGISTER DIALOG UCHUN CSS                                  -->
    <!-- ========================================================= -->
    

</x-layouts.main.app>