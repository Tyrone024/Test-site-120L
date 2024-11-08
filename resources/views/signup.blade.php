@extends('layouts.form')

@section('title', 'Sign Up')

@section('content')
    <form action="{{ route('signup') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Username</label>
            <input type="text" name="name" id="name" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
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
        <button type="submit" class="btn btn-dark w-100 mb-2">Sign Up</button>
        <a href="{{ route('login') }}" class="btn btn-secondary w-100 mb-2">Back to Login</a>
    </form>
@endsection
