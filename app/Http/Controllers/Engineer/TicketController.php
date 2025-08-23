<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;
use App\Enums\TicketStatusEnum;

class TicketController extends Controller
{
    protected $tickets;

    public function __construct(TicketRepository $tickets)
    {
        $this->tickets = $tickets;
    }

    // View all tickets of current engineer
    public function index()
    {
        $tickets = $this->tickets->getEngineerTickets();
        return view('engineer.dashboard', compact('tickets'));
    }

    // Show create form
    public function create()
    {
        return view('engineer.create');
    }

    // Store new ticket
    public function store(TicketRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = "open";
        $this->tickets->createTicket($data);

        return redirect()->route('engineer.dashboard')->with('success', 'Ticket created successfully');
    }

    // Show edit form
    public function edit(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            return redirect()->route('engineer.dashboard')->with('error', 'Unauthorized access');
        }

        return view('engineer.edit', compact('ticket'));
    }

    // Update ticket
    public function update(TicketRequest $request, Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            return redirect()->route('engineer.dashboard')->with('error', 'Unauthorized access');
        }

        $this->tickets->updateTicket($ticket, $request->validated());

        return redirect()->route('engineer.dashboard')->with('success', 'Ticket updated successfully');
    }

    // Delete ticket
    public function destroy(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            return redirect()->route('engineer.dashboard')->with('error', 'Unauthorized access');
        }

        $this->tickets->deleteTicket($ticket);

        return redirect()->route('engineer.dashboard')->with('success', 'Ticket deleted successfully');
    }
}
