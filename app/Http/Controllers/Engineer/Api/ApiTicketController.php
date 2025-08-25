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
use App\Http\Resources\TicketResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;



class ApiTicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $tickets)
    {
        $this->ticketService = $tickets;
    }

public function index(): AnonymousResourceCollection
{
    $tickets = $this->ticketService->getEngineerTickets(Auth::id());
    return TicketResource::collection($tickets);
}

public function store(TicketRequest $request): JsonResponse
{
    $dto = CreateTicketDTO::fromRequest($request, auth('api')->id());
    $ticket = $this->ticketService->createTicket($dto);

    return response()->json([
        'message' => 'Ticket created successfully',
        'ticket' => new TicketResource($ticket)
    ], 201);
}

public function show($id): JsonResponse
{
    $ticket = Ticket::find($id);

    if (!$ticket) {
        return response()->json(['message' => 'Ticket not found'], 404);
    }

    return response()->json(new TicketResource($ticket));
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
        'ticket' => new TicketResource($updated)
    ]);
}

public function destroy($id): JsonResponse
{
    $ticket = Ticket::find($id);

    if (!$ticket) {
        return response()->json(['message' => 'Ticket not found'], 404);
    }

    try {
        $this->ticketService->deleteTicket($ticket);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 403);
    }

    return response()->json(['message' => 'Ticket deleted successfully']);
}

}
