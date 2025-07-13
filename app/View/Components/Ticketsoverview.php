<?php
namespace App\View\Components;

use Illuminate\View\Component;

class TicketOverview extends Component
{
    public $recentTickets;

    public function __construct($recentTickets)
    {
        $this->recentTickets = $recentTickets;
    }

    public function render()
    {
        return view('components.Ticket-overview');
    }
}
