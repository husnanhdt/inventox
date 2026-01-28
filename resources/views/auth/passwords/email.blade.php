@extends('layouts.guest')

@section('content')
<div class="card p-4 shadow">
    <h3 class="text-center mb-4">Lupa Password?</h3>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" id="email" class="form-control ps-5" required autofocus>
            </div>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
        </div>
    </form>

    <div class="mt-3 text-center">
        <small><a href="{{ route('login') }}">Kembali ke Login</a></small>
    </div>
</div>
@endsection