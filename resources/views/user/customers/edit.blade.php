<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    
    <link href="{{ asset('assets/libs/nice-select2/css/nice-select2.css') }}" rel="stylesheet" type="text/css">
    <div class="page-content">
        @include('../layouts.top-header')
        <div x-data="editCustomers()">
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
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Customer</a>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Edit Customer</a>
                            </div>
                        </div>
                    </div>
                    <!-- Page Title End -->

                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                    

                        <div class="col-span-2">
                            <div class="card">
                                <div class="card-header">
                                    <div class="flex justify-between items-center">
                                        {{-- <h4 class="card-title">Create Draft</h4> --}}
                                        
                                    </div>
                                </div>
                                <div class="p-6">
                                     <form method="POST" action="{{ route('customers.update', $customer->id) }}" enctype="multipart/form-data"
                                         x-on:submit="isSubmitting = true">
                                         @csrf
                                        @method('PUT')
                                        <!-- Default row (always visible) -->
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label for="fname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">First name</label>
                                                <input type="text" class="form-input" x-model="formData.fname" name="fname" id="fname" placeholder="">
                                            </div>
                                            {{-- <div>
                                                <label for="mname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Middle name</label>
                                                <input type="text" class="form-input" x-model="formData.mname" name="mname" id="mname" placeholder="">
                                            </div>
                                            <div>
                                                <label for="lname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Last name</label>
                                                <input type="text" class="form-input" x-model="formData.lname" name="lname" id="lname" placeholder="">
                                            </div> --}}
                                            <div>
                                                <label for="inputEmail" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                                <input type="email" class="form-input" x-model="formData.email" name="email" id="inputEmail" placeholder="">
                                            </div>
                                             <div>
                                                <label for="staticEmail2" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Display Picture</label>
                                                <input type="file" class="form-input" x-model="formData.display_picture" name="display_picture" id="staticEmail2">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-4 gap-2 mb-6">
                                           
                                            {{-- <div class="">
                                                <label for="user_type" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                                <select id="user_type" x-model="formData.user_type" name="user_type" class="search-select">
                                                    <option selected disabled hidden>Choose</option>
                                                    <option value="1">Support Staff</option>
                                                    <option value="2">QA</option>
                                                    <option value="3">User</option>
                                                </select>
                                            </div> --}}
                                        </div>

                                           <button type="submit" class="btn bg-primary text-white" x-bind:disabled="isSubmitting">
                                            <template x-if="isSubmitting">
                                                <span class="animate-spin mr-2 border-2 border-white border-t-transparent rounded-full w-4 h-4 inline-block"></span>
                                            </template>
                                            <span x-text="isSubmitting ? 'Submitting...' : 'Submit'"></span>
                                        </button>
                                    </form>
                                </div>
                            </div> <!-- end card -->

                            {{-- KYC --}}

                            <div class="card">
                                <div class="card-header">
                                    <div class="flex justify-between items-center">
                                        {{-- <h4 class="card-title">Create Draft</h4> --}}
                                        
                                    </div>
                                </div>
                                <div class="p-6">
                                     <form method="POST" action="{{ route('customers.submit-kyc', $customer->customer->id) }}"
                                         x-on:submit="isSubmitting = true">
                                         @csrf
                                        @method('PUT')
                                          <!-- Contact Information -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4 flex">KYC Information <span class="ml-2">
                                              
                                            @if (Auth::user()->customer->is_kyced == 0)
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFA500" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                                
                                            @elseif(Auth::user()->customer->is_kyced == 1)
                                                
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            @elseif(Auth::user()->customer->is_kyced == 2)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="#1DA1F2" d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.818-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.437 2.25c-.415-.165-.866-.25-1.336-.25-2.11 0-3.818 1.79-3.818 4 0 .494.083.964.237 1.4-1.272.65-2.147 2.018-2.147 3.6 0 1.495.782 2.798 1.942 3.486-.02.17-.032.34-.032.514 0 2.21 1.708 4 3.818 4 .47 0 .92-.086 1.335-.25.62 1.334 1.926 2.25 3.437 2.25 1.512 0 2.818-.916 3.437-2.25.415.163.865.248 1.336.248 2.11 0 3.818-1.79 3.818-4 0-.174-.012-.344-.033-.513 1.158-.687 1.943-1.99 1.943-3.484zm-6.616-3.334l-4.334 6.5c-.145.217-.382.334-.625.334-.143 0-.288-.04-.416-.126l-.115-.094-2.415-2.415c-.293-.293-.293-.768 0-1.06s.768-.294 1.06 0l1.77 1.767 3.825-5.74c.23-.345.696-.436 1.04-.207.346.23.44.696.21 1.04z"/>
                                            </svg>
                                            
                                            @elseif(Auth::user()->customer->is_kyced == 3)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" fill="#dc3545"/>
                                                <path stroke="#ffffff" stroke-width="2" stroke-linecap="round" d="M8 8l8 8m0-8l-8 8"/>
                                            </svg>
                                            @endif
                                            
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#FFA500" stroke="#FFF" stroke-width="1">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12" stroke="#FFF" stroke-width="2"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16" stroke="#FFF" stroke-width="2"></line>
                                            </svg> --}}

                                           


                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="12" fill="#1DA1F2"/> <!-- Twitter blue -->
                                                <path fill="#FFFFFF" d="M9.6 16.6l-3.2-3.2 1.4-1.4 1.8 1.8 4.8-4.8 1.4 1.4z"/>
                                            </svg>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="12" fill="#1877F2"/> <!-- Facebook blue -->
                                                <path fill="#FFFFFF" d="M17.3 8.3l-7.1 7.1-3.1-3.1-1.4 1.4 4.5 4.5 8.5-8.5z"/>
                                            </svg> --}}

                                            
                                            </span> </h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label for="business_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Business Name *</label>
                                                    <input type="text" name="business_name" class="form-input" x-model="formData.business_name" id="business_name" required>
                                                </div>
                                                <div>
                                                    <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                                    <input type="tel" name="phone_number" class="form-input" x-model="formData.phone_number" id="phone_number">
                                                </div>
                                                <div>
                                                    <label for="nin" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">NIN</label>
                                                    <input type="number" name="nin" class="form-input" x-model="formData.nin" id="nin" maxlength="11">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Address Information -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Address Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="address" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                                    <textarea name="address" class="form-input" x-model="formData.address" id="address" rows="3"></textarea>
                                                </div>
                                                <div>
                                                    <label for="land_mark" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Landmark</label>
                                                     <textarea name="land_mark" class="form-input" x-model="formData.land_mark" id="land_mark" rows="3"></textarea>

                                                    {{-- <input type="text" name="land_mark" class="form-input" x-model="formData.land_mark" id="land_mark"> --}}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Next of Kin Information -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Next of Kin Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label for="nok_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Next of Kin Name</label>
                                                    <input type="text" name="nok_name" class="form-input" x-model="formData.nok_name" id="nok_name">
                                                </div>
                                                <div>
                                                    <label for="nok_phone" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Next of Kin Phone</label>
                                                    <input type="tel" name="nok_phone" class="form-input" x-model="formData.nok_phone" id="nok_phone">
                                                </div>
                                                <div>
                                                    <label for="nok_address" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Next of Kin Address</label>
                                                    <textarea name="nok_address" class="form-input" x-model="formData.nok_address" id="nok_address" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>


                                           <button type="submit" class="btn bg-primary text-white" x-bind:disabled="isSubmitting">
                                            <template x-if="isSubmitting">
                                                <span class="animate-spin mr-2 border-2 border-white border-t-transparent rounded-full w-4 h-4 inline-block"></span>
                                            </template>
                                            <span x-text="isSubmitting ? 'Submitting...' : 'Submit'"></span>
                                        </button>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    </div>
            </main>

          

    @include('layouts.footer')

    <script>
          document.addEventListener('alpine:init', () => {
            Alpine.data('editCustomers', () => ({
                isSubmitting: false,
                formData: {
                    fname: @json($customer->fname),
                    mname: @json($customer->mname),
                    lname: @json($customer->lname),
                    email: @json($customer->email),
                    business_name: @json($customer->customer->business_name),
                    phone_number: @json($customer->customer->phone_number),
                    nin: @json($customer->customer->nin),
                    nok_phone: @json($customer->customer->nok_phone),
                    nok_address: @json($customer->customer->nok_address),
                    nok_name: @json($customer->customer->nok_name),
                    land_mark: @json($customer->customer->land_mark),
                    address: @json($customer->customer->address),
                    // role: @json($customer->user_type),
                    display_picture: ''
                },
            }));
        });
    </script>
    
         <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>

         <!-- Choices Demo js -->
         <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 
</x-app-layout>