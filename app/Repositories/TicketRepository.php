<?php
// app/Repositories/TicketRepository.php
namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function update(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);
        return $ticket;
    }

    public function delete(Ticket $ticket): void
    {
        $ticket->delete();
    }

    public function findById(int $id): ?Ticket
    {
        return Ticket::find($id);
    }

    public function findByUser(int $userId)
    {
        return Ticket::where('user_id', $userId)->get();
    }
}
