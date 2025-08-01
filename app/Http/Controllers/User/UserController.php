<?php

namespace App\Http\Controllers\User;

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
        return view('user.settings.manage_roles');
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
}
