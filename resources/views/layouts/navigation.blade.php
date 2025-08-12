<!-- Sidenav Menu -->
<div class="app-menu">
    <!-- Sidenav Brand Logo -->
    <a href="/dashboard" class="logo-box">
        <!-- Light Brand Logo -->
        <div class="logo-light">
            <img src="{{ asset('storage/'. $settings->light_logo)}}" class="h-24 hover:h-10 w-40 hover:w-32" alt="Light logo">
            <img src="{{ asset('storage/'. $settings->light_logo_sm)}}" class="logo-sm" alt="Small logo">
        </div>

        <!-- Dark Brand Logo -->
        <div class="logo-dark">
            <img src="{{ asset('storage/' . $settings->dark_logo) }}" class="h-32 hover:h-10 w-40 hover:w-32" alt="Dark logo">
            <img src="{{ asset('storage/'. $settings->dark_logo_sm)}}" class="logo-sm" alt="Small logo">
        </div>
    </a>

    <!-- Sidenav Menu Toggle Button -->
    <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5">
        <span class="sr-only">Menu Toggle Button </span>
        <i class="mgc_round_line text-xl"></i>
    </button>

    <!--- Menu -->
    <div class="srcollbar" data-simplebar>
        <ul class="menu" data-fc-type="accordion">
            <li class="menu-title">Menu</li>

            <li class="menu-item">
                <a href="{{ route('dashboard')}}" class="menu-link">
                    <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
                    <span class="menu-text"> Dashboard </span>
                </a>
            </li>

                @php
                $isCustomer = auth()->user()->hasRole('customer');
                $isKycBlocked = $isCustomer && auth()->user()->customer->is_kyced !== 2;
            @endphp

            <li class="menu-title">{{ $settings->short_name }}</li>

            {{-- Manage Tickets --}}
            <li class="menu-item">
                <a href="javascript:void(0)"
                data-fc-type="collapse"
                class="menu-link {{ request()->is('tickets*') ? 'open' : '' }} {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                    <span class="menu-icon"><i class="mgc_building_2_line"></i></span>
                    <span class="menu-text"> Manage Tickets </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{ $isKycBlocked ? 'javascript:void(0)' : route('tickets.index') }}"
                        class="menu-link {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                            <span class="menu-text">Tickets</span>
                        </a>
                    </li>

                    @if (!$isCustomer)
                        <li class="menu-item">
                            <a href="{{ route('tickets.create-onbehalf') }}" class="menu-link">
                                <span class="menu-text">Create Ticket</span>
                            </a>
                        </li>
                    @endif

                    @if ($isCustomer)
                        <li class="menu-item">
                            <a href="{{ $isKycBlocked ? 'javascript:void(0)' : route('tickets.create') }}"
                            class="menu-link {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                                <span class="menu-text">Create Ticket</span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ $isKycBlocked ? 'javascript:void(0)' : route('tickets.view-tickets-onbehalf') }}"
                            class="menu-link {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                                <span class="menu-text">Accept Tickets</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            {{-- Manage Drafts --}}
            @if ($isCustomer)
                <li class="menu-item">
                    <a href="javascript:void(0)"
                    data-fc-type="collapse"
                    class="menu-link {{ request()->is('tickets/draft') || request()->is('tickets/view-drafts') ? 'open' : '' }} {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                        <span class="menu-icon"><i class="mgc_building_2_line"></i></span>
                        <span class="menu-text"> Manage Drafts </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="sub-menu hidden">
                        <li class="menu-item">
                            <a href="{{ $isKycBlocked ? 'javascript:void(0)' : route('tickets.draft') }}"
                            class="menu-link {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                                <span class="menu-text">Draft</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ $isKycBlocked ? 'javascript:void(0)' : route('tickets.view-drafts') }}"
                            class="menu-link {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                                <span class="menu-text">View Draft</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif


            @if (Auth::user()->hasRole('account'))
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mgc_box_3_line"></i></span>
                    <span class="menu-text"> Invoice </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{ route('invoices.index')}}" class="menu-link">
                            <span class="menu-text">View Subscriptions</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('invoices.manual-invoice')}}" class="menu-link">
                            <span class="menu-text">Manual Subscription</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if (!Auth::user()->hasRole('support') && !Auth::user()->hasRole('customer'))
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mgc_layout_line"></i></span>
                    <span class="menu-text"> Business Management </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    @if (Auth::user()->hasRole('businessdeveloper'))
                    <li class="menu-item">
                        <a href="{{ route('customers.onboard')}}" class="menu-link">
                            <span class="menu-text">Customer Onboarding</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (!Auth::user()->hasRole('customer'))
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mgc_box_3_line"></i></span>
                    <span class="menu-text"> User Management </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    @if (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('businessmanager') || Auth::user()->hasRole('customermanager'))
                    <li class="menu-item">
                        <a href="{{route('users.create')}}" class="menu-link">
                            <span class="menu-text">Create user</span>
                        </a>
                    </li>
                    @endif
                    
                    @if (Auth::user()->hasRole('administrator'))
                    <li class="menu-item">
                        <a href="{{route('users.manage-users')}}" class="menu-link">
                            <span class="menu-text">Manage users</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('users.assign-customer')}}" class="menu-link">
                            <span class="menu-text">Assign Customer to BD</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('settings.index')}}" class="menu-link">
                            <span class="menu-text">Settings</span>
                        </a>
                    </li>
                    
                    <li class="menu-item">
                        <a href="{{route('users.manage-roles')}}" class="menu-link">
                            <span class="menu-text">Role Management</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('users.approve-kyc')}}" class="menu-link">
                            <span class="menu-text">Approve KYC</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (Auth::user()->hasRole('customer'))
            <li class="menu-item">
                <a href="{{route('customers.pricing')}}" class="menu-link">
                    <span class="menu-icon"><i class="mgc_box_2_line"></i></span>
                    <span class="menu-text"> Pricing </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{route('customers.payment-history')}}" class="menu-link">
                    <span class="menu-icon"><i class="mgc_wallet_5_fill"></i></span>
                    <span class="menu-text"> Payment History </span>
                </a>
            </li>
            @endif

            @if (!auth()->user()->hasRole('customer'))
            <li class="menu-item">
                <a href="https://esupportpro.com:2096/" class="menu-link">
                    <span class="menu-icon"><i class="mgc_box_2_line"></i></span>
                    <span class="menu-text"> Web mail </span>
                </a>
            </li>
            @endif

            <!-- Help Box Widget -->
            <div class="sticky bottom-0 fixed px-5 border-t border-gray-300 mx-2">
                <div class="help-box p-6 bg-black/5 text-left rounded-md">
                    <h5 class="mb-2 bold ">{{auth()->user()->fname .' '. auth()->user()->lname}}</h5>
                    <p class="mb-3 text-sm">{{Str::ucfirst(auth()->user()->user_type)}}</p>
                </div>
            </div>
        </ul>
    </div>
</div>
<!-- Sidenav Menu End  -->













{{-- <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav> --}}
