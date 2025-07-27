<?php

namespace App\Http\Controllers;

use App\Models\Support;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

    public function contactEmail(Request $request)
    {

        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'phone' => 'nullable',
        ]);
        $validated = $validator->validate();

        //dd($validated);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try{
                Mail::to('contact@esupportpro.com')->send(new ContactMail($validator->validated()));

                return back()->with('success', 'Email sent successfully');
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
        //$data = $request->all();
       
    }
}
