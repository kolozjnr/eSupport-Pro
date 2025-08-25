<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;
    
    protected $fillable = ['type', 'title', 'ticket_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot('joined_at', 'last_read_at')
                    ->withTimestamps();
    }
    
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function scopeForTicket($query, $ticketId)
    {
        return $query->where('ticket_id', $ticketId);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function getOtherParticipant($currentUserId)
    {
        return $this->participants()->where('user_id', '!=', $currentUserId)->first();
    }

    public function getUnreadCount($userId)
    {
        $participant = $this->participants()->where('user_id', $userId)->first();
        $lastReadAt = $participant->pivot->last_read_at;
        
        return $this->messages()
                    ->where('user_id', '!=', $userId)
                    ->when($lastReadAt, function ($query) use ($lastReadAt) {
                        return $query->where('created_at', '>', $lastReadAt);
                    })
                    ->count();
    }
}
