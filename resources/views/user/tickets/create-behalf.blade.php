<x-app-layout>
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css">
    <div class="page-content">
        @include('../layouts.top-header')
        <main class="flex-grow p-6">

            <!-- Page Title Start -->
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Ticket Management</h4>
                <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                    <!-- Breadcrumb remains the same -->
                </div>
            </div>
            <!-- Page Title End -->

            <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                <!-- Single Ticket Form -->
                <div class="col-span-2" x-data="ticketSystem()">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Create Ticket</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">
                                Create a ticket with multiple phone numbers
                            </p>
                
                            <form class="grid gap-4 mb-6" @submit.prevent="submitTicket">
                                <!-- Ticket Information -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label for="ticket-name" class="block text-sm font-medium mb-1">Service <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
</label>
                                        <select x-model="ticket.service_type" class="form-select w-full" required>
                                            <option value="call_service_points">Call Service</option>
                                            <option value="general_support_points">General Support</option>
                                            <option value="virtual_assistance_points">Virtual Assistant</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Ticket Name & Description -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="ticket-name" class="block text-sm font-medium mb-1">Ticket Subject <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
</label>
                                        <input type="text" id="ticket-name" class="form-input w-full"
                                            x-model="ticket.name" placeholder="Ticket subject" required>
                                    </div>
                                    <div>
                                        <label for="ticket-description" class="block text-sm font-medium mb-1">Description <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
