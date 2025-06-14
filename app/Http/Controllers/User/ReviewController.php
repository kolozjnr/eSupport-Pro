<?php

namespace App\Http\Controllers\User;

use App\Models\Rating;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
      //Review Tickets

    public function reviewTicket(Request $request)
    {
        $customerId = auth()->user()->getCustomerId();
        
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:1000'
        ]);

        // Verify the ticket belongs to the user and is completed
        $ticket = Ticket::where('id', $validated['ticket_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        // Check if review already exists
        if ($ticket->review()->exists()) {
            return response()->json([
                'message' => 'You have already reviewed this ticket'
            ], 422);
        }

        
        $review = new Rating([
            'ticket_id' => $validated['ticket_id'],
            'user_id' => Auth::id(),
            'customer_id' => $customerId,
            'rating' => $validated['rating'],
            'comment' => $validated['review']
        ]);

        $review->save();

        return response()->json([
            'message' => 'Review submitted successfully',
            'review' => $review
        ]);
    }

}
