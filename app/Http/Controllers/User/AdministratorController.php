<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Support;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\QualityControl;
use App\Models\BusinessDeveloper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdministratorController extends Controller
{
    public function adminStats()
    {
        $supports = Support::all()->count() ?? 0;
        $customers = Customer::all()->count() ?? 0;
        $qualitycontrols = QualityControl::all()->count() ?? 0;
        $businessdevelopers = BusinessDeveloper::all()->count() ?? 0;
        $users = User::all()->count() ?? 0;
        $tickets = Ticket::all()->count() ?? 0;
        $totalIncome = Subscription::where('status', 'successful')
        ->sum('amount');

        //subscription Chart
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
            'supports' => $supports,
            'customers' => $customers,
            'qualitycontrols' => $qualitycontrols,
            'businessdevelopers' => $businessdevelopers,
            'users' => $users,
            'tickets' => $tickets,
            'metrics' => array_values($metrics),
            'total_failed' => $total_failed,
            'total_success' => $total_success,
            'total_pending' => $total_pending,
            'totalIncome' => $totalIncome
        ]);
    }
}
