<x-app-layout>
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
        <main x-data="createTicket()" class="flex-grow p-6">

            <!-- Page Title Start -->
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Layout</h4>

                <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                    <div class="flex items-center gap-2">
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                    </div>

                    <div class="flex items-center gap-2">
                        <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Task</a>
                    </div>

                    <div class="flex items-center gap-2">
                        <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                        <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Layout</a>
                    </div>
                </div>
            </div>
            <!-- Page Title End -->

            <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Single Task Upload</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">
                                Create a single Ticket
                            </p>
                
                            <form class="grid gap-4 mb-6" @submit.prevent="submitForm">
                                <!-- Ticket Rows Container -->
                                <template x-for="(ticket, index) in tickets" :key="index">
                                    <div class="grid grid-cols-4 gap-4 items-end">
                                        <div>
                                            <label :for="'name-' + index" class="sr-only">Name</label>
                                            <input type="text" class="form-input" :id="'name-' + index" 
                                                   x-model="ticket.name" placeholder="Ticket name" required>
                                        </div>
                                         <div>
                                            <label :for="'phone_number-' + index" class="sr-only">Phone Numbers</label>
                                            <div class="form-input flex flex-wrap gap-1 items-center min-h-[42px]"
                                                @keydown.enter.prevent="addPhoneNumber(index)"
                                                @keydown.space.prevent="addPhoneNumber(index)">
                                                <template x-for="(number, numIndex) in ticket.phone_numbers" :key="numIndex">
                                                    <div class="bg-gray-100 px-2 py-1 rounded flex items-center text-sm">
                                                        <span x-text="number"></span>
                                                        <button type="button" @click="removePhoneNumber(index, numIndex)" class="ml-1 text-gray-500 hover:text-red-500">
                                                            &times;
                                                        </button>
                                                    </div>
                                                </template>
                                                <input type="text" 
                                                    class="flex-grow outline-none bg-transparent min-w-[100px]"
                                                    x-model="ticket.currentPhoneNumber"
                                                    @blur="addPhoneNumber(index)"
                                                    placeholder="Add phone numbers">
                                            </div>
                                        </div>
                                        <div>
                                            <label :for="'description-' + index" class="sr-only">Description</label>
                                            <input type="text" class="form-input" :id="'description-' + index" 
                                                   x-model="ticket.description" placeholder="Description" required>
                                        </div>
                                        <div>
                                            <button type="button" class="btn bg-red-500 text-white" 
                                                    @click="removeTicket(index)" x-show="tickets.length > 1">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <span class="grid grid-cols-4 gap-4 items-end pointer hover:pointer" @click="addTicket">
                                    + Add
                                </span>
                
                                <!-- Submit Button with Loader -->
                                <div class="mt-4 flex items-center gap-3">
                                    <button type="submit" class="btn bg-primary text-white" :disabled="isLoading">
                                        <span x-show="!isLoading">Create Tickets</span>
                                        <span x-show="isLoading">Processing...</span>
                                    </button>
                                    
                                    <!-- Loading spinner -->
                                    <svg x-show="isLoading" class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                
                                <!-- Success/Error Message -->
                                <div x-show="message" x-text="message" 
                                     :class="{'text-green-600': isSuccess, 'text-red-600': !isSuccess}" 
                                     class="mt-2"></div>
                            </form>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Multiple Ticket Upload</h4>
                                <div class="flex items-center gap-2">
                                    <button class="btn-code" data-clipboard-action="copy">
                                        <i class="mgc_download_line text-lg"></i>
                                        <span class="ms-2">Download Template</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Here you can upload multiple tickets using the provided template above.</p>

                            <form method="POST" enctype="multipart/form-data" x-data="{ isUploading: false }" @submit.prevent="isUploading = true; $el.submit()">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="inputPassword4" class="text-gray-800 text-sm font-medium inline-block mb-2">File</label>
                                        <input type="file" name="tickets_file" class="form-input" id="inputPassword4" placeholder="Password" required>
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
                </div> <!-- end col -->
            </div>
        </main>

        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('createTicket', () => ({
                tickets: [
                    { 
                        name: '', 
                        description: '',
                        phone_numbers: [],
                        currentPhoneNumber: '' 
                    }
                ],
                isLoading: false,
                isSuccess: false,
                message: '',
                
                addTicket() {
                    this.tickets.push({ name: '', description: '', phone_number: '' });
                },
                
                removeTicket(index) {
                    this.tickets.splice(index, 1);
                },
                 addPhoneNumber(index) {
                    const ticket = this.tickets[index];
                    if (ticket.currentPhoneNumber.trim()) {
                        ticket.phone_numbers.push(ticket.currentPhoneNumber.trim());
                        ticket.currentPhoneNumber = '';
                    }
                },
                
                removePhoneNumber(ticketIndex, numberIndex) {
                    this.tickets[ticketIndex].phone_numbers.splice(numberIndex, 1);
                },
                
                async submitForm() {
                    this.isLoading = true;
                    this.message = '';
                    
                    try {
                        // Prepare the data with phone_numbers as JSON
                        const formData = this.tickets.map(ticket => ({
                            name: ticket.name,
                            description: ticket.description,
                            phone_numbers: JSON.stringify(ticket.phone_numbers) // Convert array to JSON string
                        }));
                        
                        const response = await fetch('{{ route("tickets.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                tickets: formData
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (response.ok) {
                            this.isSuccess = true;
                            this.message = data.message || 'Tickets created successfully!';
                            // Reset form after successful submission
                            this.tickets = [{ 
                                name: '', 
                                description: '', 
                                phone_numbers: [],
                                currentPhoneNumber: '' 
                            }];
                        } else {
                            throw new Error(data.message || 'Failed to create tickets');
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