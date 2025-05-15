<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
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
                                    <span class="mt-7 font-bold text-5xl text-gray-800 dark:text-gray-200">
                                        <span class="font-bold text-2xl -me-2">&#8358;</span>
                                        10,000
                                    </span>
                                </div>

                                <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                    <ul class="space-y-2.5 text-center text-sm">
                                        {{-- <li class="text-gray-800 dark:text-gray-400">
                                            1 user
                                        </li> --}}

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
                                            Virtual Asistance 10,000 Points
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
                                    <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white" href="#">
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
                                    <span class="mt-7 font-bold text-5xl text-gray-800 dark:text-gray-200">
                                        <span class="font-bold text-2xl -me-2">&#8358;</span>
                                        30,000
                                    </span>
                                </div>

                                <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                    <ul class="space-y-2.5 text-center text-sm">
                                        {{-- <li class="text-gray-800 dark:text-gray-400">
                                            1 user
                                        </li> --}}

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
                                            Virtual Asistance 20,000
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
                                    <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white" href="#">
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
                                    <span class="mt-7 font-bold text-5xl text-gray-800 dark:text-gray-200">
                                        <span class="font-bold text-2xl -me-2">&#8358;</span>
                                        40,000
                                    </span>
                                </div>

                                <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                    <ul class="space-y-2.5 text-center text-sm">
                                        {{-- <li class="text-gray-800 dark:text-gray-400">
                                            5 users
                                        </li> --}}

                                        <li class="text-gray-800 dark:text-gray-400">
                                            Plan features
                                        </li>

                                        <li class="text-gray-800 dark:text-gray-400">
                                            101 - 500 Tasks
                                        </li>

                                        <li class="text-gray-800 dark:text-gray-400">
                                            Virtual Asistance 30,000
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
                                    <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white" href="#">
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
                                    <span class="mt-7 font-bold text-5xl text-gray-800 dark:text-gray-200">
                                        <span class="font-bold text-2xl -me-2">&#8358;</span>
                                        50,000
                                    </span>
                                </div>

                                <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                    <ul class="space-y-2.5 text-center text-sm">
                                        {{-- <li class="text-gray-800 dark:text-gray-400">
                                            10 users
                                        </li> --}}

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
                                            Virtual Asistance 50,000
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
                                    <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white" href="#">
                                        Proceed
                                    </a>
                                </div>
                            </div>
                            <!-- End Card -->
                        </div>
                    </div><!-- End Grid -->

                        <!-- Grid -->
                    <div class="mt-12 relative before:absolute before:inset-0 before:-z-[1] before:bg-[radial-gradient(closest-side,#cbd5e1,transparent)] dark:before:bg-[radial-gradient(closest-side,#334155,transparent)]">
                        <div class="grid gap-px sm:grid-cols-2 lg:grid-cols-4 lg:items-center">
                            <!-- Card -->
                            <div class="flex flex-col h-full text-center">
                                <div class="bg-white pt-8 pb-5 px-8 dark:bg-gray-800">
                                    <h4 class="font-medium text-lg text-gray-800 dark:text-gray-200">Premiun</h4>
                                </div>

                                <div class="h-full bg-white lg:mt-px lg:py-5 px-8 dark:bg-gray-800">
                                    <span class="mt-7 font-bold text-5xl text-gray-800 dark:text-gray-200">
                                        <span class="font-bold text-2xl -me-2">&#8358;</span>
                                        100,000
                                    </span>
                                </div>

                                <div class="bg-white flex justify-center lg:mt-px pt-7 px-8 dark:bg-gray-800">
                                    <ul class="space-y-2.5 text-center text-sm">
                                        {{-- <li class="text-gray-800 dark:text-gray-400">
                                            1 user
                                        </li> --}}

                                        <li class="text-gray-800 dark:text-gray-400">
                                            Plan features
                                        </li>

                                        <li class="text-gray-800 dark:text-gray-400">
                                            Call Centre Service 
                                        </li>

                                        <li class="text-gray-800 dark:text-gray-400">
                                            Virtual Asistance
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
                                    <a class="btn btn-lg border-primary text-primary hover:bg-primary hover:text-white" href="#">
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
    </script>
</x-app-layout>