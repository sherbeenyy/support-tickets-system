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
    
    <livewire:tickets-grid />

@endsection
