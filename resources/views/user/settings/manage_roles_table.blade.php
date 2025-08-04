<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="page-content">
        @include('../layouts.top-header')

            <main class="flex-grow p-6">

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Manage Roles</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">User</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Manage Roles</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Roles</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            {{-- <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">The most basic list group is an unordered list with list items and the proper classes. Build upon it with the options that follow, or with your own CSS as needed.</p> --}}

                            <div id="table-manageRoles"></div>
                        </div>
                    </div>


                </div>

            </main>

            <style>
                /* Custom grid.js styles */
.gridjs-container {
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.gridjs-wrapper {
    border: 1px solid #e5e7eb;
}

.gridjs-th {
    background-color: #f9fafb;
    color: #374151;
    font-weight: 600;
}

.gridjs-tr:hover {
    background-color: #f3f4f6;
}

.gridjs-pagination {
    border-top: 1px solid #e5e7eb;
    padding: 12px;
}

.gridjs-search input {
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    width: 100%;
    max-width: 300px;
}

.role-select {
    width: 120px;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid #d1d5db;
}
            </style>

            

    @include('layouts.footer')
  <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}" defer></script>
     
    <!-- Gridjs Demo js -->
    <script src="{{ asset('assets/js/pages/table-gridjs.js') }}" defer></script>
    
</x-app-layout>