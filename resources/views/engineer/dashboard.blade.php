@extends('layouts.engineer')

@section('title', 'My Tickets')

@section('content')
    <h2 class="mb-4">Hello, {{ auth()->user()->name }}! Your Tickets</h2>

    {{-- Global Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create New Ticket</a>

    <div class="row g-3">
        @forelse($tickets as $ticket)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-lg h-100 rounded-4">
                    <div class="card-body d-flex flex-column">
                        <!-- Title -->
                        <h5 class="card-title fw-bold text-primary mb-2">
                            <i class="bi bi-ticket-perforated"></i> {{ $ticket->title }}
                        </h5>

                        <!-- Description -->
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit($ticket->description, 120, '...') }}
                        </p>

                        <!-- Priority & Status -->
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

                        <!-- Created at -->
                        <p class="text-muted small mb-3">
                            <i class="bi bi-clock-history"></i> 
                            {{ $ticket->created_at->timezone('Africa/Cairo')->format('M d, Y h:i A') }}
                        </p>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between mt-auto">
                            <a href="{{ route('tickets.edit', $ticket->id) }}" 
                               class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>

                        <!-- Comments -->
                        <div class="mt-3">
                            <!-- View Comments -->
                            <a href="{{ route('comments.index', $ticket->id) }}" 
                               class="btn btn-sm btn-outline-secondary rounded-pill px-3 mb-2">
                                <i class="bi bi-chat-dots"></i> View Comments
                            </a>

                            <!-- Add Comment Form -->
                            <form action="{{ route('comments.store', $ticket->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                <div class="input-group input-group-sm">
                                    <input type="text" name="content" 
                                           class="form-control rounded-pill" 
                                           placeholder="Write a comment..." required>
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill ms-2">
                                        Post 
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No tickets available.</p>
        @endforelse
    </div>
@endsection
