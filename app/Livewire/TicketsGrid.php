<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;

class TicketsGrid extends Component
{
public function delete(int $ticketId): void
{
    $ticket = Ticket::findOrFail($ticketId);
    $ticket->delete();

    $this->dispatch('ticket-deleted');
}
    public function render()
    {
        $tickets = Ticket::latest()->get();
        return view('livewire.tickets-grid', compact('tickets'));
    }
}
