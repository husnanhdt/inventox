@extends('layouts.guest')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; height: 90vh; background-color: #f8f9fa; padding: 2rem; box-sizing: border-box;">
    <div class="card shadow-lg" style="width: 100%; max-width: 450px; border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.08); box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; min-height: 300px;">
        <h3 class="text-center mb-4" style="font-weight: 600;">InventOx</h3>

        @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email dengan label + ikon (opsional) -->
            <div class="mb-3 position-relative">
                <label for="email" class="form-label">Email</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="text" name="email" id="email" class="form-control ps-5" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <!-- Password dengan label, ikon kunci, dan ikon mata -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" class="form-control ps-5 pe-5" required>
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer;" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggle-icon"></i>
                    </span>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Masuk</button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <small>
                <a href="{{ route('password.request') }}">Lupa Password?</a>
            </small>
        </div>

        <div class="mt-2 text-center">
            <small>
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar di sini</a>
            </small>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggle-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection