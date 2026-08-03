<x-layouts.main.website>
    <x-slot:title>
        @lang('words.messages')
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/chat.css') }}" />

    <!-- Breadcrumb Navigation -->
    <div class="container pt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @lang('words.messages')
                </li>
            </ol>
        </nav>

        <!-- Search Card -->
        <div class="search-card">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h4 class="mb-0"> 
                        @lang('words.messages')
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="chat-container"> 

        <!-- Main Chat Area -->
        <div class="chat-main">
            <!-- Contacts Sidebar -->
            <div class="contacts-sidebar active" id="contactsSidebar">
                <div class="contacts-header">
                    <h4><i class="fas fa-users"></i> @lang('words.contacts')</h4>
                </div>
                
                <div class="search-box">
                    <input type="text" placeholder="@lang('words.search_by_name')" id="contactSearch" autocomplete="off">
                    <i class="fas fa-search"></i>
                    
                    <!-- Search Results -->
                    <div class="search-results" id="searchResults"></div>
                </div>
                
                <div class="contacts-list" id="contactsList">
                    <!-- Suhbatdoshlar ro'yxati - backend dan kelgan myChats orqali -->
                    @forelse($myChats as $chat)
                        <div class="contact-item" data-id="{{ $chat->id }}" data-name="{{ $chat->name }} {{ $chat->last_name }}">
                            <div class="contact-avatar">
                                {{ substr($chat->name, 0, 1) }}{{ substr($chat->last_name, 0, 1) }}
                            </div>
                            <div class="contact-info">
                                <div class="contact-name">{{ $chat->name }} {{ $chat->last_name }}</div>
                                <div class="contact-last-message">
                                    @php
                                        $lastMessage = App\Models\ChMessage::where(function($q) use ($chat) {
                                            $q->where('from_id', auth()->id())->where('to_id', $chat->id);
                                        })->orWhere(function($q) use ($chat) {
                                            $q->where('from_id', $chat->id)->where('to_id', auth()->id());
                                        })->latest()->first();
                                    @endphp
                                    @if($lastMessage)
                                        {{ Str::limit($lastMessage->message, 25) }}
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="contact-time">
                                    @if($lastMessage)
                                        {{ $lastMessage->created_at->format('H:i') }}
                                    @endif
                                </div>
                                @php
                                    $unreadCount = App\Models\ChMessage::where('from_id', $chat->id)
                                        ->where('to_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <div class="unread-badge mt-1">{{ $unreadCount }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 30px; color: var(--gray-color);">
                            <i class="fas fa-comments" style="font-size: 50px; margin-bottom: 15px; color: #e2e8f0;"></i>
                            <h5 style="margin-bottom: 10px;">@lang('words.no_chats_yet')</h5>
                            <p style="font-size: 13px;">@lang('words.start_new_chat')</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Chat Area -->
            <div class="chat-area" id="chatArea">
                <!-- Chat Header -->
                <div class="chat-header-bar">
                    <div class="current-chat-info">
                        <button class="mobile-back-button" id="backToContactsBtn">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div class="user-avatar" id="currentChatAvatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h4 id="currentChatName">@lang('words.select_chat')</h4>
                            <div class="chat-status" id="currentChatStatus">
                                <i class="fas fa-circle" style="color: #95a5a6"></i> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="chat-actions">
                        <button type="button" title="@lang('words.video_call')" disabled style="opacity: 0.5;">
                            <i class="fas fa-video"></i>
                        </button>
                        <button type="button" title="@lang('words.audio_call')" disabled style="opacity: 0.5;">
                            <i class="fas fa-phone"></i>
                        </button>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="messages-area" id="messagesArea">
                    <div class="empty-chat">
                        <!-- <i class="fas fa-search"></i> -->
                        <h4>@lang('words.select_contact')</h4>
                        <!-- <p>Chapdagi qidiruv orqali userlarni toping va suhbat boshlang</p> -->
                    </div>
                </div>

                <!-- Message Input -->
                <div class="message-input-area">
                    <div class="input-actions">
                        <button type="button" title="@lang('words.add_file')" disabled style="opacity: 0.5;">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <button type="button" title="@lang('words.send_image')" disabled style="opacity: 0.5;">
                            <i class="fas fa-image"></i>
                        </button>
                    </div>
                    
                    <input type="text" class="message-input" id="messageInput" 
                           placeholder="@lang('words.select_contact_first')" disabled>
                    
                    <div class="input-actions">
                        <button type="button" class="send-button" id="sendButton" disabled>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactsSidebar = document.getElementById('contactsSidebar');
            const chatArea = document.getElementById('chatArea');
            const backButton = document.getElementById('backToContactsBtn');
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.getElementById('sendButton');
            const messagesArea = document.getElementById('messagesArea');
            const breadcrumb = document.querySelector('.container.pt-4');
            const chatHeader = document.querySelector('.chat-header');
            const searchInput = document.getElementById('contactSearch');
            const searchResults = document.getElementById('searchResults');
            
            let currentUserId = null;
            let currentUserName = '';
            let currentUserAvatar = '';
            let messageInterval = null;
            let lastMessageId = 0; // Oxirgi xabar ID sini saqlash
            
            // Users data from Laravel (barcha userlar)
            const users = [
                @foreach($users as $user)
                {
                    id: {{ $user->id }},
                    name: "{{ $user->name }} {{ $user->last_name }}",
                    firstName: "{{ $user->name }}",
                    lastName: "{{ $user->last_name }}",
                    avatar: "{{ substr($user->name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}"
                },
                @endforeach
            ];

            // Search input event
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                
                if (searchTerm.length < 2) {
                    searchResults.classList.remove('show');
                    return;
                }
                
                // Filter users
                const filteredUsers = users.filter(user => 
                    user.name.toLowerCase().includes(searchTerm)
                );
                
                if (filteredUsers.length > 0) {
                    displaySearchResults(filteredUsers);
                } else {
                    searchResults.innerHTML = `
                        <div style="padding: 15px; text-align: center; color: var(--gray-color);">
                            <i class="fas fa-user-slash"></i> Hech narsa topilmadi
                        </div>
                    `;
                    searchResults.classList.add('show');
                }
            });

            // Display search results
            function displaySearchResults(users) {
                let html = '';
                
                users.forEach(user => {
                    html += `
                        <div class="search-result-item" data-id="${user.id}" data-name="${user.name}" data-avatar="${user.avatar}">
                            <div class="result-avatar">${user.avatar}</div>
                            <div class="result-info">
                                <h5>${user.name}</h5>
                                <p>Yangi suhbat</p>
                            </div>
                            <span class="start-chat-badge">
                                <i class="fas fa-comment"></i> Suhbat
                            </span>
                        </div>
                    `;
                });
                
                searchResults.innerHTML = html;
                searchResults.classList.add('show');
                
                // Add click events to search results
                document.querySelectorAll('.search-result-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const userId = parseInt(this.dataset.id);
                        const userName = this.dataset.name;
                        const userAvatar = this.dataset.avatar;
                        
                        openChat(userId, userName, userAvatar);
                        searchResults.classList.remove('show');
                        searchInput.value = '';
                    });
                });
            }

            // Open chat
            function openChat(userId, userName, userAvatar) {
                // Stop previous interval
                if (messageInterval) {
                    clearInterval(messageInterval);
                }
                
                // Set current user
                currentUserId = userId;
                currentUserName = userName;
                currentUserAvatar = userAvatar;
                lastMessageId = 0; // Reset last message ID
                
                // Update chat header
                document.getElementById('currentChatName').textContent = userName;
                document.getElementById('currentChatAvatar').innerHTML = userAvatar;
                document.getElementById('currentChatStatus').innerHTML = `
                    <i class="fas fa-circle" style="color: #2ecc71"></i> Online
                `;
                
                // Enable input
                messageInput.disabled = false;
                sendButton.disabled = false;
                messageInput.placeholder = `${userName} ga xabar yozing...`;
                
                // Load messages
                loadMessages(userId, false);
                
                // Start polling for new messages (har 5 sekundda)
                messageInterval = setInterval(() => {
                    if (currentUserId) {
                        checkNewMessages(currentUserId);
                    }
                }, 5000);
                
                // Mobile: show chat area
                if (window.innerWidth <= 768) {
                    contactsSidebar.classList.remove('active');
                    chatArea.classList.add('active');
                    if (breadcrumb) breadcrumb.style.display = 'none';
                    if (chatHeader) chatHeader.style.display = 'none';
                }
                
                // Update active state in contacts list
                document.querySelectorAll('.contact-item').forEach(item => {
                    item.classList.remove('active');
                    if (parseInt(item.dataset.id) === userId) {
                        item.classList.add('active');
                    }
                });
            }

            // Load messages from server
            function loadMessages(userId, isPolling = false) {
                fetch(`/chat/messages/${userId}`)
                    .then(response => response.json())
                    .then(messages => {
                        if (messages.length > 0) {
                            if (!isPolling) {
                                // Birinchi marta yuklanganda hamma xabarlarni ko'rsat
                                displayAllMessages(messages);
                                // Update last message ID
                                lastMessageId = messages[messages.length - 1].id;
                            }
                        } else if (!isPolling) {
                            // Show empty state for new chat
                            messagesArea.innerHTML = `
                                <div class="empty-chat">
                                    <div class="user-avatar" style="width: 80px; height: 80px; font-size: 32px; margin: 0 auto 20px;">${currentUserAvatar}</div>
                                    <h4>${currentUserName} bilan suhbat</h4>
                                    <p>Hali xabarlar yo'q. Birinchi xabarni yozing!</p>
                                </div>
                            `;
                        }
                    });
            }

            // Check for new messages only
            function checkNewMessages(userId) {
                fetch(`/chat/messages/${userId}`)
                    .then(response => response.json())
                    .then(messages => {
                        if (messages.length > 0) {
                            // Find messages newer than lastMessageId
                            const newMessages = messages.filter(msg => msg.id > lastMessageId);
                            
                            if (newMessages.length > 0) {
                                // Add only new messages
                                addNewMessages(newMessages);
                                // Update last message ID
                                lastMessageId = messages[messages.length - 1].id;
                            }
                        }
                    });
            }

            // Display all messages (first time)
            function displayAllMessages(messages) {
                let html = '';
                let lastDate = '';
                
                messages.forEach(msg => {
                    const msgDate = new Date(msg.created_at).toLocaleDateString('uz-UZ', { 
                        day: 'numeric', 
                        month: 'long' 
                    });
                    
                    if (msgDate !== lastDate) {
                        html += `<div class="message-date">${msgDate}</div>`;
                        lastDate = msgDate;
                    }
                    
                    const time = new Date(msg.created_at).toLocaleTimeString('uz-UZ', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    
                    const isSent = msg.from_id === {{ auth()->id() }};
                    
                    let statusIcon = '';
                    if (isSent) {
                        if (msg.is_read) {
                            statusIcon = '<i class="fas fa-check-double"></i>';
                        } else {
                            statusIcon = '<i class="fas fa-check"></i>';
                        }
                    }
                    
                    html += `
                        <div class="message ${isSent ? 'sent' : 'received'}">
                            <div class="message-content">${escapeHtml(msg.message)}</div>
                            <div class="message-time">
                                ${time}
                                ${isSent ? '<span class="message-status">' + statusIcon + '</span>' : ''}
                            </div>
                        </div>
                    `;
                });
                
                messagesArea.innerHTML = html;
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }

            // Add only new messages to existing chat
            function addNewMessages(newMessages) {
                // Agar messagesArea da xabarlar bo'lmasa, avval date qo'shish kerak
                if (messagesArea.children.length === 0 || 
                    (messagesArea.children.length === 1 && messagesArea.firstChild.classList.contains('empty-chat'))) {
                    // Agar empty-chat bo'lsa, uni tozalab, yangi date qo'shamiz
                    messagesArea.innerHTML = '';
                    const dateElement = document.createElement('div');
                    dateElement.className = 'message-date';
                    dateElement.textContent = new Date().toLocaleDateString('uz-UZ', { 
                        day: 'numeric', 
                        month: 'long' 
                    });
                    messagesArea.appendChild(dateElement);
                }
                
                // Oxirgi element date bo'lsa, uning ostiga qo'shamiz
                const lastElement = messagesArea.lastElementChild;
                const lastDate = lastElement && lastElement.classList.contains('message-date') 
                    ? lastElement.textContent 
                    : null;
                
                newMessages.forEach(msg => {
                    const msgDate = new Date(msg.created_at).toLocaleDateString('uz-UZ', { 
                        day: 'numeric', 
                        month: 'long' 
                    });
                    
                    // Agar sana o'zgargan bo'lsa, yangi date qo'shish
                    if (msgDate !== lastDate) {
                        const dateElement = document.createElement('div');
                        dateElement.className = 'message-date';
                        dateElement.textContent = msgDate;
                        messagesArea.appendChild(dateElement);
                    }
                    
                    const time = new Date(msg.created_at).toLocaleTimeString('uz-UZ', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    
                    const isSent = msg.from_id === {{ auth()->id() }};
                    
                    let statusIcon = '';
                    if (isSent) {
                        if (msg.is_read) {
                            statusIcon = '<i class="fas fa-check-double"></i>';
                        } else {
                            statusIcon = '<i class="fas fa-check"></i>';
                        }
                    }
                    
                    const messageElement = document.createElement('div');
                    messageElement.className = `message ${isSent ? 'sent' : 'received'}`;
                    messageElement.innerHTML = `
                        <div class="message-content">${escapeHtml(msg.message)}</div>
                        <div class="message-time">
                            ${time}
                            ${isSent ? '<span class="message-status">' + statusIcon + '</span>' : ''}
                        </div>
                    `;
                    
                    messagesArea.appendChild(messageElement);
                });
                
                // Scroll to bottom
                messagesArea.scrollTop = messagesArea.scrollHeight;
                
                // Update unread count in contacts list
                updateUnreadCount(currentUserId);
            }

            // Update unread count in contacts list
            function updateUnreadCount(userId) {
                const contactItem = document.querySelector(`.contact-item[data-id="${userId}"]`);
                if (contactItem) {
                    // Unread count ni 0 ga tushirish
                    const unreadBadge = contactItem.querySelector('.unread-badge');
                    if (unreadBadge) {
                        unreadBadge.remove();
                    }
                }
            }

            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Send message
            function sendMessage() {
                const message = messageInput.value.trim();
                
                if (!message || !currentUserId) return;
                
                // Send to server
                fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        to_id: currentUserId,
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        messageInput.value = '';
                        // Yangi xabarlarni tekshirish (o'zimiz yuborgan xabar ham qo'shiladi)
                        checkNewMessages(currentUserId);
                    }
                });
            }

            // Back button click handler
            backButton.addEventListener('click', function() {
                contactsSidebar.classList.add('active');
                chatArea.classList.remove('active');
                
                if (window.innerWidth <= 768) {
                    if (breadcrumb) breadcrumb.style.display = '';
                    if (chatHeader) chatHeader.style.display = '';
                }
            });

            // Contact item click event (existing chats)
            document.querySelectorAll('.contact-item').forEach(item => {
                item.addEventListener('click', function() {
                    const userId = parseInt(this.dataset.id);
                    const userName = this.dataset.name;
                    const userAvatar = this.querySelector('.contact-avatar').textContent;
                    
                    openChat(userId, userName, userAvatar);
                });
            });

            // Send message on Enter
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Send button click
            sendButton.addEventListener('click', sendMessage);

            // Click outside to close search results
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.remove('show');
                }
            });

            // Window resize handler
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    contactsSidebar.classList.add('active');
                    chatArea.classList.remove('active');
                    
                    if (breadcrumb) breadcrumb.style.display = '';
                    if (chatHeader) chatHeader.style.display = '';
                }
            });

            // Cleanup on page unload
            window.addEventListener('beforeunload', function() {
                if (messageInterval) {
                    clearInterval(messageInterval);
                }
            });
        });
    </script>

</x-layouts.main.website>