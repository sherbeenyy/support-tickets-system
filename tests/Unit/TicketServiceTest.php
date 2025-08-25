<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TicketService;
use App\DTOs\Ticket\CreateTicketDTO;
use App\DTOs\Ticket\UpdateTicketDTO;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TicketServiceTest extends TestCase
{
    use RefreshDatabase;

    private TicketService $service;
    private User $engineer;
    private TicketRepository $ticketRepo;
    private UserRepository $userRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ticketRepo = $this->app->make(TicketRepository::class);
        $this->userRepo = $this->app->make(UserRepository::class);
        $this->service = $this->app->make(TicketService::class);

        // create engineer manually using repository
        $this->engineer = $this->userRepo->create([
            'name' => 'Engineer Test',
            'email' => 'engineer@test.com',
            'password' => Hash::make('secret123'),
            'role' => 'engineer',
        ]);
    }

    /** @test */
    public function it_creates_a_ticket_successfully()
    {
        $dto = new CreateTicketDTO(
            user_id: $this->engineer->id,
            title: null,
            description: 'This is a test ticket',
            priority: 'high'
        );

        $ticket = $this->service->createTicket($dto);

        $this->assertDatabaseHas('tickets', [
            'title' => 'Test Ticket',
            'user_id' => $this->engineer->id,
        ]);

        $this->assertEquals('Test Ticket', $ticket->title);
    }

    /** @test */
    public function it_updates_a_ticket_successfully()
    {

        // create ticket manually via repo
        $ticket = $this->ticketRepo->create([
            'user_id' => $this->engineer->id,
            'title' => 'Old Title',
            'description' => 'Old description',
            'priority' => 'low',
        ]);

        $dto = new UpdateTicketDTO(
            title: 'New Title',
            description: 'Updated description',
            priority: 'high'
        );

        $updatedTicket = $this->service->updateTicket($ticket, $dto);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'New Title',
            'priority' => 'high',
        ]);

        $this->assertEquals('New Title', $updatedTicket->title);
    }

    /** @test */
    public function it_deletes_a_ticket_successfully()
    {
        $ticket = $this->ticketRepo->create([
            'user_id' => $this->engineer->id,
            'title' => 'To Delete',
            'description' => 'To Delete',
            'priority' => 'low',
        ]);

        $this->service->deleteTicket($ticket);

        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);
    }
}
