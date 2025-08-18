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
                <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Password Reset</h4>

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
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Reset Password</a>
                    </div>
                </div>
            </div>
            <!-- Page Title End -->

            <div class="grid lg:grid-cols-1 grid-cols-1 gap-6">
                <div class="col-span-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">User password reset</h4>
                            </div>
                        </div>
                        <div x-data="passwordResetManager()" class="p-6">
                            
                            <!-- Customer Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <!-- Customer Selection -->
                                <div class="col-span-1">
                                    <label for="search-select" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Select Customer
                                    </label>
                                    <select 
                                        x-model="selectedCustomerId" 
                                        id="search-select" 
                                        class="form-select w-full search-select"
                                        @change="loadCustomerData()"
                                    >
                                        <option value="">Choose a customer...</option>
                                        @foreach ($customers as $customer)
                                            <option 
                                                value="{{ $customer->id }}" 
                                                data-user-id="{{ $customer->user->id }}"
                                                data-user-name="{{ $customer->user->fname }} {{ $customer->user->lname }}"
                                                data-user-email="{{ $customer->user->email }}"
                                            >
                                                {{ $customer->user->fname }} {{ $customer->user->lname }} -
                                                ({{ $customer->user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-span-1" x-show="selectedCustomerId">
                                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Actions
                                    </label>
                                    <div class="flex gap-3">
                                        <button 
                                            @click="showResetConfirmation()"
                                            :disabled="isResetting"
                                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium text-sm"
                                        >
                                            <span x-show="!isResetting">Reset Password</span>
                                            <span x-show="isResetting" class="flex items-center gap-2">
                                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                                Resetting...
                                            </span>
                                        </button>
                                        
                                        <button 
                                            @click="cancelReset()"
                                            class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-medium text-sm"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected User Info -->
                            <div x-show="selectedCustomerId && selectedUser" class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <h4 class="text-sm font-medium mb-2">Selected User Details</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Name:</span>
                                        <span x-text="selectedUser.name" class="font-medium ml-2"></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Email:</span>
                                        <span x-text="selectedUser.email" class="font-medium ml-2"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirmation Modal -->
                            <div x-show="showConfirmation" class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Confirm Password Reset</h4>
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                            This will reset <span x-text="selectedUser.name" class="font-medium"></span>'s password to the default system password. 
                                            The user will need to change it on their next login.
                                        </p>
                                        <div class="flex gap-2 mt-3">
                                            <button 
                                                @click="resetPassword()" 
                                                class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700"
                                                :disabled="isResetting"
                                            >
                                                Proceed
                                            </button>
                                            <button 
                                                @click="cancelReset()" 
                                                class="px-3 py-1 bg-gray-300 text-gray-700 text-xs rounded hover:bg-gray-400"
                                            >
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div x-show="!selectedCustomerId" class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Password Reset Instructions</h4>
                                        <div class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                            <p class="mb-2">Select a customer from the dropdown to reset their password:</p>
                                            <ul class="list-disc list-inside space-y-1 ml-2">
                                                <li>The password will be reset to the system default</li>
                                                {{-- <li>The user will be forced to change it on next login</li> --}}
                                                <li>An email notification will be sent to the user</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Success/Error Messages -->
                            <div x-show="message.text" x-transition class="mt-4">
                                <div 
                                    class="p-4 rounded-lg border"
                                    :class="{
                                        'bg-green-50 border-green-200 text-green-800': message.type === 'success',
                                        'bg-red-50 border-red-200 text-red-800': message.type === 'error',
                                        'bg-yellow-50 border-yellow-200 text-yellow-800': message.type === 'warning'
                                    }"
                                >
                                    <div class="flex items-center gap-2">
                                        <svg x-show="message.type === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <svg x-show="message.type === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <svg x-show="message.type === 'warning'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium" x-text="message.text"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>
        <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('passwordResetManager', () => ({
                    selectedCustomerId: '',
                    selectedUser: null,
                    isResetting: false,
                    showConfirmation: false,
                    message: { text: '', type: '' },

                    loadCustomerData() {
                        if (!this.selectedCustomerId) {
                            this.selectedUser = null;
                            return;
                        }

                        const selectElement = document.getElementById('search-select');
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        
                        this.selectedUser = {
                            id: selectedOption.getAttribute('data-user-id'),
                            name: selectedOption.getAttribute('data-user-name'),
                            email: selectedOption.getAttribute('data-user-email')
                        };
                    },

                    showResetConfirmation() {
                        if (!this.selectedCustomerId || !this.selectedUser) {
                            this.showMessage('Please select a customer first', 'warning');
                            return;
                        }
                        this.showConfirmation = true;
                    },

                    async resetPassword() {
                        if (!this.selectedUser?.id) {
                            this.showMessage('No user selected', 'error');
                            return;
                        }

                        this.isResetting = true;
                        
                        try {
                            const response = await fetch(`/dashboard/administrator/${this.selectedUser.id}/reset-password`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (response.ok) {
                                this.showMessage(`Password for ${this.selectedUser.name} reset successfully!`, 'success');
                                this.showConfirmation = false;
                            } else {
                                throw new Error(data.message || 'Failed to reset password');
                            }
                        } catch (error) {
                            console.error('Error resetting password:', error);
                            this.showMessage(error.message || 'Error resetting password', 'error');
                        } finally {
                            this.isResetting = false;
                        }
                    },

                    cancelReset() {
                        this.showConfirmation = false;
                    },

                    showMessage(text, type = 'success') {
                        this.message = { text, type };
                        setTimeout(() => {
                            this.message = { text: '', type: '' };
                        }, 5000);
                    }
                }));
            });
        </script>

        <!-- Custom CSS -->
        <style>
            .form-switch {
                width: 3rem;
                height: 1.5rem;
            }
            
            .form-switch:checked {
                background-color: #10b981;
                border-color: #10b981;
            }
            
            .animate-spin {
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .search-select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                padding-right: 2.5rem;
            }
        </style>

    @include('layouts.footer')
</x-app-layout>