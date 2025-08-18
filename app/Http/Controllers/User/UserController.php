<?php

namespace App\Http\Controllers\User;

use Laratrust;
use App\Models\User;
use App\Models\Admin;
use App\Models\Account;
use App\Models\Support;
use App\Models\Customer;
use App\Models\Identity;
use App\Models\Supervisor;
use Laratrust\Models\Role;
use Illuminate\Http\Request;
use App\Models\QualityControl;
use App\Models\BusinessManager;
use App\Models\CustomerManager;
use App\Mail\UserRegisteredMail;
use App\Models\BusinessDeveloper;
use App\Models\BusinessSupervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RoleChangedNotification;

class UserController extends Controller
{
    public function createUser()
    {
        $roles = Role::all();
        return view('user.settings.create-user', compact('roles'));
    }

    public function postUserCreation(Request $request)
    {
         $validated = $request->validate([
            'fname' => 'required|string',
            'mname' => 'nullable|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'user_type' => 'required|string',
            'display_picture' => 'nullable|image|max:2048',
            'identities' => 'nullable|array',
            'identities.*' => 'nullable|string',
        ]);

        //dd($validated);


        // Handle file upload
        $filePath = null;
        // if ($request->hasFile('display_picture')) {
        //     $filePath = $request->file('display_picture')->store('avatars', 'public');
        // }

        try{
            if ($request->hasFile('display_picture')) {
                // if ($customer->display_picture && Storage::disk('public')->exists($customer->display_picture)) {
                //     Storage::disk('public')->delete($customer->display_picture);
                // }
                $filePath = $request->file('display_picture')->store('profile_pictures', 'public');
                $validated['display_picture'] = $filePath;
            }
            
            
            DB::beginTransaction();
            
            // Create user
            $user = User::create([
                'fname' => $validated['fname'],
                'mname' => $validated['mname'],
                'lname' => $validated['lname'],
                'email' => $validated['email'],
                'user_type' => $validated['user_type'],
                'display_picture' => $filePath,
                'password' => Hash::make('123456789'),
            ]);

            //dd($user->id);

            if($request->user_type == 'customer')
            {
                //dd($request->referral_code);
                $refId = null;
                if (isset($request->referral_code) && !empty($request->referral_code)) {
                    $referrer = BusinessDeveloper::where('referral_code', $request->referral_code)->first();
                    if ($referrer) {
                        //dd($referrer);
                        $refId = $referrer->id;
                    }
                    
                }
                //dd($referrer);

                $customer = Customer::create([
                    'user_id' => $user->id,
                    'business_developer_id' => $refId,
                    'is_kyced' => 0

                ]);
            }
            elseif($validated['user_type'] == 'support')
            {
                $support = Support::create([
                    'user_id' => $user->id
                ]);

                // Save identities
                foreach ($validated['identities'] as $identityName) {
                    $identity = Identity::create([
                        'user_id' => $user->id,
                        'support_id' => $support->id,
                        'name' => $identityName
                    ]);
                    //$support->identity()->create(['fname' => $identityName]);
                }
            }
            elseif($validated['user_type'] == 'qualitycontrol')
            {
               // dd($user->id);
                QualityControl::create([
                    'user_id' => $user->id
                ]);
            }
            elseif($validated['user_type'] == 'supervisor')
            {
                
                
            //dd($validated['user_type']);
                Supervisor::create([
                    'user_id' => $user->id
                ]);
            }
            elseif($validated['user_type'] == 'administrator')
            {
                Admin::create([
                    'user_id' => $user->id
                ]);
            }
            elseif($validated['user_type'] == 'account')
            {
                Account::create([
                    'user_id' => $user->id
                ]);
            }
            elseif($validated['user_type'] == 'businessdeveloper')
            {
                $refCode = BusinessDeveloper::generateRefCode();

                BusinessDeveloper::create([
                    'user_id' => $user->id,
                    'referral_code' => $refCode
                ]);
            }
            elseif($validated['user_type'] == 'businessmanager')
            {
                BusinessManager::create([
                    'user_id' => $user->id
                ]);
            }
            elseif($validated['user_type'] == 'businesssupervisor')
            {
                BusinessSupervisor::create([
                    'user_id' => $user->id
                ]);
            }
            elseif($validated['user_type'] == 'customermanager')
            {
                CustomerManager::create([
                    'user_id' => $user->id
                ]);
            }

            event(new Registered($user));
            $user->addRole($validated['user_type']);
            // if($validated['user_type'] == 'customer')
            // {
                Mail::to($user->email)->send(new UserRegisteredMail($user));
            //}

            DB::commit();

            if($user)
            {
                return back()->with('success', 'User created successfully.');
            }
            else{
                return back()->with('error', 'User creation failed.');
            }
            
            
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create: ' . $e->getMessage()
            ], 500);
        }
    }

    public function approveKYC()
    {
         $user = Auth::user();
        if($user->user_type != 'administrator')
        {
            return abort(403);
        }
        $customers = Customer::with('user')
        ->where('is_kyced', 1)
        //->orWhere('is_kyced')
                    ->get();

        return view('user.settings.approve-kyc', compact('customers'));
    }
    public function updateKYCStatus(Request $request, Customer $customer)
    {
        $user = Auth::user();
        if ($user->user_type != 'administrator') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'is_kyced' => 'required|integer|in:2,3', // Only allow rejection (2) or approval (3)
        ]);

        try {
            // Update the customer's KYC status
            $customer->update([
                'is_kyced' => $request->is_kyced,
                'updated_at' => now(),
            ]);

            // Optional: Log the action for audit purposes
            \Log::info("KYC status updated", [
                'customer_id' => $customer->id,
                'user_id' => $customer->user->id,
                'old_status' => $customer->getOriginal('is_kyced'),
                'new_status' => $request->is_kyced,
                'updated_by' => $user->id,
                'updated_at' => now()
            ]);

            // Optional: Send notification to customer
            if ($request->is_kyced == 2) {
                // KYC Approved - you can send approval notification
                // Mail::to($customer->user->email)->send(new KYCApprovedMail($customer));
                $message = 'KYC approved successfully';
            } else {
                // KYC Rejected - you can send rejection notification
                 Mail::to($customer->user->email)->send(new KYCRejectedMail($customer));
                $message = 'KYC rejected successfully';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'customer' => [
                    'id' => $customer->id,
                    'is_kyced' => $customer->is_kyced,
                    'updated_at' => $customer->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error("Failed to update KYC status", [
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
                'updated_by' => $user->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update KYC status. Please try again.'
            ], 500);
        }
    }

    public function manageUsers()
    {
        //
        $user = Auth::user();
        if($user->user_type != 'administrator')
        {
            return abort(403);
        }
        //  Get all users with their current status
        $users = User::select('id', 'fname', 'lname', 'email', 'user_type', 'is_active', 'created_at', 'updated_at')
                    ->orderBy('fname')
                    ->get();

        return view('user.settings.manage_users', compact('users'));
    }

    /**
     * Update user status via API
     */
    public function updateStatus(Request $request, $userId)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Find the user
            $user = User::findOrFail($userId);
            
            // Store old status for logging
            $oldStatus = $user->is_active;
            $newStatus = $request->input('is_active');
            
            // Update the user status
            $user->is_active = $newStatus;
            $user->save();

            // Log the status change
            $statusText = $newStatus ? 'activated' : 'deactivated';
            Log::info("User status updated", [
                'user_id' => $user->id,
                'user_name' => $user->fname . ' ' . $user->lname,
                'old_status' => $oldStatus ? 'active' : 'inactive',
                'new_status' => $newStatus ? 'active' : 'inactive',
                'updated_by' => auth()->user() ? auth()->user()->id : 'system',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => true,
                'message' => "User {$statusText} successfully",
                'data' => [
                    'user_id' => $user->id,
                    'name' => $user->fname . ' ' . $user->lname,
                    'is_active' => $user->is_active,
                    'updated_at' => $user->updated_at->toISOString()
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error updating user status: ' . $e->getMessage(), [
                'user_id' => $userId,
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating user status'
            ], 500);
        }
    }

    /**
     * Get user status information
     */
    public function getUserStatus($userId)
    {
        try {
            $user = User::select('id', 'fname', 'lname', 'email', 'user_type', 'is_active', 'updated_at')
                       ->findOrFail($userId);

            return response()->json([
                'success' => true,
                'data' => [
                    'user_id' => $user->id,
                    'name' => $user->fname . ' ' . $user->lname,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                    'is_active' => $user->is_active,
                    'updated_at' => $user->updated_at->toISOString()
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error fetching user status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching user status'
            ], 500);
        }
    }

    /**
     * Bulk update user statuses
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $userIds = $request->input('user_ids');
            $newStatus = $request->input('is_active');
            
            // Update all selected users
            $updatedCount = User::whereIn('id', $userIds)
                               ->update(['is_active' => $newStatus]);

            // Log the bulk update
            Log::info("Bulk user status update", [
                'user_ids' => $userIds,
                'new_status' => $newStatus ? 'active' : 'inactive',
                'updated_count' => $updatedCount,
                'updated_by' => auth()->user() ? auth()->user()->id : 'system',
                'ip_address' => $request->ip()
            ]);

            $statusText = $newStatus ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} users {$statusText} successfully",
                'data' => [
                    'updated_count' => $updatedCount,
                    'user_ids' => $userIds,
                    'new_status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in bulk status update: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during bulk update'
            ], 500);
        }
    }

    /**
     * Get user status statistics
     */
    public function getStatusStats()
    {
        try {
            $activeCount = User::where('is_active', true)->count();
            $inactiveCount = User::where('is_active', false)->count();
            $totalCount = User::count();

            return response()->json([
                'success' => true,
                'data' => [
                    'active_users' => $activeCount,
                    'inactive_users' => $inactiveCount,
                    'total_users' => $totalCount,
                    'active_percentage' => $totalCount > 0 ? round(($activeCount / $totalCount) * 100, 2) : 0
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching status statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching statistics'
            ], 500);
        }
    }
    

    public function assignCustomer()
    {
        $user = Auth::user();
        if($user->user_type != 'administrator')
        {
            return abort(403);
        }

        $customers = Customer::with('user')->get();
        $bds = BusinessDeveloper::with('user')->get();
        return view('user.settings.assign-customer-to-bd', compact('customers', 'bds'));
    }

    public function postAssignCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'business_developer_id' => 'required|exists:business_developers,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $customer = Customer::find($request->customer_id);
            $customer->business_developer_id = $request->business_developer_id;
            $customer->save();

            DB::commit();
            return redirect()->back()->with('success', 'Customer assigned successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to assign customer: ' . $e->getMessage());
        }

     
    }

    

    public function manageRoles()
    {
        $user = Auth::user();
        if($user->user_type != 'administrator')
        {
            return abort(403);
        }
        
        $users = User::with(['customer', 'support', 'administrator', 'qualitycontrol', 'supervisor', 'account', 'businessDeveloper', 'bussinesManager', 'bussinessSupervisor', 'customerManager']) // Add all your role relationships
            ->get()
            ->map(function ($user) {
                $roleData = null;
                $roleName = 'user'; // Default role
                
                if ($user->customer) {
                    $roleData = $user->customer;
                    $roleName = 'Customer';
                } elseif ($user->support) {
                    $roleData = $user->support;
                    $roleName = 'Support';
                } elseif ($user->administrator) {
                    $roleData = $user->administrator;
                    $roleName = 'Admin';
                }
                elseif($user->qualitycontrol){
                    $roleData = $user->qualitycontrol;
                    $roleName = 'QA';
                }
                elseif($user->supervisor){
                    $roleData = $user->supervisor;
                    $roleName = 'Supervisor';
                }
                elseif($user->account){
                    $roleData = $user->account;
                    $roleName = 'Account';
                }
                elseif($user->businessdeveloper){
                    $roleData = $user->businessdeveloper;
                    $roleName = 'Business Developer';
                }
                elseif($user->businessmanager){
                    $roleData = $user->businessmanager;
                    $roleName = 'Business Manager';
                }
                elseif($user->businesssupervisor){
                    $roleData = $user->businesssupervisor;
                    $roleName = 'Business Supervisor';
                }
                elseif($user->customermanager){
                    $roleData = $user->customermanager;
                    $roleName = 'Customer Manager';
                }
                
                return [
                    'id' => $user->id,
                    'name' => $user->fname,
                    'email' => $user->email,
                    'role' => $roleName,
                    'status' => $user->is_active ?? 'active',
                    'role_data' => $roleData,
                    'user_type' => $user->role
                ];
            });

            $roles = Role::where('name', '!=', 'customer')->get();
        return view('user.settings.manage_roles', compact('users', 'roles'));
    }


