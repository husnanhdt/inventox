@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kategori</h1>
    <a href="{{ route('categories.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kategori
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<!-- Statistik Ringkas -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">TOTAL KATEGORI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categories->total() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">TOTAL STOK BARANG</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ \App\Models\Product::sum('stok') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Pencarian Cepat -->
<div class="row mb-4 justify-content-end">
    <div class="col-md-6">
        @if(request('q'))
        <!-- Mode Pencarian Aktif -->
        <form action="{{ route('categories.index') }}" method="GET" class="d-flex">
            <input type="text" name="q" class="form-control mr-2"
                placeholder="Cari kategori..."
                value="{{ request('q') }}"
                disabled
                style="padding: 0.5rem 0.75rem; font-size: 1rem;">
            <button type="submit" class="btn btn-secondary btn-sm" title="Batal Pencarian">
                <i class="fas fa-times"></i>
            </button>
        </form>
        @else
        <!-- Mode Normal -->
        <form action="{{ route('categories.index') }}" method="GET" class="d-flex">
            <input type="text" name="q" class="form-control mr-2"
                placeholder="Cari kategori..."
                value="{{ request('q') }}"
                style="padding: 0.5rem 0.75rem; font-size: 1rem;">
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
        </form>
        @endif
    </div>
</div>

<!-- Tabel Kategori -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-center" style="width: 30px;">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td>{{ $category->nama_category }}</td>
                        <td class="text-center">{{ $category->products_count }} barang</td>
                        <td class="text-center">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Hapus kategori ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div>
                <span class="text-muted small">
                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
                </span>
            </div>
            <div>
                @if ($categories->hasPages())
                <a href="{{ $categories->previousPageUrl() }}"
                    class="btn btn-outline-primary me-2 {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                    Previous
                </a>
                <a href="{{ $categories->nextPageUrl() }}"
                    class="btn btn-outline-primary {{ !$categories->hasMorePages() ? 'disabled' : '' }}">
                    Next
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection