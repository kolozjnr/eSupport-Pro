<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare./ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="page-content">
        @include('../layouts.top-header')
     
            <main class="flex-grow p-6"> 
                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Ticket single</h4>

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
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Single Ticket</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Preview Ticket</h4>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="card">
                                {{-- <div class="flex flex-wrap justify-between items-center gap-2 p-6">
                                    <a href="javascript:void(0);" class="btn bg-danger/20 text-sm font-medium text-danger hover:text-white hover:bg-danger"><i class="mgc_add_circle_line me-3"></i> Add Customers</a>
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" class="btn bg-success/25 text-lg font-medium text-success hover:text-white hover:bg-success"><i class="mgc_settings_3_line"></i></button>
                                        <button type="button" class="btn bg-dark/25 text-sm font-medium text-slate-900 dark:text-slate-200/70 hover:text-white hover:bg-dark/90">Import</button>
                                        <button type="button" class="btn bg-dark/25 text-sm font-medium text-slate-900 dark:text-slate-200/70 hover:text-white hover:bg-dark/90">Export</button>
                                    </div>
                                </div> --}}
                                  <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --border: #e2e8f0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--secondary);
        }
        
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .breadcrumb i {
            font-size: 12px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 24px;
        }
        
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }
        
        .card-body {
            padding: 24px;
        }
        
        .ticket-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        .info-group {
            margin-bottom: 20px;
        }
        
        .info-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--secondary);
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .description-section {
            grid-column: 1 / -1;
            margin-top: 10px;
        }
        
        .description-content {
            border-radius: 8px;
            padding: 16px;
            margin-top: 10px;
            line-height: 1.6;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        
        .status-open {
            background: #dcfce7;
            color: #16a34a;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }
        
        .status-closed {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-hover);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--secondary);
        }
        
        .btn-outline:hover {
            background: #f8fafc;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        /* Review Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--secondary);
        }
        
        .modal-body {
            padding: 24px;
        }
        
        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        .rating-stars {
            display: flex;
            gap: 8px;
            margin: 15px 0;
        }
        
        .rating-star {
            font-size: 28px;
            color: #e2e8f0;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .rating-star.active {
            color: #f59e0b;
        }
        
        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            font-family: inherit;
            resize: vertical;
            min-height: 120px;
        }
        
        .text-danger {
            color: var(--danger);
            font-size: 13px;
            margin-top: 5px;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .ticket-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
   

        <!-- Ticket Details Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title text-lg text-slate-700 dark:text-slate-400">Ticket Information</h2>
                @php
                    $status = $ticket->status ?? '';

                    // If user is customer and status is rejected, override
                    if(auth()->user()->hasRole('customer') && $status === 'rejected') {
                        $status = 'awaiting response';
                    }

                    // Map statuses to badge colors
                    $statusClasses = [
                        'open' => 'bg-blue-100 text-blue-800',
                        'resolved' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                        'awaiting response' => 'bg-yellow-100 text-yellow-800',
                    ];

                    $statusClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
                @endphp

                <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                    <i class="fas fa-circle mr-2 text-[8px]"></i>
                    {{ ucfirst($status) }}
                </span>

            </div>
            
            <div class="card-body">
                <div class="ticket-grid">
                    <div class="info-group">
                        <span class="info-label text-xl text-slate-700 dark:text-slate-400">Requested By</span>
                        <div class="info-value text-lg text-slate-700 dark:text-slate-400">{{$ticket->customer->user->fname .' ' . $ticket->customer->user->lname ?? ''}}</div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label text-xl text-slate-700 dark:text-slate-400">Support Agent</span>
                        <div class="info-value text-lg text-slate-700 dark:text-slate-400">{{$ticket->support?->user?->fname .' ' . $ticket->support?->user?->lname ?? ''}}</div>
                    </div>
{{--                     
                    <div class="info-group">
                        <span class="info-label">Priority</span>
                        <div class="info-value">High</div>
                    </div> --}}

                    <div class="info-group">
                        <span class="info-label text-xl text-slate-700 dark:text-slate-400">Subject</span>
                        <div class="info-value text-lg text-slate-700 dark:text-slate-400">{{$ticket->name}}</div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label text-xl text-slate-700 dark:text-slate-400">Comment</span>
                        <div class="info-value text-lg text-slate-700 dark:text-slate-400">{{$ticket->comments}}</div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label text-xl text-slate-700 dark:text-slate-400">Created Date</span>
                        <div class="info-value text-lg text-slate-700 dark:text-slate-400">{{$ticket->created_at}}</div>
                    </div>
                    
                    {{-- <div class="info-group">
                        <span class="info-label">Due Date</span>
                        <div class="info-value">Oct 22, 2023 - 05:00 PM</div>
                    </div> --}}
                    
                    <div class="description-section">
                        <span class="info-label text-xl text-slate-700 dark:text-slate-400">Description</span>
                        <div class="description-content">
                            <p class="text-lg text-slate-700 dark:text-slate-400">{{$ticket->description ?? ''}}</p>
                            {{-- <p>I've tried clearing cache and cookies but the problem persists. This started happening after the last update was deployed.</p> --}}
                        </div>
                    </div>
                </div>
                
                {{-- <div class="action-buttons">
                    <button class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Ticket
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div> --}}
            </div>
        </div>

        <!-- Additional Information Card -->
        {{-- <div class="card">
            <div class="card-header">
                <h2 class="card-title">Additional Information</h2>
            </div>
            
            <div class="card-body">
                <div class="ticket-grid">
                    <div class="info-group">
                        <span class="info-label">Ticket ID</span>
                        <div class="info-value">#EST-12345</div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label">Department</span>
                        <div class="info-value">Technical Support</div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label">Last Updated</span>
                        <div class="info-value">Oct 18, 2023 - 02:15 PM</div>
                    </div>
                    
                    <div class="info-group">
                        <span class="info-label">Related Tickets</span>
                        <div class="info-value">#EST-12201, #EST-12235</div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    

                            </div>
                        </div>
                    </div>


                </div>

            </main>



            
            
   <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}" defer></script>
     
   
         
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
<script src="https://unpkg.com/gridjs-plugins/dist/gridjs-plugins.umd.js"></script>

       

    @include('layouts.footer')

</x-app-layout>