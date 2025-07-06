<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function identity()
    {
        return $this->hasMany(Identity::class);
    }
    public function performanceMetrics()
    {
        return $this->hasOne(SupportPerformanceMetric::class, 'support_id');
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'support_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'support_id')->where('status', 'assigned');
    }
}
