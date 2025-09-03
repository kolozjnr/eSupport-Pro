<?php

namespace App\Http\Controllers\User;

use App\Models\Ticket;
use App\Models\Message;
use App\Events\UserTyping;
use App\Events\MessageSent;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(Ticket $ticket)
    {
        //dd(auth()->user()->id);
        if (!$this->hasAccessToTicket($ticket)) {
            abort(403, 'You do not have access to this ticket');
        }
        
        // Get or create conversation for this ticket
        $conversation = $this->getOrCreateTicketConversation($ticket);
        
        // Get the other user in the conversation
        $otherUser = $this->getOtherUser($ticket);
        
        return view('user.chat.index', compact('ticket', 'conversation', 'otherUser'));
    }

    public function getTicketConversation(Request $request, $ticketId)
{
    $ticket = Ticket::find($ticketId);
    
    if (!$ticket) {
        return response()->json(['error' => 'Ticket not found'], 404);
    }
    
    // Verify user has access to this ticket
    if (!$this->hasAccessToTicket($ticket)) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    $conversation = $this->getOrCreateTicketConversation($ticket);
    
    // Get other user info - PASS THE TICKET, NOT NULL
    $otherUser = $this->getOtherUser($ticket);
    
    return response()->json([
        'conversation' => $conversation,
        'other_user' => $otherUser ? [
            'id' => $otherUser->id,
            'name' => $otherUser->name,
            'email' => $otherUser->email,
            'initials' => $this->getInitials($otherUser->name),
            'is_online' => $otherUser->isOnline(), // if you have this method
            'last_seen' => $otherUser->last_seen_at?->diffForHumans()
        ] : null
    ]);
}

    public function getTicketMessages(Request $request, $ticketId)
{
    $ticket = Ticket::find($ticketId);

    if (!$ticket) {
        return response()->json(['error' => 'Ticket not found'], 404);
    }

    if (!$this->hasAccessToTicket($ticket)) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $conversation = $this->getOrCreateTicketConversation($ticket);

    $query = $conversation->messages()->with('user')->orderBy('created_at', 'asc');

    if ($request->has('after')) {
        $query->where('id', '>', (int)$request->get('after'));
    }

    $messages = $query->get();

    // Debugging dump
    if ($messages->isEmpty()) {
        return response()->json([
            'debug' => [
                'ticket_id' => $ticketId,
                'conversation_id' => $conversation->id ?? null,
                'message_count' => $conversation->messages()->count(),
            ],
            'messages' => [],
        ]);
    }

    return response()->json($messages->map(function ($message) {
        return [
            'id' => $message->id,
            'content' => $message->content,
            'type' => $message->type,
            'attachments' => $message->attachments,
            'user_id' => $message->user_id,
            'is_mine' => $message->user_id === auth()->id(),
            'formatted_time' => $message->created_at->format('H:i'),
            'read_at' => $message->read_at,
            'created_at' => $message->created_at,
        ];
    }));
}


    public function sendTicketMessage(Request $request, Ticket $ticket)
    {
        // Verify user has access to this ticket
        if (!$this->hasAccessToTicket($ticket)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'files.*' => 'file|max:10240|mimes:jpeg,png,gif,webp,pdf,doc,docx,txt'
        ]);

        $conversation = $this->getOrCreateTicketConversation($ticket);
        
        $attachments = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('chat-attachments', 'wasabi');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                    'url' => Storage::disk('wasabi')->url($path)
                    //'url' => Storage::url($path)
                ];
            }
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'type' => !empty($attachments) ? 'file' : 'text',
            'attachments' => !empty($attachments) ? $attachments : null,
        ]);

        // Update conversation timestamp
        $conversation->touch();

        // Format message for response
        $formattedMessage = [
            'id' => $message->id,
            'content' => $message->content,
            'type' => $message->type,
            'attachments' => $message->attachments,
            'user_id' => $message->user_id,
            'is_mine' => true,
            'formatted_time' => $message->created_at->format('H:i'),
            'read_at' => $message->read_at,
            'created_at' => $message->created_at,
        ];

        // Broadcast message to others - PASS THE MESSAGE MODEL INSTANCE
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            \Log::error('Failed to broadcast message: ' . $e->getMessage());
        }

        return response()->json($formattedMessage);
    }
    public function markTicketAsRead(Ticket $ticket)
    {
        // Verify user has access to this ticket
        if (!$this->hasAccessToTicket($ticket)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $conversation = $this->getOrCreateTicketConversation($ticket);

        // Update last read timestamp for the participant
        $conversation->participants()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now()
        ]);

        // Mark unread messages from other users as read
        $conversation->messages()
                    ->where('user_id', '!=', auth()->id())
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function sendTypingIndicator(Request $request, Ticket $ticket)
    {
        // Verify user has access to this ticket
        if (!$this->hasAccessToTicket($ticket)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $conversation = $this->getOrCreateTicketConversation($ticket);

        try {
        broadcast(new UserTyping(
            auth()->id(),          // First argument: user_id
            $conversation->id      // Second argument: conversation_id
        ))->toOthers();
        } catch (\Exception $e) {
            \Log::error('Failed to broadcast typing indicator: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    // Helper methods
    private function hasAccessToTicket(Ticket $ticket)
    {
        $userId = auth()->id();
        $customerUserId = (int)$ticket->customer->user_id;
        $supportUserId = (int)$ticket->support->user_id;
        
        // \Log::debug('hasAccessToTicket check', [
        //     'user_id' => $userId,
        //     'customer_user_id' => $customerUserId,
        //     'support_user_id' => $supportUserId,
        //     'is_customer' => $customerUserId === $userId,
        //     'is_support' => $supportUserId === $userId
        // ]);
        
        return $customerUserId === $userId || 
               $supportUserId === $userId;
    }

    private function getOrCreateTicketConversation(Ticket $ticket)
    {
        // Check if conversation already exists for this ticket
        $conversation = Conversation::where('ticket_id', $ticket->id)->first();
        
        if ($conversation) {
            return $conversation;
        }
        
        // Validate that both users exist
        if (empty($ticket->customer->user_id) || empty($ticket->support->user_id)) {
            throw new \Exception("Ticket is missing required user information");
        }
        
        // Create new conversation for ticket
        $conversation = DB::transaction(function () use ($ticket) {
            
        //dd($ticket->id);
            $conversation = Conversation::create([
                'type' => 'ticket',
                'ticket_id' => $ticket->id
            ]);
            
            // Add both users to conversation
            $participants = [
                (int)$ticket->customer->user_id => ['joined_at' => now()],
                (int)$ticket->support->user_id => ['joined_at' => now()]
            ];
            
            $conversation->participants()->attach($participants);
            
            return $conversation;
        });

        return $conversation;
    }

    private function getOtherUser(Ticket $ticket)
    {
        $currentUserId = auth()->id();
        
        // Check if ticket has required relationships
        if (!$ticket->customer || !$ticket->support) {
            \Log::error('Ticket missing customer or support relationship', [
                'ticket_id' => $ticket->id,
                'has_customer' => !is_null($ticket->customer),
                'has_support' => !is_null($ticket->support)
            ]);
            return null;
        }
        
        // Check if current user is the customer
        if ($ticket->customer->user_id === $currentUserId) {
            return $ticket->support->user; // Return the support user
        } else {
            return $ticket->customer->user; // Return the customer user
        }
    }

    private function formatConversation($conversation, $currentUserId)
    {
        if ($conversation->type === 'ticket') {
            // For ticket conversations, get the other user from the ticket
            $otherUser = $this->getOtherUser($conversation->ticket);
        } else {
            // For private conversations, get the other participant
            $otherUser = $conversation->participants()
                ->where('user_id', '!=', $currentUserId)
                ->first();
        }
        
        return [
            'id' => $conversation->id,
            'type' => $conversation->type,
            'participant' => [
                'id' => $otherUser->id,
                'name' => $otherUser->fname . ' ' . $otherUser->lname,
                'initials' => strtoupper(substr($otherUser->fname, 0, 1) . substr($otherUser->lname, 0, 1)),
                'is_online' => $otherUser->isOnline(),
                'last_seen' => $otherUser->last_seen_at?->diffForHumans(),
            ],
            'last_message' => $conversation->latestMessage?->content,
            'last_message_time' => $conversation->latestMessage?->created_at?->format('H:i'),
            'unread_count' => $conversation->getUnreadCount($currentUserId),
            'updated_at' => $conversation->updated_at,
        ];
    }

    // Regular conversation methods (non-ticket)
    public function getConversations()
    {
        $userId = auth()->id();
        
        $conversations = Conversation::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['latestMessage.user', 'participants' => function ($query) use ($userId) {
            $query->where('user_id', '!=', $userId);
        }])
        ->orderBy('updated_at', 'desc')
        ->get()
        ->map(function ($conversation) use ($userId) {
            return $this->formatConversation($conversation, $userId);
        });

        return response()->json($conversations);
    }

    private function getInitials($name)
{
    if (!$name || !is_string($name)) {
        return '??';
    }
    
    $names = explode(' ', $name);
    $initials = '';
    
    if (count($names) >= 2) {
        $initials = strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
    } else {
        $initials = strtoupper(substr($name, 0, 2));
    }
    
    return $initials;
}

    public function createConversation(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:users,id|different:' . auth()->id()
        ]);

        // Check if conversation already exists
        $existingConversation = Conversation::whereHas('participants', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->whereHas('participants', function ($query) use ($request) {
            $query->where('user_id', $request->participant_id);
        })
        ->where('type', 'private')
        ->first();

        if ($existingConversation) {
            return response()->json($this->formatConversation($existingConversation, auth()->id()));
        }

        // Create new conversation
        $conversation = DB::transaction(function () use ($request) {
            $conversation = Conversation::create(['type' => 'private']);
            
            $conversation->participants()->attach([
                auth()->id() => ['joined_at' => now()],
                $request->participant_id => ['joined_at' => now()]
            ]);
            
            return $conversation;
        });

        return response()->json($this->formatConversation($conversation, auth()->id()));
    }

    public function getMessages(Request $request, Conversation $conversation)
    {
        // Verify user has access to this conversation
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $query = $conversation->messages()->with('user')->orderBy('created_at', 'asc');
        
        // Support polling for new messages
        if ($request->has('after')) {
            $query->where('id', '>', (int)$request->get('after'));
        }
        
        $messages = $query->get()->map(function ($message) {
            return [
                'id' => $message->id,
                'content' => $message->content,
                'type' => $message->type,
                'attachments' => $message->attachments,
                'user_id' => $message->user_id,
                'is_mine' => $message->user_id === auth()->id(),
                'formatted_time' => $message->created_at->format('H:i'),
                'read_at' => $message->read_at,
                'created_at' => $message->created_at,
            ];
        });

        return response()->json($messages);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        // Verify user has access to this conversation
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'content' => 'required|string|max:1000',
            'files.*' => 'file|max:10240|mimes:jpeg,png,gif,webp,pdf,doc,docx,txt'
        ]);

        $attachments = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('chat-attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                    'url' => Storage::url($path)
                ];
            }
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'type' => !empty($attachments) ? 'file' : 'text',
            'attachments' => !empty($attachments) ? $attachments : null,
        ]);

        // Update conversation timestamp
        $conversation->touch();

        // Format message for response
        $formattedMessage = [
            'id' => $message->id,
            'content' => $message->content,
            'type' => $message->type,
            'attachments' => $message->attachments,
            'user_id' => $message->user_id,
            'is_mine' => true,
            'formatted_time' => $message->created_at->format('H:i'),
            'read_at' => $message->read_at,
            'created_at' => $message->created_at,
        ];

        // Broadcast message to others
        try {
            // broadcast(new MessageSent([
            //     'message' => $formattedMessage,
            //     'conversation_id' => $conversation->id
            // ]))->toOthers();
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            \Log::error('Failed to broadcast message: ' . $e->getMessage());
        }

        return response()->json($formattedMessage);
    }

    public function markAsRead(Conversation $conversation)
    {
        // Verify user has access to this conversation
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update last read timestamp
        $conversation->participants()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now()
        ]);

        // Mark messages as read
        $conversation->messages()
                    ->where('user_id', '!=', auth()->id())
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function sendTyping(Request $request, Conversation $conversation)
    {
        // Verify user has access to this conversation
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            broadcast(new UserTyping([
                'user_id' => auth()->id(),
                'conversation_id' => $conversation->id
            ]))->toOthers();
        } catch (\Exception $e) {
            \Log::error('Failed to broadcast typing indicator: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    // Download attachment
    public function downloadAttachment(Request $request, $messageId, $attachmentIndex)
    {
        $message = Message::findOrFail($messageId);
        
        // Check if user has access to this message
        $conversation = $message->conversation;
        if (!$conversation->participants()->where('user_id', auth()->id())->exists() && 
            ($conversation->type === 'ticket' && !$this->hasAccessToTicket($conversation->ticket))) {
            abort(403, 'Unauthorized');
        }
        
        if (!$message->attachments || !isset($message->attachments[$attachmentIndex])) {
            abort(404, 'Attachment not found');
        }
        
        $attachment = $message->attachments[$attachmentIndex];
        $filePath = storage_path('app/public/' . $attachment['path']);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        
        return response()->download($filePath, $attachment['name']);
    }
}