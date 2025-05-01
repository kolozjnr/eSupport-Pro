<x-app-layout>

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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Task</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Task</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Basic</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">The most basic list group is an unordered list with list items and the proper classes. Build upon it with the options that follow, or with your own CSS as needed.</p>

                            <div id="table-gridjs"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Pagination</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Pagination can be enabled by setting <code>pagination: true</code>:</p>

                            <div id="table-pagination"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Search</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Grid.js supports global search on all rows and columns. Set <code>search: true</code> to enable the search plugin:</p>

                            <div id="table-search"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Sorting</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">To enable sorting, simply add <code>sort: true</code> to your config:</p>

                            <div id="table-sorting"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Loading State</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Grid.js renders a loading bar automatically while it waits for the data to be fetched. Here we are using an async
                                function to demonstrate this behaviour (e.g. an async function can be a XHR call to a server backend)</p>

                            <div id="table-loading-state"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Fixed Header</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">The most basic list group is an unordered list with list items and the proper classes. Build upon it with the options that follow, or with your own CSS as needed.</p>

                            <div id="table-fixed-header"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Hidden Columns</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">Add <code>hidden: true</code> to the columns definition to hide them. </p>

                            <div id="table-hidden-column"></div>
                        </div>
                    </div>
                </div>

            </main>

            

    @include('layouts.footer')
</x-app-layout>