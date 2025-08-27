
    <style>
        @import url('https://cdn.jsdelivr.net/npm/@mgc_icons/core@1.0.0/index.css');
        
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --light-bg: #f8fafc;
            --dark-bg: #0f172a;
        }
        
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body>
    <!-- Topbar Start -->
    <header class="app-header flex items-center px-4 gap-3">
        <!-- Sidenav Menu Toggle Button -->
        <button id="button-toggle-menu" class="nav-link p-2">
            <span class="sr-only">Menu Toggle Button</span>
            <span class="flex items-center justify-center h-6 w-6">
                <i class="mgc_menu_line text-xl"></i>
            </span>
        </button>

        <!-- Topbar Brand Logo -->
        <a href="index.html" class="logo-box">
            <!-- Light Brand Logo -->
            <div class="logo-light">
                <img src="https://via.placeholder.com/150x40/3b82f6/ffffff?text=Logo+Light" class="logo-lg h-6" alt="Light logo">
                <img src="https://via.placeholder.com/40x40/3b82f6/ffffff?text=SM" class="logo-sm" alt="Small logo">
            </div>

            <!-- Dark Brand Logo -->
            <div class="logo-dark">
                <img src="https://via.placeholder.com/150x40/1e293b/ffffff?text=Logo+Dark" class="logo-lg h-6" alt="Dark logo">
                <img src="https://via.placeholder.com/40x40/1e293b/ffffff?text=SM" class="logo-sm" alt="Small logo">
            </div>
        </a>

        <!-- Topbar Search Modal Button -->
        <button type="button" data-fc-type="modal" data-fc-target="topbar-search-modal" class="nav-link p-2 me-auto">
            <span class="sr-only">Search</span>
            <span class="flex items-center justify-center h-6 w-6">
                <i class="mgc_search_line text-2xl"></i>
            </span>
        </button>

        <!-- Fullscreen Toggle Button -->
        <div class="md:flex hidden">
            <button data-toggle="fullscreen" type="button" class="nav-link p-2">
                <span class="sr-only">Fullscreen Mode</span>
                <span class="flex items-center justify-center h-6 w-6">
                    <i class="mgc_fullscreen_line text-2xl"></i>
                </span>
            </button>
        </div>

        <!-- Notification Bell Button -->
        <div class="relative md:flex hidden" x-data="notificationSystem()">
            <button 
                data-fc-type="dropdown" 
                data-fc-placement="bottom-end" 
                type="button" 
                class="nav-link p-2 fc-dropdown relative"
                @click="fetchNotifications()"
            >
                <span class="sr-only">View notifications</span>
                <span class="flex items-center justify-center h-6 w-6">
                    <i class="mgc_notification_line text-2xl"></i>
                </span>
                <span 
                    x-show="unreadCount > 0"
                    x-cloak
                    class="notification-badge"
                    x-text="unreadCount"
                ></span>
            </button>
            
            <!-- Notification Dropdown Panel -->
            <div 
                class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-80 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg"
            >
                <div class="p-2 border-b border-dashed border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h6 class="text-sm"> Notification</h6>
                        <a href="javascript: void(0);" class="text-gray-500 underline" @click="markAllAsRead()">
                            <small>Clear All</small>
                        </a>
                    </div>
                </div>

                <div class="p-4 h-80" data-simplebar>
                    <template x-if="loading">
                        <div class="flex justify-center items-center h-full">
                            <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </template>
                    
                    <template x-if="!loading && notifications.length === 0">
                        <div class="flex justify-center items-center h-full text-gray-500">
                            <div class="text-center">
                                <i class="mgc_notification_line text-4xl mb-2"></i>
                                <p>No notifications</p>
                            </div>
                        </div>
                    </template>
                    
                    <template x-if="!loading && notifications.length > 0">
                        <div>
                            <h5 class="text-xs text-gray-500 mb-2">Today</h5>

                            <template x-for="notification in notifications" :key="notification.id">
                                <a 
                                    href="javascript:void(0);" 
                                    class="block mb-4"
                                    @click="markAsRead(notification)"
                                    :class="notification.read_at ? 'opacity-75' : ''"
                                >
                                    <div class="card-body">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="flex justify-center items-center h-9 w-9 rounded-full text-white" 
                                                    :class="{
                                                        'bg-primary': notification.type === 'message',
                                                        'bg-info': notification.type === 'user',
                                                        'bg-gray-400': notification.read_at
                                                    }">
                                                    <i class="mgc_message_3_line text-lg" x-show="notification.type === 'message'"></i>
                                                    <i class="mgc_user_add_line text-lg" x-show="notification.type === 'user'"></i>
                                                    <i class="mgc_message_1_line text-lg" x-show="!notification.type"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow truncate ms-2">
                                                <h5 class="text-sm font-semibold mb-1" x-text="notification.data.title || 'Notification'">
                                                    <small class="font-normal text-gray-500 ms-1" x-text="formatTime(notification.created_at)"></small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted" x-text="notification.data.message || 'No message content'"></small>
                                            </div>
                                            <span x-show="!notification.read_at" class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                                        </div>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>
                </div>

                <a 
                    href="javascript:void(0);" 
                    class="p-2 border-t border-dashed border-gray-200 dark:border-gray-700 block text-center text-primary underline font-semibold"
                    @click="viewAll()"
                >
                    View All
                </a>
            </div>
        </div>

        <!-- Light/Dark Toggle Button -->
        <div class="flex">
            <button id="light-dark-mode" type="button" class="nav-link p-2">
                <span class="sr-only">Light/Dark Mode</span>
                <span class="flex items-center justify-center h-6 w-6">
                    <i class="mgc_moon_line text-2xl"></i>
                </span>
            </button>
        </div>

        <!-- Profile Dropdown Button -->
        <div class="relative">
            <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link">
                <img src="https://via.placeholder.com/40x40/3b82f6/ffffff?text=U" alt="user-image" class="rounded-full h-10">
            </button>
            <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-[margin,opacity] duration-300 mt-2 bg-white shadow-lg border rounded-lg p-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                    <i class="mgc_pic_2_line  me-2"></i> 
                    <span>Gallery</span>
                </a>
                <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                    <i class="mgc_task_2_line  me-2"></i> 
                    <span>Kanban</span>
                </a>
                <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                    <i class="mgc_lock_line  me-2"></i> 
                    <span>Lock Screen</span>
                </a>
                <hr class="my-2 -mx-2 border-gray-200 dark:border-gray-700">
                <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                    <i class="mgc_exit_line  me-2"></i> 
                    <span>Log Out</span>
                </a>
            </div>
        </div>
    </header>

    <script>
        // Light/Dark mode toggle
        // document.getElementById('light-dark-mode').addEventListener('click', function() {
        //     document.body.classList.toggle('dark-mode');
        // });
        
        // Notification system
        function notificationSystem() {
            return {
                isOpen: false,
                notifications: [],
                loading: false,
                unreadCount: 3,
                
                init() {
                    // Initialize with some sample notifications
                    this.notifications = [
                        {
                            id: 1,
                            type: 'message',
                            data: {
                                title: 'Datacorp',
                                message: 'Caleb Flakelar commented on Admin'
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        },
                        {
                            id: 2,
                            type: 'user',
                            data: {
                                title: 'Admin',
                                message: 'New user registered'
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        },
                        {
                            id: 3,
                            data: {
                                title: 'Cristina Pride',
                                message: 'Hi, How are you? What about our next meeting'
                            },
                            created_at: new Date(Date.now() - 86400000).toISOString(), // Yesterday
                            read_at: new Date().toISOString()
                        }
                    ];
                    
                    this.unreadCount = this.notifications.filter(n => !n.read_at).length;
                },
                
                async fetchNotifications() {
                    // Simulate API call
                    this.loading = true;
                    await new Promise(resolve => setTimeout(resolve, 800));
                    this.loading = false;
                },
                
                async markAsRead(notification) {
                    if (!notification.read_at) {
                        notification.read_at = new Date().toISOString();
                        this.unreadCount--;
                    }
                },
                
                async markAllAsRead() {
                    this.notifications.forEach(notification => {
                        if (!notification.read_at) {
                            notification.read_at = new Date().toISOString();
                        }
                    });
                    this.unreadCount = 0;
                },
                
                viewAll() {
                    alert('Redirecting to all notifications page');
                    // window.location.href = '/notifications';
                },
                
                formatTime(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffInSeconds = Math.floor((now - date) / 1000);
                    
                    if (diffInSeconds < 60) return 'just now';
                    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
                    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
                    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)}d ago`;
                    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                }
            }
        }
    </script>