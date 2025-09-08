@if(auth()->user()->hasRole('customer'))
<div class="grid 2xl:grid-cols-4 md:grid-cols-2 gap-6">
                    <div class="2xl:col-span-3 md:col-span-2">
                        <div class="card">
                            <div class="p-6">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">Recent Tickets Uploaded</h4>
                                    
                                </div> 
                              

                                <div class="grid md:grid-cols-2 items-center gap-4">
                                    <div class="md:order-1 order-2">
                                        <div class="flex flex-col gap-6">
                                              @foreach ($recentTickets as $item)
                                   
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">{{$item->status}}</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item">{{ \Illuminate\Support\Str::limit($item->description, 80, '...') }}</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                                    </ul>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
{{-- 
                                    <div class="md:order-2 order-1">
                                        <div id="project-overview-chart" class="apex-charts" data-colors="#3073F1,#ff679b,#0acf97,#ffbc00"></div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>

            
{{-- 
                    <div class="col-span-1">
                        <div class="card">
                            <div class="card-header flex justify-between items-center">
                                <h4 class="card-title">Drafts</h4>
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
                                                    <div>Support Agent</div>
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
                                                    <div>Accountant</div>
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
                                                    <div>Support Agent</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>1 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-6.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Zara Raws</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>Business Analyst</div>
                                                    <i class="mgc_round_fill text-[5px]"></i>
                                                    <div>1 Year Experience</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div> <!-- Grid End -->
                @elseif(auth()->user()->hasRole('administrator'))
<div class="grid 2xl:grid-cols-4 md:grid-cols-2 gap-6">
    <div class="2xl:col-span-2 md:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">SAs Overview</h4>
                    
                </div>

                <div class="grid md:grid-cols-2 items-center gap-4">
                    <div class="md:order-1 order-2">
                        <div class="flex flex-col gap-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">Jane Long</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>56</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">Barnabas Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>6</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            {{-- <div class="flex items-center">
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
                            </div> --}}
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
                    <h4 class="card-title">Todays Task</h4>
                    {{-- <div>
                        <select class="form-input form-select-sm">
                            <option selected>Today</option>
                            <option value="1">Yesterday</option>
                            <option value="2">Tomorrow</option>
                        </select>
                    </div> --}}
                </div>
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-4">
                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Call Jane Doe</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">2 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Call Jane Doe to fix the transsaction issue</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Muhamed</p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Admin Dashboard</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">3 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Sunday Users</p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Client Work</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">5 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Barnabas</p>
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
                <h4 class="card-title">All Team Members</h4>
                {{-- <div>
                    <select class="form-select form-select-sm">
                        <option selected>Active</option>
                        <option value="1">Offline</option>
                    </select>
                </div> --}}
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <img class="me-3 rounded-full" src="assets/images/users/avatar-1.jpg" width="40" alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Risa Pearson</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>Support Agent</div>
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
                                    <div>Accountant</div>
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
                                    <div>Support Agent</div>
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
                                    <div>Support Agent</div>
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
                                    <div>Business Analyst</div>
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
                                    <div>Business Analyst</div>
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

<div class="grid 2xl:grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="2xl:col-span-2 md:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Recent Tickets</h4>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Grid End -->

@elseif(auth()->user()->hasRole('qualitycontrol'))
<div class="grid 2xl:grid-cols-4 md:grid-cols-2 gap-6">
    <div class="2xl:col-span-2 md:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">SAs Overview</h4>
                    
                </div>

                <div class="grid md:grid-cols-2 items-center gap-4">
                    <div class="md:order-1 order-2">
                        <div class="flex flex-col gap-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">Jane Long</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>56</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">Barnabas Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>6</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            {{-- <div class="flex items-center">
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
                            </div> --}}
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
                    <h4 class="card-title">Todays Task</h4>
                    {{-- <div>
                        <select class="form-input form-select-sm">
                            <option selected>Today</option>
                            <option value="1">Yesterday</option>
                            <option value="2">Tomorrow</option>
                        </select>
                    </div> --}}
                </div>
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-4">
                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Call Jane Doe</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">2 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Call Jane Doe to fix the transsaction issue</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Muhamed</p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Admin Dashboard</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">3 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Sunday Users</p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Client Work</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">5 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Barnabas</p>
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
                <h4 class="card-title">All Team Members</h4>
                {{-- <div>
                    <select class="form-select form-select-sm">
                        <option selected>Active</option>
                        <option value="1">Offline</option>
                    </select>
                </div> --}}
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <img class="me-3 rounded-full" src="assets/images/users/avatar-1.jpg" width="40" alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Risa Pearson</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>Support Agent</div>
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
                                    <div>Accountant</div>
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
                                    <div>Support Agent</div>
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
                                    <div>Support Agent</div>
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
                                    <div>Business Analyst</div>
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
                                    <div>Business Analyst</div>
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

