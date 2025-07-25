<x-app-layout>
    <style>
        .overlay-invoice {
          position: fixed;
          top: 0; left: 0; right: 0; bottom: 0;
          background: rgba(0, 0, 0, 0.5);
          display: none;
          z-index: 999;
        }

        .modal-invoice {
          position: fixed;
          top: -100%; /* Start off-screen */
          left: 50%;
          transform: translateX(-50%);
          transition: top 0.5s ease;
          z-index: 1000;
          background: #fff;
          padding: 20px;
          border-radius: 10px;
          width: 900px;
        }
        .form-group {
          display: flex;
          gap: 10px;
          margin-bottom: 20px;
        }

        .form-input {
          flex: 1;
          padding: 10px 12px;
          border: 1px solid #ccc;
          border-radius: 8px;
          font-size: 14px;
          transition: border-color 0.3s;
        }

        .form-input:focus {
          outline: none;
          border-color: #b2a1a1;
          box-shadow: 0 0 5px rgba(93, 214, 163, 0.4);
        }

        .submit-btn {
            width: 150px;
          background-color: #4169DD;
          color: white;
          border: none;
          padding: 5px 5px;
          font-weight: 200;
          border-radius: 5px;
          cursor: pointer;
          transition: background-color 0.3s;
          text-shadow: none;
        }

        .submit-btn:hover {
          background-color: #576694;
          color: #fff;
        }
    </style>

     <!-- Pay Modal ends here -->

     <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
     <div class="overlay-invoice"></div>
    {{-- <button onclick="updateInvoice()">Open</button> --}}

        <div class="modal-invoice">
            <span id="dynamic"></span>

        <h2>Process Payment</h2>
        <form id="invoice-form">
            <div class="form-group">
            <select class="form-input" required id="processPayment">
                <option value="" selected disabled>Select</option>
                <option value="Processed">Processed</option>
                <option value="Partially_paid">Partially Paid</option>
            </select>

            <input type="text" name="invoiceAmount" id="invoiceAmount" class="form-input" placeholder=" " readonly />
            </div>

            <button type="submit" class="submit-btn">Process</button>
        </form>
        </div>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="page-content">
        @include('../layouts.top-header')

            <main class="flex-grow p-6">

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Data Table</h4>

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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">All Subscriptions</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Subscriptions</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <div id="loading-indicator" class="hidden fixed inset-0 bg-white dark:bg-slate-900 bg-opacity-75 flex items-center justify-center z-50">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
                            </div>

                            <div id="table-viewInvoice"></div>
                        </div>
                    </div>


                </div>
            </main>

            <script>
                function updateInvoice() {
                            document.getElementById("dynamic").textContent = "invoice";
                          $('.overlay-invoice').fadeIn();
                          $('.modal-invoice').css('top', '100px');
                        }

                        $('.close-btn-invoice, .overlay-invoice').on('click', function () {
                          $('.modal-invoice').css('top', '-100%');
                          $('.overlay-invoice').fadeOut();
                        });

                  

            </script>

                        
    <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}" defer></script>
        
            <!-- Gridjs Demo js -->
            <script src="{{ asset('assets/js/pages/table-gridjs.js') }}" defer></script>


            
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script src="https://unpkg.com/gridjs-plugins/dist/gridjs-plugins.umd.js"></script>

    @include('layouts.footer')
    
</x-app-layout>