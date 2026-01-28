@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Kategori</h1>
    <a href="{{ route('categories.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Kategori</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <td width="35%" class="font-weight-bold">Nama Kategori</td>
                            <td>{{ $category->nama_category }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Jumlah Barang</td>
                            <td>{{ $category->products_count }} barang</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Dibuat Pada</td>
                            <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Diperbarui Pada</td>
                            <td>{{ $category->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection