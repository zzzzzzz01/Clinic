<x-layouts.main.website>
    <x-slot:title>
        @lang('words.notifications')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/notifications.css') }}" />

    <div class="main-content">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main.page')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @lang('words.notifications')
                    </li>
                </ol>
            </nav>

            <!-- Search Card -->
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="mb-0"> 
                            @lang('words.notifications')
                            <span class="notification-count">{{ $unreadCount }}</span>
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Mark All Read Container -->
            <div class="mark-all-read-container">
                <form action="{{ route('notification.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="mark-all-read">
                        <i class="fas fa-check-double"></i> @lang('words.mark_all_read')
                    </button>
                </form>
            </div>

            <!-- Notifications List -->
            <div class="notifications-list">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                            <div class="notification-avatar" style="background-color: {{ $notification->bgColor }};">
                                {{ $notification->senderInitials }}
                            </div>
                            
                            <div class="notification-content">
                                <div class="notification-header">
                                    <div class="notification-title">
                                        {{ $notification->displayTitle }}
                                        <span class="notification-type {{ $notification->typeClass }}">{{ $notification->typeText }}</span>
                                    </div>
                                    <div class="notification-time">
                                        {{ $notification->timeAgo }}
                                    </div>
                                </div>
                                
                                <div class="notification-message">
                                    {{ $notification->displayMessage }}
                                </div>
                                
                                <div class="notification-actions">
                                    <form action=" {{ route('notification.destroy', $notification->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="notification-action-btn action-delete">
                                            <i class="fas fa-trash"></i> @lang('words.delete')
                                        </button>
                                    </form>
                                    
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notification.read', $notification->id) }} " method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="notification-action-btn action-mark-read">
                                                <i class="fas fa-check"></i> @lang('words.mark_read')
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-bell-slash"></i>
                        </div>
                        <h3>@lang('words.no_notifications')</h3>
                        <p>@lang('words.no_notifications_desc')</p>     
                    </div>
                @endif
            </div>
            
            <!-- Pagination -->  

            @include('partials.paginations.notification')

        </div>
    </div>

</x-layouts.main.website>