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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Ticket</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Asign Ticket</a>
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
                                   Assign Ticket
                                </p>

                                <form class="grid grid-cols-4 gap-4 mb-6">
                                    <div>
                                        <label for="staticEmail2" class="sr-only">Name</label>
                                        <input type="text" readonly class="form-input" id="staticEmail2" value="">
                                    </div>
                                    <div>
                                        <label for="inputPassword2" class="sr-only">Content</label>
                                        <input type="text" class="form-input" id="inputPassword2" placeholder="">
                                    </div>
                                    <div class="">
                                        <select id="search-select" class="search-select">
                                            <option selected disabled hidden>Choose</option>
                                            <option value="1">Daniel</option>
                                            <option value="2">Tinubu</option>
                                            <option value="3">X</option>
                                        </select>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn bg-primary text-white">Assign</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>




            </main>
    @include('layouts.footer')
</x-app-layout>