<style>
    /* Dialog overlay */
    .register-dialog {
        border: none;
        border-radius: 16px;
        padding: 0;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: dialogFadeIn 0.3s ease;
        overflow: hidden;
    }

    .register-dialog::backdrop {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
    }

    @keyframes dialogFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .register-dialog-header {
        background: #15b9d9 ;
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    } 

    .register-dialog-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: white;
        font-family: "Plus Jakarta Sans", sans-serif !important;
    }

    .register-dialog-close-btn {
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

    .register-dialog-close-btn:hover {
        background: rgba(255,255,255,0.3);
    }

    .register-dialog-body {
        padding: 25px;
        max-height: 60vh;
        overflow-y: auto;
    }

    /* ========================================================= */
    /* AUTH DIALOG UCHUN CSS                                     */
    /* ========================================================= */
    .auth-dialog-body {
        text-align: center;
        padding: 40px 30px;
    }

    .auth-message {
        font-size: 16px;
        color: #4a5568;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .auth-btn {
        display: block;
        width: 100%;
        padding: 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .auth-btn-login {
        background: #15b9d9;
        color: white;
        box-shadow: 0 4px 15px rgba(21, 185, 217, 0.3);
    }

    .auth-btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(21, 185, 217, 0.4);
        color: white;
    }

    .auth-btn-register {
        background: transparent;
        color: #15b9d9;
        border: 2px solid #15b9d9;
    }

    .auth-btn-register:hover {
        background: #15b9d9;
        color: white;
        transform: translateY(-2px);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        margin: 20px 0;
        color: #a0aec0;
        font-size: 13px;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .auth-divider span {
        padding: 0 15px;
        font-weight: 500;
        color: #a0aec0;
    }

    .auth-footer-text {
        margin-top: 20px;
        font-size: 13px;
        color: #a0aec0;
    }

    /* Mobil moslashuv */
    @media (max-width: 576px) {
        .register-dialog {
            width: 95%;
            border-radius: 12px;         
        }
        .register-dialog-header {
            padding: 10px 15px;
        }

        .register-dialog-header h3 {
            font-size: 14px;
        }

        .register-dialog-close-btn {
            width: 28px;
            height: 28px;
            font-size: 14px;
        }

        .register-dialog-body {
            padding: 18px;
        }

        .auth-dialog-body {
            padding: 25px 18px;
        }

        .auth-message {
            font-size: 14px;
        }

        .auth-btn {
            font-size: 13px;
            padding: 12px;
        } 
    }
</style>

<dialog id="authDialog" class="register-dialog">
    <div class="register-dialog-header">
        <h3>Qabulga yozilish</h3>
        <button type="button" class="register-dialog-close-btn" onclick="closeAuthDialog()">✕</button>
    </div>
    <div class="register-dialog-body auth-dialog-body">
        <p class="auth-message">
            Qabulga yozilish uchun tizimga kirishingiz yoki yangi akkaunt yaratishingiz kerak.
        </p>
        
        <a href="{{ route('auth.login') }}" class="auth-btn auth-btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Tizimga kirish
        </a>
        
        <div class="auth-divider">
            <span>yoki</span>
        </div>
        
        <a href="{{ route('auth.register') }}" class="auth-btn auth-btn-register">
            <i class="fas fa-user-plus me-2"></i>Ro'yxatdan o'tish
        </a>
        
        <p class="auth-footer-text">
            Ro'yxatdan o'tish 1 daqiqadan kam vaqt oladi.
        </p>
    </div>
</dialog>