@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Barang Keluar</h1>
    <a href="{{ route('stock-out.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Transaksi Keluar</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('stock-out.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Barang -->
                    <div class="mb-3">
                        <label for="id_product" class="form-label">Barang</label>
                        <select name="id_product" id="id_product" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($products as $p)
                            @if($p->stok > 0)
                            <option value="{{ $p->id_product }}">
                                {{ $p->nama_barang }} (Stok: {{ $p->stok }})
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('id_product')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto Barang -->
                    <div class="mb-3">
                        <label for="foto" class="form-label">Upload Foto Barang (Opsional)</label>
                        <input type="file"
                            name="foto"
                            id="foto"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/gif">
                        @error('foto')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">JPEG/PNG/JPG/GIF (Max 2MB)</small>
                    </div>

                    <!-- Jumlah Keluar -->
                    <div class="mb-3">
                        <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                        <input type="number"
                            name="jumlah_keluar"
                            id="jumlah_keluar"
                            class="form-control"
                            value="{{ old('jumlah_keluar') }}"
                            required
                            min="1">
                        @error('jumlah_keluar')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan"
                            id="keterangan"
                            class="form-control"
                            rows="3">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection