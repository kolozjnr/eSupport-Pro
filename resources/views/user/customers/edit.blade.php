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
                                        <div class="grid grid-cols-4 gap-4 mb-6">
                                            <div>
                                                <label for="fname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">First name</label>
                                                <input type="text" class="form-input" x-model="formData.fname" name="fname" id="fname" placeholder="">
                                            </div>
                                            <div>
                                                <label for="mname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Middle name</label>
                                                <input type="text" class="form-input" x-model="formData.mname" name="mname" id="mname" placeholder="">
                                            </div>
                                            <div>
                                                <label for="lname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Last name</label>
                                                <input type="text" class="form-input" x-model="formData.lname" name="lname" id="lname" placeholder="">
                                            </div>
                                            <div>
                                                <label for="inputEmail" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                                <input type="email" class="form-input" x-model="formData.email" name="email" id="inputEmail" placeholder="">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-4 gap-2 mb-6">
                                            <div>
                                                <label for="staticEmail2" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Display Picture</label>
                                                <input type="file" class="form-input" x-model="formData.display_picture" name="display_picture" id="staticEmail2">
                                            </div>
                                            <div class="">
                                                <label for="user_type" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                                <select id="user_type" x-model="formData.user_type" name="user_type" class="search-select">
                                                    <option selected disabled hidden>Choose</option>
                                                    <option value="1">Support Staff</option>
                                                    <option value="2">QA</option>
                                                    <option value="3">User</option>
                                                </select>
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
                    role: @json($customer->user_type),
                    display_picture: ''
                },
            }));
        });
    </script>
    
         <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>

         <!-- Choices Demo js -->
         <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 
</x-app-layout>