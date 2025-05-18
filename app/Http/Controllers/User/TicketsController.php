<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
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

    public function edit()
    {
        return view('user.tickets.edit');
    }

    public function draft()
    {
        return view('user.tickets.draft');
    }

    public function viewDrafts()
    {
        return view('user.tickets.view-drafts');
    }

    public function viewFeedback()
    {
        return view('user.tickets.view-feedback');
    }

   
}
