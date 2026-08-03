<x-layouts.main.app>

<style>
    /* ===== CSS Variables ===== */
    :root {
        --primary: #00BFFF;
        --primary-dark: #0095ff;
        --primary-gradient: linear-gradient(135deg, #00BFFF, #0095ff);
        --shadow: 0 15px 40px rgba(0, 191, 255, 0.15);
        --shadow-hover: 0 20px 50px rgba(0, 191, 255, 0.25);
        --radius: 20px;
        --radius-sm: 16px;
        --transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        --bg-light: #f0f5fe;
        --card-bg: #ffffff;
        --text-dark: #1a2332;
        --text-muted: #6b7a8f;
    }

    /* ===== Base Styles ===== */
    body {
        background: var(--bg-light);
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: var(--text-dark);
    }

    /* ===== Animations ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-fade {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* ===== Header ===== */
    .developer-header {
        background: var(--primary-gradient);
        border-radius: var(--radius);
        padding: 40px 45px;
        color: #fff;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .developer-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .developer-header h2 {
        font-weight: 800;
        font-size: 28px;
        margin-bottom: 6px;
        position: relative;
        z-index: 1;
    }

    .developer-header p {
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    /* ===== Developer Card ===== */
    .developer-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
        transition: var(--transition);
        animation: fadeInUp 0.6s ease;
    }

    .developer-card:hover {
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
    }

    .developer-left {
        padding: 50px 45px;
    }

    /* ===== Avatar ===== */
    .avatar-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid var(--primary);
        transition: var(--transition);
        box-shadow: 0 0 0 0 rgba(0, 191, 255, 0.3);
    }

    .avatar:hover {
        transform: scale(1.03);
        box-shadow: 0 0 0 12px rgba(0, 191, 255, 0.15);
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ===== Developer Info ===== */
    .dev-name {
        font-size: 34px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--text-dark);
    }

    .dev-job {
        color: var(--primary);
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .dev-about {
        color: var(--text-muted);
        line-height: 1.8;
        font-size: 15px;
        max-width: 500px;
    }

    /* ===== Info Box ===== */
    .info-box {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        border-radius: 14px;
        background: #f8fbff;
        transition: var(--transition);
        margin-top: 4px;
    }

    .info-box:hover {
        background: #eef6ff;
        transform: translateX(4px);
    }

    .info-box i {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eaf8ff;
        color: var(--primary);
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 14px;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-box h6 {
        margin: 0;
        font-weight: 600;
        font-size: 13px;
        color: var(--text-dark);
    }

    .info-box p {
        margin: 0;
        color: var(--text-muted);
        font-size: 13px;
    }

    /* ===== Right Panel ===== */
    .developer-right {
        background: #fafdff;
        padding: 50px 40px;
        border-left: 1px solid rgba(0, 0, 0, 0.04);
    }

    .developer-right h4 {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 28px;
    }

    /* ===== Skill Card ===== */
    .skill-card {
        background: var(--card-bg);
        border-radius: var(--radius-sm);
        text-align: center;
        padding: 20px 12px;
        transition: var(--transition);
        border: 1px solid #edf2f7;
        cursor: default;
        height: 100%;
    }

    .skill-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 191, 255, 0.15);
        border-color: var(--primary);
    }

    .skill-card i {
        font-size: 32px;
        color: var(--primary);
        margin-bottom: 12px;
        display: block;
    }

    .skill-card h6 {
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 3px;
    }

    .skill-card small {
        color: var(--text-muted);
        font-size: 11px;
    }

    /* ===== Section Title ===== */
    .section-title {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 28px;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary);
        font-size: 22px;
    }

    /* ===== Contact Card ===== */
    .contact-card,
    .project-card,
    .stats-card,
    .timeline-card,
    .project-progress,
    .achievement-card,
    .social-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        padding: 35px 40px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
        transition: var(--transition);
        height: 100%;
        animation: fadeInUp 0.6s ease;
    }

    .contact-card:hover,
    .project-card:hover,
    .stats-card:hover,
    .timeline-card:hover,
    .project-progress:hover {
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
    }

    .contact-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f4f9;
        transition: var(--transition);
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-item:hover {
        transform: translateX(6px);
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        background: #e9f8ff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 18px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .contact-item span {
        font-size: 12px;
        color: var(--text-muted);
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .contact-item p {
        margin: 0;
        font-weight: 600;
        font-size: 15px;
    }

    /* ===== Project Card ===== */
    .project-text {
        line-height: 1.9;
        color: var(--text-muted);
        font-size: 15px;
    }

    .project-box {
        background: #f8fbff;
        padding: 22px 15px;
        text-align: center;
        border-radius: var(--radius-sm);
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .project-box:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 191, 255, 0.12);
        border-color: var(--primary);
    }

    .project-box h2 {
        color: var(--primary);
        font-size: 38px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .project-box span {
        color: var(--text-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .feature-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .feature-list li {
        padding: 8px 0;
        font-weight: 500;
        font-size: 14px;
        color: var(--text-dark);
        border-bottom: 1px solid #f5f8fc;
    }

    .feature-list li:last-child {
        border-bottom: none;
    }

    .feature-list i {
        color: var(--primary);
        margin-right: 10px;
        font-size: 14px;
    }

    /* ===== Stats ===== */
    .stat-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f4f9;
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: #eaf9ff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        color: var(--primary);
        margin-right: 16px;
        flex-shrink: 0;
    }

    .stat-item h2 {
        margin: 0;
        font-weight: 700;
        font-size: 26px;
        color: var(--text-dark);
        letter-spacing: -0.5px;
    }

    .stat-item span {
        color: var(--text-muted);
        font-size: 13px;
    }

    /* ===== Timeline ===== */
    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        position: relative;
        padding-left: 28px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item:before {
        content: "";
        position: absolute;
        left: 6px;
        top: 22px;
        width: 2px;
        height: calc(100% + 8px);
        background: #e5eff9;
    }

    .timeline-item:last-child:before {
        display: none;
    }

    .timeline-dot {
        width: 14px;
        height: 14px;
        background: var(--primary);
        border-radius: 50%;
        position: absolute;
        left: 0;
        top: 6px;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px var(--primary);
    }

    .timeline-dot.active {
        background: #28a745;
        box-shadow: 0 0 0 3px #28a745;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 3px #28a745; }
        50% { box-shadow: 0 0 0 8px rgba(40, 167, 69, 0.25); }
        100% { box-shadow: 0 0 0 3px #28a745; }
    }

    .timeline-item h5 {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .timeline-item p {
        margin: 0;
        color: var(--text-muted);
        font-size: 14px;
    }

    /* ===== Progress ===== */
    .progress-box {
        margin-bottom: 22px;
    }

    .progress-box:last-child {
        margin-bottom: 0;
    }

    .progress-box span {
        font-weight: 600;
        font-size: 14px;
        display: block;
        margin-bottom: 6px;
        color: var(--text-dark);
    }

    .progress {
        height: 10px;
        border-radius: 50px;
        background: #eef5ff;
        overflow: hidden;
    }

    .progress-bar {
        background: var(--primary-gradient);
        font-size: 10px;
        font-weight: 600;
        border-radius: 50px;
        transition: width 1.2s ease;
    }

    /* ===== Quote Box ===== */
    .quote-box {
        height: 100%;
        background: var(--primary-gradient);
        border-radius: var(--radius);
        padding: 40px 38px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .quote-box::before {
        content: '"';
        position: absolute;
        right: 20px;
        top: -10px;
        font-size: 140px;
        opacity: 0.08;
        font-family: Georgia, serif;
    }

    .quote-box i {
        font-size: 36px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .quote-box p {
        font-size: 18px;
        line-height: 1.8;
        font-weight: 400;
        position: relative;
        z-index: 1;
    }

    .quote-box h5 {
        margin-top: 18px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    /* ===== Achievement ===== */
    .achievement-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f4f9;
    }

    .achievement-item:last-child {
        border-bottom: none;
    }

    .achievement-item i {
        width: 48px;
        height: 48px;
        background: #eaf8ff;
        color: var(--primary);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .achievement-item h6 {
        margin: 0;
        font-weight: 700;
        font-size: 15px;
    }

    .achievement-item small {
        color: var(--text-muted);
        font-size: 12px;
    }

    /* ===== Social Buttons ===== */
    .social-btn {
        display: block;
        text-decoration: none;
        margin-bottom: 14px;
        padding: 16px 20px;
        border-radius: 14px;
        font-weight: 600;
        transition: var(--transition);
        color: #fff;
        font-size: 15px;
        border: none;
    }

    .social-btn:last-child {
        margin-bottom: 0;
    }

    .social-btn i {
        margin-right: 14px;
        font-size: 18px;
    }

    .social-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        color: #fff;
    }

    .github { background: #24292e; }
    .telegram { background: #229ED9; }
    .linkedin { background: #0A66C2; }
    .email { background: var(--primary-gradient); }

    /* ===== Footer ===== */
    .developer-footer {
        margin-top: 40px;
        background: var(--primary-gradient);
        padding: 55px 50px;
        border-radius: 25px;
        text-align: center;
        color: #fff;
        box-shadow: 0 20px 50px rgba(0, 191, 255, 0.25);
        animation: fadeInUp 0.8s ease;
        position: relative;
        overflow: hidden;
    }

    .developer-footer::before {
        content: '';
        position: absolute;
        top: -60%;
        left: -20%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }

    .footer-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        position: relative;
        z-index: 1;
        animation: float 3s ease-in-out infinite;
    }

    .footer-line {
        width: 100px;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50px;
        margin: 20px auto;
    }

    .developer-footer h3 {
        font-weight: 700;
        font-size: 26px;
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }

    .developer-footer p {
        max-width: 600px;
        margin: 0 auto 10px;
        line-height: 1.9;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    .developer-footer span {
        opacity: 0.8;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }

    .developer-footer strong {
        font-weight: 700;
    }

    /* ===== Responsive ===== */
    @media (max-width: 991px) {
        .developer-right {
            border-left: none;
            border-top: 1px solid rgba(0, 0, 0, 0.04);
        }

        .developer-left {
            padding: 35px 30px;
        }

        .developer-right {
            padding: 35px 30px;
        }

        .dev-name {
            font-size: 28px;
        }

        .avatar {
            width: 120px;
            height: 120px;
        }

        .contact-card,
        .project-card,
        .stats-card,
        .timeline-card,
        .project-progress,
        .achievement-card,
        .social-card {
            padding: 28px 25px;
        }
    }

    @media (max-width: 767px) {
        .developer-header {
            padding: 28px 25px;
        }

        .developer-header h2 {
            font-size: 22px;
        }

        .developer-left .d-flex {
            flex-direction: column;
            align-items: center !important;
            text-align: center;
        }

        .avatar-wrapper {
            margin-bottom: 20px;
        }

        .avatar {
            width: 130px;
            height: 130px;
        }

        .dev-name {
            font-size: 26px;
        }

        .dev-about {
            max-width: 100%;
            text-align: center;
        }

        .info-box {
            justify-content: center;
        }

        .developer-footer {
            padding: 40px 25px;
        }

        .developer-footer h3 {
            font-size: 22px;
        }

        .quote-box {
            margin-top: 20px;
            padding: 30px 25px;
        }

        .quote-box p {
            font-size: 16px;
        }
    }

    @media (max-width: 575px) {
        .developer-left {
            padding: 25px 20px;
        }

        .developer-right {
            padding: 25px 20px;
        }

        .contact-card,
        .project-card,
        .stats-card,
        .timeline-card,
        .project-progress,
        .achievement-card,
        .social-card {
            padding: 22px 18px;
        }

        .project-box h2 {
            font-size: 30px;
        }

        .stat-item h2 {
            font-size: 22px;
        }

        .social-btn {
            font-size: 14px;
            padding: 14px 16px;
        }
    }
</style>

<!-- ===== MAIN CONTENT ===== -->
<div class="container-fluid mt-4">

    <!-- ===== Header ===== -->
    <div class="developer-header animate-fade">
        <h2>
            <i class="fas fa-code me-2"></i>
            Dasturchi haqida
        </h2>
        <p>Hospital Management System loyihasi muallifi</p>
    </div>

    <!-- ===== Developer Card ===== -->
    <div class="developer-card">
        <div class="row g-0">

            <!-- Left Column -->
            <div class="col-lg-8 developer-left">
                <div class="d-flex align-items-start">

                    <!-- Avatar -->
                    <div class="avatar-wrapper">
                        <div class="avatar">
                            <img src="{{ asset('dashboard/images/developer.jpg') }}" alt="Developer">
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="ms-4 flex-grow-1">
                        <div class="dev-name">Xurramov Shohjaxon</div>
                        <div class="dev-job">Backend Laravel Developer</div>
                        <div class="dev-about">
                            PHP Laravel asosida zamonaviy Hospital Management System,
                            CRM va ERP tizimlarini ishlab chiqishga ixtisoslashgan backend dasturchiman.
                            Kod sifati, xavfsizlik, toza arxitektura va yuqori unumdorlik mening asosiy maqsadim.
                        </div>

                        <!-- Info Grid -->
                        <div class="row mt-4 g-2">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <h6>Manzil</h6>
                                        <p>Toshkent, O'zbekiston</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="fas fa-user-tie"></i>
                                    <div>
                                        <h6>Lavozim</h6>
                                        <p>Backend Developer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="fas fa-briefcase"></i>
                                    <div>
                                        <h6>Tajriba</h6>
                                        <p>2+ yil</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="fas fa-language"></i>
                                    <div>
                                        <h6>Tillar</h6>
                                        <p>Uzbek / English / Russian</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Column - Skills -->
            <div class="col-lg-4 developer-right">
                <h4 class="fw-bold">
                    <i class="fas fa-cogs me-2" style="color: var(--primary);"></i>
                    Texnologiyalar
                </h4>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fab fa-php"></i>
                            <h6>PHP</h6>
                            <small>Backend</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fab fa-laravel"></i>
                            <h6>Laravel</h6>
                            <small>Framework</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fas fa-database"></i>
                            <h6>MySQL</h6>
                            <small>Database</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fas fa-memory"></i>
                            <h6>Redis</h6>
                            <small>Cache</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fab fa-bootstrap"></i>
                            <h6>Bootstrap</h6>
                            <small>Frontend</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fab fa-js"></i>
                            <h6>JavaScript</h6>
                            <small>Frontend</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fab fa-git-alt"></i>
                            <h6>Git</h6>
                            <small>Version Control</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="skill-card">
                            <i class="fab fa-github"></i>
                            <h6>GitHub</h6>
                            <small>Repository</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== Contact + Project Row ===== -->
    <div class="row mt-4">

        <!-- Contact -->
        <div class="col-lg-4">
            <div class="contact-card">
                <h4 class="section-title">
                    <i class="fas fa-address-card"></i>
                    Bog'lanish
                </h4>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <span>Email</span>
                        <p>shohjahon@example.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-telegram-plane"></i>
                    </div>
                    <div>
                        <span>Telegram</span>
                        <p>@shohjahon</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-github"></i>
                    </div>
                    <div>
                        <span>GitHub</span>
                        <p>github.com/shohjahon</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-linkedin"></i>
                    </div>
                    <div>
                        <span>LinkedIn</span>
                        <p>linkedin.com/in/shohjahon</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project -->
        <div class="col-lg-8">
            <div class="project-card">
                <h4 class="section-title">
                    <i class="fas fa-hospital"></i>
                    Hospital Management System
                </h4>

                <p class="project-text">
                    Ushbu loyiha zamonaviy shifoxona boshqaruv tizimi bo'lib, Laravel Framework yordamida ishlab chiqilgan.
                    Tizim shifokorlar, hamshiralar, laboratoriya, dorixona, qabul bo'limi va administrator uchun
                    alohida boshqaruv paneliga ega.
                </p>

                <!-- Stats -->
                <div class="row mt-4 g-3">
                    <div class="col-md-4">
                        <div class="project-box">
                            <h2>15</h2>
                            <span>Bo'lim</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="project-box">
                            <h2>180</h2>
                            <span>Statsionar bemor</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="project-box">
                            <h2>7</h2>
                            <span>User Roles</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Features -->
                <div class="row">
                    <div class="col-md-6">
                        <ul class="feature-list">
                            <li><i class="fas fa-check-circle"></i>Appointment System</li>
                            <li><i class="fas fa-check-circle"></i>Hospitalization</li>
                            <li><i class="fas fa-check-circle"></i>Medicine Inventory</li>
                            <li><i class="fas fa-check-circle"></i>Pharmacy Module</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="feature-list">
                            <li><i class="fas fa-check-circle"></i>Laboratory Module</li>
                            <li><i class="fas fa-check-circle"></i>Nurse Panel</li>
                            <li><i class="fas fa-check-circle"></i>Doctor Dashboard</li>
                            <li><i class="fas fa-check-circle"></i>Redis Cache</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== Statistics + Timeline Row ===== -->
    <div class="row mt-4">

        <!-- Statistics -->
        <div class="col-lg-4">
            <div class="stats-card">
                <h4 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Statistikalar
                </h4>

                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-code"></i></div>
                    <div>
                        <h2>120K+</h2>
                        <span>Lines of Code</span>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-folder-open"></i></div>
                    <div>
                        <h2>35+</h2>
                        <span>Laravel Modules</span>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-database"></i></div>
                    <div>
                        <h2>60+</h2>
                        <span>Database Tables</span>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-server"></i></div>
                    <div>
                        <h2>Redis</h2>
                        <span>Cache System</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="col-lg-8">
            <div class="timeline-card">
                <h4 class="section-title">
                    <i class="fas fa-road"></i>
                    Loyiha rivojlanishi
                </h4>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div>
                        <h5>Project Started</h5>
                        <p>Database structure va Authentication yaratildi.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div>
                        <h5>Hospital Modules</h5>
                        <p>Doctor, Nurse, Patient va Department modullari yaratildi.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div>
                        <h5>Advanced Features</h5>
                        <p>Appointment, Hospitalization, Laboratory va Pharmacy modullari qo'shildi.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot active"></div>
                    <div>
                        <h5>Current Version</h5>
                        <p>Hospital Management System Portfolio Version.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== Progress + Quote Row ===== -->
    <div class="row mt-4">

        <!-- Progress -->
        <div class="col-lg-6">
            <div class="project-progress">
                <h4 class="section-title">
                    <i class="fas fa-tasks"></i>
                    Project Progress
                </h4>

                <div class="progress-box">
                    <span>Backend</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 95%;">95%</div>
                    </div>
                </div>

                <div class="progress-box">
                    <span>Frontend</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 90%;">90%</div>
                    </div>
                </div>

                <div class="progress-box">
                    <span>Database</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 98%;">98%</div>
                    </div>
                </div>

                <div class="progress-box">
                    <span>Testing</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 80%;">80%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quote -->
        <div class="col-lg-6">
            <div class="quote-box">
                <i class="fas fa-quote-left"></i>
                <p>"Good software is built not only to work, but to be maintainable, scalable and enjoyable to use."</p>
                <h5>— Xurramov Shohjaxon</h5>
            </div>
        </div>

    </div>

    <!-- ===== Achievements + Social Row ===== -->
    <div class="row mt-4">

        <!-- Achievements -->
        <div class="col-lg-6">
            <div class="achievement-card">
                <h4 class="section-title">
                    <i class="fas fa-trophy"></i>
                    Achievements
                </h4>

                <div class="achievement-item">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h6>Hospital Management System</h6>
                        <small>Complete Full Stack Project</small>
                    </div>
                </div>

                <div class="achievement-item">
                    <i class="fas fa-database"></i>
                    <div>
                        <h6>Database Design</h6>
                        <small>60+ Professional Tables</small>
                    </div>
                </div>

                <div class="achievement-item">
                    <i class="fas fa-users"></i>
                    <div>
                        <h6>Role Management</h6>
                        <small>7 Different User Panels</small>
                    </div>
                </div>

                <div class="achievement-item">
                    <i class="fas fa-bolt"></i>
                    <div>
                        <h6>Performance</h6>
                        <small>Redis Cache Integration</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social -->
        <div class="col-lg-6">
            <div class="social-card">
                <h4 class="section-title">
                    <i class="fas fa-paper-plane"></i>
                    Connect With Me
                </h4>

                <a href="#" class="social-btn github">
                    <i class="fab fa-github"></i> GitHub
                </a>
                <a href="#" class="social-btn telegram">
                    <i class="fab fa-telegram-plane"></i> Telegram
                </a>
                <a href="#" class="social-btn linkedin">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </a>
                <a href="mailto:example@gmail.com" class="social-btn email">
                    <i class="fas fa-envelope"></i> Email
                </a>
            </div>
        </div>

    </div>

    <!-- ===== Footer ===== -->
    <div class="developer-footer">
        <div class="footer-icon">
            <i class="fas fa-heart"></i>
        </div>
        <h3>Thank You For Visiting</h3>
        <p>Ushbu Hospital Management System Laravel Framework yordamida zamonaviy arxitektura asosida ishlab chiqilgan.</p>
        <div class="footer-line"></div>
        <span>© {{ date('Y') }} Developed by <strong>Xurramov Shohjaxon</strong></span>
    </div>

</div>

</x-layouts.main.app>