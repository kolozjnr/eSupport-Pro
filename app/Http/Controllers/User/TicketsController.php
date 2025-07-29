<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Draft;
use App\Models\Rating;
use App\Models\Ticket;
use App\Models\Setting;
use App\Models\Support;
use App\Models\Customer;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Services\SupportPerformanceService;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\CustomerTicketUpdateNotification;
use App\Notifications\TicketUploadedOnbehalfofCustomerNotification;

class TicketsController extends Controller
{
    private SupportPerformanceService $performanceService;
    
    public function __construct(SupportPerformanceService $performanceService)
    {
        $this->performanceService = $performanceService;
    }
    
    public function index()
    {
        return view('user.tickets.index');
    }

    public function create()
    {
        return view('user.tickets.create');
    }

    public function show()
    {
        return view('user.tickets.assign-single');
    }

    public function dashboard(){
        $user = auth()->user();
        $customerId = $user->customer->id;

        $recentTickets = Ticket::where('customer_id', $customerId)
            ->latest()
            ->take(20)
            ->get();

        return view('user.dashboard', compact('recentTickets'));
    }

    public function viewOnbehalfTicket()
    {
        return view('user.tickets.view-onbehalf-tickets');
    }

    public function editTicket($id)
    {
        $ticket = Ticket::with('phoneNumbers')->findOrFail($id);
        //dd($ticket);
        //send dude back to his home if he doesn't own the ticket
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this ticket.');
        }
        return view('user.tickets.edit-ticket', compact('ticket'));
    }

    public function updateTicket(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $customerId = auth()->user()->getCustomerId();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'phone_numbers' => 'required|array|min:1',
            'phone_numbers.*.number' => 'required|string|max:20',
        ]);

        try {
            $ticket = Ticket::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            DB::beginTransaction();

            $ticket->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);

            // Delete old phone numbers
            $ticket->phoneNumbers()->delete();

            // Add updated phone numbers
            foreach ($validated['phone_numbers'] as $phone) {
                $ticket->phoneNumbers()->create([
                    'number' => $phone['number'],
                    'user_id' => $userId,
                    'customer_id' => $customerId,
                ]);
            }

            DB::commit();

             return back()->with('success', ' tickets updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update ticket: ' . $e->getMessage()
            ], 500);
        }
    }


    public function draft()
    {
        return view('user.tickets.draft');
    }

    public function viewDrafts()
    {
        //dd(auth()->user()->id);
        return view('user.tickets.view-drafts');
    }

    public function viewFeedback()
    {
        return view('user.tickets.view-feedback');
    }
    // public function getCustomerTickets()
    // {
    //     try {
    //         $drafts = Ticket::with('user', 'phoneNumbers')
    //             ->where('user_id', auth()->id())
    //             ->where('customer_id', auth()->user()->getCustomerId())
    //             ->get();
                
    //         return response()->json($drafts);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Failed to fetch drafts',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function createTicketonBehalf()
    {
        $customers = Customer::with('user')->get();

        return view('user.tickets.create-behalf', compact('customers'));
    }

    public function getCustomerTickets()
    {
        try {
            $query = Ticket::with('user', 'phoneNumbers', 'support.identity', 'support.user')
                ->where('user_id', auth()->id())
                ->where('accepted_status', true)
                ->where('customer_id', auth()->user()->getCustomerId());
                
            // Add status filter if provided
            if (request()->has('status')) {
                $query->where('status', request('status'));
            }
            
            // Add search filter if provided
            if (request()->has('search')) {
                $query->where(function($q) {
                    $q->where('subject', 'like', '%'.request('search').'%')
                    ->orWhere('description', 'like', '%'.request('search').'%');
                });
            }
            
            // Add sorting if provided
            if (request()->has('sort')) {
                $query->orderBy(request('sort'), request('order', 'asc'));
            }
            
            $tickets = $query->get();
                
            return response()->json($tickets);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch tickets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //get tickets uploaded on behalf of customer
    public function getCustomerTicketsOnBehalf()
    {
        $tickets = Ticket::select('id', 'description', 'created_at', 'status')
            ->where('user_id', auth()->id())
            ->where('customer_id', auth()->user()->getCustomerId())
            ->where('accepted_status', false)
            ->latest()
            ->get();

        return response()->json($tickets);
    }


    public function getQualityControlTickets()
    {
        try {
            $tickets = Ticket::with('customer.user', 'phoneNumbers', 'review','support.user', 'support.identity' )
            ->where('accepted_status', true)
            ->latest()
            ->get();
                
            return response()->json($tickets);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch drafts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function assignTicketByQualityControl(Request $request)
{
    $validate = Validator::make($request->all(), [
        'ticket_ids' => 'required|array',
        'ticket_ids.*' => 'required|exists:tickets,id',
        'staff_id' => 'required|exists:supports,id',
        'notes' => 'nullable|string',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validate->errors()->first()
        ], 422);
    }

    try {
        DB::beginTransaction();
        
        foreach ($request->ticket_ids as $ticketId) {

            $identity = Identity::where('support_id', $request->staff_id)
            ->whereNotNull('name')
            ->inRandomOrder()
            ->first();

            if (!$identity) {
                $ticket = Ticket::where('id', $ticketId)->update([
                'status' => 'assigned',
                'support_id' => $request->staff_id,
                'notes' => $request->notes,
                'assigned_at' => now()->addHour(),
                ]);
            }
            else {
                $ticket = Ticket::where('id', $ticketId)->update([
                    'status' => 'assigned',
                    'support_id' => $request->staff_id,
                    'identity_id' => $identity->id,
                    'notes' => $request->notes,
                    'assigned_at' => now()->addHour(),
                ]);
            }
           
        }

          $support = Support::with('user')->findOrFail($request->staff_id);

          //dd($support);

        if ($support->user) {
           $support->user->notify(new TaskAssignedNotification($request->ticket_ids));
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Tickets successfully assigned.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

public function viewSingleTicket($id)
{
    $ticket = Ticket::with('customer.user', 'phoneNumbers', 'review','support.user' )->findOrFail($id);
    return view('user.tickets.view-single-ticket', compact('ticket'));
}

//view support ticket
public function getSupportTicket()
{
    $supportId = auth()->user()->getSupportId();
    try {
            $tickets = Ticket::with('customer.user', 'phoneNumbers', 'review','support.user', 'support.identity' )
            ->where('support_id', $supportId)
            ->where('accepted_status', true)
            ->latest()
            ->get();
                
            return response()->json($tickets);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch drafts',
                'error' => $e->getMessage()
            ], 500);
        }
}
public function updateSupportTicket(Request $request, $id)
{
    $validated = $request->validate([
        'status' => 'required|in:open,assigned,pending,resolved,rejected'
    ]);

    $deduction = Cache::rememberForever('deduction', function () {
        return Setting::first();
    });

    //dd($deduction);
    
    if(auth()->user()->hasRole('support'))
    {
        try {
            DB::beginTransaction();

            $ticket = Ticket::findOrFail($id);

           

            $updates = ['status' => $validated['status']];
            
            if($validated['status'] == 'rejected')
            {
                $ticket->update([
                    'status' => 'rejected',
                    'support_id' => null,
                    'identity_id' => null,
                    'notes' => null,
                ]);
            }
            else if($validated['status'] === 'resolved')
            {
                $updates['resolved_at'] = now()->addHour();
                $updates['resolution_time'] = $ticket->assigned_at->diffInMinutes(now()->addHour());
                //$updates['resolution_time'] = now()->addHour()->diffInMinutes($ticket->assigned_at, false);

                $ticket->update($updates);
                $ticket->customer->decrement('call_service_points', $deduction->call_center_charge);
                // Fixed: Changed $performanceService to $this->performanceService
                $this->performanceService->updateSupportPerformance($ticket->support_id, $ticket->id);
            }
            else
            {
               $updatedTicket = $ticket->update([
                    'status' => $validated['status'],
                    'first_response_at' => $validated['status'] === 'assigned' ? now()->addHour() : $ticket->first_response_at,
                    'response_time' => Carbon::parse($ticket->assigned_at)->diffInMinutes(now()->addHour()),
                    
                ]);
                $ticket->customer->decrement('call_service_points', $deduction->call_center_charge);
                if (!$updatedTicket) {
                    throw new \Exception('Failed to update ticket status');
                }
            }

            $customer = Customer::with('user')->findOrFail($ticket->customer_id);
            //dd($customer);

            if ($customer->user) {
                $customer->user->notify(new CustomerTicketUpdateNotification($validated['status'], $id));
            }
             
            DB::commit();

            return response()->json([
                'message' => 'Ticket status updated successfully to '. $validated['status'],
                'ticket' => $ticket
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Failed to update ticket',
                'error' => $e->getMessage()
            ], 500); // Changed from 404 to 500 for server errors
        }
    }
    else {
        return response()->json([
            'message' => 'You are not authorized to update this ticket',
        ], 403);
    }
}

    public function getPerformanceMetrics(int $supportId)
    {
        $score = $this->performanceService->calculatePerformanceScore($supportId);
        
        return response()->json([
            'performance_score' => $score,
            'metrics' => SupportPerformanceMetric::where('support_id', $supportId)->first()
        ]);
    }



    public function store(Request $request)
    {
        
        //dd($request->customer_id);
        $deduction = Cache::rememberForever('deduction', function(){
            return Setting::first();
        });
        $deduction = $deduction->general_support_charge;
        $userId = auth()->user()->id;
        $customerId = auth()->user()->getCustomerId();
        $citizenBal = auth()->user()->customer->general_support_points;
        //dd($userId);
        //dd(auth()->user()->id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'phone_numbers' => 'required|array|min:1',
            'phone_numbers.*.number' => 'required|max:20',
        ]);

        try {

            if ($citizenBal < $deduction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient service points to create ticket.'
                ], 400);
            }

            DB::beginTransaction();

            if($request->filled('customer_id'))
            {
                //dd($request->customer_id);
                $customer = Customer::findOrFail($request->customer_id);
                $userId = $customer->user_id;
            
                $userFname = auth()->user()->fname;
                //dd($userFname);
                //dd('its for someone please');  this is when someone is uploading on behalf of a customer
                $ticket = Ticket::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'subject' => 'New Ticket',
                    'status' => 'open',
                    'user_id' => $userId,
                    'customer_id' => $request->customer_id,
                    'accepted_status' => false
                ]);
                foreach ($validated['phone_numbers'] as $phone) {
                $ticket->phoneNumbers()->create([
                    'number' => $phone['number'],
                    'user_id' => $userId,
                    'customer_id' => $request->customer_id
                ]);
            }
            $customer->user->notify(new TicketUploadedOnbehalfofCustomerNotification($userFname, $ticket->id));

            }
            else{
                //dd('i own it'); this is customers ticket uploaded by itself
                $ticket = Ticket::create([
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'subject' => 'New Ticket',
                    'status' => 'open',
                    'user_id' => $userId,
                    'customer_id' => $customerId
                ]);
                foreach ($validated['phone_numbers'] as $phone) {
                    $ticket->phoneNumbers()->create([
                        'number' => $phone['number'],
                        'user_id' => $userId,
                        'customer_id' => $customerId
                    ]);
                }
                //$citizenBal - 5;
                auth()->user()->customer->decrement('general_support_points', $deduction);
            }

            

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully',
                'ticket' => $ticket
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create ticket: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadTemplate()
    {
        $filename = "tickets_template.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['name', 'description', 'phone_numbers']);
        fputcsv($handle, ['Sample Ticket', 'Sample description', '1234567890,9876543210']);
        fclose($handle);

        return response()->streamDownload(
            function () {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['name', 'description', 'phone_numbers']);
                fputcsv($handle, ['Sample Ticket', 'Sample description', '1234567890,9876543210']);
                fclose($handle);
            },
            $filename,
            $headers
        );
    }

    public function bulkUpload(Request $request)
    {
         $deduction = Cache::rememberForever('deduction', function(){
            return Setting::first();
        });
        $cost = $deduction->general_support_charge;
        
        $userId = auth()->user()->id;
        $customerId = auth()->user()->getCustomerId();

        //dd($request->all());

        $request->validate([
            'tickets_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        try {
            $path = $request->file('tickets_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            
            // Remove header if exists
            if (count($data) > 0 && $data[0][0] === 'name') {
                array_shift($data);
            }

            $ticketCount = count($data);
            $citizenBal = auth()->user()->customer->general_support_points;

            if ($ticketCount === 0) {
                return back()->with('error', 'No data found in file.');
            }

            if ($citizenBal < $cost * $ticketCount) {
                return back()->with('error', 'Insufficient service points to create tickets.');
            }

            DB::beginTransaction();

            if($request->has('customer_id'))
            {
                $customerId = $request->customer_id;
                $customer = Customer::find($customerId);
                $userId = $customer->user->id;
                //this is the user who uploads the ticket
                $userFname = auth()->user()->fname;
                foreach ($data as $row) {
                    if (count($row) < 3) continue;
                    
                    $ticket = Ticket::create([
                        'name' => $row[0],
                        'description' => $row[1],
                        'subject' => 'New Ticket',
                        'status' => 'open',
                        'user_id' => $userId,
                        'customer_id' => $customerId,
                        'accepted_status' => false
                    ]);

                    $phoneNumbers = explode(',', $row[2]);
                    foreach ($phoneNumbers as $number) {
                        $ticket->phoneNumbers()->create([
                            'number' => trim($number),
                            'user_id' => $userId,
                            'customer_id' => $customerId
                        ]);
                    }
                }
                 $customer->user->notify(new TicketUploadedOnbehalfofCustomerNotification($userFname, $ticket->id));

                // Don't deduct first untill customer accepts
                // auth()->user()->customer->decrement('general_support_points', $cost * $ticketCount);
            }
            else
            {
                foreach ($data as $row) {
                    if (count($row) < 3) continue;
                    
                    $ticket = Ticket::create([
                        'name' => $row[0],
                        'description' => $row[1],
                        'subject' => 'New Ticket',
                        'status' => 'open',
                        'user_id' => $userId,
                        'customer_id' => $customerId
                    ]);

                    $phoneNumbers = explode(',', $row[2]);
                    foreach ($phoneNumbers as $number) {
                        $ticket->phoneNumbers()->create([
                            'number' => trim($number),
                            'user_id' => $userId,
                            'customer_id' => $customerId
                        ]);
                    }
                }

                // Deduct total cost at once
                auth()->user()->customer->decrement('general_support_points', $cost * $ticketCount);
            }
            

            DB::commit();

            return back()->with('success', $ticketCount . ' tickets imported successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to import tickets: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        Ticket::find($id)->delete();
        return redirect()->route('user.tickets.index')->with('success', 'Ticket deleted successfully!');
    }

    //Dratfs begins here

    public function getDraft()
    {
        try {
            $drafts = Draft::with('phoneNumbers')
                ->where('user_id', auth()->id())
                ->where('customer_id', auth()->user()->getCustomerId())
                ->get();
                
            return response()->json($drafts);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch drafts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyDraft(Draft $draft)
    {
        $draft->delete();
        
        return response()->json(['message' => 'Draft deleted successfully']);
    }

    public function storeDraft(Request $request)
    {
        //dd($request->all());
         $userId = auth()->user()->id;
        $customerId = auth()->user()->getCustomerId();
        //dd(auth()->user()->id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_numbers' => 'required|array|min:1',
            'phone_numbers.*.number' => 'required|string|max:20',
        ]);

        try {
            DB::beginTransaction();
            
            $draft = Draft::create([
                'fname' => $validated['name'],
                'user_id' => $userId,
                'customer_id' => $customerId
            ]);

            foreach ($validated['phone_numbers'] as $phone) {
                $draft->phoneNumbers()->create([
                    'number' => $phone['number'],
                    'user_id' => $userId,
                    'customer_id' => $customerId
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully',
                'draft' => $draft
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create draft: ' . $e->getMessage()
            ], 500);
        }
    }

     public function draftTemplate()
    {
        $filename = "drafts_template.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['name', 'phone_numbers']);
        fputcsv($handle, ['Sample Draft', '1234567890,9876543210']);
        fclose($handle);

        return response()->streamDownload(
            function () {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['name', 'phone_numbers']);
                fputcsv($handle, ['Sample Ticket', '1234567890,9876543210']);
                fclose($handle);
            },
            $filename,
            $headers
        );
    }
    public function bulkDraftUpload(Request $request)
    {
        //dd($request->all());
        $userId = auth()->user()->id;
        $customerId = auth()->user()->getCustomerId();
        $request->validate([
            'draft_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        try {
            $path = $request->file('draft_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            
            // Remove header if exists
            if (count($data) > 0 && $data[0][0] === 'name') {
                array_shift($data);
            }
            //dd($data);

            DB::beginTransaction();
            
            foreach ($data as $row) {
                if (count($row) < 2) continue;
                
                $draft = Draft::create([
                    'fname' => $row[0],
                    'user_id' => $userId,
                    'customer_id' => $customerId
                ]);

                $phoneNumbers = explode(',', $row[1]);
                foreach ($phoneNumbers as $number) {
                    $draft->phoneNumbers()->create([
                        'number' => trim($number),
                        'user_id' => $userId,
                        'customer_id' => $customerId
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', count($data) . ' draft imported successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to import draft: ' . $e->getMessage());
        }
    }

   
}
