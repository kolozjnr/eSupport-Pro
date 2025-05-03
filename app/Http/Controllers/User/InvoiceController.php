<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('user.invoice.index');
    }

    public function create()
    {
        return view('user.invoice.create');
    }
    public function financialReport()
    {
        return view('user.invoice.financial-report');
    }
}
