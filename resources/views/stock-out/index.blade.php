@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Barang Keluar</h1>
    <a href="{{ route('stock-out.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Transaksi
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <!-- Form Pencarian Cepat -->
        <div class="row mb-4 justify-content-end">
            <div class="col-md-6">
                @if(request('q'))
                <!-- Mode Pencarian Aktif -->
                <form action="{{ route('stock-out.index') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control me-2"
                        placeholder="Cari barang atau petugas..."
                        value="{{ request('q') }}"
                        disabled
                        style="padding: 0.5rem 0.75rem; font-size: 1rem;">
                    <button type="submit" class="btn btn-secondary btn-sm" title="Batal Pencarian">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
                @else
                <!-- Mode Normal -->
                <form action="{{ route('stock-out.index') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control me-2"
                        placeholder="Cari barang atau petugas..."
                        value="{{ request('q') }}"
                        style="padding: 0.5rem 0.75rem; font-size: 1rem;">
                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                </form>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%">
                <thead>
                    <tr class="text-center">
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th>Foto</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th> <!-- 🔹 Kolom Aksi -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockOuts as $so)
                    @foreach($so->details as $detail)
                    <tr>
                        <td class="text-center">{{ $so->tanggal_keluar->format('d M Y H:i') }}</td>
                        <td class="text-center">{{ $so->user->nama ?? '-' }}</td>
                        <td class="text-center align-middle">
                            @if($detail->product?->foto)
                            <img src="{{ asset('storage/' . $detail->product->foto) }}" width="100" class="rounded">
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $detail->product->nama_barang ?? '-' }}</td>
                        <td class="text-center">{{ $detail->jumlah_keluar }}</td>
                        <td>{{ $so->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <!-- Preview -->
                            <a href="{{ route('stock-out.show', $so->id_stock_out) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <!-- Edit -->
                            <a href="{{ route('stock-out.edit', $so->id_stock_out) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <!-- Delete -->
                            <form action="{{ route('stock-out.destroy', $so->id_stock_out) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Hapus transaksi ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">
                        Showing {{ $stockOuts->firstItem() }} to {{ $stockOuts->lastItem() }} of {{ $stockOuts->total() }} results
                    </span>
                </div>
                <div>
                    @if ($stockOuts->hasPages())
                    <a href="{{ $stockOuts->previousPageUrl() }}"
                        class="btn btn-outline-primary me-2 {{ $stockOuts->onFirstPage() ? 'disabled' : '' }}">
                        Previous
                    </a>
                    <a href="{{ $stockOuts->nextPageUrl() }}"
                        class="btn btn-outline-primary {{ !$stockOuts->hasMorePages() ? 'disabled' : '' }}">
                        Next
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection