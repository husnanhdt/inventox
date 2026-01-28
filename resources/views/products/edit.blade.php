@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Barang</h1>
    <a href="{{ route('products.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Barang</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="id_category" class="form-label">Kategori</label>
                        <select name="id_category" id="id_category" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id_category }}" {{ $product->id_category == $cat->id_category ? 'selected' : '' }}>
                                {{ $cat->nama_category }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_category')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Barang -->
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text"
                            name="nama_barang"
                            id="nama_barang"
                            class="form-control"
                            value="{{ old('nama_barang', $product->nama_barang) }}"
                            required
                            placeholder="Masukkan nama barang">
                        @error('nama_barang')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Minimal Stok -->
                    <div class="mb-3">
                        <label for="minimal_stok" class="form-label">Minimal Stok</label>
                        <input type="number"
                            name="minimal_stok"
                            id="minimal_stok"
                            class="form-control"
                            value="{{ old('minimal_stok', $product->minimal_stok) }}"
                            required
                            min="0">
                        @error('minimal_stok')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text"
                            name="satuan"
                            id="satuan"
                            class="form-control"
                            value="{{ old('satuan', $product->satuan) }}"
                            required>
                        @error('satuan')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto Barang -->
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Barang</label>
                        @if($product->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->foto) }}" alt="Foto {{ $product->nama_barang }}" width="100" class="rounded">
                        </div>
                        @endif
                        <input type="file"
                            name="foto"
                            id="foto"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/gif">
                        @error('foto')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">JPEG/PNG/JPG - Biarkan kosong jika tidak ingin mengganti foto</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection