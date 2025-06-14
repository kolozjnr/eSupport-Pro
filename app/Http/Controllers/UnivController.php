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

    public function fetchSupport()
    {
        $supports = Support::with('user')
            ->withCount(['assignedTickets'])
            ->get();

        return response()->json($supports);
    }
}
