<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
        <main class="flex-grow p-4 lg:p-6">
            <!-- Page Title Start -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">System Settings</h4>

                <div class="flex flex-wrap items-center gap-1.5 text-sm font-semibold">
                    <div class="flex items-center gap-1">
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                    </div>

                    <div class="flex items-center gap-1">
                        <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Users</a>
                    </div>

                    <div class="flex items-center gap-1">
                        <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Settings</a>
                    </div>
                </div>
            </div>
            <!-- Page Title End -->

            <div class="grid grid-cols-1 gap-6">
                <div class="col-span-1 lg:col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Settings</h4>
                            </div>
                        </div>
                        <div x-data="settings()" class="p-4 sm:p-6">
                            {{-- General Settings --}}
                            <div class="mb-8 sm:mb-10">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data"
                                        x-on:submit="isSubmitting = true">
                                        @csrf
                                        
                                    <h4 class="block mb-4 text-lg sm:text-xl font-medium text-gray-700 dark:text-gray-300">Ticket Charges settings</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 sm:mb-10">
                                        <div>
                                            <label for="long_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">System Name</label>
                                            <input type="text" class="form-input w-full" x-model="formData.long_name" name="long_name" id="long_name" value="" placeholder="Eltech Support Pro">
                                        </div>
                                        <div>
                                            <label for="short_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Alias</label>
                                            <input type="text" class="form-input w-full" x-model="formData.short_name" name="short_name" id="short_name" placeholder="eSupport">
                                        </div>
                                        <div>
                                            <label for="support_email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Support Email</label>
                                            <input type="email" class="form-input w-full" x-model="formData.support_email" name="support_email" id="support_email" placeholder="support@eltech.com">
                                        </div>
                                        <div>
                                            <label for="billing_email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Billing Email</label>
                                            <input type="email" class="form-input w-full" x-model="formData.billing_email" name="billing_email" id="billing_email" placeholder="support@eltech.com">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                        <div>
                                            <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                            <input type="number" class="form-input w-full" x-model="formData.phone_number" name="phone_number" id="phone_number" value="" placeholder="2347067317819">
                                        </div>
                                        <div>
                                            <label for="dark_logo" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Dark mode Logo</label>
                                            <input type="file" class="form-input w-full" x-model="formData.dark_logo" name="dark_logo" id="dark_logo" placeholder="eSupport">
                                        </div>
                                        <div>
                                            <label for="light_logo" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Light Mode Logo</label>
                                            <input type="file" class="form-input w-full" x-model="formData.light_logo" name="light_logo" id="light_logo">
                                        </div>
                                        <div>
                                            <label for="fav_icon" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Favicon</label>
                                            <input type="file" class="form-input w-full" x-model="formData.favicon" name="favicon" id="" placeholder="support@eltech.com">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                        <div>
                                            <label for="dark_logo_sm" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Dark mode Logo <small>small</small></label>
                                            <input type="file" class="form-input w-full" x-model="formData.dark_logo_sm" name="dark_logo_sm" id="dark_logo_sm" placeholder="eSupport">
                                        </div>
                                        <div>
                                            <label for="light_logo_sm" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Light Mode Logo <small>small</small></label>
                                            <input type="file" class="form-input w-full" x-model="formData.light_logo_sm" name="light_logo_sm" id="light_logo_sm">
                                        </div>
                                    </div>

                                    <h4 class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Charges settings</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 sm:mb-8">
                                        <div>
                                            <label for="general_support_charge" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">General support charge</label>
                                            <input type="number" class="form-input w-full" x-model="formData.general_support_charge" name="general_support_charge" id="general_support_charge" value="">
                                        </div>
                                        <div>
                                            <label for="call_center_charge" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Call Center Charge</label>
                                            <input type="text" class="form-input w-full" x-model="formData.call_center_charge" name="call_center_charge" id="call_center_charge" placeholder="">
                                        </div>
                                        <div>
                                            <label for="virtual_support_charge" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Virtual Support Charge</label>
                                            <input type="text" class="form-input w-full" x-model="formData.virtual_support_charge" name="virtual_support_charge" id="virtual_support_charge" placeholder="">
                                        </div>
                                    </div>

                                    <h4 class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Pricing settings</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                                        <div>
                                            <label for="citizen_desk_plan_amount" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Citizen Desk</label>
                                            <input type="number" class="form-input w-full" x-model="formData.citizen_desk_plan_amount" name="citizen_desk_plan_amount" id="citizen_desk_plan_amount" value="">
                                        </div>
                                        <div>
                                            <label for="startup_up_amount" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Start up</label>
                                            <input type="text" class="form-input w-full" x-model="formData.startup_up_amount" name="startup_up_amount" id="startup_up_amount" placeholder="">
                                        </div>
                                        <div>
                                            <label for="team_amount" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Team</label>
                                            <input type="text" class="form-input w-full" x-model="formData.team_amount" name="team_amount" id="team_amount" placeholder="">
                                        </div>
                                        
                                        <div>
                                            <label for="enterprise_amount" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Enterprise</label>
                                            <input type="text" class="form-input w-full" x-model="formData.enterprise_amount" name="enterprise_amount" id="enterprise_amount" placeholder="">
                                        </div>
                                        <div>
                                            <label for="premium_amount" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Premium</label>
                                            <input type="text" class="form-input w-full" x-model="formData.premium_amount" name="premium_amount" id="premium_amount" placeholder="">
                                        </div>
                                    </div>

                                    

                                    <h4 class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Lite Pricing settings</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                        <div>
                                            <label for="call_center_lite" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Call Center Points</label>
                                            <input type="number" class="form-input w-full" x-model="formData.call_center_lite" name="call_center_lite" id="call_center_lite" value="">
                                        </div>
                                        <div>
                                            <label for="virtual_support_lite" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Virtual Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.virtual_support_lite" name="virtual_support_lite" id="virtual_support_lite" placeholder="">
                                        </div>
                                        <div>
                                            <label for="general_support_lite" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">General Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.general_support_lite" name="general_support_lite" id="general_support_lite" placeholder="">
                                        </div>
                                    </div>

                                     <h4 class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Standard Pricing settings</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                        <div>
                                            <label for="call_center_standard" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Call Center Points</label>
                                            <input type="number" class="form-input w-full" x-model="formData.call_center_standard" name="call_center_standard" id="call_center_standard" value="">
                                        </div>
                                        <div>
                                            <label for="virtual_support_standard" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Virtual Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.virtual_support_standard" name="virtual_support_standard" id="virtual_support_standard" placeholder="">
                                        </div>
                                        <div>
                                            <label for="general_support_standard" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">General Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.general_support_standard" name="general_support_standard" id="general_support_standard" placeholder="">
                                        </div>
                                    </div>

                                    <h4 class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Advanced Pricing settings</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                        <div>
                                            <label for="call_center_advanced" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Call Center Points</label>
                                            <input type="number" class="form-input w-full" x-model="formData.call_center_advanced" name="call_center_advanced" id="call_center_advanced" value="">
                                        </div>
                                        <div>
                                            <label for="virtual_support_advanced" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Virtual Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.virtual_support_advanced" name="virtual_support_advanced" id="virtual_support_advanced" placeholder="">
                                        </div>
                                        <div>
                                            <label for="general_support_advanced" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">General Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.general_support_advanced" name="general_support_advanced" id="general_support_advanced" placeholder="">
                                        </div>
                                    </div>

                                    
                                    <h4 class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Advanced Business settings</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                        <div>
                                            <label for="call_center_business" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Call Center Points</label>
                                            <input type="number" class="form-input w-full" x-model="formData.call_center_business" name="call_center_business" id="call_center_business" value="">
                                        </div>
                                        <div>
                                            <label for="virtual_support_business" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Virtual Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.virtual_support_business" name="virtual_support_business" id="virtual_support_business" placeholder="">
                                        </div>
                                        <div>
                                            <label for="general_support_business" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">General Support</label>
                                            <input type="text" class="form-input w-full" x-model="formData.general_support_business" name="general_support_business" id="general_support_business" placeholder="">
                                        </div>
                                    </div>
                                
                                    
                                    <div class="flex gap-4 mt-4">
                                    
                                        <button type="submit" class="btn bg-primary text-white w-40 sm:w-40" :disabled="isSubmitting">
                                            <span x-show="!isSubmitting">Save Changes</span>
                                            <span x-show="isSubmitting">Submitting...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
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
                    Alpine.data('settings', () => ({
                    isSubmitting: false,
                        formData: {
                            long_name: @json($settings->long_name ?? ''),
                            short_name: @json($settings->short_name ?? ''),
                            support_email: @json($settings->support_email ?? ''),
                            billing_email: @json($settings->billing_email ?? ''),
                            phone_number: @json($settings->phone_number ?? ''),
                            general_support_charge: @json($settings->general_support_charge ?? ''),
                            call_center_charge: @json($settings->call_center_charge ?? ''),
                            virtual_support_charge: @json($settings->virtual_support_charge ?? ''),
                            citizen_desk_plan_amount: @json($settings->citizen_desk_plan_amount ?? ''),
                            startup_up_amount: @json($settings->startup_up_amount ?? ''),
                            team_amount: @json($settings->team_amount ?? ''),
                            enterprise_amount: @json($settings->enterprise_amount ?? ''),
                            premium_amount: @json($settings->premium_amount ?? ''),
                            call_center_advanced: @json($settings->call_center_advanced ?? ''),
                            virtual_support_advanced: @json($settings->virtual_support_advanced ?? ''),
                            general_support_advanced: @json($settings->general_support_advanced ?? ''),
                            call_center_business: @json($settings->call_center_business ?? ''),
                            virtual_support_business: @json($settings->virtual_support_business ?? ''),
                            general_support_business: @json($settings->general_support_business ?? ''),
                            
                            call_center_lite: @json($settings->call_center_lite ?? ''),
                            virtual_support_lite: @json($settings->virtual_support_lite ?? ''),
                            general_support_lite: @json($settings->general_support_lite ?? ''),
                            call_center_standard: @json($settings->call_center_standard ?? ''),
                            virtual_support_standard: @json($settings->virtual_support_standard ?? ''),
                            general_support_standard: @json($settings->general_support_standard ?? ''),

                        
                            user_type: @json($settings->user_type ?? ''),

                        },
                       
                        //  isSupportStaff() {
                        //     return this.formData.user_type === 'support';
                        // }
                    }));
                });
            </script>
    @include('layouts.footer')
</x-app-layout>