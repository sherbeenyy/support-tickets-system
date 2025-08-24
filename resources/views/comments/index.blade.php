@extends('layouts.engineer')

@section('title', 'Comments on ' . $ticket->title)

@section('content')
<h3 class="mb-3">Comments for Ticket: <span class="text-primary">{{ $ticket->title }}</span></h3>

<a href="{{ route('engineer.dashboard') }}" class="btn btn-outline-secondary mb-3">← Back to Tickets</a>

<div class="list-group">
    @forelse($comments as $comment)
        <div class="list-group-item d-flex justify-content-between align-items-start rounded-3 shadow-sm mb-2">
            <div>
                <strong>{{ $comment->user->name }}</strong> 
                <span class="text-muted small">({{ $comment->created_at->timezone('Africa/Cairo')->format('M d, Y h:i A') }})</span>
                <p class="mb-1">{{ $comment->content }}</p>
            </div>
        </div>
    @empty
        <p class="text-muted">No comments yet. Be the first to comment!</p>
    @endforelse
</div>
@endsection
