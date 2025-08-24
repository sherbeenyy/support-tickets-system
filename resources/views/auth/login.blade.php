@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-body">
                <h3 class="text-center mb-4">Login</h3>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf 
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

            </div>
        </div>
    </div>
</div>
@endsection
