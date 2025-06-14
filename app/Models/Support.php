<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $quarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'support_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'support_id')->where('status', 'assign');
    }
}
