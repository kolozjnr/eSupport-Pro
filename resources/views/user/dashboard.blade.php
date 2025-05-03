<x-app-layout>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">
            @include('layouts.top-header')
            <main class="flex-grow p-6">

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Dashboard</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Menu</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Dashboard</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid 2xl:grid-cols-4 gap-6 mb-6">
                    
                    <div class="2xl:col-span-3">
                        @include('layouts.admin-top-head')

                        @include('layouts.admin-revenue-chart')	
                    </div>

                    @include('layouts.admin-ticket-summary')
                </div> <!-- Grid End -->

               @include('layouts.admin-mid-cards')

                <div class="grid 2xl:grid-cols-4 md:grid-cols-2 gap-6">
                    <div class="2xl:col-span-2 md:col-span-2">
                        <div class="card">
                            <div class="p-6">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Project Overview</h4>
                                    <div>
                                        <button class="text-gray-600 dark:text-gray-400" data-fc-type="dropdown" data-fc-placement="left-start" type="button">
                                            <i class="mgc_more_2_fill text-xl"></i>
                                        </button>

                                        <div class="hidden fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-36 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" href="javascript:void(0)">
                                                Today
                                            </a>
                                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" href="javascript:void(0)">
                                                Yesterday
                                            </a>
                                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                                                Last Week
                                            </a>
                                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                                                Last Month
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 items-center gap-4">
                                    <div class="md:order-1 order-2">
                                        <div class="flex flex-col gap-6">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">Product Design</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>26</b> Total Projects</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        <li class="list-inline-item"><b>4</b> Employees</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-danger/25 text-lg text-danger"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">Web Development</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>30</b> Total Projects</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        <li class="list-inline-item"><b>5</b> Employees</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-success/25 text-lg text-success"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">Illustration Design</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>12</b> Total Projects</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        <li class="list-inline-item"><b>3</b> Employees</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-warning/25 text-lg text-warning"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">UI/UX Design</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>8</b> Total Projects</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        <li class="list-inline-item"><b>4</b> Employees</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="md:order-2 order-1">
                                        <div id="project-overview-chart" class="apex-charts" data-colors="#3073F1,#ff679b,#0acf97,#ffbc00"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Daily Task</h4>
                                    <div>
                                        <select class="form-input form-select-sm">
                                            <option selected>Today</option>
                                            <option value="1">Yesterday</option>
                                            <option value="2">Tomorrow</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="py-6">
                                <div class="px-6" data-simplebar style="max-height: 304px;">
                                    <div class="space-y-4">
                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                                            <ul class="flex items-center gap-2 mb-2">
                                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Landing Page Design</a>
                                                <i class="mgc_round_fill text-[5px]"></i>
                                                <h5 class="text-sm font-semibold">2 Hrs ago</h5>
                                            </ul>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new landing page (Saas Product)</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> <b>5</b> People</p>
                                        </div>

                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                                            <ul class="flex items-center gap-2 mb-2">
                                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Admin Dashboard</a>
                                                <i class="mgc_round_fill text-[5px]"></i>
                                                <h5 class="text-sm font-semibold">3 Hrs ago</h5>
                                            </ul>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Admin dashboard</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> <b>2</b> People</p>
                                        </div>

                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                                            <ul class="flex items-center gap-2 mb-2">
                                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Client Work</a>
                                                <i class="mgc_round_fill text-[5px]"></i>
                                                <h5 class="text-sm font-semibold">5 Hrs ago</h5>
                                            </ul>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> <b>2</b> People</p>
                                        </div>

                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                                            <ul class="flex items-center gap-2 mb-2">
                                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">UI/UX Design</a>
                                                <i class="mgc_round_fill text-[5px]"></i>
                                                <h5 class="text-sm font-semibold">6 Hrs ago</h5>
                                            </ul>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new UI Kit in figma</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> <b>3</b> People</p>
                                        </div>

                                        <div class="flex items-center justify-center">
                                            <div class="animate-spin flex">
                                                <i class="mgc_loading_2_line text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div class="card">
                            <div class="card-header flex justify-between items-center">
                                <h4 class="card-title">Team Members</h4>
                                <div>
                                    <select class="form-select form-select-sm">
                                        <option selected>Active</option>
                                        <option value="1">Offline</option>
                                    </select>
                                </div>
                            </div>

                            <div class="py-6">
                                <div class="px-6" data-simplebar style="max-height: 304px;">
                                    <div class="space-y-6">
                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-1.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Risa Pearson</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>UI/UX Designer</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>2.5 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-2.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Margaret D. Evans</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>PHP Developer</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>2 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-3.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Bryan J. Luellen</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>Front end Developer</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>1 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-4.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Kathryn S. Collier</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>UI/UX Designer</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>3 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-5.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Timothy Kauper</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>Backend Developer</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>2 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-6.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Zara Raws</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>Python Developer</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>1 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Grid End -->

            </main>

           @include('layouts.footer')
    </x-app-layout>