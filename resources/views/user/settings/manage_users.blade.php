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
                <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">User Management</h4>

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
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Status Management</a>
                    </div>
                </div>
            </div>
            <!-- Page Title End -->

            <div class="grid lg:grid-cols-1 grid-cols-1 gap-6">
                <div class="col-span-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Manage User Status</h4>
                            </div>
                        </div>
                        <div x-data="userStatusManager()" class="p-6">
                            
                            <!-- User Selection and Status Display -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <!-- User Selection -->
                                <div class="col-span-1">
                                    <label for="search-select" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Select User
                                    </label>
                                    <select 
                                        x-model="selectedUserId" 
                                        @change="loadUserStatus()"
                                        id="search-select" 
                                        class="form-select w-full search-select"
                                    >
                                        <option value="">Choose a user...</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" data-active="{{ $user->is_active ? 1 : 0 }}">
                                                {{ $user->fname . ' ' . $user->lname }} ({{ $user->user_type }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Arrow -->
                                <div class="col-span-1 flex flex-col items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400 font-semibold text-sm mb-2">Current Status</span>
                                    <div class="flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Status Toggle -->
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        User Status
                                    </label>
                                    <div class="flex flex-col gap-3">
                                        <!-- Status Display -->
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center">
                                                <input 
                                                    class="form-switch" 
                                                    type="checkbox" 
                                                    role="switch" 
                                                    id="status_toggle"
                                                    x-model="userStatus"
                                                    @change="updateUserStatus()"
                                                    :disabled="!selectedUserId || isUpdating"
                                                >
                                                <label class="ms-2 text-sm font-medium" for="status_toggle">
                                                    <span x-show="userStatus" class="text-green-600">Active</span>
                                                    <span x-show="!userStatus" class="text-red-600">Inactive</span>
                                                </label>
                                            </div>
                                            
                                            <!-- Loading indicator -->
                                            <div x-show="isUpdating" class="flex items-center gap-2">
                                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                                                <span class="text-sm text-blue-600">Updating...</span>
                                            </div>
                                        </div>

                                        <!-- Status Badge -->
                                        <div x-show="selectedUserId" class="flex items-center gap-2">
                                            <span 
                                                x-show="userStatus" 
                                                class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                            >
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                                                Active User
                                            </span>
                                            <span 
                                                x-show="!userStatus" 
                                                class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800"
                                            >
                                                <span class="w-2 h-2 bg-red-400 rounded-full mr-1.5"></span>
                                                Inactive User
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Details (when selected) -->
                            <div x-show="selectedUserId && selectedUser" class="mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <h5 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">User Details</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedUser?.fname + ' ' + selectedUser?.lname"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedUser?.email"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">User Type:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedUser?.user_type"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="formatDate(selectedUser?.updated_at)"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div x-show="!selectedUserId" class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Instructions</h4>
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                            Select a user from the dropdown to view and manage their status. You can toggle between Active and Inactive states using the switch.
                                        </p>
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
                                        <span class="font-medium" x-text="message.text"></span>
                                    </div>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="mt-4 alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>
         <!-- Choices Demo js -->
         <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('userStatusManager', () => ({
                    selectedUserId: '',
                    userStatus: false,
                    isUpdating: false,
                    selectedUser: null,
                    message: { text: '', type: '' },
                    
                    // User data from server
                    users: @json($users),

                    loadUserStatus() {
                        if (!this.selectedUserId) {
                            this.userStatus = false;
                            this.selectedUser = null;
                            return;
                        }

                        // Find selected user
                        this.selectedUser = this.users.find(user => user.id == this.selectedUserId);
                        
                        if (this.selectedUser) {
                            this.userStatus = Boolean(this.selectedUser.is_active);
                            this.showMessage(`Loaded status for ${this.selectedUser.fname} ${this.selectedUser.lname}`, 'success');
                        }
                    },

                    async updateUserStatus() {
                        if (!this.selectedUserId) {
                            this.showMessage('Please select a user first', 'warning');
                            return;
                        }

                        this.isUpdating = true;
                        
                        try {
                            const response = await fetch(`/dashboard/users/${this.selectedUserId}/status`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    is_active: this.userStatus
                                })
                            });

                            const data = await response.json();

                            if (response.ok) {
                                // Update local user data
                                if (this.selectedUser) {
                                    this.selectedUser.is_active = this.userStatus;
                                    this.selectedUser.updated_at = new Date().toISOString();
                                }
                                
                                // Update users array
                                const userIndex = this.users.findIndex(user => user.id == this.selectedUserId);
                                if (userIndex !== -1) {
                                    this.users[userIndex].is_active = this.userStatus;
                                    this.users[userIndex].updated_at = new Date().toISOString();
                                }

                                const statusText = this.userStatus ? 'activated' : 'deactivated';
                                this.showMessage(`User ${statusText} successfully!`, 'success');
                            } else {
                                throw new Error(data.message || 'Failed to update user status');
                            }
                        } catch (error) {
                            console.error('Error updating user status:', error);
                            this.showMessage(error.message || 'Error updating user status', 'error');
                            
                            // Revert the toggle on error
                            this.userStatus = !this.userStatus;
                        } finally {
                            this.isUpdating = false;
                        }
                    },

                    showMessage(text, type = 'success') {
                        this.message = { text, type };
                        setTimeout(() => {
                            this.message = { text: '', type: '' };
                        }, 5000);
                    },

                    formatDate(dateString) {
                        if (!dateString) return 'N/A';
                        return new Date(dateString).toLocaleString();
                    }
                }));
            });
        </script>

        <!-- Custom CSS for better styling -->
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
        </style>

    @include('layouts.footer')
</x-app-layout>