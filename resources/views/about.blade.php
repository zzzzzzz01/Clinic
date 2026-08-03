<x-layouts.main.app>


        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Biz Haqimizda</h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Bosh sahifa</a></li>
                    <li class="breadcrumb-item"><a href="#">Sahifalar</a></li>
                    <li class="breadcrumb-item active text-primary">Biz Haqimizda</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->


        <!-- About Start -->
        <div class="container-fluid about bg-light py-5">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-img pb-5 ps-5">
                            <img src="{{ asset('temp/img/about-1.jpg') }}" class="img-fluid rounded w-100" style="object-fit: cover;" alt="Kasalxona binosi">
                            <div class="about-img-inner">
                                <img src="{{ asset('temp/img/about-2.jpg') }}" class="img-fluid rounded-circle w-100 h-100" alt="Bosh shifokor">
                            </div>
                            <div class="about-experience">15 yillik tajriba</div>
                        </div>
                    </div>
                    <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="section-title text-start mb-5">
                            <h4 class="sub-title pe-3 mb-0">Biz Haqimizda</h4>
                            <h1 class="display-3 mb-4">Biz Sog'lig'ingizni Tiklashga Tayyormiz</h1>
                            <p class="mb-4">Markaziy Kasalxona 15 yildan beri bemorlargina eng yuqori sifatli tibbiy xizmatlarni taqdim etib kelmoqda. Bizning maqsadimiz - har bir bemorning sog'lig'ini tiklash va uni saqlashga yordam berish. Zamonaviy uskunalar va yuqori malakali shifokorlar bilan kuniga 24 soat xizmat ko'rsatamiz.</p>
                            <div class="mb-4">
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Zamonaviy diagnostika uskunalari</p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Yuqori malakali shifokorlar</p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> 24/7 shoshilinch yordam xizmati</p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Individual davolash dasturlari</p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Qulay va zamonaviy sharoitlar</p>
                            </div>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Ko'proq Ma'lumot</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Team Start -->
        <div class="container-fluid team py-5">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0">Bizning Jamoa</h4>
                    </div>
                    <h1 class="display-3 mb-4">Professional Shifokorlar Jamoadan Tibbiy Xizmatlar</h1>
                    <p class="mb-0">Bizning kasalxonada har bir soha bo'yicha yuqori malakali va tajribali mutaxassislar ishlaydi. Har bir shifokor o'z sohasining eng yaxshi amaliyotchilaridan biri hisoblanadi va doimiy ravishda malaka oshirib turadi.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item rounded">
                            <div class="team-img rounded-top h-100">
                                <img src="{{ asset('temp/img/team-1.jpg') }}" class="img-fluid rounded-top w-100" alt="Bosh Shifokor">
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-telegram"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                                <h5>Dr. Alijonov Sanjar</h5>
                                <p class="mb-0">Bosh Shifokor, Kardiolog</p>
                                <small class="text-muted">15 yillik tajriba</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item rounded">
                            <div class="team-img rounded-top h-100">
                                <img src="{{ asset('temp/img/team-2.jpg') }}" class="img-fluid rounded-top w-100" alt="Nevrolog">
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-telegram"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                                <h5>Dr. Yusupova Malika</h5>
                                <p class="mb-0">Nevrolog</p>
                                <small class="text-muted">12 yillik tajriba</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item rounded">
                            <div class="team-img rounded-top h-100">
                                <img src="{{ asset('temp/img/team-3.jpg') }}" class="img-fluid rounded-top w-100" alt="Pediatr">
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-telegram"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                                <h5>Dr. Xolmatova Dilobar</h5>
                                <p class="mb-0">Pediatr</p>
                                <small class="text-muted">10 yillik tajriba</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="team-item rounded">
                            <div class="team-img rounded-top h-100">
                                <img src="{{ asset('temp/img/team-4.jpg') }}" class="img-fluid rounded-top w-100" alt="Jarroh">
                                <div class="team-icon d-flex justify-content-center">
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-telegram"></i></a>
                                    <a class="btn btn-square btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                                <h5>Dr. Karimov Farxod</h5>
                                <p class="mb-0">Jarroh</p>
                                <small class="text-muted">14 yillik tajriba</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->


        <!-- Feature Start -->
        <div class="container-fluid feature py-5">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0">Nima Uchun Bizni Tanlaysiz</h4>
                    </div>
                    <h1 class="display-3 mb-4">Nima Uchun Bizni Tanlaysiz? Sog'lig'ingizni Tiklang</h1>
                    <p class="mb-0">Bizning kasalxona zamonaviy uskunalar, tajribali shifokorlar va individual yondashuv bilan bemorlargina eng yuqori sifatli tibbiy xizmatlarni taqdim etadi. Sizning sog'lig'ingiz bizning eng muhim vazifamizdir.</p>
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
                                    <h5 class="mb-4">Malakali Shifokorlar</h5>
                                    <p class="mb-0">Barcha shifokorlarimiz yuqori malakaga ega va doimiy ravishda malaka oshirib turadi</p>
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
                                    <h5 class="mb-4">Individual Davolash</h5>
                                    <p class="mb-0">Har bir bemor uchun alohida davolash dasturi tuziladi va boshqariladi</p>
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
                                    <h5 class="mb-4">Aniq Diagnostika</h5>
                                    <p class="mb-0">Zamonaviy diagnostika uskunalari bilan aniq tashxis qo'yish</p>
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
                                    <h5 class="mb-4">Mutaxassislar Jamoasi</h5>
                                    <p class="mb-0">Turli sohalar bo'yicha mutaxassislarning keng jamoasi</p>
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
                                    <h5 class="mb-4">Qulay Sharoitlar</h5>
                                    <p class="mb-0">Zamonaviy va qulay sharoitlarda davolash va dam olish</p>
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
                                    <h5 class="mb-4">G'amxo'r Xodimlar</h5>
                                    <p class="mb-0">Ko'p yillik tajribaga ega malakali va g'amxo'r xodimlar</p>
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
                                    <h5 class="mb-4">Zamonaviy Uskunalar</h5>
                                    <p class="mb-0">Eng so'nggi tibbiy texnologiyalar va uskunalar</p>
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
                                    <h5 class="mb-4">24/7 Qo'llab-quvvatlash</h5>
                                    <p class="mb-0">Kunduzi-kechasi tibbiy yordam va maslahat xizmati</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Batafsil Ma'lumot</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->


</x-layouts.main.app>