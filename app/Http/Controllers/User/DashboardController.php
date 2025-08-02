<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(){
        $user = auth()->user();
        if($user->hasRole('customer')){
             $customerId = $user->customer->id;

            $recentTickets = Ticket::where('customer_id', $customerId)
                ->latest()
                ->take(5)
                ->get();

            return view('user.dashboard', compact('recentTickets'));
        }else{
            return view('user.dashboard');
        }
    }

    public function dashboard1(){
        return view('user.index1');
    }

    // public function supportDashboard()
    // {
    //     $user = auth()->user();
    //     $CustomerCount = Customer::where('support_id', $user->id)->count();
    //     $totalTicketCount = Ticket::where('support_id', $user->id)->count();
    //     $totalResolvedTicketCount = Ticket::where('support_id', $user->id)->count();
    //     $totalAssignTicketCount = Ticket::where('support_id', $user->id)->count();

    //     $pastMonthTicketCount = Ticket::where('support_id', $user->id)->count();
    //     $customerCount = Ticket::where('support_id', $user->id)->count();

    //     return view('user.support-dashboard', compact('CustomerCount', 'totalTicketCount', 'totalResolvedTicketCount', 'totalAssignTicketCount', 'pastMonthTicketCount', 'pastMonthTicketCount'));
    // }

    public function supportChart()
    {
        $user = auth()->user();
        $supportId = $user->getSupportId();
        $now = now();
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth(); // 6 months total (including current)

        // Get ticket counts for last 6 months
        $ticketData = Ticket::where('support_id', $supportId)
            ->whereBetween('created_at', [$sixMonthsAgo, $now])
            ->selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(*) as ticket_count,
                SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved_count
            ')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Get customer counts for last 6 months
        $customerData = Ticket::where('support_id', $supportId)
            ->whereBetween('created_at', [$sixMonthsAgo, $now])
            ->selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(DISTINCT customer_id) as customer_count
            ')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $monthlyTicketCount = Ticket::where('support_id', $supportId)
        ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

            $monthlyTicketResolvedCount = Ticket::where('support_id', $supportId)
            ->where('status', 'resolved')
        ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
            
            $monthlyTicketAssignedCount = Ticket::where('support_id', $supportId)
            ->where('status', 'rejected')
        ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

            
            $totalTicketRejectedCount = Ticket::where('support_id', $supportId)
            ->where('status', 'rejected')
            ->count();

            $totalCustomerCount = Customer::where('support_id', $supportId)
            ->count();


            $totalTicketCount = Ticket::where('support_id', $supportId)
            ->count();


        // Format data for chart
        $chartData = [];
        $current = $sixMonthsAgo->copy();
        
        while ($current <= $now) {
            $month = $current->format('m');
            $year = $current->format('Y');
            $monthName = $current->format('M Y');
            
            $ticketMonth = $ticketData->first(fn($item) => $item->month == $month && $item->year == $year);
            $customerMonth = $customerData->first(fn($item) => $item->month == $month && $item->year == $year);
            //$monthlyTicketCount = $ticketMonth ? $ticketMonth->ticket_count : 0;

            
            $chartData[] = [
                'month' => $monthName,
                'tickets' => $ticketMonth ? $ticketMonth->ticket_count : 0,
                'resolved' => $ticketMonth ? $ticketMonth->resolved_count : 0,
                'customers' => $customerMonth ? $customerMonth->customer_count : 0,
                'month_iso' => $current->toISOString(), // For ApexCharts datetime format
            ];
            
            $current->addMonth();
        }

        return response()->json([
            'success' => true,
            'data' => $chartData,
            'stats' => [
                'past_month_tickets' => array_slice(array_column($chartData, 'tickets'), -1)[0],
                'total_customers' => array_sum(array_column($chartData, 'customers')),
                'resolution_rate' => $this->calculateResolutionRate($chartData),
                'monthlyTicketCount' => $monthlyTicketCount,
                'monthlyTicketResolvedCount' => $monthlyTicketResolvedCount,
                'monthlyTicketAssignedCount' => $monthlyTicketAssignedCount,
                'totalTicketRejectedCount' => $totalTicketRejectedCount,
                //'totalTicketAssignedCount' => $totalTicketAssignedCount,
                'totalTicketCount' => $totalTicketCount,
                'totalCustomerCount' => $totalCustomerCount
            ]
        ]);
    }

    private function calculateResolutionRate($chartData)
    {
        $totalTickets = array_sum(array_column($chartData, 'tickets'));
        $totalResolved = array_sum(array_column($chartData, 'resolved'));
        
        return $totalTickets > 0 ? round(($totalResolved / $totalTickets) * 100, 2) : 0;
    }


    public function getCustomerChart()
    {
        $now = Carbon::now();
        
    }

   public function subscriptionMetrics()
    {
        if(auth()->user()->hasRole('account')){
            // Get current date and calculate start date (13 months ago)
            $endDate = now();
            $startDate = now()->subMonths(12)->startOfMonth();
            
            // Generate all months in the range
            $months = [];
            $current = clone $startDate;
            while ($current <= $endDate) {
                $months[$current->format('Y-m')] = [
                    'total_amount' => 0,
                    'total_subscribers' => 0
                ];
                $current->addMonth();
            }
            
            // Get actual data from database
            $results = Subscription::where('status', 'successful')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('SUM(amount) as total_amount'),
                    DB::raw('COUNT(DISTINCT customer_id) as total_subscribers')
                )
                ->groupBy('month')
                ->get()
                ->keyBy('month');
            
            // Merge actual data with all months
            foreach ($results as $month => $data) {
                $months[$month] = [
                    'total_amount' => $data->total_amount,
                    'total_subscribers' => $data->total_subscribers
                ];
            }
            
            // Format for response
            $metrics = array_map(function($month, $data) {
                return [
                    'month' => $month,
                    'total_amount' => $data['total_amount'],
                    'total_subscribers' => $data['total_subscribers']
                ];
            }, array_keys($months), $months);

            $total_failed = Subscription::where('status', 'failed')->count();
            $total_success = Subscription::where('status', 'successful')->count();
            $total_pending = Subscription::where('status', 'pending')->count();
            
            return response()->json([
                'success' => true,
                'metrics' => array_values($metrics),
                'total_failed' => $total_failed,
                'total_success' => $total_success,
                'total_pending' => $total_pending
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 403);
    }

    

   
}