</label>
                                        <textarea id="ticket-description" cols="1" rows="1" 
                                            class="form-input w-full"
                                            x-model="ticket.description" placeholder="Description" required></textarea>
                                    </div>
                                </div>

                                <!-- Phone Numbers & Customer -->
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Phone Numbers Section -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium mb-2">Phone Numbers <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
</label>
                                        <template x-for="(phone, index) in ticket.phone_numbers" :key="index">
                                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 items-end">
                                                <div class="sm:col-span-3">
                                                    <input type="text" class="form-input w-full"
                                                        x-model="phone.number"
                                                        :placeholder="'Phone Number ' + (index + 1)" required>
                                                </div>
                                                <div>
                                                    <button type="button" 
                                                            class="btn bg-red-500 text-white w-full py-2 px-3 text-sm"
                                                            @click="removePhoneNumber(index)"
                                                            x-show="ticket.phone_numbers.length > 1">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                        <button type="button" 
                                            class="btn bg-gray-200 text-gray-700 mt-4 w-full sm:w-52 text-sm"
                                            @click="addPhoneNumber">
                                            + Add Phone Number
                                        </button>
                                    </div>

                                    <!-- Customer Section -->
                                    <div>
                                        <label for="customer_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Customer <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
                                        </label>
                                        <select id="customer_id" x-model="ticket.customer_id" name="customer_id"
                                            class="form-select w-full" required>
                                            <option selected>Choose</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->user->fname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button with Loader -->
                                <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                                    <button type="submit" class="btn bg-primary text-white w-full sm:w-auto" :disabled="isLoading">
                                        <span x-show="!isLoading">Create Ticket</span>
                                        <span x-show="isLoading">Processing...</span>
                                    </button>

                                    <svg x-show="isLoading" class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>

                                <!-- Success/Error Message -->
                                <div x-show="message" x-text="message"
                                    :class="{'text-green-600': isSuccess, 'text-red-600': !isSuccess}"
                                    class="mt-2 text-sm"></div>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- Bulk Upload Section -->
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Bulk Ticket Upload</h4>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('tickets.download-template') }}" class="btn-code">
                                        <i class="mgc_download_line text-lg"></i>
                                        <span class="ms-2">Download CSV Template</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">
                                Upload a CSV file with ticket data. Format: name,description,phone_numbers (comma-separated)
                            </p>

                            <form method="POST" action="{{ route('tickets.bulk-upload') }}" 
                                enctype="multipart/form-data" 
                                x-data="bulkUpload()" 
                                @submit.prevent="isUploading = true; $el.submit()">
                                @csrf

                                <div class="space-y-6">
                                    <!-- File Upload and Customer Select -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <!-- File Upload -->
                                        <div class="space-y-2">
                                            <label for="csv-upload" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                CSV File
                                            </label>
                                            <div>
                                                <input type="file" name="tickets_file" id="csv-upload"
                                                    class="block w-full text-sm text-gray-600
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-lg file:border-0
                                                        file:text-sm file:font-medium
                                                        file:bg-primary file:text-white
                                                        hover:file:bg-primary-dark
                                                        focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                    accept=".csv" required>
                                            </div>
                                            <p class="text-xs text-gray-500">Max 5MB. CSV format only.</p>
                                        </div>

                                        <!-- Customer Select -->
                                        <div class="space-y-2">
                                            <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Customer
                                            </label>
                                            <select x-model="formData.customer_id" name="customer_id" id="search-select2"
                                                    class="form-select w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/30"
                                                    required>
                                                <option value="">Choose customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->user->fname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-4">
                                        <button type="submit" 
                                                class="btn bg-primary text-white w-full sm:w-40 flex items-center justify-center rounded-lg py-2"
                                                :disabled="isUploading"
                                                :class="{'opacity-75 cursor-not-allowed': isUploading}">
                                            <span x-show="!isUploading">Upload</span>
                                            <span x-show="isUploading" class="flex items-center gap-2">
                                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Uploading...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>

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
                Alpine.data('ticketSystem', () => ({
                    ticket: {
                        name: '',
                        description: '',
                        customer_id: '',
                        service_type: '',
                        phone_numbers: [{ number: '' }]
                    },
                    isLoading: false,
                    isSuccess: false,
                    message: '',
                    
                    addPhoneNumber() {
                        this.ticket.phone_numbers.push({ number: '' });
                    },
                    
                    removePhoneNumber(index) {
                        this.ticket.phone_numbers.splice(index, 1);
                    },
                    
                    async submitTicket() {
                        this.isLoading = true;
                        this.message = '';
                        
                        try {
                            const response = await fetch('{{ route("tickets.store") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(this.ticket)
                            });
                            
                            const data = await response.json();
                            
                            if (response.ok) {
                                this.isSuccess = true;
                                this.message = data.message || 'Ticket created successfully!';
                                this.ticket = {
                                    name: '',
                                    description: '',
                                    customer_id: '',
                                    service_type: '',
                                    phone_numbers: [{ number: '' }]
                                };
                            } else {
                                throw new Error(data.message || 'Failed to create ticket');
                            }
                        } catch (error) {
                            this.isSuccess = false;
                            this.message = error.message;
                        } finally {
                            this.isLoading = false;
                        }
                    }
                }));

                // ✅ New Alpine component just for Bulk Upload
                Alpine.data('bulkUpload', () => ({
                    isUploading: false,
                    formData: {
                        customer_id: ''
                    }
                }));
            });





        // document.addEventListener('alpine:init', () => {
        //     Alpine.data('ticketSystem', () => ({
        //         ticket: {
        //             name: '',
        //             description: '',
        //             customer_id: '',
        //             service_type: '',
        //             phone_numbers: [{ number: '' }]
        //         },
        //         isLoading: false,
        //         isUploading: false,
        //         isSuccess: false,
        //         message: '',
                
        //         addPhoneNumber() {
        //             this.ticket.phone_numbers.push({ number: '' });
        //         },
                
        //         removePhoneNumber(index) {
        //             this.ticket.phone_numbers.splice(index, 1);
        //         },
                
        //         async submitTicket() {
        //             this.isLoading = true;
        //             this.message = '';

        //             // console.log(this.ticket);
        //             // return
                    
        //             try {
        //                 const response = await fetch('{{ route("tickets.store") }}', {
        //                     method: 'POST',
        //                     headers: {
        //                         'Content-Type': 'application/json',
        //                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        //                         'Accept': 'application/json'
        //                     },
        //                     body: JSON.stringify(this.ticket)
        //                 });
                        
        //                 const data = await response.json();
                        
        //                 if (response.ok) {
        //                     this.isSuccess = true;
        //                     this.message = data.message || 'Ticket created successfully!';
        //                     // Reset form after successful submission
        //                     this.ticket = {
        //                         name: '',
        //                         description: '',
        //                         customer_id: '',
        //                         phone_numbers: [{ number: '' }]
        //                     };
        //                 } else {
        //                     throw new Error(data.message || 'Failed to create ticket');
        //                 }
        //             } catch (error) {
        //                 this.isSuccess = false;
        //                 this.message = error.message;
        //             } finally {
        //                 this.isLoading = false;
        //             }
        //         }
        //     }));
        // });
        </script>

        @include('layouts.footer')
    </div>
   
         
</x-app-layout>