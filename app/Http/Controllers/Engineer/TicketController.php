<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Services\TicketService;
use App\DTOs\Ticket\CreateTicketDTO;
use App\DTOs\Ticket\UpdateTicketDTO;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    protected TicketService $tickets;

    public function __construct(TicketService $tickets)
    {
        $this->tickets = $tickets;
    }

    public function index()
    {
        $tickets = $this->tickets->getEngineerTickets(Auth::id());
        return view('engineer.dashboard', compact('tickets'));
    }

    public function create()
    {
        return view('engineer.create');
    }


public function store(TicketRequest $request)
{
    $dto = CreateTicketDTO::fromRequest($request, Auth::id());
    $this->tickets->createTicket($dto);

    return redirect()->route('engineer.dashboard')
        ->with('success', 'Ticket created successfully');
}

public function update(TicketRequest $request, Ticket $ticket)
{
    $dto = UpdateTicketDTO::fromRequest($request);

    try {
        $this->tickets->updateTicket($ticket, $dto);
    } catch (\Exception $e) {
        return redirect()->route('engineer.dashboard')->with('error', $e->getMessage());
    }

    return redirect()->route('engineer.dashboard')->with('success', 'Ticket updated successfully');
}


public function edit(Ticket $ticket)
    {
        // Ownership is checked in Service
        return view('engineer.edit', compact('ticket'));
    }



public function destroy(Ticket $ticket)
    {
        try {
            $this->tickets->deleteTicket($ticket);
        } catch (\Exception $e) {
            return redirect()->route('engineer.dashboard')->with('error', $e->getMessage());
        }

        return redirect()->route('engineer.dashboard')->with('success', 'Ticket deleted successfully');
    }
}
