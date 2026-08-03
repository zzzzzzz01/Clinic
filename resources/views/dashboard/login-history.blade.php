<x-layouts.main.website>
    <x-slot:title>
        @lang('words.login_history_title')
    </x-slot:title>

    <div class="container pt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main_page')
                    </a>
                </li>
                <li class="breadcrumb-item active">@lang('words.login_history')</li>
            </ol>
        </nav>

        <!-- Search Card -->
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.login_history')</h4>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="main-content"> 
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr> 
                            <th>@lang('words.ip_address')</th>
                            <th>@lang('words.login')</th>
                            <th class="device-header">@lang('words.device')</th> 
                            <th>@lang('words.browser')</th>
                            <th class="time-header">@lang('words.login_time')</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr> 
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $history->ip_address }}
                                    </span>
                                </td>
                                <td>
                                    {{ $history->user->login }}
                                </td>
                                <td class="device-cell">
                                    <span class="device-name">{{ $history->device }}</span>
                                    <span class="device-platform">{{ $history->platform }}</span>
                                </td> 
                                <td>
                                    {{ $history->browser }}
                                </td>
                                <td class="time-cell">
                                    <span class="time-date">{{ \Carbon\Carbon::parse($history->login_at)->format('d.m.Y') }}</span>
                                    <span class="time-time">{{ \Carbon\Carbon::parse($history->login_at)->format('H:i:s') }}</span>
                                </td> 
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"> 
                                        <p>@lang('words.no_login_history')</p>
                                    </div>
                                </td>
                            </tr> 
                        @endforelse
                    </tbody>
                </table>
            </div> 

            @include('partials.paginations.login-history')
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('temp2/css/login-history.css') }}" />
</x-layouts.main.website>