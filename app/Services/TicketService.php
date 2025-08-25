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
        // $dto->validate();
        return $this->tickets->create($dto->toArray());
    }

    public function updateTicket(Ticket $ticket, UpdateTicketDTO $dto): Ticket
    {

        return $this->tickets->update($ticket, $dto->toArray());
    }

    public function deleteTicket(Ticket $ticket): void
    {
        $this->tickets->delete($ticket);
    }
}
