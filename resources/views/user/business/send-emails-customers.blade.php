<x-app-layout>
    <!-- Previous head content remains the same -->
    
    <div class="page-content">
        @include('../layouts.top-header')
        <main class="flex-grow p-6">
            <!-- Previous page title and breadcrumb remains the same -->

            <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Send Emails</h4>
                            </div>
                        </div>
                        <div x-data="sendCustomerEmail()" class="p-6">
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Recipients</label>
                                <select x-model="recipientType" class="selectize" placeholder="Choose...">
                                    <option value="all">Send to all Customers</option>
                                    <option value="inactive">Inactive customers</option>
                                    {{-- <option value="selected">Selected customers</option> --}}
                                    <option value="single">Single customer</option>
                                </select>
                            </div>
                            
                            <!-- Loading state -->
                            <div x-show="isLoading" class="mb-4 text-center py-4">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-primary"></div>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Loading customers...</p>
                            </div>

                            <!-- Error state -->
                            <div x-show="loadError" class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700" x-text="loadError"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- All Customers Form -->
                            <form method="POST" action="{{ route('busines-developer.send-all-customers') }}" x-show="recipientType === 'all' && !isLoading" x-on:submit="isSubmitting = true">
                                @csrf
                                <input type="hidden" name="recipient_type" value="all">
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                    <input type="text" name="subject" class="form-input w-full" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                    <textarea name="message" class="form-textarea w-full" rows="5" required></textarea>
                                </div>
                                
                                <div class="flex gap-4 mt-4">
                                    <button type="submit" class="btn bg-primary text-white w-40" :disabled="isSubmitting">
                                        <span x-show="!isSubmitting">Submit</span>
                                        <span x-show="isSubmitting">Submitting...</span>
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Inactive Customers Form -->
                            <form method="POST" action="{{ route('busines-developer.send-inactive-post') }}" x-show="recipientType === 'inactive' && !isLoading" x-on:submit="isSubmitting = true">
                                @csrf
                                <input type="hidden" name="recipient_type" value="inactive">
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inactive Customers</label>
                                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded border border-gray-200 dark:border-gray-700">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Inactive customers will be automatically selected</p>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                    <input type="text" name="subject" class="form-input w-full" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                    <textarea name="message" class="form-textarea w-full" rows="5" required></textarea>
                                </div>
                                
                                <div class="flex gap-4 mt-4">
                                    <button type="submit" class="btn bg-primary text-white w-40" :disabled="isSubmitting">
                                        <span x-show="!isSubmitting">Submit</span>
                                        <span x-show="isSubmitting">Submitting...</span>
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Selected Customers Form -->
                            {{-- <form method="POST" action="{{ route('users.post-customer') }}" x-show="recipientType === 'selected' && !isLoading" x-on:submit="isSubmitting = true">
                                @csrf
                                <input type="hidden" name="recipient_type" value="selected">
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Customers</label>
                                    <select name="customer_ids[]" class="selectize" multiple placeholder="Select customers..." x-ref="customerMultiSelect">
                                        <template x-for="customer in customers" :key="customer.id">
                                            <option :value="customer.id" x-text="`${customer.user.fname} (${customer.user.email})`"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                    <input type="text" name="subject" class="form-input w-full" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                    <textarea name="message" class="form-textarea w-full" rows="5" required></textarea>
                                </div>
                                
                                <div class="flex gap-4 mt-4">
                                    <button type="submit" class="btn bg-primary text-white w-40" :disabled="isSubmitting">
                                        <span x-show="!isSubmitting">Submit</span>
                                        <span x-show="isSubmitting">Submitting...</span>
                                    </button>
                                </div>
                            </form> --}}
                            
                            <!-- Single Customer Form -->
                            <form method="POST" action="{{ route('busines-developer.send-single-post') }}" x-show="recipientType === 'single' && !isLoading" x-on:submit="isSubmitting = true">
                                @csrf
                                <input type="hidden" name="recipient_type" value="single">
                                
                           <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Customer</label>
                                <select name="email" class="selectize" placeholder="Select a customer...">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->user->email }}">
                                            {{ $customer->user->fname }} ({{ $customer->is_subscribed == 1 ? 'Active' : 'Inactive' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                    <input type="text" name="subject" class="form-input w-full" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                    <textarea name="message" class="form-textarea w-full" rows="5" required></textarea>
                                </div>
                                
                                <div class="flex gap-4 mt-4">
                                    <button type="submit" class="btn bg-primary text-white w-40" :disabled="isSubmitting">
                                        <span x-show="!isSubmitting">Submit</span>
                                        <span x-show="isSubmitting">Submitting...</span>
                                    </button>
                                </div>
                            </form>
                            
                            @if ($errors->any())
                                <div class="alert alert-danger mt-4">
                                    <ul>
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
        <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('sendCustomerEmail', () => ({
                    recipientType: 'all',
                    isSubmitting: false,
                    isLoading: false,
                    loadError: null,
                    customers: [],
                    
                    init() {
                        // Watch for changes to recipientType and only fetch when 'selected' is chosen
                        this.$watch('recipientType', (value) => {
                            if (value === 'selected') {
                                this.fetchCustomers();
                            } else {
                                // Clear customers when not in 'selected' mode
                                this.customers = [];
                            }
                        });
                    },
                    
                    // async fetchCustomers() {
                    //     this.isLoading = true;
                    //     this.loadError = null;
                        
                    //     try {
                    //         const response = await fetch('/dashboard/busines-developer/my-customers', {
                    //             headers: {
                    //                 'Accept': 'application/json',
                    //                 'X-Requested-With': 'XMLHttpRequest'
                    //             }
                    //         });
                            
                    //         if (!response.ok) {
                    //             throw new Error('Failed to fetch customers');
                    //         }
                            
                              
                    //         const data = await response.json();
                    //         this.customers = data.customers; // Note the change here

                    //         console.log(data.customers);
        
                    //         // Reinitialize selectize control after data loads
                    //         this.$nextTick(() => {
                    //             if (this.$refs.customerMultiSelect) {
                    //                 $(this.$refs.customerMultiSelect).selectize();
                    //             }
                    //         });
                            
                    //     } catch (error) {
                    //         console.error('Error fetching customers:', error);
                    //         this.loadError = error.message || 'Failed to load customers';
                    //         this.customers = [];
                    //     } finally {
                    //         this.isLoading = false;
                    //     }
                    // }
                }));
            });
        </script>
        
        @include('layouts.footer')
    </div>
</x-app-layout>