<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $table = 'ticket_attachments';
    protected $guarded = [];

    public function tickets()
    {
        return $this->belongsTo(Ticket::class);
    }
}
