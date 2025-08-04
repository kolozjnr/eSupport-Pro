<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
        <main class="flex-grow p-6">

    

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Layout</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Users</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Create User</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">

                    <div class="col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Credit a Customer</h4>
                                    
                                </div>
                            </div>
                            <div x-data="assignCustomer()" class="p-6">
                                <form method="POST" action="{{ route('invoices.post-manual-invoice') }}" x-on:submit="isSubmitting = true">
                                         @csrf
                                    <div class="">

                                        <div class="grid grid-cols-3 gap-2 mb-6">
                                           <div>
                                             <label for="customer_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                                            <select id="search-select" x-model="formData.customer_id" name="customer_id" id="customer_id" class="search-select">
                                                <option selected>Choose</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->user->fname }}</option>
                                                @endforeach
                                            </select>
                                           </div>

                                            <div>
                                                <label for="amount" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Amount Paid</label>
                                                <input type="number" class="form-input w-full" x-model="formData.amount" name="amount" id="amount" value="">
                                            </div>
                                            
                                            <div>
                                                <label for="frequency" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Amount Paid</label>
                                                <select id="search-select2" x-model="formData.frequency" name="frequency" id="frequency" class="search-select">
                                                <option selected>Choose</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                                
                                            </select>
                                            </div>
                                        </div>

                                        


                                          <!-- Arrow Divider -->
                                        {{-- <div class="flex flex-col items-center justify-center pt-6">
                                            <span class="text-gray-500 dark:text-gray-400 font-semibold text-sm mb-1">Assign to</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                            </svg>
                                        </div> --}}
                                        
                                        <div class="">
                                            <label for="business_developer_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Points</label>
                                           <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-3 gap-4 mb-6">
                                        <div>
                                            <label for="call_center" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Call Center Points</label>
                                            <input type="number" class="form-input w-full" x-model="formData.call_center" name="call_center" id="call_center" value="">
                                        </div>
                                        <div>
                                            <label for="virtual_support" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Virtual Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.virtual_support" name="virtual_support" id="virtual_support" placeholder="">
                                        </div>
                                        <div>
                                            <label for="general_support" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">General Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.general_support" name="general_support" id="general_support" placeholder="">
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="flex gap-4 mt-4">

                                         <button type="submit" class="btn bg-primary text-white w-40" :disabled="isSubmitting">
                                            <span x-show="!isSubmitting">Submit</span>
                                            <span x-show="isSubmitting">Submitting...</span>
                                        </button>
                                        {{-- <button type="submit" class="btn bg-primary text-white">Submit</button> --}}
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
            </main>

        <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>
         <!-- Choices Demo js -->
         <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 

            <script>
                 document.addEventListener('alpine:init', () => {
                    Alpine.data('assignCustomer', () => ({
                    isSubmitting: false,
                        formData: {
                            customer_id: '',
                            amount: '',
                            frequency: '',
                            call_center: '',
                            virtual_support: '',
                            general_support: ''
                        }
                    }));
                });
            </script>
    @include('layouts.footer')
</x-app-layout>