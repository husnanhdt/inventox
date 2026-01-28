@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Barang</h1>
    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left fa-sm"></i> Kembali
    </a>
</div>

<div class="row d-flex h-100"> <!-- 🔹 Tambahkan d-flex & h-100 -->
    <!-- Informasi Utama -->
    <div class="col-lg-8">
        <div class="card shadow mb-4 h-100"> <!-- 🔹 Tambahkan h-100 -->
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Barang</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <td width="35%" class="font-weight-bold">Nama Barang</td>
                            <td>{{ $product->nama_barang }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Kategori</td>
                            <td>{{ $product->category->nama_category ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Stok</td>
                            <td>
                                <span class="{{ $product->stok == 0 ? 'text-danger' : ($product->stok <= $product->minimal_stok ? 'text-warning font-weight-bold' : '') }}">
                                    {{ $product->stok }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Minimal Stok</td>
                            <td>{{ $product->minimal_stok }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Satuan</td>
                            <td>{{ $product->satuan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Foto Barang -->
    <div class="col-lg-4">
        <div class="card shadow mb-4 h-100"> <!-- 🔹 Tambahkan h-100 -->
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foto Barang</h6>
            </div>
            <div class="card-body text-center">
                @if($product->foto)
                <img src="{{ asset('storage/' . $product->foto) }}"
                    alt="Foto {{ $product->nama_barang }}"
                    class="img-fluid rounded"
                    style="max-height: 300px; object-fit: contain;">
                @else
                <span class="text-muted">Tidak ada foto</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection