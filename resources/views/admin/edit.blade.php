@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body">
                <h3 class="text-center mb-4">Edit User</h3>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select name="role" class="form-control">
                            <option value="admin" {{ $user->role->value === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ $user->role->value === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="tech_lead" {{ $user->role->value === 'tech_lead' ? 'selected' : '' }}>Tech Lead</option>
                            <option value="engineer" {{ $user->role->value === 'engineer' ? 'selected' : '' }}>Engineer</option>
                        </select>
                        @error('role')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password">Password <small class="text-muted">(Leave blank to keep current)</small></label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100 mt-2">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
