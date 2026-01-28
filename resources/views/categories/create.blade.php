@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Kategori</h1>
    <a href="{{ route('categories.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kategori</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_category" class="form-label">Nama Kategori</label>
                        <input type="text"
                            name="nama_category"
                            id="nama_category"
                            class="form-control"
                            value="{{ old('nama_category') }}"
                            required
                            autofocus>
                        @error('nama_category')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection