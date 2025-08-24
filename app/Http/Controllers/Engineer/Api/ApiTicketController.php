<?php
// app/Http/Controllers/API/ApiTicketController.php
namespace App\Http\Controllers\Engineer\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Services\TicketService;
use App\DTOs\Ticket\CreateTicketDTO;
use App\DTOs\Ticket\UpdateTicketDTO;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


class ApiTicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $tickets)
    {
        $this->ticketService = $tickets;
    }

    public function index(): JsonResponse
    {
        $tickets = $this->ticketService->getEngineerTickets(Auth::id());
        return response()->json($tickets);
    }

// ApiTicketController.php
public function store(TicketRequest $request): JsonResponse
{
    $dto = CreateTicketDTO::fromRequest($request, auth('api')->id());
    $ticket = $this->ticketService->createTicket($dto);

    return response()->json([
        'message' => 'Ticket created successfully',
        'ticket' => $ticket
    ], 201);
}

public function update(TicketRequest $request, $id): JsonResponse
{
    $ticket = Ticket::find($id);

    if (!$ticket) {
        return response()->json(['message' => 'Ticket not found'], 404);
    }

    $dto = UpdateTicketDTO::fromRequest($request);

    try {
        $updated = $this->ticketService->updateTicket($ticket, $dto);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 403);
    }

    return response()->json([
        'message' => 'Ticket updated successfully',
        'ticket' => $updated
    ]);
}

    public function show($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'message' => 'Ticket not found'
            ], 404);
        }

        return response()->json($ticket);
    }



public function destroy($id): JsonResponse
{
    $ticket = Ticket::find($id);

    if (!$ticket) {
        return response()->json([
            'message' => 'Ticket not found'
        ], 404);
    }

    try {
        $this->ticketService->deleteTicket($ticket);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 403);
    }

    return response()->json(['message' => 'Ticket deleted successfully']);
}

}
