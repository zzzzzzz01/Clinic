<x-layouts.main.website>
    <x-slot:title>
        @lang('words.my_profile')
    </x-slot:title>
    <link rel="stylesheet" href="{{ asset('temp2/css/profil.css') }}" />

    <!-- Breadcrumb Navigation -->
    <div class="container pt-4"> 

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.my_profile')
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.my_profile')</h4>
                    </div>
                </div>
            </div>
        </div> 
    </div>  

    <div class="container"> 

        <div class="profile-card">
            <!-- Left Column - Rasm -->
            <div class="profile-left">
                <div class="profile-image">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" alt="@lang('words.profile_photo')">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                    <form action="" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        <label class="avatar-upload" for="profile_photo">
                            <i class="fas fa-camera"></i>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*" onchange="document.getElementById('photoForm').submit()">
                        </label>
                    </form>
                </div>
            </div>

            <!-- Right Column - Ma'lumotlar -->
            <div class="profile-right"> 

                <!-- Ismi -->
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user"></i>
                            @lang('words.name')
                        </div>
                        <div class="info-value">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                <!-- Familiya -->
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user-tag"></i>
                            @lang('words.last_name')
                        </div>
                        <div class="info-value">{{ auth()->user()->last_name }}</div>
                    </div>
                </div>

                <!-- Login -->
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-sign-in-alt"></i>
                            @lang('words.login')
                        </div>
                        <div class="info-value highlight">{{ auth()->user()->login }}</div>
                    </div>
                </div>

                <!-- Pasport raqami -->
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-label" style="width: 50%;">
                            <i class="fas fa-passport"></i>
                            @lang('words.passport_number')
                        </div>
                        <div class="info-value">
                            @if(auth()->user()->passport_number)
                                {{ auth()->user()->passport_number }}
                            @else
                                <span class="empty">@lang('words.not_provided')</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            @lang('words.email')
                        </div>
                        <div class="info-value">
                            @if(auth()->user()->email)
                                {{ auth()->user()->email }}
                            @else
                                <span class="empty">@lang('words.not_provided')</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Telefon -->
                <div class="info-section">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-phone-alt"></i>
                            @lang('words.phone')
                        </div>
                        <div class="info-value">
                            @if(auth()->user()->phone)
                                {{ auth()->user()->phone }}
                            @else
                                <span class="empty">@lang('words.not_provided')</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Parolni o'zgartirish -->
                <div class="password-section">
                    <h3>@lang('words.change_password')</h3>
                    
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="password-form">
                            <div class="info-section">
                                <div class="info-item">
                                    <div class="info-label" style="width: 50%;">
                                        <i class="fa-solid fa-shield-halved"></i>
                                        @lang('words.current_password')
                                    </div>
                                    <div class="info-value" style="width: 50%;">
                                        <input type="password" class="form-control" name="current_password" placeholder="@lang('words.enter_current_password')" required>
                                    </div>
                                </div>
                            </div>
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror 

                            <div class="info-section">
                                <div class="info-item">
                                    <div class="info-label" style="width: 50%;">
                                        <i class="fas fa-key"></i>
                                        @lang('words.new_password')
                                    </div>
                                    <div class="info-value" style="width: 50%;">
                                        <input type="password" class="form-control" name="new_password" placeholder="@lang('words.enter_new_password')" required>
                                    </div>
                                </div>
                            </div> 

                            <div class="info-section">
                                <div class="info-item">
                                    <div class="info-label" style="width: 50%;">
                                        <i class="fas fa-check-circle"></i>
                                        @lang('words.confirm_new_password')
                                    </div>
                                    <div class="info-value" style="width: 50%;">
                                        <input type="password" class="form-control" name="new_password_confirmation" placeholder="@lang('words.repeat_new_password')" required>
                                    </div>
                                </div>
                            </div>
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn-primary"> 
                                @lang('words.change_password')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 

</x-layouts.main.website>