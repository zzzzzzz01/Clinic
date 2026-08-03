<x-layouts.main.app>

    <style>
        :root {
            --primary: #15b9d9;
            --primary-dark: #0099CC;
            --primary-light: #e6f7ff;
            --secondary: #6c757d;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --success: #2ecc71;
            --info: #3498db;
            --warning: #f39c12;
            --danger: #e74c3c;
            --purple: #9b59b6;
            --teal: #1abc9c;
            --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            color: var(--dark);
            min-height: 100vh;
            line-height: 1.6;
        }
        
        .faq-header {
            background: var(--gradient);
            color: white;
            padding: 120px 0 100px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }
        
        .faq-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,0 1000,100 0,100"></polygon></svg>');
            background-size: cover;
        }
        
        .faq-section {
            padding: 80px 0;
            position: relative;
        }
        
        .faq-section:nth-child(even) {
            background: white;
        }
        
        .section-title {
            color: var(--dark);
            padding-bottom: 25px;
            margin-bottom: 50px;
            font-weight: 800;
            position: relative;
            font-size: 2.5rem;
            text-align: center;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }
        
        .faq-top-nav {
            background: white;
            border-radius: 25px;
            padding: 40px;
            margin: -50px 30px 60px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.5);
            backdrop-filter: blur(20px);
            position: relative;
            z-index: 20;
        }
        
        .search-box {
            background: var(--primary-light);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,191,255,0.1);
            border: 2px solid rgba(0,191,255,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .search-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-primary);
        }
        
        .search-box .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px 25px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .search-box .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.3rem rgba(0,191,255,0.15);
            transform: translateY(-2px);
        }
        
        .search-btn {
            background: var(--gradient-primary);
            border: none;
            border-radius: 15px;
            padding: 15px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,191,255,0.3);
        }
        
        .stats-counter {
            background: var(--gradient-primary);
            color: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0,191,255,0.2);
            position: relative;
            overflow: hidden;
        }
        
        .stats-counter::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }
        
        .counter-number {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }
        
        .category-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .category-nav .nav-link {
            background: white;
            color: var(--dark);
            font-weight: 700;
            padding: 20px;
            border-radius: 15px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid transparent;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .category-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s ease;
        }
        
        .category-nav .nav-link:hover::before {
            left: 100%;
        }
        
        .category-nav .nav-link.active, .category-nav .nav-link:hover {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 15px 35px rgba(0,191,255,0.3);
        }
        
        .nav-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .category-nav .nav-link.active .nav-icon,
        .category-nav .nav-link:hover .nav-icon {
            background: rgba(255,255,255,0.3);
            transform: rotate(10deg) scale(1.1);
        }
        
        .contact-box {
            background: var(--primary);
            color: white;
            border-radius: 20px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(102,126,234,0.2);
        }
        
        .contact-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(180deg); }
        }
        
        .faq-category-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 25px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.5);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .faq-category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .faq-category-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .faq-category-card:hover::before {
            transform: scaleX(1);
        }
        
        .category-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            color: white;
            font-size: 2rem;
            box-shadow: 0 12px 25px rgba(0,191,255,0.3);
            transition: all 0.4s ease;
        }
        
        .faq-category-card:hover .category-icon {
            transform: rotate(15deg) scale(1.15);
            box-shadow: 0 15px 30px rgba(0,191,255,0.4);
        }
        
        .accordion-faq {
            border: none;
        }
        
        .accordion-faq .accordion-item {
            border: none;
            margin-bottom: 25px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: white;
            transition: all 0.4s ease;
            border-left: 5px solid var(--primary);
        }
        
        .accordion-faq .accordion-item:hover {
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            transform: translateY(-5px);
            border-left-color: var(--primary-dark);
        }
        
        .accordion-faq .accordion-button {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            padding: 30px;
            font-weight: 700;
            color: var(--dark);
            border-radius: 20px !important;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .accordion-faq .accordion-button:not(.collapsed) {
            background: var(--gradient-primary);
            color: white;
            box-shadow: none;
        }
        
        .accordion-faq .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%232c3e50'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transition: all 0.4s ease;
            width: 1.5rem;
            height: 1.5rem;
        }
        
        .accordion-faq .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transform: rotate(180deg);
        }
        
        .accordion-faq .accordion-body {
            padding: 30px;
            background: white;
            border-top: 1px solid rgba(0,0,0,0.05);
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .back-to-home {
            background: rgba(255,255,255,0.9);
            color: var(--primary);
            border: 2px solid rgba(255,255,255,0.5);
            padding: 18px 35px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            font-size: 1.1rem;
        }
        
        .back-to-home:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        
        .feature-badge {
            background: var(--gradient-primary);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-left: 20px;
            box-shadow: 0 6px 20px rgba(0,191,255,0.3);
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }
        
        .shape {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }
        
        .shape:nth-child(1) { width: 100px; height: 100px; top: 10%; left: 5%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 150px; height: 150px; top: 60%; left: 85%; animation-delay: -5s; }
        .shape:nth-child(3) { width: 80px; height: 80px; top: 80%; left: 15%; animation-delay: -10s; }
        .shape:nth-child(4) { width: 120px; height: 120px; top: 20%; left: 75%; animation-delay: -15s; }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, 30px) rotate(90deg); }
            50% { transform: translate(0, 60px) rotate(180deg); }
            75% { transform: translate(-30px, 30px) rotate(270deg); }
        }
        
        .quick-contact {
            background: var(--primary);
            border-radius: 30px;
            padding: 40px 15px;
            margin-top: 50px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(102,126,234,0.3);
        }
        
        .quick-contact::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,0 1000,100 0,100"></polygon></svg>');
            background-size: cover;
        }
        
        .contact-card {
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.4s ease;
            height: 100%;
        }
        
        .contact-card:hover {
            transform: translateY(-10px);
            background: rgba(255,255,255,0.25);
            box-shadow: 0 15px 35px rgba(255,255,255,0.1);
        }
        
        .progress-ring {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
        }
        
        .progress-ring circle {
            fill: none;
            stroke: var(--primary);
            stroke-width: 4;
            stroke-linecap: round;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        /* Custom icon class */
        .contact-icon {
            font-size: 3rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
        }

        /* Quick Contact custom classes */
        .contact-title {
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .contact-subtitle {
            margin-bottom: 3rem;
            font-size: 1.25rem;
            position: relative;
            z-index: 2;
        }

        .contact-wrapper {
            position: relative;
            z-index: 2;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
        }

        .contact-item {
            flex: 0 0 calc(25% - 1.5rem);
            max-width: calc(25% - 1.5rem);
        }

        .contact-item .contact-card {
            height: 100%;
        }

        

        .quick-contact .contact-card .phone {
                font-size: 15px; 
                color: white;
            }

        /* Quick Contact Mobile */
        @media (max-width: 768px) {
            .quick-contact {
                padding: 20px 15px;
            }

            .quick-contact .contact-title {
                font-size: 1.2rem;
                margin-bottom: 0.75rem;
            }

            .quick-contact .contact-subtitle {
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
            }

            .quick-contact .contact-wrapper {
                gap: 0.5rem;
            }

            .quick-contact .contact-item {
                flex: 0 0 calc(50% - 0.5rem);
                max-width: calc(50% - 0.5rem);
                margin-bottom: 0.5rem;
            }

            .quick-contact .contact-card {
                padding: 15px 8px;
                border-radius: 12px;
            }

            .quick-contact .contact-card .progress-ring {
                width: 50px;
                height: 50px;
                margin-bottom: 8px;
            }

            .quick-contact .contact-card .contact-icon {
                font-size: 25px;
            }

            .quick-contact .contact-card h4 {
                font-size: 0.75rem;
                margin-bottom: 4px;
            }

            .quick-contact .contact-card .phone {
                font-size: 0.7rem !important;
                margin-bottom: 2px;
                color: white;
            }

            .quick-contact .contact-card small {
                font-size: 0.55rem;
            }
        }

        @media (max-width: 480px) {
            .quick-contact {
                padding: 15px 10px;
                border-radius: 20px;
            }

            .quick-contact .contact-title {
                font-size: 18px;
                margin-bottom: 0.5rem;
            }

            .quick-contact .contact-subtitle {
                font-size: 13px;
                margin-bottom: 1rem;
            }

            .quick-contact .contact-wrapper {
                gap: 0.3rem;
            }

            .quick-contact .contact-item {
                flex: 0 0 calc(50% - 0.3rem);
                max-width: calc(50% - 0.3rem);
                margin-bottom: 0.3rem;
            }

            .quick-contact .contact-card {
                padding: 10px 5px;
                border-radius: 10px;
            }

            .quick-contact .contact-card .progress-ring {
                width: 40px;
                height: 40px;
                margin-bottom: 5px;
            }

            .quick-contact .contact-card .contact-icon {
                font-size: 1.2rem;
            }

            .quick-contact .contact-card h4 {
                font-size: 0.6rem;
                margin-bottom: 2px;
            }

            .quick-contact .contact-card .fs-5 {
                font-size: 11px !important;
                margin-bottom: 1px;
            }

            .quick-contact .contact-card small {
                font-size: 10px;
            }
        }

        /* Header custom classes */
        .header-container {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            padding: 3rem 0;
        }

        .header-title {
            color: white;
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        .header-breadcrumb {
            display: flex;
            justify-content: center;
            margin-bottom: 0;
            list-style: none;
            padding: 0;
        }

        .header-breadcrumb li {
            padding: 0 0.5rem;
        }

        .header-breadcrumb li a {
            color: white;
            text-decoration: none;
        }

        .header-breadcrumb .active {
            color: var(--primary);
        }

        /* Section title custom */
        .section-subtitle {
            padding: 0 1rem;
            margin-bottom: 0;
        }

        .section-main-title {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        /* Accordion custom */
        .accordion-item-custom {
            margin-bottom: 1.5rem;
        }

        .accordion-body-custom {
            padding: 1.5rem;
        }

        /* Row custom */
        .row-custom {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -0.75rem;
        }

        .col-half {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 0.75rem;
        }

        /* Card custom */
        .card-custom {
            border: none;
            background: var(--light);
            margin-bottom: 1rem;
        }

        .card-body-custom {
            padding: 1.25rem;
        }

        .card-title-custom {
            font-size: 1.25rem;
        }

        .card-text-success {
            color: var(--success);
        }

        .text-muted-custom {
            color: var(--secondary);
            font-size: 0.875rem;
        }

        /* Alert custom */
        .alert-custom {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            background-color: #cce5ff;
            border-color: #b8daff;
            color: #004085;
        }

        .alert-custom small {
            font-size: 0.875rem;
        }

        .alert-custom i {
            margin-right: 0.5rem;
        }

        /* Blog container */
        .blog-container {
            padding: 3rem 0;
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* FAQ Section */
        .faq-section-custom {
            padding: 30px 0;
            position: relative;
        }

        .question-number {
            background: var(--primary);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
            min-width: 35px;
        }

        @media (max-width: 768px) {
            .category-nav {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .faq-top-nav {
                margin: -30px 15px 40px;
                padding: 25px;
            }
            
            .search-box {
                padding: 20px;
            }

            .header-title {
                font-size: 2rem;
            }

            .section-main-title {
                font-size: 2rem;
            }

            .col-half {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        
        .question-counter {
            background: var(--success);
            color: white;
            border-radius: 15px;
            padding: 8px 15px;
            font-size: 0.8rem;
            font-weight: 600;
            position: absolute;
            top: 15px;
            right: 15px;
        }
        
        .highlight {
            background: linear-gradient(120deg, var(--primary-light) 0%, transparent 100%);
            border-left: 4px solid var(--primary);
            padding: 15px 20px;
            border-radius: 10px;
            margin: 15px 0;
        }

        .bg-primary-custom {
            background-color: var(--primary);
        }

        @media (max-width: 480px) {
            .accordion-faq .accordion-button {
                padding: 12px;
                font-size: 15px;
            }

            .accordion-faq .accordion-button .question-number {
                width: 25px;
                height: 25px;
                min-width: 25px;
            }

            .accordion-faq .accordion-body { 
                font-size: 13px;
                line-height: 1.7;
                padding: 22px;
            }
        }
    </style>


    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="header-container">
            <h3 class="header-title">Ko'p Beriladigan Savollar</h3>
            <ol class="header-breadcrumb">
                <li><a href="{{ route('home.page') }}">Bosh sahifa</a></li>
                <li><a href="#">Sahifalar</a></li>
                <li class="active">Ko'p Beriladigan Savollar</li>
            </ol>    
        </div>
    </div>
    <!-- Header End -->

    <!-- Blog Start -->
    <div class="blog-container">
        <div class="section-title">
            <div class="sub-style">
                <h4 class="section-subtitle">Ko'p Beriladigan Savollar</h4>
            </div>
            <h1 class="section-main-title">Bemorlar tomonidan eng ko'p so'raladigan savolga batafsil javoblar</h1>
        </div> 
        <!-- FAQ Content -->
        <div class="container-custom"> 
            <!-- To'lov Savollari -->
            <section class="faq-section-custom" id="tolov-savollari">
                <div class="accordion accordion-faq" id="faqAccordion">
                    @foreach($faqs as $faq)
                    <div class="accordion-item bg-primary-custom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                <div class="question-number">{{ $loop->iteration }}</div>
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faq{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            
            <!-- Quick Contact Section -->
            <section class="faq-section-custom">
                <div class="quick-contact">
                    <div class="floating-shapes">
                        <div class="shape"></div>
                        <div class="shape"></div>
                        <div class="shape"></div>
                        <div class="shape"></div>
                    </div>
                    <h2 class="contact-title">Savolingizga javob topmadingizmi?</h2>
                    <p class="contact-subtitle">Bizning mutaxassislarimiz sizga yordam berishga tayyor. 24/7 qo'llab-quvvatlash xizmati</p>
                    <div class="contact-wrapper">
                        <div class="contact-item">
                            <div class="contact-card">
                                <div class="progress-ring">
                                    <i class="fas fa-phone contact-icon"></i>
                                </div> 
                                <p class="phone" style="color: white;">+998 91 133 56 54</p>
                                <small>Ish vaqti: 24/7</small>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-card">
                                <div class="progress-ring">
                                    <i class="fas fa-envelope contact-icon"></i>
                                </div> 
                                <p class="phone">khrrmvsh@gmail.com</p>
                                <small>24 soat ichida javob</small>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-card">
                                <div class="progress-ring">
                                    <i class="fab fa-telegram-plane contact-icon"></i>
                                </div> 
                                <p class="phone">
                                    <a href="https://t.me/khrrmvsh" target="_blank" class="phone">
                                        @khrrmvsh
                                    </a>
                                </p>
                                <small>Tezkor javob</small>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-card">
                                <div class="progress-ring">
                                    <i class="fab fa-instagram contact-icon"></i>
                                </div> 
                                <p class="phone">
                                    <a href="https://www.instagram.com/khurramov.shx/" class="phone" target="_blank" rel="noopener noreferrer">
                                        @khurramov.shx
                                    </a>
                                </p>
                                <small>Bizni kuzating</small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Blog Detail End -->

    <!-- Back to Top -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fa fa-arrow-up"></i>
    </a>

    <script>
        $(document).ready(function(){
            $(window).scroll(function(){
                if ($(this).scrollTop() > 300) {
                    $('#backToTop').addClass('show');
                } else {
                    $('#backToTop').removeClass('show');
                }
            });
            
            $('#backToTop').click(function(){
                $("html, body").animate({ scrollTop: 0 }, 600);
                return false;
            });
        });
    </script>
</x-layouts.main.app>