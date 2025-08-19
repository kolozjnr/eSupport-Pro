<x-app-layout>
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css">
    <div class="page-content">
        @include('../layouts.top-header')
        <main x-data="ticketSystem()" class="flex-grow p-6">

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
                <div class="col-span-2">
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
                
                            <form class="grid gap-4 mb-6" @submit.prevent="submitTicket" enctype="multipart/form-data">
                                <!-- Ticket Information -->
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label for="ticket-name" class="block text-sm font-medium mb-1">Service</label>
                                        <select x-model="ticket.service_type" class="search-select" id="search-select" required>
                                            <option value="call_service_points">Call Service</option>
                                            <option value="general_support_points">General Support</option>
                                            <option value="virtual_assistance_points">Virtual Assistant</option>
                                            <option value="special">Special</option>
                                        </select>
                                    </div>
                                </div>
                                

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label for="ticket-name" class="block text-sm font-medium mb-1">Ticket Name</label>
                                        <input type="text" id="ticket-name" class="form-input w-full" 
                                               x-model="ticket.name" placeholder="Ticket name" required>
                                    </div>
                                    <div>
                                        <label for="ticket-description" class="block text-sm font-medium mb-1">Description</label>
                                        <textarea x-model="ticket.description"  class="form-input w-full" id="" cols="1" rows="1"></textarea>
                                        {{-- <input type="text" id="ticket-description" class="form-input w-full" 
                                               x-model="ticket.description" placeholder="Description" required> --}}
                                    </div>
                                    
                                    <div>
                                        <label for="ticket-file" class="block text-sm font-medium mb-1">Attach File (Optional)</label>
                                        <input type="file" id="ticket-file" class="form-input w-full" 
                                                @change="ticket.file = $event.target.files[0]" 
                                            accept=".jpg,.jpeg,.png">
                                    </div>
                                </div>
                                
                                <!-- Phone Numbers Section -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium mb-2">Phone Numbers</label>
                                    <template x-for="(phone, index) in ticket.phone_numbers" :key="index">
                                        <div class="grid grid-cols-4 gap-4 items-end mb-2">
                                            <div class="col-span-3">
                                                <input type="text" 
                                                class="form-input w-full" 
                                                x-model="phone.number" 
                                                :name="'phone_numbers[' + index + '][number]'" 
                                                :placeholder="'Phone Number ' + (index + 1)" 
                                                required>

                                                {{-- <input type="text" class="form-input w-full" 
                                                       x-model="phone.number" 
                                                       :placeholder="'Phone Number ' + (index + 1)" required> --}}
                                            </div>
                                            <div>
                                                <button type="button" class="btn bg-red-500 text-white w-full" 
                                                        @click="removePhoneNumber(index)" 
                                                        x-show="ticket.phone_numbers.length > 1">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    <button type="button" class="btn bg-gray-200 text-gray-700 mt-2" 
                                            @click="addPhoneNumber">
                                        + Add Phone Number
                                    </button>
                                </div>
                
                                <!-- Submit Button with Loader -->
                                <div class="mt-6 flex items-center gap-3">
                                    <button type="submit" class="btn bg-primary text-white" :disabled="isLoading">
                                        <span x-show="!isLoading">Create Ticket</span>
                                        <span x-show="isLoading">Processing...</span>
                                    </button>
                                    
                                    <svg x-show="isLoading" class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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

                            <form method="POST" action="{{ route('tickets.download-template') }}" 
                                  enctype="multipart/form-data" 
                                  x-data="{ isUploading: false }" 
                                  @submit.prevent="isUploading = true; $el.submit()">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="csv-upload" class="block text-sm font-medium mb-1">CSV File</label>
                                        <input type="file" name="tickets_file" id="csv-upload" 
                                               class="form-input" accept=".csv" required>
                                        <p class="text-xs text-gray-500 mt-1">Max 5MB. CSV format only.</p>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <button type="submit" class="btn bg-primary text-white w-40" :disabled="isUploading">
                                            <span x-show="!isUploading">Upload</span>
                                            <span x-show="isUploading">Uploading...</span>
                                        </button>
                                        <svg x-show="isUploading" class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
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
            service_type: 'call_center',
            name: '',
            description: '',
            phone_numbers: [{ number: '' }],
            file: null
        },
        isLoading: false,
        message: '',
        isSuccess: false,
        
        addPhoneNumber() {
            this.ticket.phone_numbers.push({ number: '' });
        },
        
        removePhoneNumber(index) {
            if (this.ticket.phone_numbers.length > 1) {
                this.ticket.phone_numbers.splice(index, 1);
            }
        },
        
        async submitTicket() {
            this.isLoading = true;
            this.message = '';
            
    
            // Client-side validation
            if (this.ticket.phone_numbers.every(phone => phone.number.trim() === '')) {
                this.message = 'At least one phone number is required';
                this.isSuccess = false;
                this.isLoading = false;
                return;
            }

            try {
                const formData = new FormData();
                
                formData.append('service_type', this.ticket.service_type);
                formData.append('name', this.ticket.name);
                formData.append('description', this.ticket.description);
                
                // Format phone numbers correctly
                // this.ticket.phone_numbers.forEach((phone, index) => {
                //     if (phone.number.trim() !== '') {
                //         formData.append(`phone_numbers[${index}]`, phone.number);
                //     }
                // });

                this.ticket.phone_numbers.forEach((phone) => {
                    if (phone.number.trim() !== '') {
                        formData.append('phone_numbers[]', phone.number);
                    }
                });
                
                if (this.ticket.file) {
                    formData.append('file', this.ticket.file);
                }

                for (let pair of formData.entries()) {
                        console.log(pair[0] + ": " + pair[1]);
                    }
               // return;
                
                const response = await fetch('{{ route("tickets.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                        
                const data = await response.json();
                
                if (response.ok) {
                    this.isSuccess = true;
                    this.message = data.message || 'Ticket created successfully!';
                    // Reset form
                    this.ticket = {
                        service_type: 'call_center',
                        name: '',
                        description: '',
                        phone_numbers: [{ number: '' }],
                        file: null
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
});
        </script>

        @include('layouts.footer')
    </div>
   
         
</x-app-layout>