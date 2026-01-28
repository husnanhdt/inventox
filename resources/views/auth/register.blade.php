@extends('layouts.guest')

@section('content')
<div class="card p-4 shadow">
    <h3 class="text-center mb-4">Daftar Akun</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <div class="position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control ps-5" value="{{ old('nama_lengkap') }}" required autofocus>
            </div>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" id="email" class="form-control ps-5" value="{{ old('email') }}" required>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" id="password" class="form-control ps-5 pe-5" required minlength="8">
                <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer;" onclick="togglePassword('password', 'toggle-icon-password')">
                    <i class="fas fa-eye" id="toggle-icon-password"></i>
                </span>
            </div>
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control ps-5 pe-5" required minlength="8">
                <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer;" onclick="togglePassword('password_confirmation', 'toggle-icon-confirm')">
                    <i class="fas fa-eye" id="toggle-icon-confirm"></i>
                </span>
            </div>
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <div class="position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                    <i class="fas fa-users"></i>
                </span>
                <select name="role" id="role" class="form-control ps-5" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="Staff Gudang" {{ old('role') == 'Staff Gudang' ? 'selected' : '' }}>Staff Gudang</option>
                    <option value="Admin Toko" {{ old('role') == 'Admin Toko' ? 'selected' : '' }}>Admin Toko</option>
                </select>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
    </form>

    <div class="mt-3 text-center">
        <small>
            Sudah punya akun? 
            <a href="{{ route('login') }}">Login di sini</a>
        </small>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection