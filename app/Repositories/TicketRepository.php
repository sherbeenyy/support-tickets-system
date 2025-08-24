<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketRepository
{
    // Get all tickets for current user 
    public function getEngineerTickets()
    {
        return Ticket::where('user_id', Auth::id())
                     ->where('status', '!=', 'closed')
                     ->orderBy('created_at', 'desc')
                     ->get();
    }

    // Create a new ticket
    public function createTicket(array $data)
    {
        return Ticket::create($data);
    }

    // Update a ticket
    public function updateTicket(Ticket $ticket, array $data)
    {
        return $ticket->update($data);
    }

    // Delete a ticket
    public function deleteTicket(Ticket $ticket)
    {
        return $ticket->delete();
    }
}
