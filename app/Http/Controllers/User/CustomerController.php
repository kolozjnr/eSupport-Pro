<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
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
        return view('user.customers.edit');
    }
    public function pricing()
    {
        return view('user.customers.pricing');
    }
}
