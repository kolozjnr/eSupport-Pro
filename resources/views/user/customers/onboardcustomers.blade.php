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
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Customer onboarding</a>
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
                                    <form method="POST">
                                        <!-- Default row (always visible) -->
                                        <div class="grid grid-cols-4 gap-4 mb-6">
                                            <div>
                                                <label for="fname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">First name</label>
                                                <input type="text" class="form-input" x-model="formData.fname" id="fname" value="">
                                            </div>
                                            <div>
                                                <label for="mname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Middle name</label>
                                                <input type="text" class="form-input" x-model="formData.mname" id="mname" placeholder="">
                                            </div>
                                            <div>
                                                <label for="lname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Last name</label>
                                                <input type="text" class="form-input" x-model="formData.lname" id="lname" placeholder="">
                                            </div>
                                            <div>
                                                <label for="inputEmail" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                                <input type="email" class="form-input" id="inputEmail" placeholder="">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-4 gap-2 mb-6">
                                            <div>
                                                <label for="staticEmail2" x-model="formData.display_picture" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Display Picture</label>
                                                <input type="file" class="form-input" id="staticEmail2" value="">
                                            </div>
                                            <div class="">
                                                <label for="role" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                                <select id="search-select" x-model="formData.role" name="role" id="role" class="search-select">
                                                    <option selected disabled hidden>Choose</option>
                                                    <option value="1">Support Staff</option>
                                                    <option value="2">QA</option>
                                                    <option value="3">User</option>
                                                </select>
                                            </div>
                                        </div>
                                
                                     
                                
                                        <div class="flex gap-4 mt-4">
                                            
                                            <button type="submit" class="btn bg-primary text-white">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-span-2">
                            <div class="card">
                                <div class="card-header">
                                    <div class="flex justify-between items-center">
                                        <h4 class="card-title">Multiple Task</h4>
                                        <div class="flex items-center gap-2">
                                            {{-- <button type="button" class="btn-code" data-fc-type="collapse" data-fc-target="GridFormHtml">
                                                <i class="mgc_eye_line text-lg"></i>
                                                <span class="ms-2">Code</span>
                                            </button> --}}

                                            <button class="btn-code" data-clipboard-action="copy">
                                                <i class="mgc_download_line text-lg"></i>
                                                <span class="ms-2">Download Template</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Here you can upload multiple tasks using the provided template above.</p>

                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="grid grid-cols-1 md:grid-cols-2  gap-6">
                                            <div>
                                                <label for="inputEmail4" class="text-gray-800 text-sm font-medium inline-block mb-2">Name</label>
                                                <input type="name" class="form-input" id="inputEmail4" placeholder="Email">
                                            </div>
                                            <div>
                                                <label for="inputPassword4" class="text-gray-800 text-sm font-medium inline-block mb-2">File</label>
                                                <input type="file" class="form-input" id="inputPassword4" placeholder="Password">
                                            </div>

                                        <button type="submit" class="btn bg-primary text-white w-40">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
            </main>

          

    @include('layouts.footer')

    <script>
          document.addEventListener('alpine:init', () => {
                    Alpine.data('onboardCustomers', () => ({
                        formData: {
                            fname: '',
                            mname: '',
                            lname: '',
                            role: '',
                            display_picture: ''
                        },
                    }));
                });
    </script>
</x-app-layout>