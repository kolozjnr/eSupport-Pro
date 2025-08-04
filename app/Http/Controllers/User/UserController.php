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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createUser()
    {
        return view('user.settings.create-user');
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
                    'business_developer_id' => $refId

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

    public function assignCustomer()
    {
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

            $roles = Role::all();
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

    // Step 1: Delete existing role data
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

    // Step 2: Create new role record
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
        case 'quality control':
            QualityControl::create(['user_id' => $user->id]);
            break;
        case 'supervisor':
            Supervisor::create(['user_id' => $user->id]);
            break;
        case 'account':
            Account::create(['user_id' => $user->id]);
            break;
        case 'business developer':
            BusinessDeveloper::create(['user_id' => $user->id]);
            break;
        case 'business manager':
            BusinessManager::create(['user_id' => $user->id]);
            break;
        case 'business supervisor':
            BusinessSupervisor::create(['user_id' => $user->id]);
            break;
        case 'customer manager':
            CustomerManager::create(['user_id' => $user->id]);
            break;
    }

    // Optional: Update user table if you store role info there
    //$user->role = $newRoleName;
    $user->save();

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
