<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Http\Requests\TicketRequest; // We'll create this request for validation
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // View all tickets of current engineer (status != closed)
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
                         ->where('status', '!=', 'closed')
                         ->orderBy('created_at', 'desc')
                         ->get();

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
         $data['status'] = 'opened'; 

        Ticket::create($data);

        return redirect()->route('engineer.dashboard')->with('success', 'Ticket created successfully');
    }

    // Show edit form
    public function edit(Ticket $ticket)
    {
        // ensure ticket belongs to current engineer
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

        $ticket->update($request->validated());

        return redirect()->route('engineer.dashboard')->with('success', 'Ticket updated successfully');
    }

    // Delete ticket
    public function destroy(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            return redirect()->route('engineer.dashboard')->with('error', 'Unauthorized access');
        }

        $ticket->delete();

        return redirect()->route('engineer.dashboard')->with('success', 'Ticket deleted successfully');
    }
}
