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

                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Bank Transfer Details</h3>
                    <ul class="text-sm space-y-1">
                        <li><strong>Bank:</strong> Zenith Bank</li>
                        <li><strong>Account Name:</strong> EL Tech</li>
                        <li><strong>Account Number:</strong> 1234567890</li>
                    </ul>
                </div>

                <div class="mb-6 text-sm">
                    After successful payment, please send your proof of payment (screenshot or receipt) to:  
                    <a href="mailto:support@dictacare.org" class="text-blue-600 underline">billing@eltechsolution.com</a>
                </div>

                <a href="{{route('invoices.create')}}" id="confirmPayment" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    I’ve Made the Payment
                </a>
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
                        <p class="mt-1 text-gray-600 dark:text-gray-400">Pay as you go service, cancel anytime.</p>
                    </div>
                    <!-- End Title -->

                    <!-- Grid -->
                    <div class="mt-12 relative before:absolute before:inset-0 before:-z-[1] before:bg-[radial-gradient(closest-side,#cbd5e1,transparent)] dark:before:bg-[radial-gradient(closest-side,#334155,transparent)]">
                        <div class="grid gap-px sm:grid-cols-2 lg:grid-cols-4 lg:items-center">
                            <!-- Card -->
                       <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Citizen Service Desk</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="bi-annually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-5xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">10,000</span>
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
                                        Call Centre Service 10,000 Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance 10,000 Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support, 10,000 Points
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="10000" href="#">
                                    Proceed
                                </a>
                            </div>
                        </div>

                        <!-- End Card -->

                        <!-- Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Startup</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="bi-annually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-5xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">30,000</span>
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
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Call Centre Service 20,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance 20,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support, 20,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="30000" href="#">
                                    Proceed
                                </a>
                            </div>
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Team</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="bi-annually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-5xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">40,000</span>
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
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance 30,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support 30,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk 
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="40000" href="#">
                                    Proceed
                                </a>
                            </div>
                        </div>
                        <!-- End Card -->

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
                                        <option value="bi-annually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-5xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">50,000</span>
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
                                        Call Centre Service 50,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance 50,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support, 50,000
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="50000" href="#">
                                    Proceed
                                </a>
                            </div>
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="flex flex-col h-full text-center">
                            <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Premium</h4>
                            </div>

                            <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                <!-- Price display with frequency selector -->
                                <div class="mb-4">
                                    <select class="subscription-frequency w-full p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly (Save 5%)</option>
                                        <option value="bi-annually">Bi-Annually (Save 10%)</option>
                                        <option value="annually">Annually (Save 15%)</option>
                                    </select>
                                </div>
                                
                                <span class="font-bold text-5xl text-gray-800 dark:text-gray-200">
                                    <span class="font-bold text-2xl -me-2">&#8358;</span>
                                    <span class="display-price">100,000</span>
                                </span>
                            </div>

                            <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                <ul class="space-y-2.5 text-center text-sm">
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Plan features
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Call Centre Service 
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Virtual Assistance
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        General Support
                                    </li>
                                    <li class="text-gray-800 dark:text-gray-400">
                                        Citizen Service Desk
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-white py-8 px-8 dark:bg-gray-800">
                                <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white proceed-button" data-base-price="100000" href="#">
                                    Proceed
                                </a>
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

    function showModalWithPrice(price, frequency) {
        planPriceSpan.textContent = `₦${price.toLocaleString()}`;
        modal.style.display = "flex";
        modal.querySelector(".modal-content").style.animation = "blowUp 0.3s ease-out forwards";
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
            const modalContent = modal.querySelector(".modal-content");
            modalContent.style.animation = "goBack 0.3s ease-out forwards";
            setTimeout(() => {
                modal.style.display = "none";
            }, 300);
        });
    }

    // Optional: Close modal when clicking outside content
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // Make `showModalWithPrice` globally accessible
    window.showModalWithPrice = showModalWithPrice;
});

 // Price calculation based on frequency
        document.addEventListener('DOMContentLoaded', function() {
        // Get all frequency selectors
        const frequencySelectors = document.querySelectorAll('.subscription-frequency');
        
        frequencySelectors.forEach(selector => {
            // Get related elements for each card
            const card = selector.closest('.flex.flex-col');
            const displayPrice = card.querySelector('.display-price');
            const proceedButton = card.querySelector('.proceed-button');
            const basePrice = parseFloat(proceedButton.getAttribute('data-base-price'));
            
            // Initial calculation
            updatePrice(selector, displayPrice, proceedButton, basePrice);
            
            // Add event listener for changes
            selector.addEventListener('change', function() {
                updatePrice(selector, displayPrice, proceedButton, basePrice);
            });
        });
        
        function updatePrice(selector, displayElement, buttonElement, basePrice) {
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
                case 'bi-annually':
                    price = basePrice * 6 * 0.90; // 10% discount
                    break;
                case 'annually':
                    price = basePrice * 12 * 0.85; // 15% discount
                    break;
            }
            
            // Update displayed price (formatted with commas)
            displayElement.textContent = Math.round(price).toLocaleString();
            
            // Update the proceed button
            buttonElement.setAttribute('onclick', `showModalWithPrice(${Math.round(price)}, '${frequency}')`);
        }
    });

    </script>
</x-app-layout>

