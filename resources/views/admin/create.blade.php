@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="fw-bold page-title">Create New User</h1>
        <p class="text-muted">Fill in the details below to add a new team member.</p>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary shadow mt-2">Back to Users</a>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card form-card p-4 shadow-sm">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select">
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="tech_lead">Tech Lead</option>
                            <option value="engineer">Engineer</option>
                        </select>
                        @error('role') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary btn-form">Create User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-form">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Page background */
body {
    background-color: #f0f4f8;
    font-family: 'Inter', sans-serif;
}

/* Hero Section */
.page-title {
    font-size: 2.2rem;
    color: #1e293b;
}
.text-muted {
    color: #475569 !important;
}

/* Form card */
.form-card {
    background-color: #ffffff;
    border-radius: 20px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.form-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

/* Buttons */
.btn-form {
    padding: 0.5rem 1.2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-primary.btn-form {
    background-color: #4f46e5;
    color: white;
}
.btn-primary.btn-form:hover {
    background-color: #3730a3;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(79,70,229,0.3);
}

.btn-secondary.btn-form {
    background-color: #14b8a6;
    color: white;
}
.btn-secondary.btn-form:hover {
    background-color: #0f766e;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(20,184,166,0.3);
}

/* Form labels */
.form-label {
    color: #1e293b;
}
</style>
@endsection
