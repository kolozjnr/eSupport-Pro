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
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Layout</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Draft</a>
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
                                    <h4 class="card-title">Create Draft</h4>
                                    
                                </div>
                            </div>
                            <div class="p-6" x-data="{
                                rows: [{
                                    name: 'John Doe',
                                    phone: ''
                                }],
                                addRow() {
                                    this.rows.push({
                                        name: '',
                                        phone: ''
                                    });
                                },
                                removeRow(index) {
                                    if (this.rows.length > 1) {
                                        this.rows.splice(index, 1);
                                    }
                                }
                            }">
                                <form method="POST">
                                    <!-- Default row (always visible) -->
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <label for="name-0" class="sr-only">Name</label>
                                            <input type="text" 
                                                   class="form-input" 
                                                   id="name-0" 
                                                   x-model="rows[0].name"
                                                   placeholder="Full Name">
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1">
                                                <label for="phone-0" class="sr-only">Phone Number</label>
                                                <input type="number" 
                                                       class="form-input" 
                                                       id="phone-0" 
                                                       x-model="rows[0].phone"
                                                       placeholder="08012345678">
                                            </div>
                                            <!-- Remove button hidden for first row -->
                                            <button type="button" class="invisible w-10" aria-hidden="true"></button>
                                        </div>
                                    </div>
                            
                                    <!-- Additional rows -->
                                    <template x-for="(row, index) in rows.slice(1)" :key="index + 1">
                                        <div class="grid grid-cols-2 gap-4 mb-6">
                                            <div>
                                                <label :for="'name-'+(index+1)" class="sr-only">Name</label>
                                                <input type="text" 
                                                       class="form-input" 
                                                       :id="'name-'+(index+1)" 
                                                       x-model="rows[index+1].name"
                                                       placeholder="Full Name">
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1">
                                                    <label :for="'phone-'+(index+1)" class="sr-only">Phone Number</label>
                                                    <input type="number" 
                                                           class="form-input" 
                                                           :id="'phone-'+(index+1)" 
                                                           x-model="rows[index+1].phone"
                                                           placeholder="08012345678">
                                                </div>
                                                <button type="button" 
                                                        @click="removeRow(index+1)"
                                                        class="btn bg-red-500 text-white px-3 py-2">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                            
                                    <div class="flex gap-4 mt-4">
                                        <button type="button" 
                                                @click="addRow()"
                                                class="btn bg-blue-500 text-white flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Add Row
                                        </button>
                                        <button type="submit" class="btn bg-primary text-white">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->

                    <div class="col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Multiple Task</h4>
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
                                <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">
                                    Here you can upload multiple tasks using the provided template above.
                                </p>

                                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- File Upload -->
                                        <div class="col-span-1 md:col-span-2">
                                            <label for="task-file" class="block text-gray-800 dark:text-slate-200 text-sm font-medium mb-2">
                                                File <span class="text-red-600">*</span>
                                            </label>
                                            <input 
                                                type="file" 
                                                id="task-file" 
                                                class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" 
                                                placeholder="Choose file"
                                            >
                                        </div>

                                        <!-- Submit Button -->
                                    <div class="flex justify-start">
                                        <button 
                                            type="submit" 
                                            class="btn bg-primary text-white px-6 py-2 rounded-lg shadow hover:bg-primary/90 transition w-full sm:w-40"
                                        >
                                            Upload
                                        </button>
                                    </div>
                                    </div>

                                    
                                </form>
                            </div>

                        </div>
                    </div> <!-- end col -->
                </div>




            </main>

          

    @include('layouts.footer')
</x-app-layout>