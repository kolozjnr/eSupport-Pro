@if(auth()->user()->hasRole('customer'))
<div class="grid lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Activities</h4>
                    {{-- <div class="flex gap-2">
                        <button type="button" class="btn btn-sm bg-primary/25 text-primary hover:bg-primary hover:text-white">
                            All
                        </button>
                        <button type="button" class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                            6M
                        </button>
                        <button type="button" class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                            1Y
                        </button>
                    </div> --}}
                </div>

                {{-- <div class="card">
                    <div class="p-6">
                        <div id="column_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div> --}}

                <div dir="ltr" class="mt-2">
                   <div id="customer_activities" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(auth()->user()->hasRole('support'))

<div class="grid lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Monthly Performance</h4>
                    {{-- <div class="flex gap-2">
                        <button type="button" class="btn btn-sm bg-primary/25 text-primary hover:bg-primary hover:text-white">
                            All
                        </button>
                        <button type="button" class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                            6M
                        </button>
                        <button type="button" class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                            1Y
                        </button>
                    </div> --}}
                </div>

                {{-- <div class="card">
                    <div class="p-6">
                        <div id="column_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div> --}}

                <div dir="ltr" class="mt-2">
                   <div id="support_activities" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('supervisor'))

<div class="grid lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6 flex flex-col h-full">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">support Performance metrics</h4>
                </div>
                <div dir="ltr" class="mt-2">
                  <div id="support_performance_pie_chart" class="apex-charts h-full" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>


@elseif(auth()->user()->hasRole('account'))

<div class="grid lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6 flex flex-col h-full">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Subscription metrics</h4>
                </div>
                <div dir="ltr" class="mt-2">
                  <div id="account_invoice" class="apex-charts h-full" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(auth()->user()->hasRole('businessdeveloper'))

<div class="grid lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6 flex flex-col h-full">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Subscription metrics</h4>
                </div>
                <div dir="ltr" class="mt-2">
                  <div id="business_developer" class="apex-charts h-full" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(auth()->user()->hasRole('customermanager'))

<div class="grid lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6 flex flex-col h-full">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Customers Metrics</h4>
                </div>
                <div dir="ltr" class="mt-2">
                  <div id="customer_manager_metric" class="apex-charts h-full" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>


@elseif(auth()->user()->hasRole('qualitycontrol'))

<div class="grid lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6 flex flex-col h-full">
                <div class="card-header flex justify-between items-center">
                    <h4 class="card-title">support Performance metrics</h4>
                </div>
                <div dir="ltr" class="mt-2">
                  <div id="quality_control_pie_chart" class="apex-charts h-full" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>


@elseif(auth()->user()->hasRole('businesssupervisor'))


@elseif(auth()->user()->hasRole('developer'))


@else
    {{-- fallback content --}}
@endif