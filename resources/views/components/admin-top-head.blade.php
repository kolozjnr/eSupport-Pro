@if(auth()->user()->hasRole('customer'))
<div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400"> Total Tickets</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_tickets">0</p>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Total Resolved</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_resolved">0</p>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Total Pending</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_pending">0</p>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('support'))
<div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400"> Total Tickets</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_tickets">0</p>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Total Rejected</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_rejected"></p>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Total Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_customers">0</p>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('supervisor'))
<div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400"> Pending Tickets</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">5</p>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Assigned Tickets</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">15</p>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Total Tickets</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">1500</p>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('account'))
<div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400"> Pending Invoices</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="pending_invoices">0</p>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Succesful transsaction</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="successful_transactions">0</p>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Failed transsaction</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="failed_transactions">0</p>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('businessdeveloper'))
<div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Onboarded Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">5</p>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Active Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">15</p>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Sales</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">1500</p>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('businessmanager'))
<div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Subscription </h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">5</p>
                </div>

            </div>

            <div class="flex items-end">
                {{-- <div class="flex-grow">
                    <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i class="mgc_alarm_2_line"></i> 4 Hrs ago</p>
                </div> --}}
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">System Analyst</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">15</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">1500</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Business Analyst</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">2</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@elseif(auth()->user()->hasRole('customermanager'))
<div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Onboarded Customers </h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">5</p>
                </div>

            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Active Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">15</p>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Inactive Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">1500</p>
                </div>
            </div>
        </div>
    </div>

      {{-- <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Business Analyst</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">2</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

</div>

@elseif(auth()->user()->hasRole('businesssupervisor'))
<div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Subscription </h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">5</p>
                </div>
            </div>

            <div class="flex items-end">
                {{-- <div class="flex-grow">
                    <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i class="mgc_alarm_2_line"></i> 4 Hrs ago</p>
                </div> --}}
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">System Analyst</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">15</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">1500</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Business Analyst</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">2</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('developer'))
<div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Subscription </h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">5</p>
                </div>
            </div>

            <div class="flex items-end">
                {{-- <div class="flex-grow">
                    <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i class="mgc_alarm_2_line"></i> 4 Hrs ago</p>
                </div> --}}
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">System Analyst</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">15</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">1500</p>
                </div>
            </div>

            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div>
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Business Analyst</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center ">2</p>
                </div>
            </div>

            {{-- <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('qualitycontrol'))
<div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Support </h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_supports"></p>
                </div>
            </div>

            {{-- <div class="flex items-end">
                <div class="flex-grow">
                    <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i class="mgc_alarm_2_line"></i> 4 Hrs ago</p>
                </div>
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
     <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_customers"></p>
                </div>
            </div>

            {{-- <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div> --}}
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Active Customers</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="active_customers"></p>
                </div>
            </div>
{{-- 
            <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div> --}}
        </div>
    </div>

      <div class="card">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Tickets</h4>
                    <p class="font-bold text-xl text-gray-400 truncate dark:text-white text-center " id="total_tickets"></p>
                </div>
            </div>

            {{-- <div class="flex items-end">
                <div class="flex">
                    <a href="javascript:void(0);">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="-ms-2">
                        <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-8 w-8 border-2 border-gray-300 dark:border-gray-700" alt="friend">
                    </a>
                </div>
            </div> --}}
        </div>
    </div>

 
</div>

{{-- @elseif(auth()->user()->hasRole('qualityassurance'))
@elseif(auth()->user()->hasRole('qualityassurance')) --}}
@else
    {{-- Fallback content for unassigned role --}}
    {{-- <p>You do not have an assigned role.</p> --}}
@endif
