<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Account;
use App\Models\Support;
use App\Models\Customer;
use Illuminate\View\View;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use App\Models\QualityControl;
use App\Models\BusinessManager;
use App\Models\CustomerManager;
use Illuminate\Validation\Rules;
use App\Models\BusinessDeveloper;
use App\Models\BusinessSupervisor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['string', 'max:255'],
            'lname' => ['string', 'max:255'],
            'username' => ['string', 'max:255'],	
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //dd($request->fname);

        $user = User::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
        ]);

        if($request->user_type == 'customer')
        {
            $customer = Customer::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'support')
        {
            $support = Support::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'qualitycontrol')
        {
            QualityControl::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'supervisor')
        {
            Supervisor::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'administrator')
        {
            Admin::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'account')
        {
            Account::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'businessdeveloper')
        {
            BusinessDeveloper::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'businessmanager')
        {
            BusinessManager::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'businesssupervisor')
        {
            BusinessSupervisor::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'customermanager')
        {
            CustomerManager::create([
                'user_id' => $user->id
            ]);
        }
        elseif($request->user_type == 'businesssupervisor')
        {
            BusinessSupervisor::create([
                'user_id' => $user->id
            ]);
        }

        event(new Registered($user));
        $user->addRole($user->user_type);


        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
