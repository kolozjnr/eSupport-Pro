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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Invoice</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Create Invoice</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                   

                    <div class="col-span-2" x-data="uploadProof">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Upload Proof of Payment</h4>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">
                                    After Payment is made, please upload your proof of payment and our billing team will get back to you.
                                </p>
                    
                                <form class="grid gap-4 mb-6">
                                    <!-- Ticket Rows Container -->
                                        <div class="grid grid-cols-4 gap-4 items-end">
                                            <div>
                                                <label for="proof_upload" class="sr-only">Proof of Payment</label>
                                                <input type="file" class="form-input" id="proof_upload"
                                                       x-model="formData.proof_upload" placeholder=" name">
                                            </div>
                                        </div>
                    
                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn bg-primary text-white"> 
                                            Send</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                            
                </div>
            </main>

          <script>
            document.addEventListener('alpine:init', () => {
            Alpine.data('uploadProof', () => ({
                
                formData: {
                    proof_upload: ''
                },
            }))
          })
          </script>

    @include('layouts.footer')
</x-app-layout>