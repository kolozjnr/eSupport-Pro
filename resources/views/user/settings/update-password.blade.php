

<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    
    <link href="{{ asset('assets/libs/nice-select2/css/nice-select2.css') }}" rel="stylesheet" type="text/css">
    <div class="page-content">
        @include('../layouts.top-header')
        <div x-data="editCustomers()">
            <main class="flex-grow p-4 lg:p-6">

                <!-- Page Title Start -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Update Password</h4>

                    <div class="flex flex-wrap items-center gap-1.5 text-sm font-semibold">
                        <div class="flex items-center gap-1">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-1">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Customer</a>
                        </div>

                        <div class="flex items-center gap-1">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Update Password</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid grid-cols-1 gap-6">
                    <div class="col-span-1 lg:col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    {{-- <h4 class="card-title">Create Draft</h4> --}}
                                </div>
                            </div>
                            <div class="p-4 sm:p-6">
                                <form method="POST" action="{{ route('settings.update-password', auth()->user()->id) }}" enctype="multipart/form-data"
                                    x-on:submit="isSubmitting = true">
                                    @csrf
                                    @method('PUT')
                                    <!-- Default row (always visible) -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                        <div>
                                            <label for="old_password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Old Password</label>
                                            <input type="password" class="form-input w-full" x-model="formData.old_password" name="old_password" id="old_password" placeholder="">
                                        </div>
                                        <div>
                                            <label for="new_password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                                            <input type="password" class="form-input w-full" x-model="formData.new_password" name="new_password" id="new_password" placeholder="">
                                        </div>
                                        <div>
                                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                                            <input type="password" class="form-input w-full" x-model="formData.password_confirmation" name="password_confirmation" id="password_confirmation" placeholder="">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn bg-primary text-white w-full sm:w-auto" x-bind:disabled="isSubmitting">
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
                    }));
                });
            </script>
            
            <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>
            <!-- Choices Demo js -->
            <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 
        </div>
    </div>
</x-app-layout>