public function updateUserRole(Request $request)
{
    $request->validate([
        'user_type' => 'required|exists:users,id',
        'role' => 'required|exists:roles,id',
    ]);

    $user = User::findOrFail($request->user_type);
    $newRoleId = $request->role;
    $newRoleName = Role::findOrFail($newRoleId)->name;

    $oldRole = optional($user->roles()->first())->name ?? 'No Role';

    // Delete old role data
    $roleTables = [
        'customer' => Customer::class,
        'support' => Support::class,
        'administrator' => Administrator::class,
        'qualitycontrol' => QualityControl::class,
        'supervisor' => Supervisor::class,
        'account' => Account::class,
        'businessdeveloper' => BusinessDeveloper::class,
        'businessmanager' => BusinessManager::class,
        'businesssupervisor' => BusinessSupervisor::class,
        'customermanager' => CustomerManager::class,
    ];

    foreach ($roleTables as $relation => $model) {
        if ($user->$relation) {
            $model::where('user_id', $user->id)->delete();
        }
    }

    // Add new role record
    switch (strtolower($newRoleName)) {
        case 'customer':
            Customer::create(['user_id' => $user->id]);
            break;
        case 'support':
            Support::create(['user_id' => $user->id]);
            break;
        case 'administrator':
            Administrator::create(['user_id' => $user->id]);
            break;
        case 'qualitycontrol':
            QualityControl::create(['user_id' => $user->id]);
            break;
        case 'supervisor':
            Supervisor::create(['user_id' => $user->id]);
            break;
        case 'account':
            Account::create(['user_id' => $user->id]);
            break;
        case 'businessdeveloper':
            $refCode = BusinessDeveloper::generateRefCode();
            BusinessDeveloper::create([
                'user_id' => $user->id,
                'referral_code' => $refCode
            ]);
            break;
        case 'businessmanager':
            BusinessManager::create(['user_id' => $user->id]);
            break;
        case 'businesssupervisor':
            BusinessSupervisor::create(['user_id' => $user->id]);
            break;
        case 'customermanager':
            CustomerManager::create(['user_id' => $user->id]);
            break;
    }

    // Send role change notification
    $user->notify(new RoleChangedNotification($oldRole, $newRoleName));

    return redirect()->back()->with('success', 'User role updated successfully.');
}



    public function getKnowledgebase()
    {
        return view('user.settings.create-knowledgebase');
    }

    public function getSupport()
    {
        $support = Support::with('users')->get();
    }

    public function getRoles()
    {
        $roles = Role::with('users')->get();

        dd($roles);
    }

    public function getAllUsers()
    {
        // Get all users with their related role data
        $users = User::with(['customer', 'support', 'administrator', 'qualitycontrol', 'supervisor', 'account', 'businessDeveloper', 'bussinesManager', 'bussinessSupervisor', 'customerManager']) // Add all your role relationships
            ->get()
            ->map(function ($user) {
                // Determine the user's role and related data
                $roleData = null;
                $roleName = 'user'; // Default role
                
                if ($user->customer) {
                    $roleData = $user->customer;
                    $roleName = 'Customer';
                } elseif ($user->support) {
                    $roleData = $user->support;
                    $roleName = 'Support';
                } elseif ($user->administrator) {
                    $roleData = $user->administrator;
                    $roleName = 'Admin';
                }
                elseif($user->qualitycontrol){
                    $roleData = $user->qualitycontrol;
                    $roleName = 'QA';
                }
                elseif($user->supervisor){
                    $roleData = $user->supervisor;
                    $roleName = 'Supervisor';
                }
                elseif($user->account){
                    $roleData = $user->account;
                    $roleName = 'Account';
                }
                elseif($user->businessdeveloper){
                    $roleData = $user->businessdeveloper;
                    $roleName = 'Business Developer';
                }
                elseif($user->businessmanager){
                    $roleData = $user->businessmanager;
                    $roleName = 'Business Manager';
                }
                elseif($user->businesssupervisor){
                    $roleData = $user->businesssupervisor;
                    $roleName = 'Business Supervisor';
                }
                elseif($user->customermanager){
                    $roleData = $user->customermanager;
                    $roleName = 'Customer Manager';
                }
                
                return [
                    'id' => $user->id,
                    'name' => $user->fname,
                    'email' => $user->email,
                    'role' => $roleName,
                    'status' => $user->is_active ?? 'active',
                    'role_data' => $roleData,
                    'user_type' => $user->role
                ];
            });

        return response()->json($users);
    }

    public function changeRole(User $user, Request $request)
{
    try {
        $request->validate([
            'role' => 'required|in:customer,support,admin'
        ]);

        // Verify the role exists in Laratrust
        if (!Laratrust::role()->where('name', $request->role)->exists()) {
            return response()->json(['message' => 'Invalid role specified'], 422);
        }

        $user->syncRoles([$request->role]);
        $user->update(['user_type' => $request->role]);

        return response()->json(['message' => 'Role updated successfully']);
        
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error updating role: ' . $e->getMessage()], 500);
    }
}

    // public function changeRole(User $user, Request $request)
    // {
    //     $request->validate([
    //         'role' => 'required|in:customer,support,admin'
    //     ]);
        
    //     // Remove from old role table
    //     if ($user->user_type === 'customer') {
    //         Customer::where('user_id', $user->id)->delete();
    //     } elseif ($user->user_type === 'support') {
    //         Support::where('user_id', $user->id)->delete();
    //     } elseif ($user->user_type === 'admin') {
    //        // Admin::where('user_id', $user->id)->delete();
    //     }
        
    //     // Add to new role table
    //     if ($request->role === 'customer') {
    //         Customer::create(['user_id' => $user->id]);
    //     } elseif ($request->role === 'support') {
    //         Support::create(['user_id' => $user->id]);
    //     } elseif ($request->role === 'admin') {
    //         Admin::create(['user_id' => $user->id]);
    //     }
        
    //     // Update user type
    //     $user->update(['user_type' => $request->role]);
        
    //     return response()->json(['message' => 'Role updated successfully']);
    // }

    public function destroy(User $user)
    {
        // Delete from role-specific table first
        if ($user->user_type === 'customer') {
            Customer::where('user_id', $user->id)->delete();
        } elseif ($user->user_type === 'support') {
            Support::where('user_id', $user->id)->delete();
        } elseif ($user->user_type === 'admin') {
            Admin::where('user_id', $user->id)->delete();
        }
        
        // Then delete the user
        $user->delete();
        
        return response()->json(['message' => 'User deleted successfully']);
    }
}
