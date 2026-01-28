    @extends('layouts.app')

    @section('content')
    <!-- Header Dashboard -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        <!-- Tombol Generate Report -->
        <a href="{{ route('dashboard.report.pdf') }}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
            <i class="fas fa-file-pdf fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Form Pencarian Cepat -->
    <div class="row mb-4  justify-content-end">
        <div class="col-md-6">
            @if(request('q'))
            <!-- Mode Pencarian Aktif -->
            <form action="{{ route('dashboard') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control mr-2"
                    placeholder="Cari barang..."
                    value="{{ request('q') }}"
                    disabled>
                <button type="submit" class="btn btn-secondary" title="Batal Pencarian">
                    <i class="fas fa-times"></i>
                </button>
            </form>
            @else
            <!-- Mode Normal -->
            <form action="{{ route('dashboard.search') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control mr-2"
                    placeholder="Cari barang..."
                    value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            @endif
        </div>
    </div>

    <!-- Statistik Utama (Hanya 3 Card) -->
    <div class="row mb-4">
        <!-- Total Barang -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">TOTAL BARANG</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_barang }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Habis -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">STOK HABIS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_habis }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">STOK MENIPIS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_menipis }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Transaksi Masuk Terakhir -->
    @if(!request('q'))
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi Masuk Terakhir</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Petugas</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStockIns as $si)
                        @foreach($si->details as $detail)
                        <tr>
                            <td class="text-center" style="width: 180px;">{{ date('d M Y H:i', strtotime($si->tanggal_masuk)) }}</td>

                            <!-- Kolom Foto -->
                            <td class="text-center align-middle" style="width: 13%;">
                                @if($detail->product?->foto)
                                <img src="{{ asset('storage/' . $detail->product->foto) }}"
                                    alt="Foto {{ $detail->product->nama_barang }}"
                                    width="100"
                                    class="rounded">
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td style="width: 18%;">{{ $detail->product->nama_barang ?? '-' }}</td>
                            <td class="text-center" style="width: 10%;">{{ $detail->jumlah_masuk }}</td>
                            <td class="text-center" style="width: 10%;">{{ $si->user->nama ?? '-' }}</td>
                            <td style="width: 35%;">{{ $si->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada transaksi masuk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination Hanya untuk Masuk -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">
                        Showing {{ $recentStockIns->firstItem() }} to {{ $recentStockIns->lastItem() }} of {{ $recentStockIns->total() }} results
                    </span>
                </div>
                <div>
                    @if ($recentStockIns->hasPages())
                    <a href="{{ $recentStockIns->previousPageUrl('page_masuk') }}"
                        class="btn btn-outline-primary me-2 {{ $recentStockIns->onFirstPage() ? 'disabled' : '' }}">
                        Previous
                    </a>
                    <a href="{{ $recentStockIns->nextPageUrl('page_masuk') }}"
                        class="btn btn-outline-primary {{ !$recentStockIns->hasMorePages() ? 'disabled' : '' }}">
                        Next
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Riwayat Transaksi Keluar Terakhir -->
    @if(!request('q'))
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi Keluar Terakhir</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Petugas</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStockOuts as $so)
                        @foreach($so->details as $detail)
                        <tr>
                            <td class="text-center" style="width: 180px;">{{ date('d M Y H:i', strtotime($so->tanggal_keluar)) }}</td>

                            <!-- Kolom Foto -->
                            <td class="text-center align-middle" style="width: 13%;">
                                @if($detail->product?->foto)
                                <img src="{{ asset('storage/' . $detail->product->foto) }}"
                                    alt="Foto {{ $detail->product->nama_barang }}"
                                    width="100"
                                    class="rounded">
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td style="width: 18%;">{{ $detail->product->nama_barang ?? '-' }}</td>
                            <td class="text-center" style="width: 10%;">{{ $detail->jumlah_keluar }}</td>
                            <td class="text-center" style="width: 10%;">{{ $so->user->nama ?? '-' }}</td>
                            <td style="width: 35%;">{{ $so->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada transaksi keluar</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination untuk Keluar -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">
                        Showing {{ $recentStockOuts->firstItem() }} to {{ $recentStockOuts->lastItem() }} of {{ $recentStockOuts->total() }} results
                    </span>
                </div>
                <div>
                    @if ($recentStockOuts->hasPages())
                    <a href="{{ $recentStockOuts->previousPageUrl() }}"
                        class="btn btn-outline-primary me-2 {{ $recentStockOuts->onFirstPage() ? 'disabled' : '' }}">
                        Previous
                    </a>
                    <a href="{{ $recentStockOuts->nextPageUrl() }}"
                        class="btn btn-outline-primary {{ !$recentStockOuts->hasMorePages() ? 'disabled' : '' }}">
                        Next
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Tampilkan hasil pencarian jika ada --}}
    @if(isset($products))
    <div class="card shadow mb-4 mt-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Hasil Pencarian: "{{ $search_query ?? '' }}"
            </h6>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                        <tr>
                            <td class="text-center align-middle">
                                @if($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}"
                                    alt="Foto {{ $p->nama_barang }}"
                                    width="100"
                                    class="rounded">
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $p->nama_barang }}</td>
                            <td>{{ $p->category->nama_category ?? '-' }}</td>
                            <td>{{ $p->stok }}</td>
                            <td>
                                @if($p->stok == 0)
                                <span class="text-danger">Habis</span>
                                @elseif($p->stok <= $p->minimal_stok)
                                    <span class="text-warning">Menipis</span>
                                    @else
                                    <span class="text-success">Aman</span>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-muted">Barang tidak ditemukan.</p>
            @endif
        </div>
    </div>
    @endif

    @endsection