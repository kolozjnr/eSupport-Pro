<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('user.task.index');
    }

    public function create()
    {
        return view('user.task.create');
    }
}
