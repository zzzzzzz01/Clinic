<x-layouts.main.app>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">@lang('words.contact')</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main.page')</a></li>
            <li class="breadcrumb-item"><a href="#">@lang('words.pages')</a></li>
            <li class="breadcrumb-item active text-primary">@lang('words.contact')</li>
        </ol>    
    </div>
</div>
<!-- Header End -->

<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style mb-4">
                <h4 class="sub-title text-white px-3 mb-0">@lang('words.contact_us')</h4>
            </div>
            <p class="mb-0 text-black-50">@lang('words.contact_description')</p>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-5 col-xl-5 contact-form wow fadeInLeft" data-wow-delay="0.1s">
                <h2 class="display-5 text-white mb-2">@lang('words.get_in_touch')</h2>
                <p class="mb-4 text-white">@lang('words.contact_form_text')</p>
                <form>
                    <div class="row g-3">
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-transparent border border-white" id="name" placeholder="@lang('words.your_name')">
                                <label for="name">@lang('words.your_name')</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="email" class="form-control bg-transparent border border-white" id="email" placeholder="@lang('words.your_email')">
                                <label for="email">@lang('words.your_email')</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="phone" class="form-control bg-transparent border border-white" id="phone" placeholder="@lang('words.your_phone')">
                                <label for="phone">@lang('words.your_phone')</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <select class="form-control bg-transparent border border-white" id="department">
                                    <option value="">@lang('words.select_department')</option>
                                    <option value="cardiology">@lang('words.cardiology')</option>
                                    <option value="neurology">@lang('words.neurology')</option>
                                    <option value="surgery">@lang('words.surgery')</option>
                                    <option value="pediatrics">@lang('words.pediatrics')</option>
                                    <option value="orthopedics">@lang('words.orthopedics')</option>
                                </select>
                                <label for="department">@lang('words.department')</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-transparent border border-white" id="subject" placeholder="@lang('words.subject')">
                                <label for="subject">@lang('words.subject')</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-transparent border border-white" placeholder="@lang('words.write_your_message')" id="message" style="height: 160px"></textarea>
                                <label for="message">@lang('words.message')</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-light text-primary w-100 py-3">@lang('words.send_message')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 col-xl-2 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-transparent rounded">
                    <div class="d-flex flex-column align-items-center text-center mb-4">
                        <div class="bg-white d-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; border-radius: 50px;"><i class="fa fa-map-marker-alt fa-2x text-primary"></i></div>
                        <h4 class="text-dark">@lang('words.address')</h4>
                        <p class="mb-0 text-white">@lang('words.address_text')</p> 
                    </div>
                    <div class="d-flex flex-column align-items-center text-center mb-4">
                        <div class="bg-white d-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; border-radius: 50px;"><i class="fa fa-phone-alt fa-2x text-primary"></i></div>
                        <h4 class="text-dark">@lang('words.phone')</h4>
                        <p class="mb-0 text-white">+998 91 123 56 54</p> 
                    </div>
                   
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="bg-white d-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; border-radius: 50px;"><i class="fa fa-envelope-open fa-2x text-primary"></i></div>
                        <h4 class="text-dark">@lang('words.email')</h4>
                        <p class="mb-0 text-white">khrrmvsh@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-xl-5 wow fadeInRight" data-wow-delay="0.3s">
                <div class="d-flex justify-content-center mb-4"> 
                    <a class="btn btn-lg-square btn-light rounded-circle mx-2" href="https://t.me/khrrmvsh"><i class="fab fa-telegram"></i></a>
                    <a class="btn btn-lg-square btn-light rounded-circle mx-2" href="https://www.instagram.com/khurramov.shx/"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-lg-square btn-light rounded-circle mx-2" href="khrrmvsh@gmail.com"><i class="fas fa-envelope contact-icon"></i></a>
                </div>
                <div class="rounded h-100">
                <iframe
                    src="https://www.google.com/maps?q=Uchtepa%20Tumani%20Hokimiyati&output=embed"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

</x-layouts.main.app>