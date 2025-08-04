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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Role Management</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">

                    <div class="col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Manage users Role</h4>
                                    
                                </div>
                            </div>
                            <div x-data="assignCustomer()" class="p-6">
                                <form method="POST" action="{{ route('users.update-role') }}" x-on:submit="isSubmitting = true">
                                         @csrf
                                    <div class="grid grid-cols-4 gap-2 mb-6">

                                       <div class="">
                                            <label for="user_type" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Users</label>
                                            <select x-model="formData.user_type" name="user_type" id="search-select" class="search-select">
                                                <option selected disabled>Choose</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user['id'] }}">{{ $user['name'] }} ({{ $user['role'] }})</option>
                                                @endforeach
                                            </select>
                                        </div>


                                          <!-- Arrow Divider -->
                                        <div class="flex flex-col items-center justify-center pt-6">
                                            <span class="text-gray-500 dark:text-gray-400 font-semibold text-sm mb-1">New Role</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                        
                                        <div class="">
                                            <label for="role" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Roles</label>
                                            <select id="search-select2" x-model="formData.role" name="role" id="role" class="search-select">
                                                <option selected>Choose</option>
                                               
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
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
                            user_type: '',
                            role: ''
                        }
                    }));
                });
            </script>
    @include('layouts.footer')
</x-app-layout>