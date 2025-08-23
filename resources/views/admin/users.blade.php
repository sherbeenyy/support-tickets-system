@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="container py-5">

    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="fw-bold page-title">Manage Users</h1>
        <p class="text-muted">View, create, edit, or delete users. Keep your team organized!</p>
        <a href="{{ route('admin.users.create') }}" class="btn btn-create shadow">+ Add New User</a>
    </div>

    <!-- Users Grid -->
    <div class="row g-4">
        @foreach($users as $user)
        <div class="col-md-4">
            <div class="user-card p-4">
                <div class="user-header d-flex align-items-center mb-3">
                    <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $user->name }}</h5>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="role-badge">{{ ucfirst($user->role->value) }}</div>
                <div class="user-actions mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
/* Page background */
body {
    background-color: #f0f4f8;
    font-family: 'Inter', sans-serif;
}

/* Page title */
.page-title {
    font-size: 2.5rem;
    color: #1e293b;
}

/* Create button */
.btn-create {
    background-color: #4f46e5;
    color: white;
    border-radius: 12px;
    padding: 0.6rem 1.2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-create:hover {
    background-color: #3730a3;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(79,70,229,0.3);
}

/* User card */
.user-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}
.user-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

/* Avatar */
.avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #4f46e5;
    color: white;
    font-weight: 700;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Role badge */
.role-badge {
    display: inline-block;
    background-color: #14b8a6;
    color: white;
    font-weight: 500;
    font-size: 0.85rem;
    padding: 0.3rem 0.8rem;
    border-radius: 10px;
}

/* Buttons */
.btn-edit {
    background-color: #0ea5e9;
    color: white;
    border-radius: 10px;
    padding: 0.4rem 1rem;
    transition: all 0.3s ease;
}
.btn-edit:hover {
    background-color: #0369a1;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(14,165,233,0.3);
}

.btn-delete {
    background-color: #ef4444;
    color: white;
    border-radius: 10px;
    padding: 0.4rem 1rem;
    transition: all 0.3s ease;
}
.btn-delete:hover {
    background-color: #b91c1c;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(239,68,68,0.3);
}

/* Typography */
h5 {
    color: #1e293b;
}
p {
    font-size: 0.9rem;
    color: #475569;
}
</style>
@endsection
