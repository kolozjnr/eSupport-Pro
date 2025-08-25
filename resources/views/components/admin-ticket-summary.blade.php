@if(auth()->user()->hasRole('customer'))


<div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title">Monthly Summary</h4>
        </div>

        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i>
            <b id="total_tickets_this_month">0</b> Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">Pending</h5>
                    <p class="text-gray-400" id="total_pending_this_month">0</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Resolved</h5>
                    <p id="total_resolved_this_month">0</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Drafts</h5>
                    <p id="total_drafts_this_month">0</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            {{-- <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Completed</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- <div class="card p-6">
        <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2"><i class="mgc_arrow_up_line text-sm align-baseline me-1"></i>59%</span></h4>
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-base font-semibold">Completed Projects</h5>
            <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
        </div>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
            <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div> --}}
</div>

@elseif(auth()->user()->hasRole('administrator'))


<div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title">Monthly Summary</h4>
        </div>

        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i>
            <b id="total_tickets_this_month_admin">0</b> Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">Pending</h5>
                    <p class="text-gray-400" id="total_pending_this_month_admin">0</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Resolved</h5>
                    <p id="total_resolved_this_month_admin">0</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Drafts</h5>
                    <p id="total_drafts_this_month_admin">0</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            {{-- <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Completed</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- <div class="card p-6">
        <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2"><i class="mgc_arrow_up_line text-sm align-baseline me-1"></i>59%</span></h4>
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-base font-semibold">Completed Projects</h5>
            <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
        </div>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
            <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div> --}}
</div>


@elseif(auth()->user()->hasRole('qualitycontro'))

@elseif(auth()->user()->hasRole('bussinessmanager'))

@elseif(auth()->user()->hasRole('bussinesssupervisor'))

@elseif(auth()->user()->hasRole('support'))
<!-- Second Column (takes 1/3 of the row) -->
    <div class="col-span-1">
        <div class="card mb-6">
            <div class="px-6 py-5 flex justify-between items-center">
                <h4 class="header-title">Monthly Summary</h4>
                {{-- <div>
                    <button class="text-gray-600 dark:text-gray-400" data-fc-type="dropdown" data-fc-placement="left-start" type="button">
                        <i class="mgc_more_1_fill text-xl"></i>
                    </button>

                    <div class="hidden fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-36 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                        <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" href="javascript:void(0)">
                            <i class="mgc_add_circle_line"></i> Add
                        </a>
                        <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" href="javascript:void(0)">
                            <i class="mgc_edit_line"></i> Edit
                        </a>
                        <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                            <i class="mgc_copy_2_line"></i> Copy
                        </a>
                        <div class="h-px bg-gray-200 dark:bg-gray-700 my-2 -mx-2"></div>
                        <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-danger hover:bg-danger/5" href="javascript:void(0)">
                            <i class="mgc_delete_line"></i> Delete
                        </a>
                    </div>
                </div> --}}
            </div>
            <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
                <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b id="total_tickets">38</b> Total Tickets
            </div>

            <div class="p-6 space-y-3">
                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                            <i class="mgc_group_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="font-semibold mb-1">Resolved</h5>
                        <p class="text-gray-400">0</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                            <i class="mgc_compass_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="fw-semibold my-0">Rejected</h5>
                        <p>0</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                            <i class="mgc_check_circle_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="fw-semibold my-0">Open</h5>
                        <p>0</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                            <i class="mgc_send_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="fw-semibold my-0">Pending</h5>
                        <p>20</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2" id="resolution_rate"><i class="mgc_arrow_up_line text-sm align-baseline me-1" id=""></i>59%</span></h4>
            <div class="flex justify-between items-center mb-2">
                
            {{-- <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-red-500/25 text-red-500 ms-2" id="resolution_rate"><i class="mgc_arrow_down_line text-sm align-baseline me-1" id=""></i>59%</span></h4> --}}
            <div class="flex justify-between items-center mb-2">
                <h5 class="text-base font-semibold">Completed Projects</h5>
                <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
            </div>
            <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
                <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

{{-- 
<div class="col-span-1">
    <div class="card mb-6">
            <h4 class="header-title">Montly Ticket Summary</h4>
        </div>
        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b>38</b>1k Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">Active Staff</h5>
                    <p class="text-gray-400">6 Person</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">In Progress</h5>
                    <p>16 Tickets</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Pending</h5>
                    <p>24</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Completed</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2"><i class="mgc_arrow_up_line text-sm align-baseline me-1"></i>59%</span></h4>
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-base font-semibold">Completed Projects</h5>
            <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
        </div>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
            <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div> --}}

@elseif(auth()->user()->hasRole('supervisor'))

<div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title">Montly Ticket Summary</h4>
        </div>
        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b>38</b>1k Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">Active Staff</h5>
                    <p class="text-gray-400">6 Person</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">In Progress</h5>
                    <p>16 Tickets</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Pending</h5>
                    <p>24</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Completed</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2"><i class="mgc_arrow_up_line text-sm align-baseline me-1"></i>59%</span></h4>
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-base font-semibold">Completed Projects</h5>
            <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
        </div>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
            <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>


@elseif(auth()->user()->hasRole('account'))

<!-- Second Column (takes 1/3 of the row) -->
    <div class="col-span-1">
        <div class="card mb-6">
            <div class="px-6 py-5 flex justify-between items-center">
                <h4 class="header-title">Monthly Summary</h4>
        
            </div>
            <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
                <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b id="total_tickets">38</b> Total Tickets
            </div>

            <div class="p-6 space-y-3">
                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                            <i class="mgc_group_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="font-semibold mb-1">Project Discussion</h5>
                        <p class="text-gray-400">6 Person</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                            <i class="mgc_compass_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="fw-semibold my-0">In Progress</h5>
                        <p>16 Projects</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                            <i class="mgc_check_circle_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="fw-semibold my-0">Completed Projects</h5>
                        <p>24</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                            <i class="mgc_send_line text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h5 class="fw-semibold my-0">Delivery Projects</h5>
                        <p>20</p>
                    </div>
                    <div>
                        <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                            <i class="mgc_information_line text-xl"></i>
                        </button>
                        <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                            Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2" id="resolution_rate"><i class="mgc_arrow_up_line text-sm align-baseline me-1" id=""></i>59%</span></h4>
            <div class="flex justify-between items-center mb-2">
                
            {{-- <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-red-500/25 text-red-500 ms-2" id="resolution_rate"><i class="mgc_arrow_down_line text-sm align-baseline me-1" id=""></i>59%</span></h4> --}}
            <div class="flex justify-between items-center mb-2">
                <h5 class="text-base font-semibold">Completed Projects</h5>
                <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
            </div>
            <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
                <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>





{{-- <div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title">Montly invoice Summary</h4>
        </div>
        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b>38</b>1k Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">All Payments</h5>
                    <p class="text-gray-400">6 Person</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">In Progress</h5>
                    <p>16 Tickets</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Refund</h5>
                    <p>24</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Succesful Sales</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@elseif(auth()->user()->hasRole('businessdeveloper'))

<div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title">Montly Summary</h4>
        </div>
        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b>38</b>1k Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">All Payments</h5>
                    <p class="text-gray-400">6 Person</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">In Progress</h5>
                    <p>16 Tickets</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Refund</h5>
                    <p>24</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Succesful Sales</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card p-6">
        <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2"><i class="mgc_arrow_up_line text-sm align-baseline me-1"></i>59%</span></h4>
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-base font-semibold">Completed Projects</h5>
            <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
        </div>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
            <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div> --}}
</div>

@elseif(auth()->user()->hasRole('customermanager'))

<div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title">Montly Summary</h4>
        </div>
        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b>38</b>1k Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">All Payments</h5>
                    <p class="text-gray-400">6 Person</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">In Progress</h5>
                    <p>16 Tickets</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Refund</h5>
                    <p>24</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Succesful Sales</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card p-6">
        <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2"><i class="mgc_arrow_up_line text-sm align-baseline me-1"></i>59%</span></h4>
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-base font-semibold">Completed Projects</h5>
            <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
        </div>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
            <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div> --}}
</div>


@elseif(auth()->user()->hasRole('qualitycontrol'))

<div class="col-span-1">
    <div class="card mb-6">
        <div class="px-6 py-5 flex justify-between items-center">
            <h4 class="header-title">Montly Summary</h4>
        </div>
        <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
            <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b id="total_tickets_this_month"></b> Tickets
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                        <i class="mgc_group_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="font-semibold mb-1">Resolved</h5>
                    <p class="text-gray-400" id="resolved_tickets_this_month"></p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                        <i class="mgc_compass_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0" id="">Open</h5>
                    <p class="text-gray-400" id="open_tickets_this_month"></p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div>

            {{-- <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                        <i class="mgc_check_circle_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">closed</h5>
                    <p>24</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                <div class="flex-shrink-0 me-2">
                    <div class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                        <i class="mgc_send_line text-xl"></i>
                    </div>
                </div>
                <div class="flex-grow">
                    <h5 class="fw-semibold my-0">Succesful Sales</h5>
                    <p>20</p>
                </div>
                <div>
                    <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                        <i class="mgc_information_line text-xl"></i>
                    </button>
                    <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50" role="tooltip">
                        Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow></div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- <div class="card p-6">
        <h4 class="text-gray-600 dark:text-gray-300 mb-2.5">On Time Completed Rate <span class="px-2 py-0.5 rounded bg-success/25 text-success ms-2"><i class="mgc_arrow_up_line text-sm align-baseline me-1"></i>59%</span></h4>
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-base font-semibold">Completed Projects</h5>
            <h5 class="text-gray-600 dark:text-gray-300">65%</h5>
        </div>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 ">
            <div class="flex flex-col justify-center overflow-hidden bg-primary w-1/4" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div> --}}
</div>

@else
    {{-- fallback content --}}
@endif