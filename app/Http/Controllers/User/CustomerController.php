<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Draft;
use App\Models\Ticket;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
     
public function customerDashboard()
{
    $customerId = auth()->user()->customer->id;
    //dd($customerId);
    
    // Get the current date and calculate the start date (6 months ago)
    $now = now();
    $startDate = $now->copy()->subMonths(6)->startOfMonth();
    
    // Query to count tickets per month
    $monthlyTickets = Ticket::where('customer_id', $customerId)
        ->where('created_at', '>=', $startDate)
        ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
    
    // Generate all months in the range (including months with 0 tickets)
    $months = [];
    $current = $startDate->copy();
    
    while ($current <= $now) {
        $monthKey = $current->format('Y-m');
        $months[$monthKey] = [
            'year' => $current->year,
            'month' => $current->month,
            'count' => 0,
            'name' => $current->format('F Y')
        ];
        $current->addMonth();
    }
    
    // Merge the actual ticket counts
    foreach ($monthlyTickets as $ticket) {
        $monthKey = sprintf("%d-%02d", $ticket->year, $ticket->month);
        if (isset($months[$monthKey])) {
            $months[$monthKey]['count'] = $ticket->count;
        }
    }
    
    // Convert to simple array and take only the last 7 months (6 + current)
    $result = array_slice(array_values($months), -7);

     $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    $total_resolved_tickets = Ticket::where('customer_id', $customerId)->where('status', 'resolved')->count();
    $total_pending_tickets = Ticket::where('customer_id', $customerId)->where('status', 'open')->count();
    $total_tickets = Ticket::where('customer_id', $customerId)->count();
    $total_subscription = Subscription::where('customer_id', $customerId)->where('status', 'successful')->count();
    $total_draft = Draft::where('customer_id', $customerId)->count();

    $total_pending_tickets_this_month = Ticket::where('customer_id', $customerId)
    ->where('status', 'open')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->count();

    $total_resolved_tickets_this_month = Ticket::where('customer_id', $customerId)
    ->where('status', 'resolved')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->count();
    
     $total_tickets_this_month = Ticket::where('customer_id', $customerId)
    //->where('status', 'resolved')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->count();

    return response()->json([
        'success' => true,
        'monthlyTickets' => $result,
        'total_resolved_tickets' => $total_resolved_tickets,
        'total_pending_tickets' => $total_pending_tickets,
        'total_tickets' => $total_tickets,
        'total_subscription' => $total_subscription,
        'total_draft' => $total_draft ?? 0,
        'total_pending_tickets_this_month' => $total_pending_tickets_this_month ?? 0,
        'total_resolved_tickets_this_month' => $total_resolved_tickets_this_month ?? 0,
        'total_tickets_this_month' => $total_tickets_this_month ?? 0
    ]);
}


    public function getOnboarding()
    {
        return view('user.customers.onboardcustomers');
    }

    public function manageCustomer()
    {
        return view('user.customers.managecustomers');
    }
    public function show($id)
    {
        $customer = auth()->user();
        return view('user.customers.edit', compact('customer'));
    }


public function updateCustomer(Request $request, $id)
{
    $customer = User::findOrFail($id);

    //dd($request->all());

    $validator = Validator::make($request->all(), [
        'fname' => 'required|string|max:255',
        'email' => 'required|email',
        // 'role' => 'nullable',
        'display_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $validated = $validator->validated();

    try {
        if ($request->hasFile('display_picture')) {
            if ($customer->display_picture && Storage::disk('public')->exists($customer->display_picture)) {
                Storage::disk('public')->delete($customer->display_picture);
            }

            $filePath = $request->file('display_picture')->store('profile_pictures', 'public');
            $validated['display_picture'] = $filePath;
        }

        $customer->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update profile.');
    }
}



    public function pricing()
    {
        return view('user.customers.pricing');
    }
}
