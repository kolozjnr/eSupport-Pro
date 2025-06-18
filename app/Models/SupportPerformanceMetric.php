<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportPerformanceMetric extends Model
{
    protected $guarded = [];

     public function support()
    {
        return $this->belongsTo(Support::class, 'support_id');
    }

    // Relationship to resolved tickets (if you want to track which tickets contributed)
    public function resolvedTickets()
    {
        return $this->hasMany(Ticket::class, 'support_id', 'support_id')
            ->where('status', 'completed');
    }
}
