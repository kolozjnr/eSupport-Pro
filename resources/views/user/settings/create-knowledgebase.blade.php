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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Users</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Knowledgebase</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                   

                    <div class="col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Create Knowledgebase</h4>
                                    
                                </div>
                            </div>
                            <div x-data="createKnowledgebase()" class="p-6">
                                <form>
                                    <div class="grid grid-cols-4 gap-4 mb-6">
                                        <div>
                                            <label for="title" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                            <input type="text" class="form-input" x-model="formData.title" id="title" value="">
                                        </div>
                                        <div>
                                            <label for="category" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">category</label>
                                            <select id="search-select" x-model="formData.category" name="category" id="category" class="search-select">
                                                <option selected disabled hidden>Choose</option>
                                                <option value="1">Technical</option>
                                                <option value="2">Awarenes</option>
                                                <option value="3">Cautions</option>
                                            </select>
                                        </div>
                                        {{-- <div>
                                            <label for="subCategory" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">subCategory</label>
                                            <select id="search-select" x-model="formData.subCategory" name="subCategory" id="subCategory" class="search-select">
                                                <option selected disabled hidden>Choose</option>
                                                <option value="1">Support Staff</option>
                                                <option value="2">QA</option>
                                                <option value="3">User</option>
                                            </select>
                                        </div> --}}
                                        <div>
                                            <label for="tags" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                                            <select class="selectize" multiple="multiple" x-model="formData.tags" name="tags" id="tags">
                                                <option value="tech">Tech</option>
                                                <option value="social">social</option>
                                                <option value="Purple">Purple</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4 gap-2 mb-6">
                                        <div>
                                            <label for="file_attach" x-model="formData.img" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">File Attachment</label>
                                            <input type="file" accept="application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-input" x-model="formData.file_attach" name="file_attach[]" id="file_attach" value="">
                                        </div>
                                        <div>
                                            <label for="img" x-model="formData.video" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Video</label>
                                            <input type="file" accept="video/mp4" class="form-input" x-model="formData.video" name="video[]" id="img" value="">
                                        </div>

                                        <div class="grid grid-cols-4 gap-2 mb-6">
                                          
                                        </div>
                                    </div>
                                    
                                    <!-- Identity Fields Section -->
                                    <div class="grid grid-cols-1 gap-2 mb-6">
                                        <div id="snow-editor" style="height: 300px;">
                                           
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-4 mt-4">
                                        <button type="submit" class="btn bg-primary text-white">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
            </main>

            <script>
                 document.addEventListener('alpine:init', () => {
                    Alpine.data('createUser', () => ({
                        formData: {
                            fname: '',
                            mname: '',
                            lname: '',
                            role: '',
                            display_picture: ''
                        },
                        identities: [{ name: '' }], // First identity field available by default
                        
                        addIdentity() {
                            this.identities.push({ name: '' });
                        },
                        
                        removeIdentity(index) {
                            if (this.identities.length > 1) {
                                this.identities.splice(index, 1);
                            }
                        }
                    }));
                });
            </script>
    @include('layouts.footer')
</x-app-layout>