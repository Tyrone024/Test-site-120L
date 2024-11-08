@extends('layouts.form')

@section('title', 'Login')

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <button type="submit" class="btn btn-dark w-100 mb-2">Sign In</button>
        <a href="{{ route('signup') }}" class="btn btn-secondary w-100 mb-2">Create New Account</a>
        <div class="text-center">
            <a href="/forgot-password">Forgot password?</a>
        </div>
    </form>
@endsection
