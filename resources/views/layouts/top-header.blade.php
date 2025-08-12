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
            <img src="{{ asset('storage/'. $settings->light_logo) }}" class="logo-lg h-6" alt="Light logo">
            <img src="{{ asset('storage/'. $settings->light_logo_sm) }}" alt="Small logo">
        </div>

        <!-- Dark Brand Logo -->
        <div class="logo-dark">
            <img src="{{ asset('storage/'. $settings->dark_logo) }}" class="logo-lg h-6" alt="Dark logo">
            <img src="{{ asset('storage/'. $settings->dark_logo_sm) }}" class="logo-sm" alt="Small logo">
        </div>
    </a>

    <!-- Topbar Search Modal Button -->
    <button type="button" data-fc-type="modal" data-fc-target="topbar-search-modal" class="nav-link p-2 me-auto">
        <span class="sr-only">Search</span>
        <span class="flex items-center justify-center h-6 w-6">
            {{-- <i class="mgc_search_line text-2xl"></i> --}}
        </span>
    </button>

    <!-- Language Dropdown Button -->
    {{-- <div class="relative">
        <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link p-2 fc-dropdown">
            <span class="flex items-center justify-center h-6 w-6">
                <img src="assets/images/flags/us.jpg" alt="user-image" class="h-4 w-6">
            </span>
        </button>
        <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-40 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
            <!-- item-->
            <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                <img src="assets/images/flags/germany.jpg" alt="user-image" class="h-4">
                <span class="align-middle">German</span>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                <img src="assets/images/flags/italy.jpg" alt="user-image" class="h-4">
                <span class="align-middle">Italian</span>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                <img src="assets/images/flags/spain.jpg" alt="user-image" class="h-4">
                <span class="align-middle">Spanish</span>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                <img src="assets/images/flags/russia.jpg" alt="user-image" class="h-4">
                <span class="align-middle">Russian</span>
            </a>
        </div>
    </div> --}}

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
 <div class="relative md:flex hidden" x-data="notificationSystem()" x-init="init()">
    <button @click="toggleDropdown()" type="button" class="nav-link p-2 relative">
        <span class="sr-only">View notifications</span>
        <span class="flex items-center justify-center h-6 w-6">
            <i class="mgc_notification_line text-2xl"></i>
        </span>
        <span 
            x-show="unreadCount > 0"
            class="absolute top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center"
            x-text="unreadCount"
        ></span>
    </button>
    
<div 
        x-show="isOpen" 
        @click.away="isOpen = false"
        class="absolute right-0 mt-8 w-80 origin-top-right z-50 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
    >
        <div class="p-2 border-b border-dashed border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h6 class="text-sm">Notification</h6>
                <a 
                    href="javascript: void(0);" 
                    class="text-gray-500 underline"
                    @click="markAllAsRead()"
                >
                    <small>Clear All</small>
                </a>
            </div>
        </div>

        <div class="p-4 h-80 overflow-y-auto" data-simplebar>
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
                    No notifications
                </div>
            </template>
            
            <template x-if="!loading && notifications.length > 0">
                <div>
                    <template x-for="(group, date) in groupedNotifications" :key="date">
                        <div>
                            <h5 class="text-xs text-gray-500 mb-2" x-text="date"></h5>
                            <template x-for="notification in group" :key="notification.id">
                                <a 
                                    href="javascript:void(0);" 
                                    class="block mb-4"
                                    :class="{'opacity-70': notification.read_at}"
                                    @click="markAsRead(notification)"
                                >
                                    <div class="card-body">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div 
                                                    class="flex justify-center items-center h-9 w-9 rounded-full text-white"
                                                    :class="{
                                                        'bg-primary': !notification.read_at,
                                                        'bg-gray-400': notification.read_at
                                                    }"
                                                >
                                                    <i class="mgc_message_3_line text-lg"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow truncate ms-2">
                                                <h5 class="text-sm font-semibold mb-1">
                                                    <span x-text="notification.data.title"></span>
                                                    <small class="font-normal text-gray-500 ms-1" x-text="formatTime(notification.created_at)"></small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted" x-text="notification.data.message"></small>
                                            </div>
                                            <template x-if="!notification.read_at">
                                                <div class="ml-2 w-2 h-2 rounded-full bg-blue-500"></div>
                                            </template>
                                        </div>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <a 
            href="javascript:void(0);" 
            class="p-2 border-t border-dashed border-gray-200 dark:border-gray-700 block text-center text-primary underline font-semibold"
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
          @php
            use Illuminate\Support\Facades\Storage;

            $user = auth()->user();
            $picture = $user->display_picture ?? null;
        @endphp

        @if($picture)
            <img src="{{ asset('storage/' . $picture) }}" alt="{{auth()->user()->fname}}" class="rounded-full h-10">
        @else
            <img src="{{ asset('assets/images/users/display_picture.png') }}" alt="{{auth()->user()->fname}}" class="rounded-full h-10">
        @endif
                </button>
        <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-[margin,opacity] duration-300 mt-2 bg-white shadow-lg border rounded-lg p-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
            @if(auth()->user()->hasRole('customer'))
            <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                <i class="mgc_pic_2_line  me-2"></i> 
                <span>Plan: </span>
            </a>
            <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="">
                <i class="mgc_service_line  me-2"></i> 
                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">VP: {{ auth()->user()->customer->virtual_assistance_points ?? 0 }}</span>
            </a>
            <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                <i class="mgc_phone_line  me-2"></i> 
                <span>SP: {{ auth()->user()->customer->general_support_points ?? 0}} </span>
            </a>
            
            <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                <i class="mgc_service_line  me-2"></i> 
                <span>CP: {{ auth()->user()->customer->call_service_points ?? 0}}</span>
            </a>
            <hr class="my-2 -mx-2 border-gray-200 dark:border-gray-700">

             <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('customers.edit', auth()->user()->id) }}">
                <i class="mgc_settings_1_line  me-2"></i> 
                <span>Update Profile</span>
            </a>
            @endif

            <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('settings.get-update-password', auth()->user()->id) }}">
                <i class="mgc_settings_1_line  me-2"></i> 
                <span>Update Password</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                <i class="mgc_exit_line me-2"></i>
                <span>Log Out</span>
            </button>
        </form>

        </div>
    </div>
</header>
 @if (auth()->user()->hasRole('customer') && auth()->user()->customer->is_kyced !== 2)
                        <marquee behavior="" direction="left" scrollamount="5" class="text-red-500 text-xl"> Kindly submit your KYC for approval</marquee>
                    @endif
<!-- Topbar End -->

<!-- Topbar Search Modal -->
{{-- <div>
    <div id="topbar-search-modal" class="fc-modal hidden w-full h-full fixed top-0 start-0 z-50">
        <div class="fc-modal-open:opacity-100 fc-modal-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-12 sm:mx-auto">
            <div class="mx-auto max-w-2xl overflow-hidden rounded-xl bg-white shadow-2xl transition-all dark:bg-slate-800">
                <div class="relative">
                    <div class="pointer-events-none absolute top-3.5 start-4 text-gray-900 text-opacity-40 dark:text-gray-200">
                        <i class="mgc_search_line text-xl"></i>
                    </div>
                    <input type="search" class="h-12 w-full border-0 bg-transparent ps-11 pe-4 text-gray-900 placeholder-gray-500 dark:placeholder-gray-300 dark:text-gray-200 focus:ring-0 sm:text-sm" placeholder="Search...">
                </div>
            </div>
        </div>
    </div>
</div> --}}
<script>
function notificationSystem() {
    return {
        isOpen: false,
        notifications: [],
        loading: true,
        unreadCount: 0,
        
        // Group notifications by date
        get groupedNotifications() {
            const groups = {};
            
            this.notifications.forEach(notification => {
                const date = new Date(notification.created_at).toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                if (!groups[date]) {
                    groups[date] = [];
                }
                
                groups[date].push(notification);
            });
            
            return groups;
        },
        
        init() {
            this.fetchNotifications();
            // Poll for new notifications every 60 seconds
            //this.polling = setInterval(() => this.fetchNotifications(), 60000);
        },
        
        toggleDropdown() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.fetchNotifications();
            }
        },
        
        async fetchNotifications() {
            try {
                const response = await fetch('/dashboard/notifications/notifications');
                const data = await response.json();
                console.log("Notification", data)
                if (data.status) {
                    this.notifications = [...data.data.unread, ...data.data.read];
                    this.unreadCount = data.data.unread.length;
                }
            } catch (error) {
                console.error('Error fetching notifications:', error);
            } finally {
                this.loading = false;
            }
        },
        
        async markAsRead(notification) {
            if (!notification.read_at) {
                try {
                    const response = await fetch(`/dashboard/notifications/notifications/read/${notification.id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.status) {
                        // Update the notification locally
                        const index = this.notifications.findIndex(n => n.id === notification.id);
                        if (index !== -1) {
                            this.notifications[index].read_at = new Date().toISOString();
                            this.unreadCount = Math.max(0, this.unreadCount - 1);
                        }
                    }
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                }
            }
            
            // You can add navigation logic here if needed
            // window.location.href = notification.data.url;
        },
        
        async markAllAsRead() {
            try {
                const unreadIds = this.notifications
                    .filter(n => !n.read_at)
                    .map(n => n.id);
                
                if (unreadIds.length > 0) {
                    const response = await fetch('/dashboard/notifications/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ids: unreadIds })
                    });
                    
                    const data = await response.json();
                    console.log(data)
                    
                    if (data.status) {
                        // Update all notifications locally
                        this.notifications = this.notifications.map(n => {
                            if (!n.read_at) {
                                return { ...n, read_at: new Date().toISOString() };
                            }
                            return n;
                        });
                        this.unreadCount = 0;
                    }
                }
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
            }
        },
        
        formatTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) return 'just now';
            if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} min ago`;
            if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hr ago`;
            return `${Math.floor(diffInSeconds / 86400)} day ago`;
        }
    }
}
</script>