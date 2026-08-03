<x-layouts.main.app>
    <x-slot:title>
    @lang('words.register')
    </x-slot:title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Contact Start -->
        <div class="container-fluid contact pt-5 pb-0">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                </div>
                <div class="row g-4 justify-content-center align-items-center">
                    <div class="col-lg-6 col-xl-6 contact-form wow fadeInLeft" data-wow-delay="0.1s">
                        <h2 class="display-5 text-white mb-2 text-center">@lang('words.register')</h2>
                        <form action="{{ route('auth.register') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="register-field">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-transparent border border-white" name="name" placeholder="@lang('words.name_human')">
                                        <label for="name">@lang('words.name_human')</label>
                                    </div>
                                </div>
                                <div class="register-field">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-transparent border border-white" name="last_name" placeholder="@lang('words.last_name')">
                                        <label for="email">@lang('words.last_name')</label>
                                    </div>
                                </div>
                                <div class="register-field-full">
                                    <div class="form-floating">
                                        <input type="phone" class="form-control bg-transparent border border-white" name="phone" placeholder="@lang('words.phone')">
                                        <label for="phone">@lang('words.phone')</label>
                                    </div>
                                </div>
                                <div class="register-field">
                                    <div class="form-floating">
                                        <select name="gender" class="form-control bg-transparent border border-white text-white" style="color: #fff !important;">
                                            <option value="" class="text-dark" selected disabled>@lang('words.select_gender')</option>
                                            <option value="male" class="text-dark">@lang('words.male')</option>
                                            <option value="female" class="text-dark">@lang('words.female')</option>
                                        </select>
                                        <label for="gender">@lang('words.select_gender')</label>
                                    </div>
                                </div>
                                <div class="register-field">
                                    <div class="form-floating">
                                        <input type="date" class="form-control bg-transparent border border-white" name="birth_date" placeholder="@lang('words.birth_date')">
                                        <label for="phone">@lang('words.birth_date')</label>
                                    </div>
                                </div>
                                <div class="register-field">
                                    <div class="form-floating password-wrapper">
                                        <input type="password" class="form-control bg-transparent border border-white" name="password" id="password" placeholder="@lang('words.password')">
                                        <label for="password">@lang('words.password')</label>
                                        <span class="password-toggle" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="register-field">
                                    <div class="form-floating password-wrapper">
                                        <input type="password" class="form-control bg-transparent border border-white" name="password_confirmation" id="password_confirmation" placeholder="@lang('words.confirm_password')">
                                        <label for="password_confirmation">@lang('words.confirm_password')</label>
                                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="text-end mt-3">
                                    <p class="question">
                                        @lang('words.have_you_already_registered')
                                        <a href="{{ route('auth.login') }}" class="text-white text-decoration-underline">@lang('words.login_to_system')</a>
                                    </p>
                                </div>

                                <div class="col-lg-12 col-xl-12 col-md-8 mx-auto">
                                    <div class="d-flex gap-2 align-items-center">
                                        <button type="submit" class="btn btn-light text-primary w-100 py-3">@lang('words.register')</button>
                                        <button type="button" class="btn btn-outline-light py-3 px-4" id="quickLoginBtn" title="@lang('words.quick_login')">
                                            <i class="fas fa-bolt"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Quick Login Hint - faqat oddiy text -->
                                <div class="info-text">
                                    <div class="quick-login-hint">
                                        @lang('words.select_role')
                                    </div>
                                    <i class="fa-solid fa-arrow-turn-up"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact End -->

    <!-- Quick Login Dialog -->
    <dialog class="notification-modal" id="quickLoginModal">
        <div class="dialog-header">
            <h5 class="dialog-title">@lang('words.quick_login')</h5>
            <button type="button" class="close-btn" id="closeDialogBtn">✕</button>
        </div>
        <div class="dialog-body">
            <p class="text-muted mb-3">@lang('words.select_role_text')</p>
            <div class="role-grid">
                <button type="button" class="role-item quick-login-option" data-role="admin">
                    @lang('words.admin')
                </button>
                <button type="button" class="role-item quick-login-option" data-role="doctor">
                    @lang('words.doctor')
                </button>
                <button type="button" class="role-item quick-login-option" data-role="patient">
                    @lang('words.patient')
                </button>
                <button type="button" class="role-item quick-login-option" data-role="nurse">
                    @lang('words.nurse')
                </button>
                <button type="button" class="role-item quick-login-option" data-role="pharmacist">
                    @lang('words.pharmacist')
                </button>
                <button type="button" class="role-item quick-login-option" data-role="laboratory_technician">
                    @lang('words.laboratory_technician')
                </button>
                <button type="button" class="role-item quick-login-option" data-role="receptionist">
                    @lang('words.receptionist')
                </button>
            </div>
        </div>
        <div class="dialog-footer">
            <button type="button" class="btn-close-dialog" id="closeDialogFooterBtn">@lang('words.close')</button>
        </div>
    </dialog>

    <style>
        /* Scroll bloklash */
        body.no-scroll {
            overflow: hidden !important;
            position: fixed !important;
            width: 100% !important;
            top: 0 !important;
            left: 0 !important;
        }

        /* Quick Login Button */
        #quickLoginBtn {
            /* width: 60px; */
            flex-shrink: 0;
            transition: all 0.3s ease;
            position: relative;
        }

        #quickLoginBtn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        #quickLoginBtn i {
            font-size: 18px;
        }

        /* Quick Login Hint - faqat oddiy text, hech qanday interaktiv emas */
        .quick-login-hint {
            display: inline-block;
            color: white;
            font-size: 20px;
            font-weight: 400;
            letter-spacing: 0.5px;
            cursor: default;
            padding: 2px 0;
        }

        /* Info Text - yangi class */
        .info-text {
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 10px;
            margin-top: 16px;
            width: 100%;
            padding-right: 30px;
        }

        .info-text i {
            color: white;
            font-size: 20px;
        }

        /* Dialog styles */
        .notification-modal {
            border: none;
            border-radius: 16px;
            padding: 0;
            max-width: 950px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
        }

        .notification-modal::backdrop {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(3px);
        }

        @keyframes slideDown {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .dialog-header {
            background-color: #15b9d9;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .dialog-title {
            color: #ffffff;
            font-weight: 600;
            font-size: 18px;
            margin: 0;
        }

        .close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .dialog-body {
            background-color: #ffffff;
            padding: 24px;
        }

        .dialog-footer {
            padding: 20px 30px;
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn-close-dialog {
            background: white;
            color: #4a5568;
            border: 2px solid #cbd5e0;
            padding: 8px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .btn-close-dialog:hover {
            background: #4a5568;
            color: #f7fafc;
            border-color: #a0aec0;
        }

        /* Role Grid - 2 ta qatorda */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .role-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 14px 16px;
            text-align: left;
            color: #2d3748;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .role-item:hover {
            background: #15b9d9;
            border-color: #15b9d9;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(21, 185, 217, 0.3);
        }

        @media (max-width: 992px) {
            .info-text {
                padding-right: 157px;
            }
        }

        @media (max-width: 768px) {
            .info-text {
                padding-right: 32px;
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            #quickLoginBtn {
                width: 50px;
                height: 57px;
                padding: 12px 0 !important;
            }

            #quickLoginBtn i {
                font-size: 16px;
            } 

            .role-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .role-item {
                padding: 12px 14px;
                font-size: 13px;
            }

            .dialog-header {
                padding: 12px 16px;
            }

            .dialog-title {
                font-size: 16px;
            }

            .dialog-body {
                padding: 16px;
            }

            .dialog-footer {
                padding: 12px 18px;
        gap: 8px;
            }

            .close-btn {
                width: 28px;
                height: 28px;
                font-size: 14px;
            }

            .quick-login-hint {
                font-size: 18px;
            }

            .info-text i {
                font-size: 18px;
            }
        }

        @media (max-width: 400px) {
            .role-grid {
                gap: 6px;
            }

            .role-item {
                padding: 10px 10px;
                font-size: 12px;
            }

            .quick-login-hint {
                font-size: 16px;
            }

            .info-text i {
                font-size: 16px;
            }

            .info-text {
                gap: 6px;
                margin-top: 12px;
                padding-right: 24px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quick Login credentials
            const roleCredentials = {
                admin: { login: '440231100200', password: 'secret' },
                doctor: { login: '440231101000', password: 'secret' },
                patient: { login: '440231105000', password: 'secret' },
                nurse: { login: '440231102000', password: 'secret' },
                pharmacist: { login: '440231100300', password: 'secret' },
                laboratory_technician: { login: '440231100400', password: 'secret' },
                receptionist: { login: '440231100500', password: 'secret' }
            };

            // DOM elements
            const quickLoginBtn = document.getElementById('quickLoginBtn');
            const dialog = document.getElementById('quickLoginModal');
            const loginInput = document.getElementById('loginInput');
            const passwordInput = document.getElementById('passwordInput');
            const loginForm = document.getElementById('loginForm');
            const quickLoginOptions = document.querySelectorAll('.quick-login-option');
            const closeDialogBtn = document.getElementById('closeDialogBtn');
            const closeDialogFooterBtn = document.getElementById('closeDialogFooterBtn');

            // Scrollni boshqarish
            let scrollPosition = 0;

            function disableScroll() {
                scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                document.body.classList.add('no-scroll');
                document.body.style.top = `-${scrollPosition}px`;
            }

            function enableScroll() {
                document.body.classList.remove('no-scroll');
                document.body.style.top = '';
                window.scrollTo(0, scrollPosition);
            }

            // Open dialog - scrollni o'chirish
            quickLoginBtn.addEventListener('click', function() {
                dialog.showModal();
                disableScroll();
            });

            // Close dialog functions - scrollni qayta yoqish
            function closeDialog() {
                dialog.close();
                enableScroll();
            }

            closeDialogBtn.addEventListener('click', closeDialog);
            closeDialogFooterBtn.addEventListener('click', closeDialog);

            // Escape tugmasi bosilganda scrollni qayta yoqish
            dialog.addEventListener('cancel', function() {
                enableScroll();
            });

            // Quick login click
            quickLoginOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const role = this.dataset.role;
                    const credentials = roleCredentials[role];

                    if (credentials) {
                        // Fill login and password
                        loginInput.value = credentials.login;
                        passwordInput.value = credentials.password;

                        // Close dialog
                        closeDialog();

                        // Show loading state on button
                        const submitBtn = document.querySelector('button[type="submit"]');
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> @lang("words.waiting")...';
                        submitBtn.disabled = true;

                        // Submit form after short delay
                        setTimeout(() => {
                            loginForm.submit();
                        }, 500);
                    }
                });
            });

            // Reset button state if form submission fails
            window.addEventListener('pageshow', function() {
                const submitBtn = document.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '@lang("words.register")';
                    submitBtn.disabled = false;
                }
            });
        });
    </script>

    <style>
        .register-field {
            width: 50%;
            padding: 0 10px;
            box-sizing: border-box;
            position: relative;
        }
        
        .register-field-full {
            width: 100%;
            padding: 0 10px;
            box-sizing: border-box;
        }
        
        .row.g-3 {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-floating select option {
            color: #000 !important;
            background: #fff !important;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            z-index: 10;
            font-size: 16px;
            transition: color 0.3s ease;
        } 
        
        .password-wrapper input {
            padding-right: 45px !important;
        } 
    </style>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.closest('.password-wrapper').querySelector('.password-toggle i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    </x-layouts.main.app>