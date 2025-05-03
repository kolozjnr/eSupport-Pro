<x-app-layout>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">
            @include('layouts.top-header')
            <main class="flex-grow p-6">

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Dashboard</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Menu</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Dashboard</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid 2xl:grid-cols-4 gap-6 mb-6">
                    
                    <div class="2xl:col-span-3">
                        
                        @include('layouts.invoices.incoice-card')

                        @include('layouts.invoices.revenue-chart')	
                    </div>

                    @include('layouts.admin-ticket-summary')
                </div> <!-- Grid End -->


          

            </main>

           @include('layouts.footer')
    </x-app-layout>