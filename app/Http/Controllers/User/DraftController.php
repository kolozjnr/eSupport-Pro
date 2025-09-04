<?php

namespace App\Http\Controllers\User;

use App\Models\Draft;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DraftController extends Controller
{
    public function index() {
        return view('user.draft.draft');
    }

   public function draftTicket($id)
    {
        $draft = Draft::with('phoneNumbers')->findOrFail($id);
        
        // Transform the phone numbers data
        $draft->phone_numbers = $draft->phoneNumbers->map(function($phone) {
            return ['number' => $phone->number];
        })->toArray();
        
        return view('user.draft.draft-ticket', compact('draft'));
    }


}
