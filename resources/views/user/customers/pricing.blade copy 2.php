<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        <style>
            
        button {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        }

        /* Modal Styles */
       .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

        .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 700px;
        text-align: center;
        position: relative;
        transform: scale(0); /* Start small */
        animation: blowUp 0.3s ease-out forwards; /* Animation for opening */
        }

        /* Close Button */
        .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        }

        /* Keyframes for Blow Up Animation */
        @keyframes blowUp {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
        }

        /* Keyframes for Go Back Animation */
        @keyframes goBack {
        from {
            transform: scale(1);
        }
        to {
            transform: scale(0);
        }
        }
        
        /* Service selection styles */
        .service-options {
            margin: 20px 0;
            text-align: left;
        }
        .service-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .service-option:hover {
            background-color: #f5f5f5;
        }
        .service-option.selected {
            background-color: #e6f7ff;
            border-color: #1890ff;
        }
        .service-option input {
            margin-right: 10px;
        }
        .service-details {
            margin-left: 10px;
        }
        .service-name {
            font-weight: bold;
        }
        .service-price {
            color: #666;
        }
        </style>
        @include('../layouts.top-header')


        <!-- Modal -->
        <div id="modal" class="modal">
            <div class="modal-content bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-auto relative shadow-lg text-gray-800 dark:text-gray-200">
                <span id="closeModal" class="close absolute top-3 right-4 text-2xl cursor-pointer text-gray-500 hover:text-red-500">&times;</span>

                <h2 class="text-xl font-semibold mb-4 text-center">Make Payment</h2>

                <p class="mb-4 text-sm text-center">
                    You are about to pay <span id="planPrice" class="font-bold text-lg">&#8358;0</span>
                </p>
                
                <!-- Service Selection -->
                <div class="service-options">
                    <h3 class="font-semibold mb-2">Select Service(s)</h3>
                    <div class="service-option" onclick="selectService(this, 'all')">
                        <input type="radio" name="service" value="all" checked>
                        <div class="service-details">
                            <div class="service-name">All Services (Full Package)</div>
                            <div class="service-price hidden" id="all-price">Base price: ₦0</div>
                        </div>
                    </div>
                    <div class="service-option" onclick="selectService(this, 'call_center')">
                        <input type="radio" name="service" value="call_center">
                        <div class="service-details">
                            <div class="service-name">Call Center Service Only</div>
                            <div class="service-price hidden" id="call-center-price">Price: ₦0</div>
                        </div>
                    </div>
                    <div class="service-option" onclick="selectService(this, 'general_support')">
                        <input type="radio" name="service" value="general_support">
                        <div class="service-details">
                            <div class="service-name">General Support Only</div>
                            <div class="service-price hidden" id="general-support-price">Price: ₦0</div>
                        </div>
                    </div>
                    <div class="service-option" onclick="selectService(this, 'virtual_assistance')">
                        <input type="radio" name="service" value="virtual_assistance">
                        <div class="service-details">
                            <div class="service-name">Virtual Assistance Only</div>
                            <div class="service-price hidden" id="virtual-assistance-price">Price: ₦0</div>
                        </div>
                    </div>
                </div>
{{-- 
                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Bank Transfer Details</h3>
                    <ul class="text-sm space-y-1">
                        <li><strong>Bank:</strong> Zenith Bank plc</li>
                        <li><strong>Account Name:</strong> E-Supportpro</li>
                        <li><strong>Account Number:</strong> 1310262889</li>
                    </ul>
                </div> --}}

                {{-- <div class="mb-6 text-sm">
                    After successful payment, please send your proof of payment (screenshot or receipt) to:  
                    <a href="mailto:support@dictacare.org" class="text-blue-600 underline">billing@esupportpro.com</a>
                </div> --}}
                <form action="{{ route('monnify.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" value="" id="amount">
                    <input type="hidden" name="email" value="{{ auth()->user()->email}}" id="email">
                    <input type="hidden" name="plan" value="" id="plan">
                    <input type="hidden" name="frequency" value="" id="frequency">
                    <input type="hidden" name="service_type" value="all" id="service-type">
                    <input type="hidden" name="virtual_assistance_points" value="" id="virtual_assistance_points">
                    <input type="hidden" name="call_center_points" value="" id="call_center_points">
                    <input type="hidden" name="general_support_points" value="" id="general_support_points">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Pay with Monnify</button>
                </form>
            </div>
        </div>


        <div x-data="onboardCustomers()">
            <main class="flex-grow p-6">

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Pricing</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Pricing</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Pricing</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <!-- Pricing -->
                <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                    <!-- Title -->
                    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
                        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">Find the right plan for your your business</h2>
                        <p class="mt-1 text-gray-600 dark:text-gray-400"> <b>NOTE:</b> The amount displayed on each plan is for total package, you may choose to select a single service when you click the proceed button.</p>
                    </div>
                    <!-- End Title -->

                    <!-- Grid -->
                    <div class="mt-12 relative before:absolute before:inset-0 before:-z-[1] before:bg-[radial-gradient(closest-side,#cbd5e1,transparent)] dark:before:bg-[radial-gradient(closest-side,#334155,transparent)]">
                        <div class="grid gap-px sm:grid-cols-2 lg:grid-cols-4 lg:items-center">
                            <!-- Card -->
                       <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Lite</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="biannually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-4xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">{{$settings->citizen_desk_plan_amount}}</span>
                                </span>
                            </div>

                            <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                <ul class="space-y-2.5 text-center text-sm">
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Plan features
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Below 50 Tasks
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Call Centre Service {{$settings->call_center_lite}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance {{$settings->virtual_support_lite}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support {{$settings->general_support_lite}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="{{$settings->citizen_desk_plan_amount}}" href="#" data-general-support="{{$settings->general_support_lite}}" data-call-center="{{$settings->call_center_lite}}" data-virtual-assistance="{{$settings->virtual_support_lite}}">
                                    Proceed
                                </a>
                            </div>
                        </div>

                        <!-- End Card -->

                        <!-- Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Standard</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="biannually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-4xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">{{$settings->startup_up_amount}}</span>
                                </span>
                            </div>

                            <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                <ul class="space-y-2.5 text-center text-sm">
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Plan features
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        50 - 100 Tasks
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400" >
                                        Call Centre Service {{$settings->call_center_standard}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance {{$settings->virtual_support_standard}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support {{$settings->general_support_standard}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="{{$settings->startup_up_amount}}" href="#" data-general-support="{{$settings->general_support_standard}}" data-call-center="{{$settings->call_center_standard}}" data-virtual-assistance="{{$settings->virtual_support_standard}}">
                                    Proceed
                                </a>
                            </div>
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Advanced</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="biannually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-4xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">{{$settings->team_amount}}</span>
                                </span>
                            </div>

                            <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                <ul class="space-y-2.5 text-center text-sm">
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Plan features
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        101 - 500 Tasks
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400" data-call-center="{{$settings->call_center_advanced}}">
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400" data-virtual-assistance="{{$settings->virtual_support_advanced}}">
                                        Virtual Assistance {{$settings->virtual_support_advanced}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400" data-general-support="{{$settings->general_support_advanced}}">
                                        General Support {{$settings->general_support_advanced}} Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400" data-citizen-service-desk="30,000">
                                        Citizen Service Desk 
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="{{$settings->team_amount}}" href="#" data-general-support="{{$settings->general_support_advanced}}" data-call-center="{{$settings->call_center_advanced}}" data-virtual-assistance="{{$settings->virtual_support_advanced}}">
                                    Proceed
                                </a>
                            </div>
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Business</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="biannually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-4xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">{{$settings->enterprise_amount}}</span>
                                </span>
                            </div>

                            <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                <ul class="space-y-2.5 text-center text-sm">
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Plan features
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        501 to 1,000 Tasks
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Product support
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Call Centre Service {{$settings->call_center_business}}
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance {{$settings->virtual_support_business}}
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support {{$settings->general_support_business}}
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="{{$settings->enterprise_amount}}" href="#" data-general-support="{{$settings->general_support_business}}" data-call-center="{{$settings->call_center_business}}" data-virtual-assistance="{{$settings->virtual_support_business}}">
                                    Proceed
                                </a>
                            </div>
                        </div>
                        <!-- End Card -->
                         <!-- SPECIAL Pricing Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">SPECIAL</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with dropdown -->
                                <div class="mb-4">
                                    <select class="special-plan-select w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="updateSpecialPlanPrice(this)">
                                        <option value="bronze">BRONZE - ₦13,000</option>
                                        <option value="silver">SILVER - ₦25,000</option>
                                        <option value="gold">GOLD - ₦30,000</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-4xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">13,000</span>
                                </span>
                            </div>

                            <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                <ul class="space-y-2.5 text-center text-sm">
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Special plan features
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Customizable service points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Flexible support options
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" 
                                data-base-price="13000" 
                                href="#" 
                                id="specialProceedButton"
                                onclick="showModalWithPrice(13000, 'monthly', 0, 0, 0)">
                                    Proceed
                                </a>
                            </div>
                        </div>
                        <!-- End SPECIAL Pricing Card -->



                        <!-- Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Enterprise</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="biannually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-4xl text-gray-800 dark:text-gray-200">
                                    {{-- <span class="font-bold text-2xl -me-2">&#8358;</span> --}}
                                    <span class="display-price">Contact Sales</span>
                                </span>
                            </div>

                            <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                <ul class="space-y-2.5 text-center text-sm">
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Kindly contact our sales team. for this plan
                                    </li>
                                </ul>
                            </div>
                        </div>
                            <!-- End Card -->
                        </div>
                    </div><!-- End Grid -->
                    <div class="mt-12">
                        <span>
                            <strong class="text-gray-800 dark:text-gray-200 font-medium">Note:</strong>
                            <span class="text-gray-800 dark:text-gray-200">Duration: 1 month, Quarterly (10% discount), Semi Annual (15%), Annual (20%), Others
                                <p class="text-gray-800 dark:text-gray-200 mt-2">
                                    Expiriation: 30% (48hrs)
New sub before the expiration of the previous one. The slots on the previous subscription at the expiration date(a).

                                </p>
                            </span>
                        </span>
                    </div>
                </div>
                <!-- End Pricing -->
            </main>
          

    @include('layouts.footer')

    <script>
          document.addEventListener('alpine:init', () => {
                    Alpine.data('onboardCustomers', () => ({
                       
                    }));
                });

           document.addEventListener("DOMContentLoaded", () => {
    const openModalButton = document.getElementById("openModal");
    const closeModalButton = document.getElementById("closeModal");
    const modal = document.getElementById("modal");
    const planPriceSpan = document.getElementById("planPrice");
    var payableAmount = document.getElementById("amount");
    var frequencyInput = document.getElementById("frequency");
    var virtualAInput = document.getElementById("virtual_assistance_points");
    var callCenterInput = document.getElementById("call_center_points");
    var generalSupportInput = document.getElementById("general_support_points");
    var serviceTypeInput = document.getElementById("service-type");
    
    // Store current pricing information
    let currentPricing = {
        basePrice: 0,
        frequency: 'monthly',
        callCenterPoints: 0,
        virtualAPoints: 0,
        generalSupportPoints: 0
    };
    
    // Service weights (percentage of base price)
    const serviceWeights = {
        call_center: 0.4,  // 40% of base price
        general_support: 0.3, // 30% of base price
        virtual_assistance: 0.3 // 30% of base price
    };

    function selectService(element, serviceType) {
        // Update UI
        const serviceOptions = document.querySelectorAll('.service-option');
        if (serviceOptions) {
            serviceOptions.forEach(opt => {
                opt.classList.remove('selected');
            });
            element.classList.add('selected');
        }
        
        // Update the selected service in the form
        if (serviceTypeInput) {
            serviceTypeInput.value = serviceType;
        }
        
        // Recalculate price based on service selection
        updatePriceForSelectedService();
    }
    
    function updatePriceForSelectedService() {
        let price = currentPricing.basePrice;
        const serviceType = serviceTypeInput ? serviceTypeInput.value : 'all';
        
        // Apply frequency discount first
        switch(currentPricing.frequency) {
            case 'quarterly':
                price = price * 3 * 0.95; // 5% discount
                break;
            case 'biannually':
                price = price * 6 * 0.90; // 10% discount
                break;
            case 'annually':
                price = price * 12 * 0.85; // 15% discount
                break;
        }
        
        // If not "all" services, adjust price based on service weights
        if (serviceType !== 'all') {
            price = price * serviceWeights[serviceType];
            
            // Update points based on selected service
            if (serviceType === 'call_center') {
                if (virtualAInput) virtualAInput.value = 0;
                if (generalSupportInput) generalSupportInput.value = 0;
            } else if (serviceType === 'general_support') {
                if (callCenterInput) callCenterInput.value = 0;
                if (virtualAInput) virtualAInput.value = 0;
            } else if (serviceType === 'virtual_assistance') {
                if (callCenterInput) callCenterInput.value = 0;
                if (generalSupportInput) generalSupportInput.value = 0;
            }
        } else {
            // For "all" services, keep all points
            if (callCenterInput) callCenterInput.value = currentPricing.callCenterPoints;
            if (virtualAInput) virtualAInput.value = currentPricing.virtualAPoints;
            if (generalSupportInput) generalSupportInput.value = currentPricing.generalSupportPoints;
        }
        
        // Update displayed price
        const roundedPrice = Math.round(price);
        if (planPriceSpan) planPriceSpan.textContent = `₦${roundedPrice.toLocaleString()}`;
        if (payableAmount) payableAmount.value = roundedPrice;
        
        // Update service price displays
        const allPriceEl = document.getElementById('all-price');
        const callCenterPriceEl = document.getElementById('call-center-price');
        const generalSupportPriceEl = document.getElementById('general-support-price');
        const virtualAssistancePriceEl = document.getElementById('virtual-assistance-price');
        
        if (allPriceEl) allPriceEl.textContent = `Base price: ₦${Math.round(currentPricing.basePrice).toLocaleString()}`;
        if (callCenterPriceEl) callCenterPriceEl.textContent = `Price: ₦${Math.round(currentPricing.basePrice * serviceWeights.call_center).toLocaleString()}`;
        if (generalSupportPriceEl) generalSupportPriceEl.textContent = `Price: ₦${Math.round(currentPricing.basePrice * serviceWeights.general_support).toLocaleString()}`;
        if (virtualAssistancePriceEl) virtualAssistancePriceEl.textContent = `Price: ₦${Math.round(currentPricing.basePrice * serviceWeights.virtual_assistance).toLocaleString()}`;
    }

    function showModalWithPrice(price, frequency, virtualA, callCenter, generalSupport) {
        // Store current pricing information
        currentPricing = {
            basePrice: parseFloat(price),
            frequency: frequency,
            callCenterPoints: callCenter,
            virtualAPoints: virtualA,
            generalSupportPoints: generalSupport
        };
        
        // Reset service selection to "all"
        if (serviceTypeInput) serviceTypeInput.value = 'all';
        
        const allServiceOption = document.querySelector('.service-option input[value="all"]');
        if (allServiceOption) allServiceOption.checked = true;
        
        const serviceOptions = document.querySelectorAll('.service-option');
        if (serviceOptions) {
            serviceOptions.forEach(opt => {
                opt.classList.remove('selected');
            });
            const firstOption = document.querySelector('.service-option:first-child');
            if (firstOption) firstOption.classList.add('selected');
        }
        
        // Update prices
        updatePriceForSelectedService();
        
        // Show modal
        if (modal) {
            modal.style.display = "flex";
            const modalContent = modal.querySelector(".modal-content");
            if (modalContent) modalContent.style.animation = "blowUp 0.3s ease-out forwards";
        }
    }

    // Attach to open button if it exists
    if (openModalButton) {
        openModalButton.addEventListener("click", () => {
            showModalWithPrice(10000); // default for testing
        });
    }

    // Attach to close button
    if (closeModalButton) {
        closeModalButton.addEventListener("click", () => {
            if (modal) {
                const modalContent = modal.querySelector(".modal-content");
                if (modalContent) {
                    modalContent.style.animation = "goBack 0.3s ease-out forwards";
                    setTimeout(() => {
                        modal.style.display = "none";
                    }, 300);
                }
            }
        });
    }

    // Optional: Close modal when clicking outside content
    if (modal) {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    }

    // Make `showModalWithPrice` globally accessible
    window.showModalWithPrice = showModalWithPrice;
    window.selectService = selectService;
});

// Price calculation based on frequency
document.addEventListener('DOMContentLoaded', function() {
    // Get all frequency selectors
    const frequencySelectors = document.querySelectorAll('.subscription-frequency');
    
    frequencySelectors.forEach(selector => {
        // Get related elements for each card
        const card = selector.closest('.flex.flex-col');
        if (!card) return;
        
        const displayPrice = card.querySelector('.display-price');
        const proceedButton = card.querySelector('.proceed-button');
        if (!displayPrice || !proceedButton) return;
        
        const basePrice = parseFloat(proceedButton.getAttribute('data-base-price'));
        const virtualA = proceedButton.getAttribute('data-virtual-assistance');
        const callCenter = proceedButton.getAttribute('data-call-center');
        const generalSupport = proceedButton.getAttribute('data-general-support');
        
        // Initial calculation
        updatePrice(selector, displayPrice, proceedButton, basePrice, virtualA, callCenter, generalSupport);
        
        // Add event listener for changes
        selector.addEventListener('change', function() {
            updatePrice(selector, displayPrice, proceedButton, basePrice, virtualA, callCenter, generalSupport);
        });
    });
    
    function updatePrice(selector, displayElement, buttonElement, basePrice, virtualA, callCenter, generalSupport) {
        let price = basePrice;
        let frequency = selector.value;
        
        // Calculate price based on frequency
        switch(frequency) {
            case 'monthly':
                price = basePrice;
                break;
            case 'quarterly':
                price = basePrice * 3 * 0.95; // 5% discount
                break;
            case 'biannually':
                price = basePrice * 6 * 0.90; // 10% discount
                break;
            case 'annually':
                price = basePrice * 12 * 0.85; // 15% discount
                break;
        }
        
        // Update displayed price (formatted with commas)
        displayElement.textContent = Math.round(price).toLocaleString();
        
        // Update the proceed button
        buttonElement.setAttribute('onclick', `showModalWithPrice(${basePrice}, '${frequency}', '${virtualA}', '${callCenter}', '${generalSupport}')`);
    }
});

    </script>
</x-app-layout>