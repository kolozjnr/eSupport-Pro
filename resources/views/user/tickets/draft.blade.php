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
                                <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Here you can upload multiple tasks using the provided template above.</p>

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="grid grid-cols-1 md:grid-cols-2  gap-6">
                                        <div>
                                            <label for="inputEmail4" class="text-gray-800 text-sm font-medium inline-block mb-2">Name</label>
                                            <input type="name" class="form-input" id="inputEmail4" placeholder="Email">
                                        </div>
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

          

    @include('layouts.footer')
</x-app-layout>