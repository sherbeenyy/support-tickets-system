@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <!-- Welcome Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="lead text-muted">Manage your users and support tickets easily from this dashboard.</p>
    </div>

    <!-- Quick Links Section -->
    <div class="row g-4 justify-content-center">

        <!-- Users Card -->
        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card shadow-lg border-0 rounded-4 p-4 text-center h-100 hover-scale">
                    <div class="card-body">
                        <h3 class="card-title mb-3 text-primary">Users</h3>
                        <p class="card-text text-muted">View, create, edit, or delete users easily.</p>
                        <span class="btn btn-outline-primary mt-3">Go to Users</span>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<!-- Extra Styling -->
<style>
    .hover-scale {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .hover-scale:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    body {
        background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
        background-color: #ffffff;
    }
</style>
@endsection
