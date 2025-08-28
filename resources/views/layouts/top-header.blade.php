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
    <a href="/dashboard" class="logo-box">
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
    @php
        $notifications = auth()->user()->notifications()->take(20)->get();
        $unreadNotifications = $notifications->whereNull('read_at');
        $readNotifications = $notifications->whereNotNull('read_at');
        $unreadCount = $unreadNotifications->count();
        
        // Group notifications by date
        $groupedNotifications = $notifications->groupBy(function($notification) {
            return \Carbon\Carbon::parse($notification->created_at)->format('l, F j, Y');
        });
    @endphp
    
    <div class="relative md:flex hidden">
        <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link p-2">
            <span class="sr-only">View notifications</span>
            <span class="flex items-center justify-center h-6 w-6">
                <i class="mgc_notification_line text-2xl"></i>
            </span>
            @if($unreadCount > 0)
                <span class="absolute top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
                    {{ $unreadCount }}
                </span>
            @endif
        </button>
    
        <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-80 origin-top-right z-50 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none">
            <div class="p-2 border-b border-dashed border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h6 class="text-sm">Notification</h6>
                    @if($unreadCount > 0)
                        <a href="{{ route('notifications.mark-all-read') }}" 
                           class="text-gray-500 underline"
                           onclick="event.preventDefault(); document.getElementById('mark-all-read-form').submit();">
                            <small>Clear All</small>
                        </a>
                        <form id="mark-all-read-form" action="{{ route('notifications.mark-all-read') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endif
                </div>
            </div>

            <div class="p-4 h-80 overflow-y-auto" data-simplebar>
                @if($notifications->isEmpty())
                    <div class="flex justify-center items-center h-full text-gray-500">
                        No notifications
                    </div>
                @else
                    @foreach($groupedNotifications as $date => $dayNotifications)
                        <div class="mb-4">
                            <h5 class="text-xs text-gray-500 mb-2">{{ $date }}</h5>
                            
                            @foreach($dayNotifications as $notification)
                                <a href="{{ route('notifications.mark-as-read', $notification->id) }}" 
                                   class="block mb-4 {{ $notification->read_at ? 'opacity-70' : '' }}"
                                   onclick="event.preventDefault(); document.getElementById('mark-read-form-{{ $notification->id }}').submit();">
                                    <div class="card-body">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="flex justify-center items-center h-9 w-9 rounded-full text-white {{ $notification->read_at ? 'bg-gray-400' : 'bg-primary' }}">
                                                    <i class="mgc_message_3_line text-lg"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow truncate ms-2">
                                                <h5 class="text-sm font-semibold mb-1 text-xs text-gray-500 dark:text-white">
                                                    <span>{{ $notification->data['title'] ?? 'Notification' }}</span>
                                                    <small class="font-normal text-gray-500 ms-1 text-xxs text-gray-500 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                    </small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted text-xs text-gray-500 dark:text-white">
                                                    {{ $notification->data['message'] ?? $notification->data['body'] ?? 'No message' }}
                                                </small>
                                            </div>
                                            @if(!$notification->read_at)
                                                <div class="ml-2 w-2 h-2 rounded-full bg-blue-500"></div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                
                                <form id="mark-read-form-{{ $notification->id }}" 
                                      action="{{ route('notifications.mark-as-read', $notification->id) }}" 
                                      method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>

            <a href="{{ route('notifications.index') }}" 
               class="p-2 border-t border-dashed border-gray-200 dark:border-gray-700 block text-center text-primary underline font-semibold">
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

@php
    $isCustomer = auth()->user()->hasRole('customer');
    
    $isKycBlocked = false;
    
    if ($isCustomer) {
        $customer = auth()->user()->customer;
        if (!$customer || ($customer->is_kyced != 2)) {
            $isKycBlocked = true;
        }
    }
@endphp

@if($isKycBlocked)
    <marquee behavior="scroll" direction="left" scrollamount="5" class="text-red-500 text-xl">
        Kindly submit your KYC for approval
    </marquee>
@endif

<!-- Topbar End -->