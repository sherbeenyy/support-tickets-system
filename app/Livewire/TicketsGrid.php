<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TicketService;
use App\DTOs\Ticket\UpdateTicketDTO;
use App\Repositories\TicketRepository;
use Illuminate\Database\Eloquent\Collection;

class TicketsGrid extends Component
{
    public Collection $tickets;
    private TicketService $ticketService;

    public function __construct()
    {
        $this->ticketService = new TicketService(new TicketRepository);
    }

    public function mount(): void
    {
        $this->loadTickets();
    }

    public function loadTickets(): void
    {
        $this->tickets = $this->ticketService->getEngineerTickets(auth("web")->id());
    }

    public function delete(int $ticketId): void
    {
        $ticket = $this->tickets->firstWhere('id', $ticketId);

        if ($ticket) {
            $this->ticketService->deleteTicket($ticket);
            $this->dispatch('ticket-deleted');
            $this->loadTickets();
        }
    }

    public function update(int $ticketId, array $data): void
    {
        $ticket = $this->tickets->firstWhere('id', $ticketId);

        if ($ticket) {
            $dto = new UpdateTicketDTO(
                $data['title'],
                $data['description'],
                $data['priority']
            );
            $this->ticketService->updateTicket($ticket, $dto);
            $this->loadTickets();
        }
    }

    public function render()
    {
        return view('livewire.tickets-grid', [
            'tickets' => $this->tickets,
        ]);
    }
}