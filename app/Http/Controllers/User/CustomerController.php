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
}
