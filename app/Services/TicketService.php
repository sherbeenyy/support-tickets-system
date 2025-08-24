<?php
// app/Services/TicketService.php
namespace App\Services;

use App\DTOs\Ticket\CreateTicketDTO;
use App\DTOs\Ticket\UpdateTicketDTO;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;
use Exception;

class TicketService
{
    public function __construct(
        protected TicketRepository $tickets
    ) {}

    public function getEngineerTickets(int $userId)
    {
        return $this->tickets->findByUser($userId);
    }

    public function createTicket(CreateTicketDTO $dto): Ticket
    {
        return $this->tickets->create($dto->toArray());
    }

    public function updateTicket(Ticket $ticket, UpdateTicketDTO $dto): Ticket
    {
        if ($ticket->user_id !== Auth::id()) {
            throw new Exception("Unauthorized to update this ticket");
        }

        return $this->tickets->update($ticket, $dto->toArray());
    }

    public function deleteTicket(Ticket $ticket): void
    {
        if ($ticket->user_id !== Auth::id()) {
            throw new Exception("Unauthorized to delete this ticket");
        }

        $this->tickets->delete($ticket);
    }
}
