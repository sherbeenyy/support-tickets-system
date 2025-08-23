@extends('layouts.engineer')

@section('title', 'My Tickets')

@section('content')
<h2 class="mb-4">Hello, {{ auth()->user()->name }}! Your Tickets</h2>

<a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create New Ticket</a>

<div class="row g-3">
    @forelse($tickets as $ticket)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket->title }}</h5>
                    <p class="card-text">{{ $ticket->description }}</p>
                    <p class="mb-1"><strong>Priority:</strong> {{ ucfirst($ticket->priority->value) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($ticket->status->value) }}</p>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('engineer.tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('engineer.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No open tickets found.</p>
    @endforelse
</div>
@endsection
