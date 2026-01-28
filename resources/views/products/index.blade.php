@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Barang</h1>
    <a href="{{ route('products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Barang
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <!-- Form Pencarian Cepat -->
        <div class="row mb-4 justify-content-end">
            <div class="col-md-6">
                @if(request('q'))
                <!-- Mode Pencarian Aktif -->
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control mr-2"
                        placeholder="Cari barang..."
                        value="{{ request('q') }}"
                        disabled
                        style="padding: 0.5rem 0.75rem; font-size: 1rem;">
                    <button type="submit" class="btn btn-secondary btn-sm" title="Batal Pencarian">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
                @else
                <!-- Mode Normal -->
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control mr-2"
                        placeholder="Cari barang..."
                        value="{{ request('q') }}"
                        style="padding: 0.5rem 0.75rem; font-size: 1rem;">
                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                </form>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Foto</th> <!-- 🔹 Ditambahkan di sini -->
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Minimal Stok</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td style="width: 50px;" class="text-center">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>

                        <!-- 🔹 Kolom Foto -->
                        <td class="text-center align-middle" style="width: 80px;">
                            @if($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" alt="Foto {{ $product->nama_barang }}" width="100" class="rounded">
                            @else 
                            <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td style="width: 200px;">{{ $product->nama_barang }}</td>
                        <td style="width: 200px;">{{ $product->category->nama_category ?? '-' }}</td>
                        <td  style="width: 150px;" class="text-center">
                            <span class="{{ $product->stok == 0 ? 'text-danger' : ($product->stok <= $product->minimal_stok ? 'text-warning' : '') }}">
                                {{ $product->stok }}
                            </span>
                        </td>
                        <td style="width: 150px;" class="text-center">{{ $product->minimal_stok }}</td>
                        <td style="width: 150px;" class="text-center">{{ $product->satuan }}</td>
                        <td style="width: 130px;">
                            <!-- Preview -->
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Hapus barang ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr> <!-- 🔹 Ubah colspan jadi 8 -->
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                    </span>
                </div>
                <div>
                    @if ($products->hasPages())
                    <a href="{{ $products->previousPageUrl() }}"
                        class="btn btn-outline-primary me-2 {{ $products->onFirstPage() ? 'disabled' : '' }}">
                        Previous
                    </a>
                    <a href="{{ $products->nextPageUrl() }}"
                        class="btn btn-outline-primary {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                        Next
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection