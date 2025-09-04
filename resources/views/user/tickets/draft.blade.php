<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
        <main class="flex-grow p-6" x-data="draft()">

    

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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Create drafts</a>
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
                            <div class="p-6">
                                
                            <form class="grid gap-4 mb-6" @submit.prevent="submitDraft">
                                <!-- Ticket Information -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="draft-name" class="block text-sm font-medium mb-1">Name</label>
                                        <input type="text" id="draft-name" class="form-input w-full" 
                                            x-model="formData.name" placeholder="Name" required>
                                    </div>
                                </div>
                                
                                <!-- Phone Numbers Section -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium mb-2">Phone Numbers</label>
                                    <template x-for="(phone, index) in formData.phone_numbers" :key="index">
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 sm:gap-4 items-end mb-2">
                                            <!-- Phone Input -->
                                            <div class="sm:col-span-3">
                                                <input type="text" class="form-input w-full md:w-1/2" 
                                                    x-model="phone.number" 
                                                    :placeholder="'Phone Number ' + (index + 1)" required>
                                            </div>
                                            <!-- Remove Button -->
                                            <div>
                                                <button type="button" class="btn bg-red-500 text-white w-full sm:w-auto" 
                                                        @click="removePhoneNumber(index)" 
                                                        x-show="formData.phone_numbers.length > 1">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Add Phone Button -->
                                    <button type="button" class="btn bg-gray-200 text-gray-700 mt-2 w-full sm:w-auto" 
                                            @click="addPhoneNumber">
                                        + Add Phone Number
                                    </button>
                                </div>

                                <!-- Submit Button with Loader -->
                                <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                                    <button type="submit" class="btn bg-primary text-white w-full sm:w-auto" :disabled="isLoading">
                                        <span x-show="!isLoading">Create Draft</span>
                                        <span x-show="isLoading">Processing...</span>
                                    </button>
                                    
                                    <!-- Loader -->
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
                        </div> <!-- end card -->
                    </div> <!-- end col -->

                    <div class="col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Multiple Upload</h4>
                                    <div class="flex items-center gap-2">
                                        {{-- <button type="button" class="btn-code" data-fc-type="collapse" data-fc-target="GridFormHtml">
                                            <i class="mgc_eye_line text-lg"></i>
                                            <span class="ms-2">Code</span>
                                        </button> --}}
                                        
                                    <a href="{{ route('tickets.draft-template') }}" class="btn-code">
                                        <i class="mgc_download_line text-lg"></i>
                                        <span class="ms-2">Download CSV Template</span>
                                    </a>

                                        {{-- <button class="btn-code" data-clipboard-action="copy">
                                            <i class="mgc_download_line text-lg"></i>
                                            <span class="ms-2">Download Template</span>
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Here you can upload multiple contacts using the provided template above.</p>

                               <form method="POST" action="{{ route('tickets.bulk-draft-upload') }}" 
                                enctype="multipart/form-data" 
                                x-data="{ isUploading: false }" 
                                @submit.prevent="isUploading = true; $el.submit()"
                                class="w-full mx-auto p-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- File input -->
                                    <div>
                                        <label for="csv-upload" class="block text-sm font-medium mb-1">CSV File</label>
                                        <input type="file" name="draft_file" id="csv-upload" 
                                            class="form-input w-full border rounded-lg p-2 text-sm" 
                                            accept=".csv" required>
                                        <p class="text-xs text-gray-500 mt-1">Max 5MB. CSV format only.</p>
                                    </div>

                                    <!-- Button -->
                                
                                
                                
                                    <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                                        <button type="submit" 
                                                class="btn bg-primary text-white w-full sm:w-auto"
                                                :disabled="isUploading">
                                            <span x-show="!isUploading">Upload CSV</span>
                                            <span x-show="isUploading">Uploading...</span>
                                        </button>
                                        <svg x-show="isUploading" 
                                            class="animate-spin h-5 w-5 text-primary" 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            fill="none" 
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" 
                                                    stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" 
                                                d="M4 12a8 8 0 018-8V0C5.373 0 
                                                    0 5.373 0 12h4zm2 5.291A7.962 
                                                    7.962 0 014 12H0c0 3.042 1.135 
                                                    5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </form>

                                {{-- <form method="POST" enctype="multipart/form-data">
                                    <div class="grid grid-cols-1 md:grid-cols-2  gap-6">
                                        <div>
                                            <label for="inputPassword4" class="text-gray-800 text-sm font-medium inline-block mb-2">File</label>
                                            <input type="file" class="form-input" id="inputPassword4" placeholder="Password">
                                        </div>

                                    <button type="submit" class="btn bg-primary text-white w-40">Upload</button>
                                </form> --}}
                                <div id="GridFormHtml" class="hidden w-full overflow-hidden transition-[height] duration-300">
                                    <pre class="language-html h-56">
                                        <code>
                                            &lt;form&gt;
                                                &lt;div class=&quot;grid grid-cols-1 md:grid-cols-2  gap-6&quot;&gt;
                                                    &lt;div&gt;
                                                        &lt;label for=&quot;inputEmail4&quot; class=&quot;text-gray-800 text-sm font-medium inline-block mb-2&quot;&gt;Email&lt;/label&gt;
                                                        &lt;input type=&quot;email&quot; class=&quot;form-input&quot; id=&quot;inputEmail4&quot; placeholder=&quot;Email&quot;&gt;
                                                    &lt;/div&gt;
                                                    &lt;div&gt;
                                                        &lt;label for=&quot;inputPassword4&quot; class=&quot;text-gray-800 text-sm font-medium inline-block mb-2&quot;&gt;Password&lt;/label&gt;
                                                        &lt;input type=&quot;password&quot; class=&quot;form-input&quot; id=&quot;inputPassword4&quot; placeholder=&quot;Password&quot;&gt;
                                                    &lt;/div&gt;

                                                    &lt;div class=&quot;lg:col-span-2&quot;&gt;
                                                        &lt;label for=&quot;inputAddress&quot; class=&quot;text-gray-800 text-sm font-medium inline-block mb-2&quot;&gt;Address&lt;/label&gt;
                                                        &lt;input type=&quot;text&quot; class=&quot;form-input&quot; id=&quot;inputAddress&quot; placeholder=&quot;1234 Main St&quot;&gt;
                                                    &lt;/div&gt;

                                                    &lt;div&gt;
                                                        &lt;label for=&quot;inputAddress2&quot; class=&quot;text-gray-800 text-sm font-medium inline-block mb-2&quot;&gt;Address 2&lt;/label&gt;
                                                        &lt;input type=&quot;text&quot; class=&quot;form-input&quot; id=&quot;inputAddress2&quot; placeholder=&quot;Apartment, studio, or floor&quot;&gt;
                                                    &lt;/div&gt;

                                                    &lt;div&gt;
                                                        &lt;label for=&quot;inputCity&quot; class=&quot;text-gray-800 text-sm font-medium inline-block mb-2&quot;&gt;City&lt;/label&gt;
                                                        &lt;input type=&quot;text&quot; class=&quot;form-input&quot; id=&quot;inputCity&quot;&gt;
                                                    &lt;/div&gt;
                                                    &lt;div&gt;
                                                        &lt;label for=&quot;inputState&quot; class=&quot;text-gray-800 text-sm font-medium inline-block mb-2&quot;&gt;State&lt;/label&gt;
                                                        &lt;select id=&quot;inputState&quot; class=&quot;form-select&quot;&gt;
                                                            &lt;option&gt;Choose&lt;/option&gt;
                                                            &lt;option&gt;Option 1&lt;/option&gt;
                                                            &lt;option&gt;Option 2&lt;/option&gt;
                                                            &lt;option&gt;Option 3&lt;/option&gt;
                                                        &lt;/select&gt;
                                                    &lt;/div&gt;
                                                    &lt;div&gt;
                                                        &lt;label for=&quot;inputZip&quot; class=&quot;text-gray-800 text-sm font-medium inline-block mb-2&quot;&gt;Zip&lt;/label&gt;
                                                        &lt;input type=&quot;text&quot; class=&quot;form-input&quot; id=&quot;inputZip&quot;&gt;
                                                    &lt;/div&gt;
                                                &lt;/div&gt;

                                                &lt;div class=&quot;flex items-center gap-2 my-3&quot;&gt;
                                                    &lt;input type=&quot;checkbox&quot; class=&quot;form-checkbox rounded border border-gray-200&quot; id=&quot;customCheck11&quot;&gt;
                                                    &lt;label class=&quot;text-gray-800 text-sm font-medium inline-block&quot; for=&quot;customCheck11&quot;&gt;Check this custom checkbox !&lt;/label&gt;
                                                &lt;/div&gt;

                                                &lt;button type=&quot;submit&quot; class=&quot;btn bg-primary text-white&quot;&gt;Sign in&lt;/button&gt;
                                            &lt;/form&gt;
                                        </code>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>




            </main>

          <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('draft', () => ({
                formData: {
                    name: '',
                    phone_numbers: [{ number: '' }]
                },
                isLoading: false,
                isUploading: false,
                isSuccess: false,
                message: '',
                
                addPhoneNumber() {
                    this.formData.phone_numbers.push({ number: '' });
                },
                
                removePhoneNumber(index) {
                    this.formData.phone_numbers.splice(index, 1);
                },
                
                async submitDraft() {
                    this.isLoading = true;
                    this.message = '';
                    // console.log(this.formData);
                    // return;
                    
                    try {
                        const response = await fetch('{{ route("tickets.storeDraft") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.formData )
                        });
                        
                        const data = await response.json();
                        
                        if (response.ok) {
                            this.isSuccess = true;
                            this.message = data.message || 'Draft created successfully!';
                            // Reset form after successful submission
                            this.formData = {
                                name: '',
                                phone_numbers: [{ number: '' }]
                            };
                        } else {
                            throw new Error(data.message || 'Failed to create Draft');
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
</x-app-layout>