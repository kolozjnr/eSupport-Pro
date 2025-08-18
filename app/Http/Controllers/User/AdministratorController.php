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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordResetNotification;

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

    public function verifiedCustomers()
    {
        return view('user.settings.verified-customers');
    }

    public function getVeriedCustomers()
    {
        $customers = Customer::with('user:id,fname,lname,email')
            ->where('is_kyced', 2)
            ->select('id', 'address', 'phone_number', 'business_name', 'nin', 'created_at')
            ->cursorPaginate(15); // Or regular paginate()

        return response()->json([
            'data' => $customers->items(),
            'next_cursor' => $customers->nextCursor()?->encode(),
            // For regular pagination:
            // 'total' => $customers->total(),
            // 'per_page' => $customers->perPage(),
            // 'current_page' => $customers->currentPage()
        ]);
    }

    public function getResetPassword()
    {
          $user = Auth::user();
        if($user->user_type != 'administrator')
        {
            return abort(403);
        }
        $customers = Customer::with('user')
        ->where('is_kyced', 2)
                    ->get();

        return view('user.settings.reset-password', compact('customers'));
    }

    public function resetPassword($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->password = Hash::make('123456789');
            $user->save();

            $user->notify(new PasswordResetNotification($user));

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error resetting password: ' . $e->getMessage()
            ], 500);
        }
    }
}
