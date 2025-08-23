@extends('layouts.engineer')

@section('title', 'Edit Comment')

@section('content')
<h3>Edit Comment</h3>

<form action="{{ route('comments.update', $comment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <textarea name="body" class="form-control" rows="3" required>{{ old('content', $comment->content) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Comment</button>
    <a href="{{ route('comments.index', $comment->ticket_id) }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
