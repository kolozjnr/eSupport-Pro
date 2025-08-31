<x-app-layout>
    <!-- Make sure Alpine.js is loaded -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @vite(['resources/js/app.js'])
    <style>
        /* ... (your existing styles remain the same) ... */
    </style>

    <div class="page-content">
        @include('../layouts.top-header')
     
        <main class="flex-grow p-6"> 
            <!-- Page Title Start -->
            <div class="flex justify-between items-center mb-6">
                <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                            <div class="flex items-center gap-2">
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Customer</a>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Edit Customer</a>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Main Chat Container -->
            <div x-data="ticketChatApp()" x-init="init()" x-cloak>
                <!-- Error Display -->
                <div x-show="errorMessage" x-text="errorMessage" class="error-message" style="display: none;"></div>

                <div class="max-w-6xl mx-auto">
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden" style="height: 80vh;">
                        <div class="flex h-full">
                            <!-- Main Chat Area -->
                            <div class="flex-1 flex flex-col">
                                <!-- Chat Header -->
                                <div class="p-4 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="relative">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold"
                                                     x-text="otherUser.initials"></div>
                                                <div x-show="otherUser.is_online" 
                                                     class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white dark:border-slate-800 rounded-full" style="display: none;"></div>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white" 
                                                    x-text="otherUser.name || 'Support User'"></h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    <span x-show="otherUser.is_online" class="text-green-600 dark:text-green-400" style="display: none;">Online</span>
                                                    <span x-show="!otherUser.is_online" x-text="'Last seen ' + (otherUser.last_seen || 'recently')" style="display: none;"></span>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <!-- Connection Status -->
                                            <div class="flex items-center space-x-2">
                                                <div x-show="connectionStatus === 'connected'" class="flex items-center text-green-600" style="display: none;">
                                                    <i class="fas fa-circle text-xs"></i>
                                                    <span class="ml-1 text-xs">Connected</span>
                                                </div>
                                                <div x-show="connectionStatus === 'connecting'" class="flex items-center text-yellow-600" style="display: none;">
                                                    <i class="fas fa-circle text-xs animate-pulse"></i>
                                                    <span class="ml-1 text-xs">Connecting...</span>
                                                </div>
                                                <div x-show="connectionStatus === 'disconnected'" class="flex items-center text-red-600" style="display: none;">
                                                    <i class="fas fa-circle text-xs"></i>
                                                    <span class="ml-1 text-xs">Offline Mode</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Messages Area -->
                                <div class="flex-1 overflow-y-auto chat-scroll p-4 space-y-4" 
                                     x-ref="messagesContainer">
                                    
                                    <!-- Loading State -->
                                    <div x-show="isLoadingMessages" class="text-center py-12" style="display: none;">
                                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                        <p class="mt-2 text-gray-500 dark:text-gray-400">Loading messages...</p>
                                    </div>

                                    <!-- Welcome Message -->
                                    <div x-show="!isLoadingMessages && messages.length === 0" class="text-center py-12" style="display: none;">
                                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-comments text-blue-600 dark:text-blue-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Start a conversation</h3>
                                        <p class="text-gray-500 dark:text-gray-400">Send a message to begin chatting about this ticket</p>
                                    </div>

                                    <!-- Messages -->
                                    <template x-for="message in messages" :key="message.id">
                                        <div :class="message.is_mine ? 'flex justify-end' : 'flex justify-start'" class="message-enter">
                                            <div :class="message.is_mine ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-slate-700 text-gray-900 dark:text-white'" 
                                                 class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg shadow">
                                                <p class="text-sm" x-text="message.content"></p>
                                                
                                                <!-- File attachments -->
                                                <div x-show="message.attachments && message.attachments.length > 0" class="mt-2 space-y-1" style="display: none;">
                                                    <template x-for="attachment in message.attachments" :key="attachment.id">
                                                        <div class="flex items-center space-x-2 text-xs opacity-80">
                                                            <i class="fas fa-paperclip"></i>
                                                            <a :href="attachment.url" :download="attachment.filename" class="underline hover:no-underline" x-text="attachment.filename"></a>
                                                        </div>
                                                    </template>
                                                </div>

                                                <div :class="message.is_mine ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400'" 
                                                     class="text-xs mt-1 flex items-center justify-between">
                                                    <span x-text="message.formatted_time"></span>
                                                    <span x-show="message.is_mine && message.read_at" class="ml-2" style="display: none;">
                                                        <i class="fas fa-check-double text-blue-200"></i>
                                                    </span>
                                                    <span x-show="message.is_mine && !message.read_at" class="ml-2" style="display: none;">
                                                        <i class="fas fa-check text-blue-200"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Typing Indicator -->
                                    <div x-show="isTyping" class="flex justify-start" style="display: none;">
                                        <div class="bg-gray-200 dark:bg-slate-700 rounded-lg px-4 py-2 typing-indicator">
                                            <div class="flex space-x-1">
                                                <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                                                <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                                <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Input -->
                                <div class="p-4 border-t border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                                    <form @submit.prevent="sendMessage" class="flex items-end space-x-3">
                                        <!-- File Upload -->
                                        <button type="button" @click="$refs.fileInput.click()" 
                                                class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                        <input type="file" x-ref="fileInput" @change="handleFileUpload" class="hidden" multiple accept="image/*,.pdf,.doc,.docx,.txt">

                                        <!-- Message Input -->
                                        <div class="flex-1 relative">
                                            <textarea x-model="newMessage" 
                                                      @keydown.enter.prevent="handleEnterKey"
                                                      @input="handleTyping"
                                                      x-ref="messageInput"
                                                      placeholder="Type your message..."
                                                      rows="1"
                                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white resize-none overflow-hidden"
                                                      style="min-height: 40px; max-height: 120px;"
                                                      :disabled="isSending"></textarea>
                                        </div>

                                        <!-- Emoji Button -->
                                        <button type="button" @click="toggleEmojiPicker" 
                                                class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg">
                                            <i class="fas fa-smile"></i>
                                        </button>

                                        <!-- Send Button - Always visible but conditionally enabled -->
                                        <button type="submit" 
                                                :disabled="(!newMessage.trim() && selectedFiles.length === 0) || isSending"
                                                :class="{
                                                    'bg-blue-600 hover:bg-blue-700': (newMessage.trim() || selectedFiles.length > 0) && !isSending,
                                                    'bg-gray-300 dark:bg-gray-600 cursor-not-allowed': (!newMessage.trim() && selectedFiles.length === 0) || isSending
                                                }"
                                                class="p-2 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                            <i x-show="!isSending" class="fas fa-paper-plane"></i>
                                            <i x-show="isSending" class="fas fa-spinner animate-spin"></i>
                                        </button>
                                    </form>

                                    <!-- File Preview -->
                                    <div x-show="selectedFiles.length > 0" class="mt-3 flex flex-wrap gap-2" style="display: none;">
                                        <template x-for="(file, index) in selectedFiles" :key="index">
                                            <div class="relative bg-gray-100 dark:bg-slate-700 rounded-lg p-2 flex items-center space-x-2">
                                                <i class="fas fa-file text-gray-500"></i>
                                                <span class="text-sm text-gray-700 dark:text-gray-300 max-w-32 truncate" x-text="file.name"></span>
                                                <span class="text-xs text-gray-500" x-text="formatFileSize(file.size)"></span>
                                                <button type="button" @click="removeFile(index)" class="text-red-500 hover:text-red-700 ml-auto">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        // Additional initialization if needed
        console.log('Chat system loaded');
    </script>
    @endpush

 <script>
        // Global configuration - moved before Alpine initialization
        window.ChatConfig = {
            ticketId: {{ $ticket->id }},
            otherUserId: {{ $otherUser->id }},
            currentUserId: {{ auth()->id() }},
            pusherKey: '{{ config("broadcasting.connections.pusher.key") ?? "" }}',
            pusherCluster: '{{ config("broadcasting.connections.pusher.options.cluster") ?? "mt1" }}',
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.content || '',
            baseUrl: '{{ url("/") }}'
        };
        
        console.log('Chat Config:', window.ChatConfig);

        // Initialize Alpine data before DOM content is loaded
        document.addEventListener('alpine:init', () => {
            Alpine.data('ticketChatApp', () => ({
                // State - initialize with proper defaults
                ticketId: window.ChatConfig?.ticketId || null,
                otherUserId: window.ChatConfig?.otherUserId || null,
                currentUserId: window.ChatConfig?.currentUserId || null,
                messages: [],
                newMessage: '',
                isSending: false,
                isLoadingMessages: true,
                isTyping: false,
                selectedFiles: [],
                pusher: null,
                channel: null,
                typingTimer: null,
                connectionStatus: 'disconnected', // connected, connecting, disconnected
                errorMessage: '',
                pollingInterval: null,
                
                otherUser: {
                    id: window.ChatConfig?.otherUserId || null,
                    name: '{{ $otherUser->fname ?? "Support" }} {{ $otherUser->lname ?? "User" }}',
                    initials: '{{ substr(($otherUser->fname ?? "S"), 0, 1) . substr(($otherUser->lname ?? "U"), 0, 1) }}',
                    is_online: false,
                    last_seen: ''
                },
                
                // Initialize
                init() {
            console.log('Alpine.js initializing chat app...');
            
            // Debug ChatConfig
            console.log('ChatConfig available:', window.ChatConfig);
            console.log('Pusher key:', window.ChatConfig?.pusherKey);
            console.log('Pusher cluster:', window.ChatConfig?.pusherCluster);
            
            if (!window.ChatConfig) {
                console.error('Chat configuration is missing');
                this.showError('Chat configuration is missing');
                return;
            }

            // Validate Pusher credentials
            if (!window.ChatConfig.pusherKey || window.ChatConfig.pusherKey.trim() === '') {
                console.error('Pusher key is missing or empty');
                this.showError('Real-time connection not configured');
                this.setupPolling(); // Use polling as fallback
                return;
            }

            // Set initial values
            this.ticketId = window.ChatConfig.ticketId;
            this.otherUserId = window.ChatConfig.otherUserId;
            this.currentUserId = window.ChatConfig.currentUserId;
            this.otherUser.id = this.otherUserId;
            this.otherUser.initials = this.getInitials(this.otherUser.name);
            
            // Initialize Echo if available
            if (window.Echo) {
                console.log('Echo is available, proceeding with real-time setup');
            } else {
                console.warn('Echo is not available, will use polling');
            }
            
            // Start loading with delay
            setTimeout(() => {
                this.loadOtherUserInfo();
                this.loadMessages();
                this.initializeRealtimeConnection();
            }, 100);
        },


                // Error handling
                showError(message) {
                    this.errorMessage = message;
                    console.error('Chat Error:', message);
                    setTimeout(() => {
                        this.errorMessage = '';
                    }, 5000);
                },

                // Load other user info
                async loadOtherUserInfo() {
                    try {
                        // Use the correct API endpoint
                        const response = await this.makeApiCall(`/dashboard/chat/ticket/${this.ticketId}/conversation`);
                        if (response.ok) {
                            const data = await response.json();
                            console.log('Conversation API response:', data);
                            
                            if (data.other_user) {
                                this.otherUser = {
                                    ...this.otherUser,
                                    ...data.other_user,
                                    name: data.other_user.name || this.otherUser.name,
                                    initials: data.other_user.initials || this.getInitials(data.other_user.name || this.otherUser.name)
                                };
                            }
                        } else {
                            console.error('Failed to load conversation:', response.status);
                        }
                    } catch (error) {
                        console.log('Could not load extended user info:', error.message);
                        // This is not critical, we have basic info
                    }
                },

                // Get initials from name
                getInitials(name) {
                    if (!name || typeof name !== 'string') return '??';
                    return name.split(' ')
                        .map(n => n.charAt(0))
                        .join('')
                        .toUpperCase()
                        .substring(0, 2);
                },

                // Initialize real-time connection with fallback
                initializeRealtimeConnection() {
                    if (window.ChatConfig.pusherKey && window.ChatConfig.pusherKey.trim()) {
                        this.initializePusher();
                    } else {
                        console.log('Pusher not configured, using polling fallback');
                        this.setupPolling();
                    }
                },

                // Pusher Setup
                initializePusher() {
            console.log('Initializing real-time connection...');
            this.connectionStatus = 'connecting';
            
            try {
                // Check if Echo is available and properly initialized
                if (!window.Echo) {
                    console.error('Laravel Echo is not initialized');
                    this.setupPolling();
                    return;
                }

                // Get the underlying Pusher connection for status monitoring
                this.pusher = window.Echo.connector.pusher;
                
                // Connection event handlers
                this.pusher.connection.bind('connected', () => {
                    console.log('Pusher connected successfully');
                    this.connectionStatus = 'connected';
                    this.clearPolling();
                });

                this.pusher.connection.bind('disconnected', () => {
                    console.log('Pusher disconnected');
                    this.connectionStatus = 'disconnected';
                    this.setupPolling();
                });

                this.pusher.connection.bind('error', (error) => {
                    console.error('Pusher connection error:', error);
                    this.connectionStatus = 'disconnected';
                    this.setupPolling();
                });

                // Subscribe to the ticket channel using Echo
                const channelName = `ticket.${this.ticketId}`;
                console.log('Subscribing to channel via Echo:', channelName);

                this.channel = window.Echo.private(channelName);

                
                this.channel.listen('.new-message', (data) => {
                    console.log('✅ Received new message:', data);
                    const message = data.message;
                    message.is_mine = message.user_id === this.currentUserId;
                    
                    console.log('Message processed:', message);
                    console.log('Is mine?', message.is_mine, 'User ID:', message.user_id, 'Current User:', this.currentUserId);
                    
                    this.handleNewMessage(data);
                });

                this.channel.listen('.UserTyping', (data) => {
                    if (data.user_id !== this.currentUserId) {
                        this.handleTypingIndicator(data);
                    }
                });

                
                console.log('Echo channel subscription completed');

            } catch (error) {
                console.error('Error initializing real-time connection:', error);
                this.connectionStatus = 'disconnected';
                this.setupPolling();
            }
        },

                // Fallback polling mechanism
                setupPolling() {
                    if (this.pollingInterval) return; // Already polling
                    
                    console.log('Setting up polling for real-time updates');
                    this.pollingInterval = setInterval(() => {
                        this.loadNewMessages();
                    }, 3000); // Poll every 3 seconds
                },

                clearPolling() {
                    if (this.pollingInterval) {
                        clearInterval(this.pollingInterval);
                        this.pollingInterval = null;
                    }
                },

                // Load messages
                async loadMessages() {
                    this.isLoadingMessages = true;
                    try {
                        const response = await this.makeApiCall(`/dashboard/chat/ticket/${this.ticketId}/messages`);
                        if (response.ok) {
                            const messages = await response.json();
                            
                            // Set is_mine for each message
                            this.messages = messages.map(message => ({
                                ...message,
                                is_mine: message.user_id === this.currentUserId
                            }));
                            
                            console.log('Messages loaded:', this.messages.length);
                            // Mark messages as read
                            this.markAsRead();
                        } else {
                            console.log('Message endpoint failed with status:', response.status);
                            this.messages = [];
                        }
                    } catch (error) {
                        console.error('Error loading messages:', error);
                        this.messages = [];
                    } finally {
                        this.isLoadingMessages = false;
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                    }
                },

                // Load only new messages (for polling)
                async loadNewMessages() {
                try {
                    const lastMessageId = this.messages.length > 0 ? Math.max(...this.messages.map(m => m.id)) : 0;
                    const response = await this.makeApiCall(`/dashboard/chat/ticket/${this.ticketId}/messages?after=${lastMessageId}`);
                    
                    if (response.ok) {
                        const newMessages = await response.json();
                        if (Array.isArray(newMessages) && newMessages.length > 0) {
                            // Filter out messages we already have and set is_mine
                            const filteredMessages = newMessages
                                .filter(msg => !this.messages.find(existing => existing.id === msg.id))
                                .map(message => ({
                                    ...message,
                                    is_mine: message.user_id === this.currentUserId
                                }));
                            
                            if (filteredMessages.length > 0) {
                                this.messages = [...this.messages, ...filteredMessages];
                                this.$nextTick(() => {
                                    this.scrollToBottom();
                                });
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error loading new messages:', error);
                }
            },

                // Make API calls with proper error handling
                async makeApiCall(endpoint, options = {}) {
                    const url = endpoint.startsWith('http') ? endpoint : `${window.ChatConfig.baseUrl}${endpoint.startsWith('/') ? '' : '/'}${endpoint}`;
                    
                    const defaultOptions = {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': window.ChatConfig.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    };

                    // Don't set Content-Type for FormData - let browser handle it
                    if (!(options.body instanceof FormData)) {
                        defaultOptions.headers['Content-Type'] = 'application/json';
                    }

                    const finalOptions = {
                        ...defaultOptions,
                        ...options,
                        headers: {
                            ...defaultOptions.headers,
                            ...options.headers
                        }
                    };

                    // For FormData, ensure we don't have Content-Type in the final headers
                    if (options.body instanceof FormData && finalOptions.headers['Content-Type']) {
                        delete finalOptions.headers['Content-Type'];
                    }

                    return fetch(url, finalOptions);
                },

                // Send message
                async sendMessage() {
                    if ((!this.newMessage.trim() && this.selectedFiles.length === 0) || this.isSending) {
                        return;
                    }

                    this.isSending = true;
                    const messageContent = this.newMessage.trim();
                    const files = [...this.selectedFiles];
                    
                    this.newMessage = '';
                    this.selectedFiles = [];

                    try {
                        const formData = new FormData();
                        
                        if (messageContent) {
                            formData.append('content', messageContent);
                        }
                        
                        files.forEach((file, index) => {
                            formData.append(`files[${index}]`, file);
                        });

                        // Use a simple fetch without the makeApiCall wrapper
                        const response = await fetch(`/dashboard/chat/ticket/${this.ticketId}/message`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': window.ChatConfig.csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        if (response.ok) {
                            const result = await response.json();
                            if (this.connectionStatus !== 'connected') {
                                this.messages.push(result);
                            }
                            this.$nextTick(() => this.scrollToBottom());
                        } else {
                            throw new Error(`HTTP ${response.status}`);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.newMessage = messageContent;
                        this.selectedFiles = files;
                        this.showError('Failed to send message');
                    } finally {
                        this.isSending = false;
                    }
                },

                // Mark messages as read
                async markAsRead() {
                    try {
                        await this.makeApiCall(`/dashboard/chat/ticket/${this.ticketId}/read`, {
                            method: 'POST'
                        });
                    } catch (error) {
                        console.log('Could not mark messages as read:', error);
                    }
                },

                // Handle new message from real-time events
                handleNewMessage(data) {
                    // Ensure is_mine is set if not already
                    if (data.message.is_mine === undefined) {
                        data.message.is_mine = data.message.user_id === this.currentUserId;
                    }
                    
                    // Avoid duplicate messages
                    const exists = this.messages.find(msg => msg.id === data.message.id);
                    if (!exists) {
                        this.messages.push(data.message);
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                        // Mark new message as read if chat is active
                        this.markAsRead();
                    }
                },

                // Handle typing indicator
                handleTypingIndicator(data) {
                    this.isTyping = true;
                    clearTimeout(this.typingTimer);
                    this.typingTimer = setTimeout(() => {
                        this.isTyping = false;
                    }, 3000);
                },

                // Handle typing
                handleTyping() {
                    // Only send typing indicator if connected to real-time
                    if (this.connectionStatus === 'connected') {
                        clearTimeout(this.typingTimer);
                        
                        this.makeApiCall(`/dashboard/chat/ticket/${this.ticketId}/typing`, {
                            method: 'POST'
                        }).catch(error => {
                            console.log('Could not send typing indicator:', error);
                        });
                    }
                },

                // Handle Enter key
                handleEnterKey(event) {
                    if (event.shiftKey) {
                        return; // Allow new line with Shift+Enter
                    }
                    event.preventDefault();
                    this.sendMessage();
                },

                // File handling
                handleFileUpload(event) {
                    const files = Array.from(event.target.files);
                    const maxSize = 10 * 1024 * 1024; // 10MB
                    const maxFiles = 5;
                    const allowedTypes = [
                        'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                        'application/pdf',
                        'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'text/plain'
                    ];
                    
                    const validFiles = files.filter(file => {
                        if (file.size > maxSize) {
                            this.showError(`File "${file.name}" is too large. Maximum size is 10MB.`);
                            return false;
                        }
                        
                        if (!allowedTypes.includes(file.type)) {
                            this.showError(`File type "${file.type}" is not allowed.`);
                            return false;
                        }
                        
                        return true;
                    });
                    
                    if (this.selectedFiles.length + validFiles.length > maxFiles) {
                        this.showError(`You can only upload a maximum of ${maxFiles} files at once.`);
                        return;
                    }
                    
                    this.selectedFiles = [...this.selectedFiles, ...validFiles];
                    event.target.value = ''; // Reset input
                },

                removeFile(index) {
                    this.selectedFiles.splice(index, 1);
                },

                // Format file size
                formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                },

                // Emoji picker (basic implementation)
                toggleEmojiPicker() {
                    const emojis = ['😊', '😂', '❤️', '👍', '👎', '😢', '😮', '😡', '🎉', '💯', '🔥', '✨', '🤔', '👏', '🙌', '💪'];
                    const selectedEmoji = emojis[Math.floor(Math.random() * emojis.length)];
                    this.newMessage += selectedEmoji;
                    this.$refs.messageInput.focus();
                },

                // Utility functions
                scrollToBottom() {
                    const container = this.$refs.messagesContainer;
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                },

                // Cleanup
                destroy() {
                    this.clearPolling();
                    if (this.pusher) {
                        this.pusher.disconnect();
                    }
                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }
                }
            }));
        });

        // Auto-resize textarea
        document.addEventListener('input', function(event) {
            if (event.target.matches('textarea[x-model="newMessage"]')) {
                event.target.style.height = 'auto';
                event.target.style.height = Math.min(event.target.scrollHeight, 120) + 'px';
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            // Alpine.js will handle cleanup automatically
        });
    </script>

    @include('layouts.footer')
</x-app-layout>