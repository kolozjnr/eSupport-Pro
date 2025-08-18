<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function support()
    {
        return $this->belongsTo(Support::class);
    }

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function review()
    {
        return $this->hasMany(Rating::class);
    }

    public function attached()
    {
        return $this->hasMany(TicketAttachment::class);
    }
    

    protected $casts = [
    'assigned_at' => 'datetime',
    'first_response_at' => 'datetime',
    'resolved_at' => 'datetime'
];
    // protected $casts = [
    // 'phone_numbers' => 'array',
    // ];
}
