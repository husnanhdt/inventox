@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Transaksi Masuk</h1>
    <a href="{{ route('stock-in.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Transaksi Masuk</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('stock-in.update', $stockIn->id_stock_in) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Barang (readonly + hidden input) -->
                    <div class="mb-3">
                        <label for="product_display" class="form-label">Barang</label>
                        <input type="text"
                            id="product_display"
                            class="form-control"
                            value="{{ $stockIn->details->first()->product->nama_barang }} (Stok: {{ $stockIn->details->first()->product->stok }})"
                            readonly>

                        <!-- Hidden input untuk kirim id_product -->
                        <input type="hidden" name="id_product" value="{{ $stockIn->details->first()->product->id_product }}">

                        <!-- Tampilkan Foto -->
                        <div class="mt-3 text-center">
                            @if($stockIn->details->first()->product?->foto)
                            <img src="{{ asset('storage/' . $stockIn->details->first()->product->foto) }}"
                                alt="Foto {{ $stockIn->details->first()->product->nama_barang }}"
                                width="100"
                                class="rounded">
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>

                    <!-- Jumlah Masuk -->
                    <div class="mb-3">
                        <label for="jumlah_masuk" class="form-label">Jumlah Masuk</label>
                        <input type="number"
                            name="jumlah_masuk"
                            id="jumlah_masuk"
                            class="form-control"
                            value="{{ old('jumlah_masuk', $stockIn->details->first()->jumlah_masuk) }}"
                            required
                            min="1">
                        @error('jumlah_masuk')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan"
                            id="keterangan"
                            class="form-control"
                            rows="3">{{ old('keterangan', $stockIn->keterangan) }}</textarea>
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