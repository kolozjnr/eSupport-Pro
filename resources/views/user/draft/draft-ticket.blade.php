<x-app-layout>
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css">
    <div class="page-content">
        @include('../layouts.top-header')
        <main x-data="ticketSystem({{ json_encode($draft) }})" class="flex-grow p-6">



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
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="ticket-name" class="block text-sm font-medium mb-1">Service <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
</label>
                                        <select x-model="ticket.service_type" class="search-select w-full" id="search-select" required>
                                            <option value="" selected disabled>Choose Service</option>
                                            <option value="call_service_points">Call Service</option>
                                            <option value="general_support_points">General Support</option>
                                            <option value="virtual_assistance_points">Virtual Assistant</option>
                                            <option value="special">Special</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Ticket Name / Description / File -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="ticket-name" class="block text-sm font-medium mb-1">Ticket Subject <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
</label>
                                        <input type="text" id="ticket-name" class="form-input w-full" 
                                            x-model="ticket.name" placeholder="Ticket subject" required>
                                    </div>
                                    <div>
                                        <label for="ticket-description" class="block text-sm font-medium mb-1">Description <span class="text-red-600 text-xl font-semibold drop-shadow-sm">*</span>
</label>
                                        <textarea x-model="ticket.description" class="form-input w-full" id="ticket-description" rows="2" placeholder="Description"></textarea>
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
                                   <template x-for="(phone, index) in ticket.phone_numbers" :key="index">
                                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 sm:gap-4 items-end mb-2">
                                        <div class="sm:col-span-3">
                                            <input type="text" 
                                                class="form-input w-full" 
                                                x-model="phone.number" 
                                                :name="'phone_numbers[' + index + '][number]'" 
                                                :placeholder="'Phone Number ' + (index + 1)" 
                                                required>
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

                                <button type="button" class="btn bg-gray-200 text-gray-700 mt-2 w-full sm:w-auto" 
                                        @click="addPhoneNumber">
                                    + Add Phone Number
                                </button>

                                </div>

                                <!-- Submit Button with Loader -->
                                <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                                    <button type="submit" class="btn bg-primary text-white w-full sm:w-auto" :disabled="isLoading">
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
            </div>
        </main>

        

        <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>
         <!-- Choices Demo js -->
         <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 


        <script>
            
                document.addEventListener('alpine:init', () => {
                Alpine.data('ticketSystem', (draft) => ({
                    ticket: {
                        service_type: draft?.service_type || '',
                        name: draft?.name || '',
                        description: draft?.description || '',
                       phone_numbers: draft?.phone_numbers && draft.phone_numbers.length > 0
                        ? draft.phone_numbers.map(p => ({ number: p.number }))
                        : [{ number: '' }],

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

                        // Filter out empty phone numbers
                        const validPhoneNumbers = this.ticket.phone_numbers
                            .filter(phone => phone.number.trim() !== '')
                            .map(phone => phone.number);

                        if (validPhoneNumbers.length === 0) {
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

                            // Add only valid phone numbers
                            validPhoneNumbers.forEach((phoneNumber) => {
                                formData.append('phone_numbers[]', phoneNumber);
                            });
                            
                            if (this.ticket.file) {
                                formData.append('file', this.ticket.file);
                            }

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
                                window.location
                                
                                // Optionally clear the form
                                // this.ticket = {
                                //     service_type: '',
                                //     name: '',
                                //     description: '',
                                //     phone_numbers: [{ number: '' }],
                                //     file: null
                                // };
                                
                                // Redirect or perform other actions if needed
                                 setTimeout(() => {
                                    window.location.href = '{{ route("tickets.view-drafts") }}'; 
                                }, 4000);
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