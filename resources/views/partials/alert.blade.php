@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

    <!-- @if(session('success'))
        <div class="alert-notification show alert-success" id="sessionAlert" style="display: flex;">
            <i class="fas fa-check-circle"></i>
            <span class="message">{{ session('success') }}</span>
            <button class="close-alert" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif -->

<div id="global-alert" class="alert-success"></div>

@if($errors->has('login'))
    <div class="alert-danger fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ $errors->first('login') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif  

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">✕</button>
    </div>
@endif

@if(session('password_cancelled'))
    <div class="alert alert-success">
        @lang('words.password_reset_successfully')<br>
        @lang('words.new_password'): {{ session('new_password') }}
    </div>
    <div class="password-cancelled-data" data-password="{{ session('new_password') }}" style="display: none;"></div>
@endif
