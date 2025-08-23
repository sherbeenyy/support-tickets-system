@extends('layouts.engineer')

@section('title', 'Edit Ticket')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4">Edit Ticket</h3>

            <!-- Toasts for error/success -->
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $ticket->title) }}">
                    @error('title') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $ticket->description) }}</textarea>
                    @error('description') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="low" {{ $ticket->priority->value === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $ticket->priority->value === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $ticket->priority->value === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Update Ticket</button>
                    <a href="{{ route('engineer.dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
