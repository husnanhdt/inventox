@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Transaksi Keluar</h2>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tanggal:</strong> {{ $stockOut->tanggal_keluar }}</p>
                    <p><strong>Petugas:</strong> {{ $stockOut->user->nama ?? '-' }}</p>
                    <p><strong>Keterangan:</strong> {{ $stockOut->keterangan ?? '-' }}</p>
                </div>
            </div>

            <h4>Barang yang Keluar:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Keluar</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockOut->details as $detail)
                    <tr>
                        <td class="text-center align-middle">
                            @if($detail->product?->foto)
                            <img src="{{ asset('storage/' . $detail->product->foto) }}"
                                alt="Foto {{ $detail->product->nama_barang }}"
                                width="100"
                                class="rounded">
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $detail->product->nama_barang }}</td>
                        <td>{{ $detail->jumlah_keluar }}</td>
                        <td>{{ $detail->product->satuan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('stock-out.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection