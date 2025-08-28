<x-app-layout>
    @vite(['resources/js/app.js'])
    <style>
        .notification-enter {
            animation: slideInUp 0.3s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .notification-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        .notification-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .notification-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .notification-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 4px;
        }

        .notification-scroll::-webkit-scrollbar-thumb:hover {
            background-color: rgba(156, 163, 175, 0.7);
        }

        .notification-item {
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .unread-indicator {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>

    <div class="page-content">
        @include('../layouts.top-header')
     
        <main class="flex-grow p-6"> 
            <!-- Page Title Start -->
            <div class="flex justify-between items-center mb-6">
                <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Dashboard</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Notifications</a>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="mgc_check_line mr-2"></i>
                                Mark All Read
                            </button>
                        </form>
                    @endif
                    
                    <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="mgc_refresh_1_line mr-2"></i>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Main Notifications Container -->
            <div class="max-w-6xl mx-auto">
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden" style="height: 80vh;">
                    <div class="flex h-full">
                        <!-- Main Notifications Area -->
                        <div class="flex-1 flex flex-col">
                            <!-- Notifications Header -->
                            <div class="p-4 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            <i class="mgc_notification_line text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                @php
                                                    $totalNotifications = auth()->user()->notifications->count();
                                                    $unreadCount = auth()->user()->unreadNotifications->count();
                                                @endphp
                                                {{ $totalNotifications }} total, {{ $unreadCount }} unread
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <!-- Filter Options -->
                                        <div class="relative">
                                            <select onchange="filterNotifications(this.value)" class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="all">All Notifications</option>
                                                <option value="unread">Unread Only</option>
                                                <option value="read">Read Only</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notifications Area -->
                            <div class="flex-1 overflow-y-auto notification-scroll p-4 space-y-4">
                                @php
                                    $notifications = auth()->user()->notifications()->paginate(50);
                                    $groupedNotifications = $notifications->groupBy(function($notification) {
                                        return \Carbon\Carbon::parse($notification->created_at)->format('Y-m-d');
                                    });
                                @endphp

                                @if($notifications->isEmpty())
                                    <!-- Empty State -->
                                    <div class="text-center py-12">
                                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="mgc_notification_line text-blue-600 dark:text-blue-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No notifications yet</h3>
                                        <p class="text-gray-500 dark:text-gray-400">When you receive notifications, they'll appear here</p>
                                    </div>
                                @else
                                    <!-- Notifications -->
                                    @foreach($groupedNotifications as $date => $dayNotifications)
                                        <div class="space-y-3">
                                            <!-- Date Header -->
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-px bg-gray-300 dark:bg-gray-600"></div>
                                                </div>
                                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                                                </h4>
                                                <div class="flex-1">
                                                    <div class="w-full h-px bg-gray-300 dark:bg-gray-600"></div>
                                                </div>
                                            </div>

                                            <!-- Notifications for this date -->
                                            @foreach($dayNotifications as $notification)
                                                <div class="notification-item notification-enter {{ $notification->read_at ? 'notification-read' : 'notification-unread' }}">
                                                    <div class="flex space-x-4 p-4 rounded-lg {{ $notification->read_at ? 'bg-gray-50 dark:bg-slate-900/50' : 'bg-blue-50 dark:bg-blue-900/20' }} border {{ $notification->read_at ? 'border-gray-200 dark:border-slate-700' : 'border-blue-200 dark:border-blue-800' }}">
                                                        <!-- Notification Icon -->
                                                        <div class="flex-shrink-0">
                                                            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $notification->read_at ? 'bg-gray-400 text-white' : 'bg-blue-600 text-white' }}">
                                                                @php
                                                                    $icon = 'mgc_notification_line';
                                                                    if (isset($notification->data['type'])) {
                                                                        switch($notification->data['type']) {
                                                                            case 'success':
                                                                                $icon = 'mgc_check_circle_line';
                                                                                break;
                                                                            case 'warning':
                                                                                $icon = 'mgc_warning_line';
                                                                                break;
                                                                            case 'error':
                                                                                $icon = 'mgc_close_circle_line';
                                                                                break;
                                                                            case 'info':
                                                                                $icon = 'mgc_information_line';
                                                                                break;
                                                                        }
                                                                    }
                                                                @endphp
                                                                <i class="{{ $icon }} text-lg"></i>
                                                            </div>
                                                        </div>

                                                        <!-- Notification Content -->
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-start justify-between">
                                                                <div class="flex-1">
                                                                    <h5 class="text-sm font-semibold {{ $notification->read_at ? 'text-gray-900 dark:text-gray-200' : 'text-blue-900 dark:text-blue-100' }} mb-1">
                                                                        {{ $notification->data['title'] ?? 'Notification' }}
                                                                    </h5>
                                                                    <p class="text-sm {{ $notification->read_at ? 'text-gray-600 dark:text-gray-400' : 'text-blue-800 dark:text-blue-200' }} mb-2">
                                                                        {{ $notification->data['message'] ?? $notification->data['body'] ?? 'No message available' }}
                                                                    </p>
                                                                    
                                                                    <!-- Additional Data -->
                                                                    @if(isset($notification->data['action_url']))
                                                                        <a href="{{ $notification->data['action_url'] }}" 
                                                                           class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                                            <i class="mgc_external_link_line mr-1"></i>
                                                                            View Details
                                                                        </a>
                                                                    @endif
                                                                </div>

                                                                <!-- Time and Actions -->
                                                                <div class="flex items-center space-x-2 ml-4">
                                                                    <span class="text-xs {{ $notification->read_at ? 'text-gray-500' : 'text-blue-600 dark:text-blue-400' }}">
                                                                        {{ $notification->created_at->diffForHumans() }}
                                                                    </span>
                                                                    
                                                                    @if(!$notification->read_at)
                                                                        <div class="w-2 h-2 bg-blue-500 rounded-full unread-indicator"></div>
                                                                        <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST" class="inline">
                                                                            @csrf
                                                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                                                                Mark Read
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <i class="mgc_check_circle_line text-green-500 text-sm"></i>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Metadata -->
                                                            @if(isset($notification->data['metadata']))
                                                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                                    @foreach($notification->data['metadata'] as $key => $value)
                                                                        <span class="inline-block mr-3">
                                                                            <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Pagination Footer -->
                            @if($notifications->hasPages())
                                <div class="p-4 border-t border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} notifications
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            @if ($notifications->onFirstPage())
                                                <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                                                    <i class="mgc_left_line mr-1"></i>Previous
                                                </span>
                                            @else
                                                <a href="{{ $notifications->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600">
                                                    <i class="mgc_left_line mr-1"></i>Previous
                                                </a>
                                            @endif

                                            @if ($notifications->hasMorePages())
                                                <a href="{{ $notifications->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600">
                                                    Next<i class="mgc_right_line ml-1"></i>
                                                </a>
                                            @else
                                                <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                                                    Next<i class="mgc_right_line ml-1"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Filter notifications function
        function filterNotifications(filter) {
            const notifications = document.querySelectorAll('.notification-item');
            
            notifications.forEach(notification => {
                const isUnread = notification.classList.contains('notification-unread');
                const isRead = notification.classList.contains('notification-read');
                
                switch(filter) {
                    case 'unread':
                        notification.style.display = isUnread ? 'block' : 'none';
                        break;
                    case 'read':
                        notification.style.display = isRead ? 'block' : 'none';
                        break;
                    default:
                        notification.style.display = 'block';
                        break;
                }
            });
        }

        // Auto-refresh notifications every 2 minutes
        setInterval(function() {
            // You can implement AJAX refresh here if needed
            console.log('Auto-refresh check...');
        }, 120000);

        // Smooth scroll animation for new notifications
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification-enter');
            notifications.forEach((notification, index) => {
                notification.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

    @include('layouts.footer')
</x-app-layout>