<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnivController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

     public function getUserRole()
    {
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'role' => $user->roles->pluck('name')->first()      
          ]);
    }

    public function testEmail()
    {
        return view('emails.new_user_email');
    }

    public function fetchSupport()
    {
        $supports = Support::with('user')
            ->withCount(['assignedTickets'])
            ->get();

        return response()->json($supports);
    }
}
