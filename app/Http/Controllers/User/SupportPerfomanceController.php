<?php

namespace App\Http\Controllers\User;

use App\Models\Ticket;
use App\Models\Support;
use App\Models\Customer;
use Illuminate\Http\Request;
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

        // Log::info('Support Performance Metrics:', $stats);
        // OR dump-and-die to inspect immediately
        //dd($stats);

            
        $totalTicketCount = Ticket::all()->count();

        $totalCustomerCount = Customer::all()
        ->count();


        $totalSupportCount = Support::all()
        ->count();

       return response()->json([
        'success' => true,
        'chartData' => $stats,
        'totalTicketCount' => $totalTicketCount,
        'totalCustomerCount' => $totalCustomerCount,
        'totalSupportCount' => $totalSupportCount
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
