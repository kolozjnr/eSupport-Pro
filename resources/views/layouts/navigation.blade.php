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
                
                $isKycBlocked = false;
                
                if ($isCustomer) {
                    $customer = auth()->user()->customer;
                    if (!$customer || ($customer->is_kyced != 2)) {
                        $isKycBlocked = true;
                    }
                }

                // Debug information (remove this in production)
                // dd([
                //     'isCustomer' => $isCustomer,
                //     'customer' => $customer ?? null,
                //     'is_kyced' => $customer->is_kyced ?? 'null',
                //     'is_kyced_type' => gettype($customer->is_kyced ?? null),
                //     'isKycBlocked' => $isKycBlocked
                // ]);
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

                    
                    @if (Auth::user()->hasRole('support'))
                        <li class="menu-item">
                            <a href="{{ route('tickets.polls') }}" class="menu-link">
                                <span class="menu-text">Tickets Poll</span>
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

                    <li class="menu-item">
                        <a href="{{route('admin.password-reset')}}" class="menu-link">
                            <span class="menu-text">Reset Password</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (Auth::user()->hasRole('customer'))
            <li class="menu-item">
                <a href="{{route('customers.pricing')}}" class="menu-link {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
                    <span class="menu-icon"><i class="mgc_box_2_line"></i></span>
                    <span class="menu-text"> Pricing </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{route('customers.payment-history')}}" class="menu-link {{ $isKycBlocked ? 'pointer-events-none opacity-50' : '' }}">
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
        </ul>
    </div>
     <div class="sticky bottom-0 bg-white dark:bg-gray-800 border-t border-gray-300 dark:border-gray-700 mt-auto">
        <div class="p-4 text-left">
            <h5 class="font-bold">{{ auth()->user()->fname .' '. auth()->user()->lname }}</h5>
            <p class="text-sm">{{ Str::ucfirst(auth()->user()->user_type) }}</p>
        </div>
    </div>
</div>
<!-- Sidenav Menu End  -->