<div class="grid 2xl:grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="2xl:col-span-2 md:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Recent Tickets</h4>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Grid End -->
@elseif(auth()->user()->hasRole('qualityassurance'))
<div class="grid 2xl:grid-cols-4 md:grid-cols-2 gap-6">
                    <div class="2xl:col-span-2 md:col-span-2">
                        <div class="card">
                            <div class="p-6">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">SAs Overview</h4>
                                    
                                </div>

                                <div class="grid md:grid-cols-2 items-center gap-4">
                                    <div class="md:order-1 order-2">
                                        <div class="flex flex-col gap-6">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">Jane Long</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>56</b> Total Tickets</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                                </div>
                                                <div class="flex-grow ms-3">
                                                    <h5 class="fw-semibold mb-1">Barnabas Doe</h5>
                                                    <ul class="flex items-center gap-2">
                                                        <li class="list-inline-item"><b>6</b> Total Tickets</li>
                                                        <li class="list-inline-item">
                                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                                        </li>
                                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                                    </ul>
                                                </div>
                                            </div>

                                            {{-- <div class="flex items-center">
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
                                            </div> --}}
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
                                    <h4 class="card-title">Todays Task</h4>
                                    {{-- <div>
                                        <select class="form-input form-select-sm">
                                            <option selected>Today</option>
                                            <option value="1">Yesterday</option>
                                            <option value="2">Tomorrow</option>
                                        </select>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="py-6">
                                <div class="px-6" data-simplebar style="max-height: 304px;">
                                    <div class="space-y-4">
                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                                            <ul class="flex items-center gap-2 mb-2">
                                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Call Jane Doe</a>
                                                <i class="mgc_round_fill text-[5px]"></i>
                                                <h5 class="text-sm font-semibold">2 Hrs ago</h5>
                                            </ul>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Call Jane Doe to fix the transsaction issue</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Muhamed</p>
                                        </div>

                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                                            <ul class="flex items-center gap-2 mb-2">
                                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Admin Dashboard</a>
                                                <i class="mgc_round_fill text-[5px]"></i>
                                                <h5 class="text-sm font-semibold">3 Hrs ago</h5>
                                            </ul>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Sunday Users</p>
                                        </div>

                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                                            <ul class="flex items-center gap-2 mb-2">
                                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Client Work</a>
                                                <i class="mgc_round_fill text-[5px]"></i>
                                                <h5 class="text-sm font-semibold">5 Hrs ago</h5>
                                            </ul>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Barnabas</p>
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
                                <h4 class="card-title">All Team Members</h4>
                                {{-- <div>
                                    <select class="form-select form-select-sm">
                                        <option selected>Active</option>
                                        <option value="1">Offline</option>
                                    </select>
                                </div> --}}
                            </div>

                            <div class="py-6">
                                <div class="px-6" data-simplebar style="max-height: 304px;">
                                    <div class="space-y-6">
                                        <div class="flex items-center">
                                            <img class="me-3 rounded-full" src="assets/images/users/avatar-1.jpg" width="40" alt="Generic placeholder image">
                                            <div class="w-full overflow-hidden">
                                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Risa Pearson</a></h5>
                                                <div class="flex items-center gap-2">
                                                    <div>Support Agent</div>
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
                                                    <div>Accountant</div>
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
                                                    <div>Support Agent</div>
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
                                                    <div>Support Agent</div>
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
                                                    <div>Business Analyst</div>
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
                                                    <div>Business Analyst</div>
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

                
@elseif(auth()->user()->hasRole('supervisor'))
<div class="grid 2xl:grid-cols-4 md:grid-cols-2 gap-6">
    <div class="2xl:col-span-2 md:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">SAs Overview</h4>
                    
                </div>

                <div class="grid md:grid-cols-2 items-center gap-4">
                    <div class="md:order-1 order-2">
                        <div class="flex flex-col gap-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">John Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>26</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">Jane Long</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>56</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="mgc_round_fill h-10 w-10 flex justify-center items-center rounded-full bg-primary/25 text-lg text-primary"></i>
                                </div>
                                <div class="flex-grow ms-3">
                                    <h5 class="fw-semibold mb-1">Barnabas Doe</h5>
                                    <ul class="flex items-center gap-2">
                                        <li class="list-inline-item"><b>6</b> Total Tickets</li>
                                        <li class="list-inline-item">
                                            <div class="w-1 h-1 rounded bg-gray-400"></div>
                                        </li>
                                        {{-- <li class="list-inline-item"><b>4</b> Employees</li> --}}
                                    </ul>
                                </div>
                            </div>

                            {{-- <div class="flex items-center">
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
                            </div> --}}
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
                    <h4 class="card-title">Todays Task</h4>
                    {{-- <div>
                        <select class="form-input form-select-sm">
                            <option selected>Today</option>
                            <option value="1">Yesterday</option>
                            <option value="2">Tomorrow</option>
                        </select>
                    </div> --}}
                </div>
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-4">
                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Call Jane Doe</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">2 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Call Jane Doe to fix the transsaction issue</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Muhamed</p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Admin Dashboard</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">3 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Sunday Users</p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2">
                            <ul class="flex items-center gap-2 mb-2">
                                <a href="javascript:void(0);" class="text-base text-gray-600 dark:text-gray-400">Client Work</a>
                                <i class="mgc_round_fill text-[5px]"></i>
                                <h5 class="text-sm font-semibold">5 Hrs ago</h5>
                            </ul>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Create a new Power Project (Sktech design)</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><i class="mgc_group_line text-xl me-1 align-middle"></i> Barnabas</p>
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
                <h4 class="card-title">All Team Members</h4>
                {{-- <div>
                    <select class="form-select form-select-sm">
                        <option selected>Active</option>
                        <option value="1">Offline</option>
                    </select>
                </div> --}}
            </div>

            <div class="py-6">
                <div class="px-6" data-simplebar style="max-height: 304px;">
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <img class="me-3 rounded-full" src="assets/images/users/avatar-1.jpg" width="40" alt="Generic placeholder image">
                            <div class="w-full overflow-hidden">
                                <h5 class="font-semibold"><a href="javascript:void(0);" class="text-gray-600 dark:text-gray-400">Risa Pearson</a></h5>
                                <div class="flex items-center gap-2">
                                    <div>Support Agent</div>
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
                                    <div>Accountant</div>
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
                                    <div>Support Agent</div>
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
                                    <div>Support Agent</div>
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
                                    <div>Business Analyst</div>
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
                                    <div>Business Analyst</div>
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

<div class="grid 2xl:grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="2xl:col-span-2 md:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Recent Tickets</h4>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Grid End -- <!-- Grid End -->


@else
    {{-- fallback content --}}
@endif