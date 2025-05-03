<div class="grid lg:grid-cols-3 gap-6">
    <div class="col-span-1">
        <div class="card">
            <div class="p-6">
                <h4 class="card-title">Monthly Target</h4>

                <div id="monthly-target" class="apex-charts my-8" data-colors="#0acf97,#3073F1"></div>

                <div class="flex justify-center">
                    <div class="w-1/2 text-center">
                        <h5>Pending</h5>
                        <p class="fw-semibold text-muted">
                            <i class="mgc_round_fill text-primary"></i> Projects
                        </p>
                    </div>
                    <div class="w-1/2 text-center">
                        <h5>Done</h5>
                        <p class="fw-semibold text-muted">
                            <i class="mgc_round_fill text-success"></i> Projects
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Project Statistics</h4>
                    <div class="flex gap-2">
                        <button type="button" class="btn btn-sm bg-primary/25 text-primary hover:bg-primary hover:text-white">
                            All
                        </button>
                        <button type="button" class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                            6M
                        </button>
                        <button type="button" class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                            1Y
                        </button>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="p-6">
                        <div id="column_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div> --}}

                <div dir="ltr" class="mt-2">
                    <div id="crm-project-statistics" class="apex-charts" data-colors="#cbdcfc,#3073F1"></div>
                </div>
            </div>
        </div>
    </div>
</div>