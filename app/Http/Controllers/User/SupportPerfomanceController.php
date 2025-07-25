<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Support;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\SupportPerformanceMetric;
use App\Services\SupportPerformanceService;

class SupportPerfomanceController extends Controller
{
    private SupportPerformanceService $performanceService;
    
    public function __construct(SupportPerformanceService $performanceService)
    {
        $this->performanceService = $performanceService;
    }

    public function getSupportPerformanceMetrics()
    {
       $stats = $this->performanceService->getSupportPerformanceMetrics();

        //Log::info('Support Performance Metrics:', $stats);
        //OR dump-and-die to inspect immediately
       // dd($stats);

        //Payment failed to initialize. Array to string conversion (Connection: mysql, SQL: insert into `subscriptions` (`user_id`, `customer_id`, `payment_gateway_ref`, `paymentReference`, `reference`, `amount`, `status`, `updated_at`, `created_at`) values (1, 1, MNFY|10|20250618232811|000107, xWzuH5LmhO, ?, 10000, pending, 2025-06-18 22:28:09, 2025-06-18 22:28:09))

        $totalTicketCount = Ticket::all()->count();
        $pendingTicketCount = Ticket::where('status', 'pending')
        ->count();
        $totalCustomerCount = Customer::all()
        ->count();
        $totalActiveCustomerCount = Customer::where('is_subscribed', '1')
        ->count();
        $totalSupportCount = Support::all()
        ->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $pendingTicketCount = Ticket::where('status', 'pending')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $resolvedTicketCount = Ticket::where('status', 'resolved')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $openTicketCount = Ticket::where('status', 'open')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
            $totalTicketThisMonth = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
            
            $reviewedTicketCount = Ticket::has('review')->count();
            $totalPendingTickets = Ticket::where('status', 'open')->count();




       return response()->json([
        'success' => true,
        'chartData' => $stats,
        'totalTicketCount' => $totalTicketCount,
        'totalCustomerCount' => $totalCustomerCount,
        'totalSupportCount' => $totalSupportCount,
        'pendingTicketCount' => $pendingTicketCount,
        'resolvedTicketCount' => $resolvedTicketCount,
        'openTicketCount' => $openTicketCount,
        'totalTicketThisMonth' => $totalTicketThisMonth,
        'totalActiveCustomerCount' => $totalActiveCustomerCount,
        'reviewedTicketCount' => $reviewedTicketCount,
        'totalPendingTickets' => $totalPendingTickets
       ]);

    }
    
    public function recalculateAllMetrics(): void
    {
        $supports = Support::whereHas('performanceMetrics')->get();
        
        foreach ($supports as $support) {
            $tickets = Ticket::where('support_id', $support->id)
                ->whereNotNull('resolved_at')
                ->get();
                
            SupportPerformanceMetric::updateOrCreate(
                ['support_id' => $support->id],
                [
                    'total_tickets_resolved' => $tickets->count(),
                    'average_response_time' => $tickets->avg('response_time'),
                    'average_resolution_time' => $tickets->avg('resolution_time'),
                    'updated_at' => now()
                ]
            );
        }
    }
}
