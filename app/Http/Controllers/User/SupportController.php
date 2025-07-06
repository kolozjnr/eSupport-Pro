<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('user.supports.identity');
    }

    public function update(Request $request, $id)
    {
        $support = Support::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'support_id' => 'required| integer|exists:supports,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

    }
}
