<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createUser()
    {
        return view('user.settings.create-user');
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
