@extends('layouts.engineer')

@section('title', 'Create Ticket')

@section('content')
<h2>Create Ticket</h2>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('tickets.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        @error('title') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        @error('description') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-select">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
        @error('priority') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-success">Create Ticket</button>
    <a href="{{ route('engineer.dashboard') }}" class="btn btn-secondary">Cancel</a>
</form>


@endsection
