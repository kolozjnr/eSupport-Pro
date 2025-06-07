<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
        <main x-data="CreateTicket" class="flex-grow p-6">

    

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
                   

                    <div class="col-span-2" x-data="CreateTicket">
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
                    
                                <form class="grid gap-4 mb-6">
                                    <!-- Ticket Rows Container -->
                                    <template x-for="(ticket, index) in tickets" :key="index">
                                        <div class="grid grid-cols-4 gap-4 items-end">
                                            <div>
                                                <label :for="'name-' + index" class="sr-only">Name</label>
                                                <input type="text" class="form-input" :id="'name-' + index" 
                                                       x-model="ticket.name" placeholder="Ticket name">
                                            </div>
                                             <div>
                                                <label :for="'phone_number-' + index" class="sr-only">Phone Number</label>
                                                <input type="text" class="form-input" :id="'phone_number-' + index" 
                                                       x-model="ticket.phone_number" placeholder="Phone Number">
                                            </div>
                                            <div>
                                                <label :for="'description-' + index" class="sr-only">Description</label>
                                                <input type="text" class="form-input" :id="'description-' + index" 
                                                       x-model="ticket.description" placeholder="Description">
                                            </div>
                                            <div>
                                                {{-- <button type="button" class="btn bg-primary text-white" 
                                                        @click="createTicket()" x-show="index === tickets.length - 1">
                                                    Add
                                                </button> --}}
                                                <button type="button" class="btn bg-red-500 text-white" 
                                                        @click="removeTicket(index)" x-show="tickets.length > 1">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    <span class="grid grid-cols-4 gap-4 items-end pointer hover:pointer" @click="createTicket()">
                                        + Add
                                    </span>
                    
                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn bg-primary text-white">Create Tickets</button>
                                    </div>
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
                                        {{-- <button type="button" class="btn-code" data-fc-type="collapse" data-fc-target="GridFormHtml">
                                            <i class="mgc_eye_line text-lg"></i>
                                            <span class="ms-2">Code</span>
                                        </button> --}}

                                        <button class="btn-code" data-clipboard-action="copy">
                                            <i class="mgc_download_line text-lg"></i>
                                            <span class="ms-2">Download Template</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Here you can upload multiple tickets using the provided template above.</p>

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="grid grid-cols-1 md:grid-cols-2  gap-6">
                                        {{-- <div>
                                            <label for="inputEmail4" class="text-gray-800 text-sm font-medium inline-block mb-2">Name</label>
                                            <input type="name" class="form-input" id="inputEmail4" placeholder="Email">
                                        </div> --}}
                                        <div>
                                            <label for="inputPassword4" class="text-gray-800 text-sm font-medium inline-block mb-2">File</label>
                                            <input type="file" class="form-input" id="inputPassword4" placeholder="Password">
                                        </div>
{{-- 
                                        <div class="lg:col-span-2">
                                            <label for="inputAddress" class="text-gray-800 text-sm font-medium inline-block mb-2 bg-dark:text-white">Address</label>
                                            <input type="text" class="form-input" id="inputAddress" placeholder="1234 Main St">
                                        </div>

                                        <div>
                                            <label for="inputAddress2" class="text-gray-800 text-sm font-medium inline-block mb-2">Address 2</label>
                                            <input type="text" class="form-input" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                        </div> --}}

                                        {{-- <div>
                                            <label for="inputCity" class="text-gray-800 text-sm font-medium inline-block mb-2">City</label>
                                            <input type="text" class="form-input" id="inputCity">
                                        </div>
                                        <div>
                                            <label for="inputState" class="text-gray-800 text-sm font-medium inline-block mb-2">State</label>
                                            <select id="inputState" class="form-select">
                                                <option>Choose</option>
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="inputZip" class="text-gray-800 text-sm font-medium inline-block mb-2">Zip</label>
                                            <input type="text" class="form-input" id="inputZip">
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 my-3">
                                        <input type="checkbox" class="form-checkbox rounded border border-gray-200" id="customCheck11">
                                        <label class="text-gray-800 text-sm font-medium inline-block" for="customCheck11">Check this custom checkbox !</label>
                                    </div> --}}

                                    <button type="submit" class="btn bg-primary text-white w-40">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
            </main>

          <script>
            document.addEventListener('alpine:init', () => {
            Alpine.data('CreateTicket', () => ({
                // count: 0,
                // increment() {
                //     this.count++
                // }
                tickets: [
                    { name: '', description: '', phone_number: '' } // First row visible by default
                ],
                
                createTicket() {
                    this.tickets.push({ name: '', description: '', phone_number: '' });
                },
                
                removeTicket(index) {
                    this.tickets.splice(index, 1);
                }
            }))
          })
          </script>

    @include('layouts.footer')
</x-app-layout>