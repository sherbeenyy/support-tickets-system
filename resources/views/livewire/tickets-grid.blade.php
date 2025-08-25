<div class="row g-3">
    @forelse($tickets as $ticket)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-lg h-100 rounded-4">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-primary mb-2">
                        <i class="bi bi-ticket-perforated"></i> {{ $ticket->title }}
                    </h5>

                    <p class="card-text text-muted flex-grow-1">
                        {{ \Illuminate\Support\Str::limit($ticket->description, 120, '...') }}
                    </p>

                    <div class="mb-2">
                        <span class="badge rounded-pill 
                            @if($ticket->priority->value === 'high') bg-danger 
                            @elseif($ticket->priority->value === 'medium') bg-warning text-dark 
                            @else bg-success 
                            @endif">
                            {{ ucfirst($ticket->priority->value) }}
                        </span>

                        <span class="badge rounded-pill 
                            @if($ticket->status->value === 'open') bg-info text-dark
                            @elseif($ticket->status->value === 'in_progress') bg-warning text-dark
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($ticket->status->value) }}
                        </span>
                    </div>

                    <p class="text-muted small mb-3">
                        <i class="bi bi-clock-history"></i>
                        {{ $ticket->created_at->timezone('Africa/Cairo')->format('M d, Y h:i A') }}
                    </p>

                    <div class="d-flex justify-content-between mt-auto">
                        <a href="{{ route('tickets.edit', $ticket->id) }}" 
                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <button wire:click="delete({{ $ticket->id }})"
                                class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">No tickets available.</p>
    @endforelse
</div>

<script>
    window.addEventListener('ticket-deleted', () => {
        alert('The ticket has been successfully deleted!');
    });
</script>
