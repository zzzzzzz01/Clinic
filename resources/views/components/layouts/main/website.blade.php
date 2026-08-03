<!DOCTYPE html>
<html lang="en">
  <head>
  @if (!auth()->check())
        <script>
            window.location.replace("{{ route('auth.login') }}");
        </script>
    @endif
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="shortcut icon" href="{{ asset('temp2/images/favicon.svg') }}" type="image/x-icon" /> -->
    <title>{{ $title ?? 'Clinic' }}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('temp2/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp2/css/lineicons.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp2/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp2/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp2/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp2/css/modal.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet"/>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Zoom oldini olish -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    

    <!-- <style>
      .btn-custom-primary {
        background-color: #00BFFF;
        border-color: #00BFFF;
        color: white;
        padding: 10px 20px;
        margin-bottom: 30px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
        min-width: 160px;
      }
      
      .btn-custom-primary:hover {
        background-color: #11a0f2;
        border-color: #11a0f2;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(54, 92, 245, 0.3);
      }
      
      .right-content {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
      }
      
      /* Tugmalarni to'g'rilash uchun qo'shimcha stil */
      .title-wrapper .right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
      }
      
      .card-style .title {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
      }
      
      /* Select elementini to'g'rilash */
      .select-style-1 {
        min-width: 120px;
      }
      
      .select-style-1 select {
        height: 40px;
        display: flex;
        align-items: center;
      }
      
      /* Responsive design */
      @media (max-width: 768px) {
        .right-content {
          justify-content: flex-start;
          margin-top: 15px;
        }
        
        .title-wrapper .row {
          flex-direction: column;
        }
        
        .btn-custom-primary {
          min-width: 140px;
          font-size: 13px;
          padding: 8px 16px;
        }
      }
    </style> -->

  </head>
  <body>
    <!-- ======== Preloader =========== -->
    <!-- <div id="preloader">
      <div class="spinner"></div>
    </div> -->
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
      <div class="navbar-logo">
      <a href="{{ route('dashboard.index') }}" class="navbar-brand p-0">
          <h1 class="text-primary m-0"  style="font-family: 'Playfair Display', serif; font-size: 40px;"><i class="fas fa-star-of-life me-3"></i>Clinic</h1>
      </a>
      </div>
      <nav class="sidebar-nav">
        <ul>

          <span class="divider"><hr/></span> 
            @auth

            <li class="nav-item">
                <ul class="dropdown-nav">
                    <li><a href="{{ route('home.page') }}"> @lang('words.main.sity') </a></li>

                    @if(auth()->user()->hasRole('Laboratory Technician'))
                      <li><a href="{{ route('laboratory.dashboard') }}"> @lang('words.main.page') </a></li> 
                      <li><a href="{{ route('laboratory.test') }}"> @lang('words.laboratory') </a></li> 
                    @endif
                </ul>
            </li>

            @if(auth()->user()->hasRole('Admin'))
              <span class="divider"><hr /></span>

              <li class="nav-item">
                <ul class="dropdown-nav">
                  <li><a href="{{ route('dashboard.index') }}"> @lang('words.main.page') </a></li>
                  <li><a href="{{ route('doctors.index') }}"> @lang('words.doctors.list') </a></li>
                  <li><a href="{{ route('nurses.index') }}"> @lang('words.nurses_list') </a></li>
                  <li><a href="{{ route('department.index') }}"> @lang('words.department_management') </a></li>
                  <li><a href="{{ route('room.index') }}"> @lang('words.rooms_management') </a></li>
                  <li><a href="{{ route('features.index') }}"> @lang('words.features_management_short') </a></li>
                  <li><a href="{{ route('procedures.index') }}"> @lang('words.hospital_procedures') </a></li>
                  <li><a href="{{ route('hospitalizations.index') }}"> @lang('words.inpatients') </a></li>

                </ul>
              </li>
            @endif


            @if(auth()->user()->hasRole('Doctor'))
              <span class="divider"><hr /></span>

              <li class="nav-item">
                <ul class="dropdown-nav">
                  <li><a href="{{ route('doctor.dashboard') }}"> @lang('words.main.page') </a></li>
                  <li><a href="{{ route('doctor.appointments') }}"> @lang('words.admissions') </a></li>
                  <li><a href="{{ route('hospitalizations.index') }}"> @lang('words.inpatients') </a></li>
                </ul>
              </li>
            @endif


            @if(auth()->user()->hasRole('Nurse'))
              <span class="divider"><hr /></span>

              <li class="nav-item">
                <ul class="dropdown-nav">
                  <li><a href="{{ route('nurse.dashboard') }}"> @lang('words.main.page') </a></li>
                  <li><a href="{{ route('hospitalizations.index') }}"> @lang('words.inpatients') </a></li>
                </ul>
              </li>
            @endif


            @if(auth()->user()->hasRole('Pharmacist'))
              <span class="divider"><hr /></span>

              <li class="nav-item">
                <ul class="dropdown-nav">
                  <li><a href="{{ route('pharmacist.dashboard') }}"> @lang('words.main.page') </a></li>
                </ul>
              </li>
            @endif


            @if(auth()->user()->hasRole('Receptionist')) 
              <span class="divider"><hr /></span>

              <li class="nav-item">
                <ul class="dropdown-nav">
                  <li><a href="{{ route('receptionist.dashboard') }}"> @lang('words.main.page') </a></li>
                  <li><a href="{{ route('receptionist.index') }}"> @lang('words.admissions') </a></li>
                  <li><a href="{{ route('hospitalizations.index') }}"> @lang('words.inpatients') </a></li>
                  <li><a href="{{ route('room.index') }}"> @lang('words.rooms_management') </a></li>
                </ul>
              </li>
            @endif

            @if(auth()->user()->hasRole('Admin'))
            <span class="divider"><hr /></span> 

                <li class="nav-item">
                    <ul class="dropdown-nav">
                        <li><a href="{{ route('medicines.index') }}"> @lang('words.medicines_list') </a></li>
                        <li><a href="{{ route('medicine.inventory') }}"> @lang('words.pharmacy_inventory') </a></li>
                        <li><a href="{{ route('suppliers.index') }}"> @lang('words.suppliers')</a></li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasRole('Pharmacist'))
              <span class="divider"><hr /></span> 

                <li class="nav-item">
                    <ul class="dropdown-nav">
                      <li><a href="{{ route('medicine.inventory') }}"> @lang('words.pharmacy_inventory') </a></li>
                        <li><a href="{{ route('medicines.index') }}"> @lang('words.medicines_list') </a></li>
                        <li><a href="{{ route('pharmacist.sales') }}"> @lang('words.sales_menu') </a></li>
                        <li><a href="{{ route('pharmacist.report') }}"> @lang('words.sales_report') </a></li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasRole('Admin'))
              <span class="divider"><hr /></span>

                <li class="nav-item">
                    <ul class="dropdown-nav">
                        <li><a href="{{ route('laboratory.test') }}"> @lang('words.laboratory') </a></li>
                        <li><a href="{{ route('tests.panels') }}"> @lang('words.test_panels') </a></li>
                        <li><a href="{{ route('tests.index') }}"> @lang('words.tests_list') </a></li>
                    </ul>
                </li>
            @endif 

            @if(auth()->user()->hasRole('Laborant'))
              <span class="divider"><hr /></span>

                <li class="nav-item">
                    <ul class="dropdown-nav">
                        <li><a href=""> Test (Labaratoriya) </a></li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasRole('Nurse'))
              <span class="divider"><hr /></span>

                <li class="nav-item"> 
                    <ul class="dropdown-nav">
                        <li><a href="{{ route('nurse.treatment.sheets') }}"> @lang('words.medications') </a></li>
                    </ul>
                </li>
            @endif

            <span class="divider"><hr /></span> 

            <li class="nav-item">
                <ul class="dropdown-nav">
                    <li><a href="{{ route('profil') }}"> @lang('words.profile') </a></li>
                    <li><a href="{{ route('personal.data') }}"> @lang('words.personal_info') </a></li>
                    <li><a href="{{ route('login.history') }}"> @lang('words.login_history_title') </a></li>
                    <!-- <li><a href=""> Sorovnomalar </a></li> -->
                </ul>
            </li>


            
            @if(auth()->user()->hasRole('Admin'))
              <span class="divider"><hr /></span>

              <li class="nav-item">
                  <ul class="dropdown-nav">
                      <li><a href="{{ route('faqs.index') }}"> @lang('words.faqs.page_title') </a></li>
                      <li><a href="{{ route('posts.index') }}"> @lang('words.news') </a></li>
                  </ul>
              </li>   
            @endif  
            <span class="divider"><hr /></span>

            <li class="nav-item">
                <ul class="dropdown-nav">
                <li><a href="{{ route('posts.index') }}"> @lang('words.news') </a></li>

                <li>
                  
                <a href="{{ route('notification.page') }}"> 
                  @lang('words.notifications')
                    @php
                        $unreadCount = auth()->user()->unreadNotifications->count();
                    @endphp

                    @if($unreadCount > 0)
                        <span class="notification-count">{{ $unreadCount }}</span>
                    @endif
                </a>
                    <li><a href="{{ route('chat.index') }}"> @lang('words.messages') </a></li>
                    <!-- <li><a href="/uz"> uz </a></li>
                    <li><a href="/ru"> ru </a></li>
                    <li><a href="/en"> en </a></li> -->
                </ul>
            </li>

        </ul>
    </nav>
      <!-- <div class="promo-box">
        <div class="promo-icon">
          <img class="mx-auto" src="{{ asset('temp2/images/logo/logo-icon-big.svg') }}" alt="Logo">
        </div>
        <h3>Upgrade to PRO</h3>
        <p>Improve your development process and start doing more with PlainAdmin PRO!</p>
        <a href="https://plainadmin.com/pro" target="_blank" rel="nofollow" class="main-btn primary-btn btn-hover">
          Upgrade to PRO
        </a>
      </div> -->
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-15">
                  <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                    <i class="lni lni-chevron-left me-2"></i> Menu
                  </button>
                </div>
                <div class="header-search d-none d-md-flex">
                  <form action="#">
                    <input type="text" placeholder="Search..." />
                    <button><i class="lni lni-search-alt"></i></button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right d-flex align-items-center justify-content-end">

                <!-- saytga qaytish tugmasi -->
                <!-- <a href="{{ route('home.page') }}" class="btn me-3" 
                  style="background-color: #00BFFF; color: #fff; border: none; 
                          padding: 12px 30px; border-radius: 25px; font-size: 16px;">
                    Saytga qaytish
                </a> -->
                <!-- language start -->
                <div class="notification-box ml-15  d-md-flex">
                <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                        aria-expanded="false">

                        @if(app()->getLocale() == 'uz')
                            <img src="{{ asset('temp2/images/flags/Uzbekistan.jpg') }}" alt="UZ" width="22" height="22" style="border-radius:50%;">
                        @elseif(app()->getLocale() == 'ru')
                            <img src="{{ asset('temp2/images/flags/Russian.png') }}" alt="RU" width="22" height="22" style="border-radius:50%;">
                        @else
                            <img src="{{ asset('temp2/images/flags/English.webp') }}" alt="EN" width="22" height="22" style="border-radius:50%;">
                        @endif

                    </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="width: 74px;" aria-labelledby="notification">
                    <li>
                      <a href="/uz">
                        <div class="image">
                          <img src="{{ asset('temp2/images/flags/Uzbekistan.jpg') }}" alt="" />
                        </div>
                        <div class="content">
                          <h6>
                            O‘zbekcha 
                          </h6>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="/ru">
                        <div class="image">
                          <img src="{{ asset('temp2/images/flags/Russian.png') }}" alt="" />
                        </div>
                        <div class="content">
                          <h6>
                            Русский
                          </h6>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="/en">
                        <div class="image">
                          <img src="{{ asset('temp2/images/flags/English.webp') }}" alt="" />
                        </div>
                        <div class="content">
                          <h6>
                            English
                          </h6>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
                <!-- language end --> 

                <!-- profile start -->
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                      <div class="info">
                        <div class="image">
                          <img src="{{ asset('temp2/images/flags/profil.png') }}" alt="" />
                        </div>
                        <div class="auth-user-info">
                          <h6 class="fw-500">{{ auth()->user()->last_name }} {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</h6>
                          <p>{{ auth()->user()->roles->pluck('name')->join(', ') }}</p>
                        </div>
                      </div>
                    </div>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                    <li>
                      <div class="author-info flex items-center !p-1">
                        <div class="image">
                          <img src="{{ asset('temp2/images/flags/profil.png') }}" alt="image">
                        </div>
                        <div class="content">
                          <h4 class="text-sm">{{ auth()->user()->last_name }} {{ auth()->user()->name }}</h4>
                          <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#">{{ auth()->user()->email }}</a>
                        </div>
                      </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="{{ route('profil') }}"> 
                        <i class="lni lni-user"></i> @lang('words.profile')
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('notification.page') }}">
                        <i class="lni lni-alarm"></i> @lang('words.notifications')
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('chat.index') }}"> <i class="fa-regular fa-comments"></i> @lang('words.messages') </a>
                    </li>
                    <!-- <li>
                      <a href="#0"> <i class="lni lni-cog"></i> Settings </a>
                    </li> -->
                    <li class="divider"></li>
                    <li>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST">
                          @csrf
                      </form>

                      <a href="#" onclick="logout(event)">
                          <i class="lni lni-exit"></i> Sign Out
                      </a>
                  </li>

                  <script>
                      function logout(event) {
                          event.preventDefault();
                          document.getElementById('logout-form').submit();
                      }
                  </script>
                  </ul>
                </div>
                <!-- profile end -->
                @endauth
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- ========== header end ========== -->
      @include('partials.alert')
      
      {{ $slot }}
      <!-- @if(session('success'))
          <div class="alert alert-success position-fixed bottom-0 end-0 p-3">
              <i class="fas fa-check-circle"></i>
              {{ session('success') }}
          </div>
      @endif

      @if(session('password_cancelled'))
          <div class="alert alert-success">
              Parol muvaffaqiyatli bekor qilindi.<br>
              Yangi parol: <strong>{{ session('new_password') }}</strong>
          </div>
      @endif -->
      
    </main>
    <!-- Modal -->



      <!-- ========= All Javascript files linkup ======== -->
    <script src="{{ asset('temp2/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('temp2/js/Chart.min.js') }}"></script>
    <script src="{{ asset('temp2/js/dynamic-pie-chart.js') }}"></script>
    <script src="{{ asset('temp2/js/moment.min.js') }}"></script>
    <script src="{{ asset('temp2/js/fullcalendar.js') }}"></script>
    <script src="{{ asset('temp2/js/jvectormap.min.js') }}"></script>
    <script src="{{ asset('temp2/js/world-merc.js') }}"></script>
    <script src="{{ asset('temp2/js/polyfill.js') }}"></script>
    <script src="{{ asset('temp2/js/main.js') }}"></script>

    <script>
      // ======== jvectormap activation
      var markers = [
        { name: "Egypt", coords: [26.8206, 30.8025] },
        { name: "Russia", coords: [61.524, 105.3188] },
        { name: "Canada", coords: [56.1304, -106.3468] },
        { name: "Greenland", coords: [71.7069, -42.6043] },
        { name: "Brazil", coords: [-14.235, -51.9253] },
      ];

      var jvm = new jsVectorMap({
        map: "world_merc",
        selector: "#map",
        zoomButtons: true,

        regionStyle: {
          initial: {
            fill: "#d1d5db",
          },
        },

        labels: {
          markers: {
            render: (marker) => marker.name,
          },
        },

        markersSelectable: true,
        selectedMarkers: markers.map((marker, index) => {
          var name = marker.name;

          if (name === "Russia" || name === "Brazil") {
            return index;
          }
        }),
        markers: markers,
        markerStyle: {
          initial: { fill: "#4A6CF7" },
          selected: { fill: "#ff5050" },
        },
        markerLabelStyle: {
          initial: {
            fontWeight: 400,
            fontSize: 14,
          },
        },
      });
      // ====== calendar activation
      document.addEventListener("DOMContentLoaded", function () {
        var calendarMiniEl = document.getElementById("calendar-mini");
        var calendarMini = new FullCalendar.Calendar(calendarMiniEl, {
          initialView: "dayGridMonth",
          headerToolbar: {
            end: "today prev,next",
          },
        });
        calendarMini.render();
      });

      // =========== chart one start
      const ctx1 = document.getElementById("Chart1").getContext("2d");
      const chart1 = new Chart(ctx1, {
        type: "line",
        data: {
          labels: [
            "Jan",
            "Fab",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          datasets: [
            {
              label: "",
              backgroundColor: "transparent",
              borderColor: "#365CF5",
              data: [
                600, 800, 750, 880, 940, 880, 900, 770, 920, 890, 976, 1100,
              ],
              pointBackgroundColor: "transparent",
              pointHoverBackgroundColor: "#365CF5",
              pointBorderColor: "transparent",
              pointHoverBorderColor: "#fff",
              pointHoverBorderWidth: 5,
              borderWidth: 5,
              pointRadius: 8,
              pointHoverRadius: 8,
              cubicInterpolationMode: "monotone", // Add this line for curved line
            },
          ],
        },
        options: {
          plugins: {
            tooltip: {
              callbacks: {
                labelColor: function (context) {
                  return {
                    backgroundColor: "#ffffff",
                    color: "#171717"
                  };
                },
              },
              intersect: false,
              backgroundColor: "#f9f9f9",
              title: {
                fontFamily: "Plus Jakarta Sans",
                color: "#8F92A1",
                fontSize: 12,
              },
              body: {
                fontFamily: "Plus Jakarta Sans",
                color: "#171717",
                fontStyle: "bold",
                fontSize: 16,
              },
              multiKeyBackground: "transparent",
              displayColors: false,
              padding: {
                x: 30,
                y: 10,
              },
              bodyAlign: "center",
              titleAlign: "center",
              titleColor: "#8F92A1",
              bodyColor: "#171717",
              bodyFont: {
                family: "Plus Jakarta Sans",
                size: "16",
                weight: "bold",
              },
            },
            legend: {
              display: false,
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: false,
          },
          scales: {
            y: {
              grid: {
                display: false,
                drawTicks: false,
                drawBorder: false,
              },
              ticks: {
                padding: 35,
                max: 1200,
                min: 500,
              },
            },
            x: {
              grid: {
                drawBorder: false,
                color: "rgba(143, 146, 161, .1)",
                zeroLineColor: "rgba(143, 146, 161, .1)",
              },
              ticks: {
                padding: 20,
              },
            },
          },
        },
      });
      // =========== chart one end

      // =========== chart two start
      const ctx2 = document.getElementById("Chart2").getContext("2d");
      const chart2 = new Chart(ctx2, {
        type: "bar",
        data: {
          labels: [
            "Jan",
            "Fab",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          datasets: [
            {
              label: "",
              backgroundColor: "#365CF5",
              borderRadius: 30,
              barThickness: 6,
              maxBarThickness: 8,
              data: [
                600, 700, 1000, 700, 650, 800, 690, 740, 720, 1120, 876, 900,
              ],
            },
          ],
        },
        options: {
          plugins: {
            tooltip: {
              callbacks: {
                titleColor: function (context) {
                  return "#8F92A1";
                },
                label: function (context) {
                  let label = context.dataset.label || "";

                  if (label) {
                    label += ": ";
                  }
                  label += context.parsed.y;
                  return label;
                },
              },
              backgroundColor: "#F3F6F8",
              titleAlign: "center",
              bodyAlign: "center",
              titleFont: {
                size: 12,
                weight: "bold",
                color: "#8F92A1",
              },
              bodyFont: {
                size: 16,
                weight: "bold",
                color: "#171717",
              },
              displayColors: false,
              padding: {
                x: 30,
                y: 10,
              },
          },
          },
          legend: {
            display: false,
            },
          legend: {
            display: false,
          },
          layout: {
            padding: {
              top: 15,
              right: 15,
              bottom: 15,
              left: 15,
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              grid: {
                display: false,
                drawTicks: false,
                drawBorder: false,
              },
              ticks: {
                padding: 35,
                max: 1200,
                min: 0,
              },
            },
            x: {
              grid: {
                display: false,
                drawBorder: false,
                color: "rgba(143, 146, 161, .1)",
                drawTicks: false,
                zeroLineColor: "rgba(143, 146, 161, .1)",
              },
              ticks: {
                padding: 20,
              },
            },
          },
          plugins: {
            legend: {
              display: false,
            },
            title: {
              display: false,
            },
          },
        },
      });
      // =========== chart two end

      // =========== chart three start
      const ctx3 = document.getElementById("Chart3").getContext("2d");
      const chart3 = new Chart(ctx3, {
        type: "line",
        data: {
          labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          datasets: [
            {
              label: "Revenue",
              backgroundColor: "transparent",
              borderColor: "#365CF5",
              data: [80, 120, 110, 100, 130, 150, 115, 145, 140, 130, 160, 210],
              pointBackgroundColor: "transparent",
              pointHoverBackgroundColor: "#365CF5",
              pointBorderColor: "transparent",
              pointHoverBorderColor: "#365CF5",
              pointHoverBorderWidth: 3,
              pointBorderWidth: 5,
              pointRadius: 5,
              pointHoverRadius: 8,
              fill: false,
              tension: 0.4,
            },
            {
              label: "Profit",
              backgroundColor: "transparent",
              borderColor: "#9b51e0",
              data: [
                120, 160, 150, 140, 165, 210, 135, 155, 170, 140, 130, 200,
              ],
              pointBackgroundColor: "transparent",
              pointHoverBackgroundColor: "#9b51e0",
              pointBorderColor: "transparent",
              pointHoverBorderColor: "#9b51e0",
              pointHoverBorderWidth: 3,
              pointBorderWidth: 5,
              pointRadius: 5,
              pointHoverRadius: 8,
              fill: false,
              tension: 0.4,
            },
            {
              label: "Order",
              backgroundColor: "transparent",
              borderColor: "#f2994a",
              data: [180, 110, 140, 135, 100, 90, 145, 115, 100, 110, 115, 150],
              pointBackgroundColor: "transparent",
              pointHoverBackgroundColor: "#f2994a",
              pointBorderColor: "transparent",
              pointHoverBorderColor: "#f2994a",
              pointHoverBorderWidth: 3,
              pointBorderWidth: 5,
              pointRadius: 5,
              pointHoverRadius: 8,
              fill: false,
              tension: 0.4,
            },
          ],
        },
        options: {
          plugins: {
            tooltip: {
              intersect: false,
              backgroundColor: "#fbfbfb",
              titleColor: "#8F92A1",
              bodyColor: "#272727",
              titleFont: {
                size: 16,
                family: "Plus Jakarta Sans",
                weight: "400",
              },
              bodyFont: {
                family: "Plus Jakarta Sans",
                size: 16,
              },
              multiKeyBackground: "transparent",
              displayColors: false,
              padding: {
                x: 30,
                y: 15,
              },
              borderColor: "rgba(143, 146, 161, .1)",
              borderWidth: 1,
              enabled: true,
            },
            title: {
              display: false,
            },
            legend: {
              display: false,
            },
          },
          layout: {
            padding: {
              top: 0,
            },
          },
          responsive: true,
          // maintainAspectRatio: false,
          legend: {
            display: false,
          },
          scales: {
            y: {
              grid: {
                display: false,
                drawTicks: false,
                drawBorder: false,
              },
              ticks: {
                padding: 35,
              },
              max: 350,
              min: 50,
            },
            x: {
              grid: {
                drawBorder: false,
                color: "rgba(143, 146, 161, .1)",
                drawTicks: false,
                zeroLineColor: "rgba(143, 146, 161, .1)",
              },
              ticks: {
                padding: 20,
              },
            },
          },
        },
      });
      // =========== chart three end

      // ================== chart four start
      const ctx4 = document.getElementById("Chart4").getContext("2d");
      const chart4 = new Chart(ctx4, {
        type: "bar",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
          datasets: [
            {
              label: "",
              backgroundColor: "#365CF5",
              borderColor: "transparent",
              borderRadius: 20,
              borderWidth: 5,
              barThickness: 20,
              maxBarThickness: 20,
              data: [600, 700, 1000, 700, 650, 800],
            },
            {
              label: "",
              backgroundColor: "#d50100",
              borderColor: "transparent",
              borderRadius: 20,
              borderWidth: 5,
              barThickness: 20,
              maxBarThickness: 20,
              data: [690, 740, 720, 1120, 876, 900],
            },
          ],
        },
        options: {
          plugins: {
            tooltip: {
              backgroundColor: "#F3F6F8",
              titleColor: "#8F92A1",
              titleFontSize: 12,
              bodyColor: "#171717",
              bodyFont: {
                weight: "bold",
                size: 16,
              },
              multiKeyBackground: "transparent",
              displayColors: false,
              padding: {
                x: 30,
                y: 10,
              },
              bodyAlign: "center",
              titleAlign: "center",
              enabled: true,
            },
            legend: {
              display: false,
            },
          },
          layout: {
            padding: {
              top: 0,
            },
          },
          responsive: true,
          // maintainAspectRatio: false,
          title: {
            display: false,
          },
          scales: {
            y: {
              grid: {
                display: false,
                drawTicks: false,
                drawBorder: false,
              },
              ticks: {
                padding: 35,
                max: 1200,
                min: 0,
              },
            },
            x: {
              grid: {
                display: false,
                drawBorder: false,
                color: "rgba(143, 146, 161, .1)",
                zeroLineColor: "rgba(143, 146, 161, .1)",
              },
              ticks: {
                padding: 20,
              },
            },
          },
        },
      });
        // =========== chart four end
    </script>
    
      <script src="{{ asset('temp2/js/dropdown.js') }}"></script>
      <script src="{{ asset('temp2/js/filter.js') }}"></script>
      <script src="{{ asset('temp2/js/delete-modal.js') }}"></script>
      <script src="{{ asset('temp2/js/notification-modal.js') }}"></script>
      <script src="{{ asset('temp2/js/password-cancel.js') }}"></script>
      

  </body>
</html>