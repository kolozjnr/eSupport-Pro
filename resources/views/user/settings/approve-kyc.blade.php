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
                <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">KYC Management</h4>

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
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">KYC Approval Management</a>
                    </div>
                </div>
            </div>
            <!-- Page Title End -->

            <div class="grid lg:grid-cols-1 grid-cols-1 gap-6">
                <div class="col-span-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Approve/Reject Customer KYC</h4>
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">
                                        {{ count($customers) }} Pending KYC(s)
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div x-data="kycApprovalManager()" class="p-6">
                            
                            <!-- Customer Selection and KYC Status Display -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <!-- Customer Selection -->
                                <div class="col-span-1">
                                    <label for="search-select" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Select Customer
                                    </label>
                                    <select 
                                        x-model="selectedCustomerId" 
                                        @change="loadCustomerKYC()"
                                        id="search-select" 
                                        class="form-select w-full search-select"
                                    >
                                        <option value="">Choose a customer...</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" 
                                                data-kyc-status="{{ $customer->is_kyced }}"
                                                data-user-name="{{ $customer->user->fname . ' ' . $customer->user->lname }}"
                                                data-user-email="{{ $customer->user->email }}"
                                                data-business-name="{{ $customer->business_name ?? 'N/A' }}"
                                                data-phone-number="{{ $customer->phone_number ?? 'N/A' }}"
                                                data-phone-number1="{{ $customer->phone_number1 ?? 'N/A' }}"
                                                data-address="{{ $customer->address ?? 'N/A' }}"
                                                data-landmark="{{ $customer->land_mark ?? 'N/A' }}"
                                                data-nin="{{ $customer->nin ?? 'N/A' }}"
                                                data-nok-name="{{ $customer->nok_name ?? 'N/A' }}"
                                                data-nok-address="{{ $customer->nok_address ?? 'N/A' }}"
                                                data-nok-phone="{{ $customer->nok_phone ?? 'N/A' }}"
                                                data-created-at="{{ $customer->created_at }}"
                                                data-updated-at="{{ $customer->updated_at }}">
                                                {{ $customer->user->fname . ' ' . $customer->user->lname }} 
                                                @if($customer->business_name) - {{ $customer->business_name }} @endif
                                                ({{ $customer->user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Arrow -->
                                <div class="col-span-1 flex flex-col items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400 font-semibold text-sm mb-2">Current KYC Status</span>
                                    <div class="flex items-center justify-center">
                                        <div x-show="selectedCustomerId" class="flex flex-col items-center">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mb-2">
                                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1.5"></span>
                                                Pending Review
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- KYC Action Buttons -->
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        KYC Decision
                                    </label>
                                    <div class="flex flex-col gap-3">
                                        <!-- Action Buttons -->
                                        <div class="flex gap-3">
                                            <button 
                                                @click="updateKYCStatus(2)"
                                                :disabled="!selectedCustomerId || isUpdating"
                                                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium text-sm"
                                            >
                                                <span x-show="!isUpdating || currentAction !== 'approve'">✓ Approve</span>
                                                <span x-show="isUpdating && currentAction === 'approve'" class="flex items-center gap-2">
                                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                                    Approving...
                                                </span>
                                            </button>
                                            
                                            <button 
                                                @click="updateKYCStatus(3)"
                                                :disabled="!selectedCustomerId || isUpdating"
                                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium text-sm"
                                            >
                                                <span x-show="!isUpdating || currentAction !== 'reject'">✗ Reject</span>
                                                <span x-show="isUpdating && currentAction === 'reject'" class="flex items-center gap-2">
                                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                                    Rejecting...
                                                </span>
                                            </button>
                                        </div>

                                        <!-- Result Status Badge -->
                                        <div x-show="actionResult" class="flex justify-center">
                                            <span 
                                                x-show="actionResult === 'approved'" 
                                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                            >
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                                                KYC Approved
                                            </span>
                                            <span 
                                                x-show="actionResult === 'rejected'" 
                                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800"
                                            >
                                                <span class="w-2 h-2 bg-red-400 rounded-full mr-1.5"></span>
                                                KYC Rejected
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Details (when selected) -->
                            <div x-show="selectedCustomerId && selectedCustomer" class="mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <h5 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Customer KYC Details</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <!-- Personal Information -->
                                    <div class="col-span-full mb-4">
                                        <h6 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-2 border-b pb-1">Personal Information</h6>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.userName"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.userEmail"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">NIN:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.nin"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.phoneNumber"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Alternate Phone:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.phoneNumber1"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Business Name:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.businessName"></p>
                                    </div>

                                    <!-- Address Information -->
                                    <div class="col-span-full mt-4 mb-4">
                                        <h6 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-2 border-b pb-1">Address Information</h6>
                                    </div>
                                    <div class="md:col-span-2">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Address:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.address"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Landmark:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.landmark"></p>
                                    </div>

                                    <!-- Next of Kin Information -->
                                    <div class="col-span-full mt-4 mb-4">
                                        <h6 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-2 border-b pb-1">Next of Kin Information</h6>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">NOK Name:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.nokName"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">NOK Phone:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.nokPhone"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">NOK Address:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="selectedCustomer?.nokAddress"></p>
                                    </div>

                                    <!-- System Information -->
                                    <div class="col-span-full mt-4 mb-4">
                                        <h6 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-2 border-b pb-1">System Information</h6>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">KYC Submitted:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="formatDate(selectedCustomer?.createdAt)"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated:</span>
                                        <p class="text-sm text-gray-900 dark:text-gray-100" x-text="formatDate(selectedCustomer?.updatedAt)"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Status:</span>
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1.5"></span>
                                            Pending Review (Status: 1)
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Action Confirmation -->
                                <div x-show="showConfirmation" class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Confirmation Required</h4>
                                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1" x-text="confirmationMessage"></p>
                                            <div class="flex gap-2 mt-3">
                                                <button @click="confirmAction()" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                                    Confirm
                                                </button>
                                                <button @click="cancelAction()" class="px-3 py-1 bg-gray-300 text-gray-700 text-xs rounded hover:bg-gray-400">
                                                    Cancel
                                                </button>
                                            </div>
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
                                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">KYC Review Instructions</h4>
                                        <div class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                            <p class="mb-2">Select a customer from the dropdown to review their KYC submission:</p>
                                            <ul class="list-disc list-inside space-y-1 ml-2">
                                                <li><strong>Approve (Status 3):</strong> Customer's KYC is verified and approved</li>
                                                <li><strong>Reject (Status 2):</strong> Customer's KYC requires correction or is invalid</li>
                                            </ul>
                                            <p class="mt-2 text-xs">Current showing: Customers with KYC status 1 (Pending Review)</p>
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
                Alpine.data('kycApprovalManager', () => ({
                    selectedCustomerId: '',
                    selectedCustomer: null,
                    isUpdating: false,
                    currentAction: '',
                    actionResult: '',
                    showConfirmation: false,
                    pendingStatus: null,
                    confirmationMessage: '',
                    message: { text: '', type: '' },

                    loadCustomerKYC() {
                        if (!this.selectedCustomerId) {
                            this.selectedCustomer = null;
                            this.actionResult = '';
                            return;
                        }

                        // Get selected option data
                        const selectElement = document.getElementById('search-select');
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        
                        if (selectedOption && selectedOption.value) {
                            this.selectedCustomer = {
                                id: selectedOption.value,
                                userName: selectedOption.dataset.userName,
                                userEmail: selectedOption.dataset.userEmail,
                                businessName: selectedOption.dataset.businessName,
                                phoneNumber: selectedOption.dataset.phoneNumber,
                                phoneNumber1: selectedOption.dataset.phoneNumber1,
                                address: selectedOption.dataset.address,
                                landmark: selectedOption.dataset.landmark,
                                nin: selectedOption.dataset.nin,
                                nokName: selectedOption.dataset.nokName,
                                nokAddress: selectedOption.dataset.nokAddress,
                                nokPhone: selectedOption.dataset.nokPhone,
                                kycStatus: selectedOption.dataset.kycStatus,
                                createdAt: selectedOption.dataset.createdAt,
                                updatedAt: selectedOption.dataset.updatedAt
                            };
                            
                            this.actionResult = '';
                            this.showMessage(`Loaded KYC details for ${this.selectedCustomer.userName}`, 'success');
                        }
                    },

                    updateKYCStatus(newStatus) {
                        if (!this.selectedCustomerId) {
                            this.showMessage('Please select a customer first', 'warning');
                            return;
                        }

                        // Set pending status and show confirmation
                        this.pendingStatus = newStatus;
                        this.currentAction = newStatus === 2 ? 'approve' : 'reject';
                        
                        const actionText = newStatus === 2 ? 'approve' : 'reject';
                        this.confirmationMessage = `Are you sure you want to ${actionText} KYC for ${this.selectedCustomer.userName}? This action cannot be undone.`;
                        this.showConfirmation = true;
                    },

                    async confirmAction() {
                        this.showConfirmation = false;
                        this.isUpdating = true;
                        
                        try {
                            const response = await fetch(`/dashboard/users/${this.selectedCustomerId}/kyc-status`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    is_kyced: this.pendingStatus
                                })
                            });

                            const data = await response.json();

                            if (response.ok) {
                                // Update local customer data
                                if (this.selectedCustomer) {
                                    this.selectedCustomer.kycStatus = this.pendingStatus;
                                    this.selectedCustomer.updatedAt = new Date().toISOString();
                                }

                                const actionText = this.pendingStatus === 2 ? 'approved' : 'rejected';
                                this.actionResult = actionText;
                                this.showMessage(`KYC ${actionText} successfully!`, 'success');

                                // Remove this customer from dropdown after action
                                setTimeout(() => {
                                    const selectElement = document.getElementById('search-select');
                                    const optionToRemove = selectElement.querySelector(`option[value="${this.selectedCustomerId}"]`);
                                    if (optionToRemove) {
                                        optionToRemove.remove();
                                    }
                                    
                                    // Reset selection
                                    this.selectedCustomerId = '';
                                    this.selectedCustomer = null;
                                    this.actionResult = '';
                                    
                                    this.showMessage(`Customer removed from pending list. ${actionText.charAt(0).toUpperCase() + actionText.slice(1)} successfully!`, 'success');
                                }, 2000);

                            } else {
                                throw new Error(data.message || 'Failed to update KYC status');
                            }
                        } catch (error) {
                            console.error('Error updating KYC status:', error);
                            this.showMessage(error.message || 'Error updating KYC status', 'error');
                        } finally {
                            this.isUpdating = false;
                            this.currentAction = '';
                            this.pendingStatus = null;
                        }
                    },

                    cancelAction() {
                        this.showConfirmation = false;
                        this.pendingStatus = null;
                        this.currentAction = '';
                        this.confirmationMessage = '';
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