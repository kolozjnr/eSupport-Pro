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
                                    <h4 class="card-title">User Creation Form</h4>
                                    
                                </div>
                            </div>
                            <div x-data="createUser()" class="p-6">
                                <form>
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
                                    
                                    <!-- Identity Fields Section -->
                                    <div class="mb-6">
                                        <template x-for="(identity, index) in identities" :key="index">
                                            <div class="grid grid-cols-4 gap-2 mb-2 items-end">
                                                <div>
                                                    <label :for="'inputidentity_' + index" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Identity</label>
                                                    <input type="text" class="form-input" x-model="identity.name" :id="'inputidentity_' + index" placeholder="Enter identity">
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
                                        <button type="button" 
                                                @click="addIdentity()"
                                                class="btn bg-blue-500 text-white flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Add Identity
                                        </button>
                                        <button type="submit" class="btn bg-primary text-white">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
            </main>

            <script>
                 document.addEventListener('alpine:init', () => {
                    Alpine.data('createUser', () => ({
                        formData: {
                            fname: '',
                            mname: '',
                            lname: '',
                            role: '',
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
                        }
                    }));
                });
            </script>
    @include('layouts.footer')
</x-app-layout>