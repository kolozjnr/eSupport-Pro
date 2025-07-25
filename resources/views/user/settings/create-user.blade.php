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
                    {{-- <div x-show="isSubmitting"
                        x-cloak
                        class="fixed inset-0 bg-white/60 dark:bg-gray-800/60 z-50 flex items-center justify-center">
                        <div class="flex items-center space-x-2 text-gray-700 dark:text-white">
                            <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v8H4z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">Submitting...</span>
                        </div>
                    </div> --}}


                    <div class="col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">User Creation Form</h4>
                                    
                                </div>
                            </div>
                            <div x-data="createUser()" class="p-6">
                                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data"
                                         x-on:submit="isSubmitting = true">
                                         @csrf
                                    <div class="grid grid-cols-4 gap-4 mb-6">
                                        <div>
                                            <label for="fname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">First name</label>
                                            <input type="text" class="form-input" x-model="formData.fname" name="fname" id="fname" value="">
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
                                            <input type="email" class="form-input" id="inputEmail" name="email" placeholder="">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4 gap-2 mb-6">
                                        <div>
                                            <label for="staticEmail2" x-model="formData.display_picture" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Display Picture</label>
                                            <input type="file" class="form-input" name="display_picture" id="staticEmail2" value="">
                                        </div>
                                        <div x-show="isCustomer()">
                                            <label for="referral_code" x-model="formData.referral_code" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Referal Code</label>
                                            <input type="number" class="form-input" name="referral_code" id="referral_code" value="" autocomplete="on">
                                        </div>
                                        <div class="">
                                            <label for="user_type" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                            <select id="search-select" x-model="formData.user_type" name="user_type" id="user_type" class="search-select">
                                                <option selected>Choose</option>
                                                <option value="support">Support Staff</option>
                                                <option value="qualitycontrol">QA</option>
                                                {{-- @if(auth()->user()->hasRole('businessdeveloper')) --}}
                                                <option value="customer">Customer</option>
                                                {{-- @endif --}}
                                                <option value="businessdeveloper">Business Developer</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Identity Fields Section -->
                                    <div class="mb-6" x-show="isSupportStaff()">
                                        <template x-for="(identity, index) in identities" :key="index">
                                            <div class="grid grid-cols-4 gap-2 mb-2 items-end">
                                                <div>
                                                    <label :for="'inputidentity_' + index" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Identity</label>
                                                    {{-- <input type="text" class="form-input" x-model="identity.name" :id="'inputidentity_' + index" placeholder="Enter identity"> --}}
                                                    <input type="text" class="form-input" x-model="identity.name" :name="'identities[]'" :id="'inputidentity_' + index" placeholder="Enter identity">

                                                </div>
                                                <div>
                                                    <button type="button" 
                                                            @click="removeIdentity(index)"
                                                            class="btn bg-red-500 text-white px-3 py-2"
                                                            x-show="identities.length > 1">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <div class="flex gap-4 mt-4">
                                        <span  x-show="isSupportStaff()">
                                            <button type="button" 
                                                @click="addIdentity()"
                                                class="btn bg-blue-500 text-white flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Add Identity
                                        </button>
                                        </span>
                                        {{-- <button type="submit"
                                                :disabled="isSubmitting"
                                                class="btn bg-primary text-white flex items-center"
                                                :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }">
                                            <span x-show="!isSubmitting">Submit</span>
                                            <span x-show="isSubmitting">Submitting...</span>
                                        </button> --}}

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
                    Alpine.data('createUser', () => ({
                    isSubmitting: false,
                        formData: {
                            fname: '',
                            mname: '',
                            lname: '',
                            user_type: '',
                            referral_code: '',
                            display_picture: ''
                        },
                        identities: [{ name: '' }], // First identity field available by default
                        
                        addIdentity() {
                            this.identities.push({ name: '' });
                        },
                        
                        removeIdentity(index) {
                            if (this.identities.length > 1) {
                                this.identities.splice(index, 1);
                            }
                        },
                         isSupportStaff() {
                            return this.formData.user_type === 'support';
                        },
                        isCustomer(){
                            return this.formData.user_type === 'customer';
                        }
                    }));
                });
            </script>
    @include('layouts.footer')
</x-app-layout>