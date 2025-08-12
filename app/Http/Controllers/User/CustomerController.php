<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Draft;
use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\KYCSubmissionNotification;

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

public function paymentHistory()
{
    return view('user.customers.payment-history');
}

public function getPaymentHistory()
{
    if(auth()->user()->hasRole('customer')){
        $customer = auth()->user();
        $customer_id = $customer->customer->id;
        $subscriptions = Subscription::where('customer_id', $customer_id)
        ->latest()
        ->get();
        return response()->json([
            'success' => true,
            'subscriptions' => $subscriptions
        ]);
    }
}

public function getSinglePayment($id)
{
    if(auth()->user()->hasRole('customer')){
        $customer = auth()->user();
        $data = Subscription::findOrFail($id);
        return view('user.customers.single-payment-history', compact('data'));
    }
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
        //dd($id);
        //$customer = auth()->user();
        $customer = User::with('customer')->findOrFail($id);
        //dd($customer);
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
public function submitKYC(Request $request, $id)
{
    $customer = Customer::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'business_name' => 'required|string|max:255',
        'phone_number' => 'required|string',
        'nin' => 'required|numeric',
        'address' => 'required|string',
        'land_mark' => 'required|string',
        'nok_name' => 'required|string|max:255',
        'nok_phone' => 'required|string|max:255',
        'nok_address' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $validated = $validator->validated();

    try {
        DB::beginTransaction();

        $customer->update([
            'business_name' => $validated['business_name'],
            'phone_number' => $validated['phone_number'],
            'nin' => $validated['nin'],
            'address' => $validated['address'],
            'land_mark' => $validated['land_mark'],
            'nok_name' => $validated['nok_name'],
            'nok_phone' => $validated['nok_phone'],
            'nok_address' => $validated['nok_address'],
            'is_kyced' => 1
        ]);

        // Correct variable name
        $admins = User::where('user_type', 'administrator')->get();

        Notification::send($admins, new KYCSubmissionNotification($customer));

        DB::commit();

        return redirect()->back()->with('success', 'KYC submitted successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to update profile.');
    }
}


public function downloadTemplate()
    {
        $filename = "customers_onboarding.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'First Name', 
                'Last Name', 
                'Middle Name',
                'Email', 
                'Phone Number',
                'NIN',
                'Address',
                'Land Mark',
                'Next of Kin',
                'Next of Kin Address',
                'Next of Kin Phone'
            ]);
            
            // Sample data for user guidance
            fputcsv($file, [
                'John', 
                'Doe', 
                'William', 
                'john.doe@example.com', 
                '+2348012345678',
                '12345678901',
                'No. 12 Tafawa Street, Ibadan',
                'Near Main Market',
                'Jane Doe',
                'No. 15 Unity Street, Abuja',
                '+2349087654321'
            ]);
            
            // You can add more sample rows if needed
            fputcsv($file, [
                'Mary', 
                'Smith', 
                'Grace', 
                'mary.smith@example.com', 
                '+2347012345678',
                '09876543210',
                'Plot 45 Independence Layout',
                'Opposite Police Station',
                'Peter Smith',
                'No. 8 Victoria Island, Abuja',
                '+2348076543210'
            ]);
            
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->businessDeveloper) {
            return redirect()->back()->with('error', 'Business developer not found.');
        }
        
        $businessId = $user->businessDeveloper->id;

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'nin' => 'nullable|string|size:11',
            'address' => 'nullable|string|max:500',
            'land_mark' => 'nullable|string|max:255',
            'nok_name' => 'nullable|string|max:255',
            'nok_phone' => 'nullable|string|max:20',
            'nok_address' => 'nullable|string|max:500',
            'display_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Handle file upload
            $displayPicturePath = null;
            if ($request->hasFile('display_picture')) {
                $displayPicturePath = $request->file('display_picture')->store('customer_pictures', 'public');
            }

            // Create user
            $createUser = User::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'mname' => $request->mname,
                'email' => $request->email,
                'password' => Hash::make('123456789'),
                //'email_verified_at' => now(), // Auto-verify
                'profile_picture' => $displayPicturePath,
            ]);

            // Create customer
            $createCustomer = Customer::create([
                'user_id' => $createUser->id,
                'phone_number' => $request->phone_number,
                'business_developer_id' => $businessId,
                'nin' => $request->nin,
                'address' => $request->address,
                'land_mark' => $request->land_mark,
                'nok_name' => $request->nok_name,
                'nok_address' => $request->nok_address,
                'nok_phone' => $request->nok_phone,
                'is_kyced' => 0,
                //'is_subscribed' => 1, // Default to subscribed
            ]);

            // Add customer role
            $createUser->addRole('customer');

            // Fire events and send email
            event(new Registered($createUser));
            Mail::to($createUser->email)->send(new UserRegisteredMail($createUser));

            DB::commit();

            return redirect()->back()->with('success', 'Customer created successfully! Welcome email has been sent.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Failed to create single customer', [
                'error' => $e->getMessage(),
                'business_developer_id' => $businessId,
                'email' => $request->email
            ]);
            
            return redirect()->back()->with('error', 'Failed to create customer: ' . $e->getMessage())->withInput();
        }
    }

   public function bulkUpload(Request $request)
    {
        
        //dd($request->all());
        $user = auth()->user();
        $businessId = $user->businessDeveloper->id;
        
       if (!$user->businessDeveloper) {
        return redirect()->back()->with('error', 'Business developer not found.');
         }
        $validator = Validator::make($request->all(), [
            'customer_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            $path = $request->file('customer_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            
            if (count($data) > 0 && $data[0][0] === 'First Name') {
                array_shift($data);
            }

            $customerCount = 0;
            $errors = [];

            if (count($data) === 0) {
                return back()->with('error', 'No data found in file.');
            }

            DB::beginTransaction();

            foreach ($data as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) continue;
                
                // Check if row has minimum required columns (at least 5 for basic fields)
                if (count($row) < 5) {
                    $errors[] = "Row " . ($index + 2) . ": Insufficient data columns";
                    continue;
                }

                // Map CSV columns to variables
                $firstName = trim($row[0] ?? '');
                $lastName = trim($row[1] ?? '');
                $middleName = trim($row[2] ?? '');
                $email = trim($row[3] ?? '');
                $phoneNumber = trim($row[4] ?? '');
                $nin = trim($row[5] ?? '');
                $address = trim($row[6] ?? '');
                $landMark = trim($row[7] ?? '');
                $nextOfKin = trim($row[8] ?? '');
                $nextOfKinAddress = trim($row[9] ?? '');
                $nextOfKinPhone = trim($row[10] ?? '');

                // Validate required fields
                if (empty($firstName) || empty($lastName) || empty($email)) {
                    $errors[] = "Row " . ($index + 2) . ": Missing required fields (First Name, Last Name, or Email)";
                    continue;
                }

                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Row " . ($index + 2) . ": Invalid email format ($email)";
                    continue;
                }

                // Check if user already exists
                $existingUser = User::where('email', $email)->first();
                if ($existingUser) {
                    $errors[] = "Row " . ($index + 2) . ": User with email $email already exists";
                    continue;
                }

                try {
                    // Create user
                    $createUser = User::create([
                        'fname' => $firstName,
                        'lname' => $lastName,
                        'mname' => $middleName,
                        'email' => $email,
                        'password' => Hash::make('123456789'),
                        //'email_verified_at' => now(), // Auto-verify imported users
                    ]);

                    // Create customer with all additional fields
                    $createCustomer = Customer::create([
                        'user_id' => $createUser->id,
                        'phone_number' => $phoneNumber,
                        'business_developer_id' => $businessId,
                        'nin' => $nin,
                        'address' => $address,
                        'land_mark' => $landMark, // or 'landmark' depending on your column name
                        'nok_name' => $nextOfKin,
                        'nok_address' => $nextOfKinAddress,
                        'nok_phone' => $nextOfKinPhone,
                        //'is_subscribed' => 1, // Default to subscribed
                    ]);

                    // Add customer role
                    $createUser->addRole('customer');

                    // Fire events and send email
                    event(new Registered($createUser));
                    Mail::to($createUser->email)->send(new UserRegisteredMail($createUser));

                    $customerCount++;

                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": Failed to create user - " . $e->getMessage();
                    \Log::error('Failed to create customer from CSV', [
                        'row' => $index + 2,
                        'email' => $email,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }

            DB::commit();

            $message = "$customerCount customers imported successfully!";
            if (!empty($errors)) {
                $message .= " However, " . count($errors) . " rows had errors.";
                \Log::warning('Bulk upload errors', [
                    'business_developer_id' => $businessId,
                    'errors' => $errors
                ]);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Bulk upload failed', [
                'error' => $e->getMessage(),
                'business_developer_id' => $businessId
            ]);
            return back()->with('error', 'Failed to import customers: ' . $e->getMessage());
        }
    }




    public function pricing()
    {
        return view('user.customers.pricing');
    }
}
